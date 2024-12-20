

create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.numero_camion, em.bon_livraison, em.chauffeur, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant, age.matricule as matricule_entrant, age.nom as nom_entrant,
    em.station_id, s.station, em.magasin_id, m.magasin, em.path_bon_livraison, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag.matricule  as matricule_sortant, ag.nom as nom_sortant
from
entree_magasin em
join station s on s.id_station = em.station_id
join magasin m on m.id_magasin = em.magasin_id
left join sortant_magasin sm on sm.entree_magasin_id = em.id_entree_magasin
join v_utilisateur_global  age on age.id_utilisateur = em.agent_id
left join v_utilisateur_global ag on ag.id_utilisateur = sm.agent_id
join navire n on n.id_navire = em.navire_id;


create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.chauffeur, em.numero_camion, em.bon_livraison, em.path_bon_livraison, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant,ag.matricule as matricule_entrant, ag.nom as nom_entrant,
    ns.id_station, ns.station,ns.numero_station, em.magasin_id, m.magasin, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag1.matricule as matricule_sortant, ag1.nom as nom_sortant
from entree_magasin em
join v_station_numero_compagne ns on em.numero_station_id=ns.id_numero_station
left join sortant_magasin sm on sm.entree_magasin_id = em.id_entree_magasin
join magasin m on m.id_magasin = em.magasin_id
left join v_utilisateur_global ag on ag.id_utilisateur = em.agent_id
left join v_utilisateur_global  ag1 on ag1.id_utilisateur = sm.agent_id
join navire n on n.id_navire = em.navire_id;
