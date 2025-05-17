create or replace view v_quotas_navire_compagne as 
select
 c.id_compagne, c.annee,
 nv.id_navire, nv.navire, nv.nb_compartiment, nv.quantite_max, 
 sum(q.quotas) as quotas_navire    
from quotas q
join navire nv on q.navire_id = nv.id_navire
join numero_station n on q.numero_station_id = n.id_numero_station
join compagne c on n.compagne_id = c.id_compagne
group by  c.id_compagne, c.annee, nv.id_navire, nv.navire, nv.nb_compartiment, nv.quantite_max;