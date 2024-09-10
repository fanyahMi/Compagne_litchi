pg_dump -h localhost -p 5432 -U postgres -d tsakitsaky -f <output_file>

pg_dump -h localhost -p 5432 -U postgres -d  tsakitsaky -f D:\S6\prepa_eval\tsakitsaky\sql\dump.sql -s

psql -h localhost -p 5432 -U postgres -d tsakitsaky2 -f D:\S6\prepa_eval\tsakitsaky\sql\dump.sql



CREATE SEQUENCE unit_sequence START 1;
CREATE OR REPLACE FUNCTION format_id_unit()
RETURNS TRIGGER AS $$
BEGIN
    NEW.id_unit := 'UNI' || LPAD(nextval('unit_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_format_id_unit
BEFORE INSERT ON public.product_unit
FOR EACH ROW
EXECUTE FUNCTION format_id_unit();
