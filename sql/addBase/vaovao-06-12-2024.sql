alter table
    entree_magasin
    add column 	shift_id int;

ALTER TABLE
    entree_magasin
    ADD CONSTRAINT fk_shift_id
    FOREIGN KEY ( shift_id ) REFERENCES shift( id_shift );

delete from sortant_magasin;
alter table
    sortant_magasin
    add column 	shift_id int;

ALTER TABLE
    sortant_magasin
    ADD CONSTRAINT fk_shift_id_sortant_magasin
    FOREIGN KEY ( shift_id ) REFERENCES shift( id_shift );

create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.chauffeur, em.numero_camion, em.bon_livraison, em.path_bon_livraison, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant,ag.matricule as matricule_entrant, ag.nom as nom_entrant,
    ns.id_station, ns.station,ns.numero_station, em.magasin_id, m.magasin, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag1.matricule as matricule_sortant, ag1.nom as nom_sortant,
    s.id_shift, s.description, s.debut, s.fin
from entree_magasin em
join v_station_numero_compagne ns on em.numero_station_id=ns.id_numero_station
left join sortant_magasin sm on sm.entree_magasin_id = em.id_entree_magasin
join magasin m on m.id_magasin = em.magasin_id
left join v_utilisateur_global ag on ag.id_utilisateur = em.agent_id
left join v_utilisateur_global  ag1 on ag1.id_utilisateur = sm.agent_id
join navire n on n.id_navire = em.navire_id
join shift s on s.id_shift = em.shift_id;

create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.chauffeur, em.numero_camion, em.bon_livraison, em.path_bon_livraison, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant,ag.matricule as matricule_entrant, ag.nom as nom_entrant,
    ns.id_station, ns.station,ns.numero_station, em.magasin_id, m.magasin, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag1.matricule as matricule_sortant, ag1.nom as nom_sortant,
    s.id_shift, s.description, s.debut, s.fin,
    ns.id_compagne, ns.annee,
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





create or replace view v_palette_entree as
 SELECT e.numero_station_id, e.navire_id,
         SUM(e.quantite_palette) as somme_quantite_palette
        FROM entree_magasin e
            group by e.numero_station_id, e.navire_id

create or replace view v_reste_palette_station as
SELECT
    q.id_station,
    q.station,
    q.id_numero_station,
    q.numero_station,
    q.id_navire,
    q.navire,
    q.id_compagne,
    q.annee,
    SUM(q.quotas) AS quotas,
    coalesce(e.somme_quantite_palette, 0) as palette_entree,
    ( SUM(q.quotas) - coalesce(e.somme_quantite_palette, 0) ) as reste
FROM v_quotas_station q
left join v_palette_entree e
    on e.numero_station_id = q.id_numero_station
    and e.navire_id = q.id_navire
GROUP BY q.id_station, q.station,  q.numero_station,
         q.id_navire, q.navire, q.id_compagne, q.annee, e.somme_quantite_palette;


create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.chauffeur, em.numero_camion, em.bon_livraison, em.path_bon_livraison, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant,ag.matricule as matricule_entrant, ag.nom as nom_entrant,
    ns.id_station, ns.station,ns.numero_station, em.magasin_id, m.magasin, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag1.matricule as matricule_sortant, ag1.nom as nom_sortant,
    s.id_shift, s.description, s.debut, s.fin,
    ns.id_compagne, ns.annee,
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


create or replace view  v_historique_embarquement as
select
    e.id_embarquement,
    c.id_compagne , c.annee, c.etat as etat_campagne,
    s.id_shift, s.description,
    n.id_navire, n.navire, n.nb_compartiment,  e.numero_cal,
    u.id_utilisateur, u.matricule, CONCAT(u.nom, '-' , u.prenom) as agent,
    c.station, c.id_station, c.numero_station,
    e.date_embarquement, e.heure_embarquement,
    (e.nombre_pallets), (e.nombre_pallets ) as quantite
from embarquement e
join v_utilisateur_global u on u.id_utilisateur = e.utilisateur_id
join v_station_numero_compagne c on c.id_numero_station = e.numero_station_id
join shift s on s.id_shift = e.shift_id
join navire n on n.id_navire = e.navire_id;

