create or replace view v_station_numero_compagne as
select
    s.id_station, s.station,
    c.id_compagne, c.annee, c.debut, c.fin, c.etat,
    ns.id_numero_station, ns.numero_station
from numero_station ns
join station s on s.id_station = ns.station_id
join compagne c on c.id_compagne = ns.compagne_id;


create or replace view v_quotas_station as
select
     v.id_station, v.station, v.id_compagne, v.annee,
     n.id_navire, n.navire, q.quotas
from quotas q
join v_station_numero_compagne v on v.id_numero_station = q.numero_station_id
join navire n on n.id_navire = q.navire_id;
