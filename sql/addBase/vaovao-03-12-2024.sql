create or replace view v_quotas_station as
select
     v.id_station, v.station, v.id_numero_station, v.numero_station,
    v.id_compagne, v.annee,
     n.id_navire, n.navire,q.id_quotas, q.quotas
from quotas q
join v_station_numero_compagne v on v.id_numero_station = q.numero_station_id
join navire n on n.id_navire = q.navire_id
order by v.annee desc;


create or replace view v_mouvement_navire as
select
    c.id_compagne, c.annee, c.debut, c.fin, c.etat,
    n.id_navire, n.navire, n.nb_compartiment, n.quantite_max,
    mn.date_arriver, mn.date_depart, mn.id_mouvement_navire
from
    mouvement_navire mn
join compagne c on c.id_compagne = mn.compagne_id
join navire n on n.id_navire = mn.navire_id;
