create or replace view v_mouvement_camion as
select
   *
from entree_magasin e
left join sortant_magasin s on s.entree_magasin_id = e.id_entree_magasin
;
