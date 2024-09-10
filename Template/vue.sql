CREATE OR REPLACE VIEW v_tickets_sold AS
select
    count(id_ticket) as number,
    id_user, user_name,
    pack_name, price
from v_tickets_complet
where state = 10
group by id_user, user_name, pack_name, price;


CREATE OR REPLACE VIEW v_price_material_student AS
select
    t.id_user, t.id_pack, pk.name as pack,
    count(t.*) as number_tickets,
    p.total_price as total_material_pack , (count(t.*) * total_price )as total_price_material
from v_tickets_complet t
join v_price_pack p on p.pack_id = t.id_pack
join packs pk on pk.id_pack = p.pack_id
where t."state" = 10
group by t.id_user, t.id_pack, pk.name, p.total_price;



pg_dump -U postgres -d tsakitsaky -F c -f D:\S6\prepa_eval\tsakitsaky\database\base.sql

psql -U postgres -d tsakitsaky3 -f D:\S6\prepa_eval\tsakitsaky\database\base.sql
