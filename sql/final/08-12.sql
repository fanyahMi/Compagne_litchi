create or replace view v_mouvement_navire as
select
    c.id_compagne, c.annee, c.debut, c.fin, c.etat,
    n.id_navire, n.navire, n.nb_compartiment, n.quantite_max,
    mn.date_arriver, mn.date_depart, mn.id_mouvement_navire,
    coalesce(
       ( select sum(e.nombre_pallets)
        from v_historique_embarquement e
        where e.id_compagne = c.id_compagne
            and e.id_navire = n.id_navire), 0
    ) as quantite_embarque
from
    mouvement_navire mn
join compagne c on c.id_compagne = mn.compagne_id
join navire n on n.id_navire = mn.navire_id;


create or replace view  v_historique_embarquement as
select
    e.id_embarquement,
    c.id_compagne , c.annee, c.etat as etat_campagne,
    s.id_shift, s.description,
    n.id_navire, n.navire, n.nb_compartiment,  e.numero_cal,
    u.id_utilisateur, u.matricule, CONCAT(u.nom, ' - ' , u.prenom) as agent,
    u.prenom,
    c.station, c.id_station, c.numero_station,
    e.date_embarquement, e.heure_embarquement,
    CONCAT(e.date_embarquement, ' - ' , e.heure_embarquement) as embarquement,
    (e.nombre_pallets)
from embarquement e
join v_utilisateur_global u on u.id_utilisateur = e.utilisateur_id
join v_station_numero_compagne c on c.id_numero_station = e.numero_station_id
join shift s on s.id_shift = e.shift_id
join navire n on n.id_navire = e.navire_id;

create or replace view v_quantite_cales as
SELECT
    c.id_navire,
    c.navire,
    c.numero_cale,
    COALESCE(SUM(eh.nombre_pallets), 0) AS total_pallets,
    eh.id_compagne, eh.annee
FROM
    v_liste_numero_cale_navire c
LEFT JOIN
    v_historique_embarquement eh
    ON eh.id_navire = c.id_navire
    AND eh.numero_cal = c.numero_cale  -- Correction ici
GROUP BY
    c.id_navire,
    c.navire,
    c.numero_cale,
    eh.id_compagne;


    create or replace view v_historique_embarquement_navire as
select
    h.id_compagne, h.annee, h.etat_campagne,
    h.id_navire, h.navire, h.numero_cal,
    h.station, h.id_station,
    h.numero_station,
    sum(h.nombre_pallets) as totat_pallets
from v_historique_embarquement h
group by
     h.id_compagne, h.annee, h.etat_campagne,
    h.id_navire, h.navire,
    h.station, h.numero_station,  h.numero_cal;



    create or replace view v_quantite_cales as
SELECT
    c.id_compagne,
    c.annee,
    n.id_navire,
    n.navire,
    n.numero_cale,
    coalesce( sum(h.totat_pallets), 0) as total_pallets
FROM
    compagne c
CROSS JOIN
    v_liste_numero_cale_navire n
left join
    v_historique_embarquement_navire h
    on h.id_compagne = c.id_compagne and
    h.id_navire = n.id_navire and
    h.numero_cal = n.numero_cale
group by c.id_compagne,
    c.annee,
    n.id_navire,
    n.navire,
    n.numero_cale;

