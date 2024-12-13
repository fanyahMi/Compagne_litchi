create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.chauffeur, em.numero_camion, em.bon_livraison, em.path_bon_livraison, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant,ag.matricule as matricule_entrant, ag.nom as nom_entrant,
    ns.id_station, ns.station,ns.numero_station, em.magasin_id, m.magasin, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag1.matricule as matricule_sortant, ag1.nom as nom_sortant,
    s.id_shift, s.description, s.debut, s.fin,
    ns.id_compagne, ns.annee, ns.etat,
    ss.id_shift as id_shift_sortie, ss.description as description_sortie, ss.debut as debut_sortie, ss.fin as fin_sortie
from entree_magasin em
join v_station_numero_compagne ns on em.numero_station_id=ns.id_numero_station
left join sortant_magasin sm on sm.entree_magasin_id = em.id_entree_magasin
join magasin m on m.id_magasin = em.magasin_id
left join v_utilisateur_global ag on ag.id_utilisateur = em.agent_id
left join v_utilisateur_global  ag1 on ag1.id_utilisateur = sm.agent_id
join navire n on n.id_navire = em.navire_id
join shift s on s.id_shift = em.shift_id
left join shift ss on ss.id_shift = sm.shift_id;



create or replace view v_date_hist_embarquement as
SELECT
    h.id_compagne,
    h.annee,
    h.id_navire,
    h.navire,
    h.date_embarquement,
    CONCAT(s.id_station, ' / ', s.station) AS station,
    s.id_station
FROM
    v_historique_embarquement h
JOIN
    v_station_numero_compagne s
ON
    h.id_compagne = s.id_compagne
    AND h.annee = s.annee
group by  h.id_compagne,
    h.annee,
    h.navire,
    h.date_embarquement,
    s.id_station, s.station
ORDER BY
    h.navire, s.id_station, h.date_embarquement;


    create or replace view v_date_station_cale as
select
    dh.id_compagne, dh.annee,
   dh.id_navire, dh.navire,
    dh.date_embarquement, dh.station, dh.id_station,
    h.id_shift, h.description as shift,
    num.numero_cale
from v_date_hist_embarquement dh
join v_liste_numero_cale_navire num
    on num.id_navire = dh.id_navire
cross join shift h
order by
dh.id_navire, dh.navire,
    dh.date_embarquement, dh.station, dh.id_station,
    h.id_shift,
   num.numero_cale;


create or replace view v_rapport_embarquement as
select
    ds.id_compagne, ds.annee, ds.id_navire,
    ds.navire, ds.date_embarquement, ds.id_station, ds.station,
    ds.id_shift, ds.shift, ds.numero_cale,
    coalesce( sum(he.nombre_pallets), 0) as total_palettes
from v_date_station_cale ds
left join v_historique_embarquement he
    on he.id_compagne = ds.id_compagne
    and he.id_navire = ds.id_navire
    and he.date_embarquement = ds.date_embarquement
    and he.id_station = ds.id_station
    and he.id_shift = ds.id_shift
    and he.numero_cal = ds.numero_cale
group by
     ds.id_compagne, ds.annee, ds.id_navire,
    ds.navire, ds.date_embarquement, ds.id_station, ds.station,
    ds.id_shift, ds.shift, ds.numero_cale;


DELIMITER $$

CREATE OR REPLACE PROCEDURE GeneratePivot2()
BEGIN
    DECLARE column_list TEXT;
    DECLARE sql_query TEXT;

    SELECT GROUP_CONCAT(
        CONCAT(
            'SUM(CASE WHEN id_shift = ', id_shift, ' AND numero_cale = ', numero_cale,
            ' THEN total_palettes ELSE 0 END) AS `Shift ', id_shift, ' Cale ', numero_cale, '`'
        )
    ) INTO column_list
    FROM (
        SELECT DISTINCT id_shift, numero_cale
        FROM v_rapport_embarquement
        WHERE id_compagne = @id_compagne
          AND id_navire = @id_navire
    ) AS subquery;

    SET sql_query = CONCAT(
        'SELECT navire AS `BATEAU`, ',
        'DATE(date_embarquement) AS `DATE`, ',
        'station AS `STATION`, ',
        column_list,
        ', SUM(total_palettes) AS `TOTAL_PALLETS` ',
        'FROM v_rapport_embarquement ',
        'WHERE id_compagne = @id_compagne ',
        'AND id_navire = @id_navire ',
        'GROUP BY navire, DATE(date_embarquement), station'
    );

    PREPARE stmt FROM sql_query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;


SET @id_compagne = 1;
SET @id_navire = 1;
CALL GeneratePivot2();
