--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: format_id_axe(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_axe() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_axe := 'AXE' || LPAD(nextval('axe_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_axe() OWNER TO postgres;

--
-- Name: format_id_customer(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_customer() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_customer := 'CLI' || LPAD(nextval('customer_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_customer() OWNER TO postgres;

--
-- Name: format_id_detail_pack(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_detail_pack() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_detail_pack := 'DTP' || LPAD(nextval('detail_pack_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_detail_pack() OWNER TO postgres;

--
-- Name: format_id_pack(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_pack() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_pack := 'PACK' || LPAD(nextval('pack_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_pack() OWNER TO postgres;

--
-- Name: format_id_place_delivery(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_place_delivery() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_place_delivery := 'LIV' || LPAD(nextval('place_delivery_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_place_delivery() OWNER TO postgres;

--
-- Name: format_id_product(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_product() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_product := 'PRD' || LPAD(nextval('product_sequence')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_product() OWNER TO postgres;

--
-- Name: format_id_product_purchase(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_product_purchase() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_product_purchase := 'ACHAT' || LPAD(nextval('product_purchase_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_product_purchase() OWNER TO postgres;

--
-- Name: format_id_stock_product(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_stock_product() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_stock_product := 'STK' || LPAD(nextval('stock_product_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_stock_product() OWNER TO postgres;

--
-- Name: format_id_ticket(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_ticket() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_ticket := 'TIC' || LPAD(nextval('ticket_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_ticket() OWNER TO postgres;

--
-- Name: format_id_unit(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.format_id_unit() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.id_unit := 'UNI' || LPAD(nextval('unit_sequence')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.format_id_unit() OWNER TO postgres;

--
-- Name: generate_full_text(text, character varying, integer, numeric, double precision, date, time without time zone, timestamp without time zone, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generate_full_text(texte_texte text, texte_varchar character varying, nombre_entier integer, nombre_decimal numeric, nombre_double double precision, date_col date, heure_col time without time zone, timestamp_col timestamp without time zone, bool_col boolean) RETURNS text
    LANGUAGE plpgsql IMMUTABLE
    AS $$
BEGIN
    RETURN COALESCE(texte_texte, '') || ' ' ||
           COALESCE(texte_varchar, '') || ' ' ||
           COALESCE(nombre_entier::TEXT, '') || ' ' ||
           COALESCE(nombre_decimal::TEXT, '') || ' ' ||
           COALESCE(nombre_double::TEXT, '') || ' ' ||
           COALESCE(date_col::TEXT, '') || ' ' ||
           COALESCE(heure_col::TEXT, '') || ' ' ||
           COALESCE(timestamp_col::TEXT, '') || ' ' ||
           COALESCE(bool_col::TEXT, '');
END;
$$;


ALTER FUNCTION public.generate_full_text(texte_texte text, texte_varchar character varying, nombre_entier integer, nombre_decimal numeric, nombre_double double precision, date_col date, heure_col time without time zone, timestamp_col timestamp without time zone, bool_col boolean) OWNER TO postgres;

--
-- Name: generate_id_user(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generate_id_user() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Générer le nouvel ID_USER en utilisant la séquence
    NEW.id_user := 'TS_' || LPAD(nextval('id_user_seq')::TEXT, 3, '0');
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.generate_id_user() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: axe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.axe (
    id_axe character varying(8) NOT NULL,
    "desc" character varying(50) NOT NULL
);


ALTER TABLE public.axe OWNER TO postgres;

--
-- Name: axe_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.axe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.axe_seq OWNER TO postgres;

--
-- Name: categorie_film; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorie_film (
    id integer NOT NULL,
    nom character varying(100) NOT NULL
);


ALTER TABLE public.categorie_film OWNER TO postgres;

--
-- Name: categorie_film_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorie_film_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categorie_film_id_seq OWNER TO postgres;

--
-- Name: categorie_film_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorie_film_id_seq OWNED BY public.categorie_film.id;


--
-- Name: customer_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.customer_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.customer_seq OWNER TO postgres;

--
-- Name: customers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.customers (
    id_customer character varying(8) NOT NULL,
    name character varying(50),
    first_name character varying(50),
    sex character varying(2) DEFAULT 'F'::character varying NOT NULL,
    phone character varying(15) NOT NULL,
    email character varying(70) NOT NULL,
    address character varying(100)
);


ALTER TABLE public.customers OWNER TO postgres;

--
-- Name: departments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.departments (
    department_id integer NOT NULL,
    department_name character varying(100)
);


ALTER TABLE public.departments OWNER TO postgres;

--
-- Name: departments_department_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.departments_department_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.departments_department_id_seq OWNER TO postgres;

--
-- Name: departments_department_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.departments_department_id_seq OWNED BY public.departments.department_id;


--
-- Name: detail_pack_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detail_pack_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detail_pack_seq OWNER TO postgres;

--
-- Name: detail_packs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detail_packs (
    id_detail_pack character varying(8) NOT NULL,
    pack_id character varying(8) NOT NULL,
    product_id character varying(8) NOT NULL,
    quantity_product double precision DEFAULT 0 NOT NULL
);


ALTER TABLE public.detail_packs OWNER TO postgres;

--
-- Name: employee_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employee_details (
    employee_id integer NOT NULL,
    email character varying(100),
    phone_number character varying(20),
    address character varying(255)
);


ALTER TABLE public.employee_details OWNER TO postgres;

--
-- Name: employees; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employees (
    employee_id integer NOT NULL,
    first_name character varying(50),
    last_name character varying(50),
    department_id integer,
    hire_date date,
    salary numeric(10,2)
);


ALTER TABLE public.employees OWNER TO postgres;

--
-- Name: employees_employee_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employees_employee_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.employees_employee_id_seq OWNER TO postgres;

--
-- Name: employees_employee_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.employees_employee_id_seq OWNED BY public.employees.employee_id;


--
-- Name: exemple; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exemple (
    id integer NOT NULL,
    texte_texte text,
    texte_varchar character varying(255),
    nombre_entier integer,
    nombre_decimal numeric(10,2),
    nombre_double double precision,
    date_col date,
    heure_col time without time zone,
    timestamp_col timestamp without time zone,
    bool_col boolean
);


ALTER TABLE public.exemple OWNER TO postgres;

--
-- Name: exemple_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exemple_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.exemple_id_seq OWNER TO postgres;

--
-- Name: exemple_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exemple_id_seq OWNED BY public.exemple.id;


--
-- Name: film; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film (
    id integer NOT NULL,
    titre character varying(255) NOT NULL,
    annee_sortie integer,
    categorie_id integer
);


ALTER TABLE public.film OWNER TO postgres;

--
-- Name: film_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.film_id_seq OWNER TO postgres;

--
-- Name: film_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_id_seq OWNED BY public.film.id;


--
-- Name: id_user_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.id_user_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_user_seq OWNER TO postgres;

--
-- Name: SEQUENCE id_user_seq; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON SEQUENCE public.id_user_seq IS 'sequence de la table users';


--
-- Name: pack_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pack_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pack_seq OWNER TO postgres;

--
-- Name: packs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.packs (
    id_pack character varying(8) NOT NULL,
    name character varying(50) NOT NULL,
    price double precision DEFAULT 0 NOT NULL,
    picture text DEFAULT 'image not found'::text NOT NULL,
    state integer DEFAULT 10 NOT NULL
);


ALTER TABLE public.packs OWNER TO postgres;

--
-- Name: place; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place (
    id_place integer NOT NULL,
    place character varying(40) NOT NULL
);


ALTER TABLE public.place OWNER TO postgres;

--
-- Name: place_axe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place_axe (
    id_place_axe integer NOT NULL,
    axe_id character varying(8) NOT NULL,
    place_id integer NOT NULL
);


ALTER TABLE public.place_axe OWNER TO postgres;

--
-- Name: place_axe_id_place_axe_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_axe_id_place_axe_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_axe_id_place_axe_seq OWNER TO postgres;

--
-- Name: place_axe_id_place_axe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_axe_id_place_axe_seq OWNED BY public.place_axe.id_place_axe;


--
-- Name: place_delivery; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place_delivery (
    id_place_delivery character varying(8) NOT NULL,
    place character varying(30) NOT NULL
);


ALTER TABLE public.place_delivery OWNER TO postgres;

--
-- Name: place_delivery_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_delivery_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_delivery_seq OWNER TO postgres;

--
-- Name: place_id_place_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_id_place_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_id_place_seq OWNER TO postgres;

--
-- Name: place_id_place_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_id_place_seq OWNED BY public.place.id_place;


--
-- Name: product_purchase_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_purchase_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_purchase_seq OWNER TO postgres;

--
-- Name: product_sequence; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_sequence
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_sequence OWNER TO postgres;

--
-- Name: product_units; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_units (
    id_unit character varying(8) NOT NULL,
    unite character varying(10)
);


ALTER TABLE public.product_units OWNER TO postgres;

--
-- Name: TABLE product_units; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.product_units IS 'unite de produit pour chaque produit';


--
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id_product character varying(8) NOT NULL,
    unit_id character varying(8),
    unitary_quantity double precision DEFAULT 0,
    cost_price double precision DEFAULT 0,
    product character varying NOT NULL
);


ALTER TABLE public.products OWNER TO postgres;

--
-- Name: seance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seance (
    id integer NOT NULL,
    id_film integer,
    date date NOT NULL,
    heure time without time zone NOT NULL
);


ALTER TABLE public.seance OWNER TO postgres;

--
-- Name: seance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seance_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seance_id_seq OWNER TO postgres;

--
-- Name: seance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seance_id_seq OWNED BY public.seance.id;


--
-- Name: stock_product_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.stock_product_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.stock_product_seq OWNER TO postgres;

--
-- Name: temp_table_seance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.temp_table_seance (
    idseance integer NOT NULL,
    nom_film character varying(255),
    categorie_film character varying(100),
    date date,
    heure time without time zone
);


ALTER TABLE public.temp_table_seance OWNER TO postgres;

--
-- Name: temp_table_seance_idseance_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.temp_table_seance_idseance_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.temp_table_seance_idseance_seq OWNER TO postgres;

--
-- Name: temp_table_seance_idseance_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.temp_table_seance_idseance_seq OWNED BY public.temp_table_seance.idseance;


--
-- Name: ticket_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ticket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_seq OWNER TO postgres;

--
-- Name: tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tickets (
    id_ticket character varying(8) NOT NULL,
    student character varying(8) NOT NULL,
    pack_id character varying(8),
    state integer DEFAULT 0 NOT NULL,
    date date DEFAULT CURRENT_DATE NOT NULL,
    payment_date date,
    payment double precision DEFAULT 0,
    customer_id character varying(8) DEFAULT 'not'::character varying,
    place_id integer
);


ALTER TABLE public.tickets OWNER TO postgres;

--
-- Name: unit_sequence; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.unit_sequence
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unit_sequence OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id_user character varying(8) NOT NULL,
    name character varying(40) NOT NULL,
    first_names character varying,
    date_birth date DEFAULT CURRENT_DATE NOT NULL,
    email character varying(50) NOT NULL,
    passwords text,
    role integer DEFAULT 0
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: v_axe_place_complet; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_axe_place_complet AS
 SELECT x.id_axe,
    p.id_place,
    p.place,
    x."desc"
   FROM ((public.place_axe px
     JOIN public.axe x ON (((x.id_axe)::text = (px.axe_id)::text)))
     JOIN public.place p ON ((p.id_place = px.place_id)));


ALTER TABLE public.v_axe_place_complet OWNER TO postgres;

--
-- Name: v_delevery; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_delevery AS
 SELECT t.date,
    t.student,
    u.name AS seller,
    x.id_axe AS axe_id,
    x.place,
    t.customer_id,
    c.name,
    c.phone,
    count(t.pack_id) AS number_pack,
    sum(p.price) AS montant
   FROM ((((public.tickets t
     JOIN public.packs p ON (((p.id_pack)::text = (t.pack_id)::text)))
     JOIN public.v_axe_place_complet x ON ((x.id_place = t.place_id)))
     JOIN public.users u ON (((u.id_user)::text = (t.student)::text)))
     JOIN public.customers c ON (((c.id_customer)::text = (t.customer_id)::text)))
  WHERE ((t.customer_id)::text <> 'not'::text)
  GROUP BY t.date, t.student, u.name, x.id_axe, x.place, t.customer_id, c.name, c.phone;


ALTER TABLE public.v_delevery OWNER TO postgres;

--
-- Name: v_detail_packs_lib; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_detail_packs_lib AS
 SELECT d.id_detail_pack,
    d.quantity_product,
    p.id_pack,
    p.name AS pack,
    r.product
   FROM ((public.detail_packs d
     JOIN public.packs p ON (((p.id_pack)::text = (d.pack_id)::text)))
     JOIN public.products r ON (((r.id_product)::text = (d.product_id)::text)));


ALTER TABLE public.v_detail_packs_lib OWNER TO postgres;

--
-- Name: v_employee_details; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_employee_details AS
 SELECT e.employee_id,
    e.first_name,
    e.last_name,
    e.department_id,
    d.department_name,
    e.hire_date,
    e.salary,
    ed.email,
    ed.phone_number,
    ed.address
   FROM ((public.employees e
     JOIN public.departments d ON ((e.department_id = d.department_id)))
     JOIN public.employee_details ed ON ((e.employee_id = ed.employee_id)));


ALTER TABLE public.v_employee_details OWNER TO postgres;

--
-- Name: v_products_lib; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_products_lib AS
 SELECT p.id_product,
    p.product,
    p.unitary_quantity,
    p.cost_price,
    u.unite
   FROM (public.products p
     JOIN public.product_units u ON (((u.id_unit)::text = (p.unit_id)::text)));


ALTER TABLE public.v_products_lib OWNER TO postgres;

--
-- Name: v_price_pack; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_price_pack AS
 SELECT dt.pack_id,
    sum(((dt.quantity_product * p.cost_price) / p.unitary_quantity)) AS total_price
   FROM (public.detail_packs dt
     JOIN public.v_products_lib p ON (((p.id_product)::text = (dt.product_id)::text)))
  GROUP BY dt.pack_id;


ALTER TABLE public.v_price_pack OWNER TO postgres;

--
-- Name: v_tickets_complet; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_tickets_complet AS
 SELECT t.id_ticket,
    t.state,
    t.date,
    t.payment_date,
    t.payment,
    u.id_user,
    u.name AS user_name,
    p.id_pack,
    p.name AS pack_name,
    p.price
   FROM ((public.tickets t
     JOIN public.users u ON (((u.id_user)::text = (t.student)::text)))
     JOIN public.packs p ON (((p.id_pack)::text = (t.pack_id)::text)));


ALTER TABLE public.v_tickets_complet OWNER TO postgres;

--
-- Name: v_price_material_student; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_price_material_student AS
 SELECT t.id_user,
    t.id_pack,
    pk.name AS pack,
    count(t.*) AS number_tickets,
    p.total_price AS total_material_pack,
    ((count(t.*))::double precision * p.total_price) AS total_price_material
   FROM ((public.v_tickets_complet t
     JOIN public.v_price_pack p ON (((p.pack_id)::text = (t.id_pack)::text)))
     JOIN public.packs pk ON (((pk.id_pack)::text = (p.pack_id)::text)))
  WHERE (t.state >= 5)
  GROUP BY t.id_user, t.id_pack, pk.name, p.total_price;


ALTER TABLE public.v_price_material_student OWNER TO postgres;

--
-- Name: v_ticket_left _pay; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public."v_ticket_left _pay" AS
 SELECT t.id_user,
    t.id_pack,
    t.pack_name,
    t.price,
    sum(t.price) AS total_amount,
    sum(t.payment) AS total_amount_received,
    (sum(t.price) - sum(t.payment)) AS total_amount_remaining
   FROM public.v_tickets_complet t
  GROUP BY t.id_user, t.id_pack, t.pack_name, t.price;


ALTER TABLE public."v_ticket_left _pay" OWNER TO postgres;

--
-- Name: v_ticket_packs; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_ticket_packs AS
SELECT
    NULL::character varying(8) AS id_pack,
    NULL::character varying(50) AS name,
    NULL::bigint AS number,
    NULL::double precision AS montant;


ALTER TABLE public.v_ticket_packs OWNER TO postgres;

--
-- Name: v_ticket_total_amount; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_ticket_total_amount AS
 SELECT t.id_user,
    t.id_pack,
    t.pack_name,
    t.price,
    sum(t.price) AS total_amount,
    sum(t.payment) AS total_amount_received,
    (sum(t.price) - sum(t.payment)) AS total_amount_remaining
   FROM public.v_tickets_complet t
  GROUP BY t.id_user, t.id_pack, t.pack_name, t.price;


ALTER TABLE public.v_ticket_total_amount OWNER TO postgres;

--
-- Name: v_tickets_sold; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_tickets_sold AS
 SELECT count(v_tickets_complet.id_ticket) AS number,
    v_tickets_complet.id_user,
    v_tickets_complet.user_name,
    v_tickets_complet.pack_name,
    v_tickets_complet.price
   FROM public.v_tickets_complet
  WHERE (v_tickets_complet.state >= 5)
  GROUP BY v_tickets_complet.id_user, v_tickets_complet.user_name, v_tickets_complet.pack_name, v_tickets_complet.price;


ALTER TABLE public.v_tickets_sold OWNER TO postgres;

--
-- Name: vaovao; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vaovao (
    id_vaovao integer NOT NULL,
    name character varying(100) DEFAULT 'Diary'::character varying NOT NULL
);


ALTER TABLE public.vaovao OWNER TO postgres;

--
-- Name: vaovao_id_vaovao_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vaovao_id_vaovao_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vaovao_id_vaovao_seq OWNER TO postgres;

--
-- Name: vaovao_id_vaovao_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vaovao_id_vaovao_seq OWNED BY public.vaovao.id_vaovao;


--
-- Name: categorie_film id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorie_film ALTER COLUMN id SET DEFAULT nextval('public.categorie_film_id_seq'::regclass);


--
-- Name: departments department_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments ALTER COLUMN department_id SET DEFAULT nextval('public.departments_department_id_seq'::regclass);


--
-- Name: employees employee_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees ALTER COLUMN employee_id SET DEFAULT nextval('public.employees_employee_id_seq'::regclass);


--
-- Name: exemple id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exemple ALTER COLUMN id SET DEFAULT nextval('public.exemple_id_seq'::regclass);


--
-- Name: film id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film ALTER COLUMN id SET DEFAULT nextval('public.film_id_seq'::regclass);


--
-- Name: place id_place; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place ALTER COLUMN id_place SET DEFAULT nextval('public.place_id_place_seq'::regclass);


--
-- Name: place_axe id_place_axe; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_axe ALTER COLUMN id_place_axe SET DEFAULT nextval('public.place_axe_id_place_axe_seq'::regclass);


--
-- Name: seance id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seance ALTER COLUMN id SET DEFAULT nextval('public.seance_id_seq'::regclass);


--
-- Name: temp_table_seance idseance; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_table_seance ALTER COLUMN idseance SET DEFAULT nextval('public.temp_table_seance_idseance_seq'::regclass);


--
-- Name: vaovao id_vaovao; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vaovao ALTER COLUMN id_vaovao SET DEFAULT nextval('public.vaovao_id_vaovao_seq'::regclass);


--
-- Data for Name: axe; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.axe (id_axe, "desc") FROM stdin;
AXE001	Premier Axe
AXE002	Deuxime Axe
\.


--
-- Data for Name: categorie_film; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categorie_film (id, nom) FROM stdin;
\.


--
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.customers (id_customer, name, first_name, sex, phone, email, address) FROM stdin;
CLI001	Hasinjo	Toavina	H	0389013364	toavinahasii02@gmail.com	jfglkse
CLI002	Toavina	Toavina	H	0389013364	olivia.brown@example.com	jfglkse
CLI003	Fanyah	F	F	0389013364	fanyah@gmail.com	jfglkse
CLI004	Hasinjo	Toavina	F	03890165	123@example.com	jfglkse
\.


--
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.departments (department_id, department_name) FROM stdin;
1	D‚veloppement
2	Ressources Humaines
3	Finance
\.


--
-- Data for Name: detail_packs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detail_packs (id_detail_pack, pack_id, product_id, quantity_product) FROM stdin;
DTP006	PACK002	PRD003	1
DTP007	PACK002	PRD004	2
DTP014	PACK001	PRD003	1
DTP009	PACK001	PRD001	50
DTP015	PACK001	PRD005	7
DTP016	PACK002	PRD001	60
DTP005	PACK002	PRD002	10
DTP008	PACK002	PRD005	2
DTP017	PACK001	PRD002	7
DTP018	PACK006	PRD002	15
\.


--
-- Data for Name: employee_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employee_details (employee_id, email, phone_number, address) FROM stdin;
1	john.doe@example.com	123-456-7890	123 Main St, Anytown, USA
2	jane.smith@example.com	234-567-8901	456 Elm St, Othertown, USA
3	alice.johnson@example.com	345-678-9012	789 Oak St, Anothertown, USA
4	bob.williams@example.com	456-789-0123	012 Pine St, Somewhere, USA
5	michael.brown@example.com	567-890-1234	345 Cedar St, Nowhere, USA
6	emily.johnson@example.com	678-901-2345	234 Maple St, Anotherplace, USA
7	daniel.martinez@example.com	789-012-3456	567 Oak St, Citytown, USA
8	olivia.garcia@example.com	890-123-4567	890 Pine St, Othertown, USA
9	liam.rodriguez@example.com	901-234-5678	123 Cedar St, Newcity, USA
10	sophia.hernandez@example.com	012-345-6789	456 Elm St, Anytown, USA
11	mason.lopez@example.com	123-456-7890	789 Oak St, Anothertown, USA
12	ava.gonzalez@example.com	234-567-8901	012 Pine St, Somewhere, USA
13	ethan.perez@example.com	345-678-9012	345 Cedar St, Nowhere, USA
14	isabella.torres@example.com	456-789-0123	678 Maple St, Anotherplace, USA
15	jacob.rivera@example.com	567-890-1234	901 Oak St, Citytown, USA
16	mia.sanders@example.com	678-901-2345	234 Pine St, Othertown, USA
17	william.scott@example.com	789-012-3456	567 Cedar St, Newcity, USA
18	james.price@example.com	890-123-4567	890 Elm St, Anytown, USA
19	charlotte.bennett@example.com	901-234-5678	123 Oak St, Anothertown, USA
20	benjamin.wood@example.com	012-345-6789	456 Pine St, Somewhere, USA
21	harper.barnes@example.com	123-456-7890	789 Cedar St, Nowhere, USA
22	elijah.ross@example.com	234-567-8901	012 Elm St, Anotherplace, USA
23	amelia.morales@example.com	345-678-9012	345 Oak St, Citytown, USA
24	michael.cooper@example.com	456-789-0123	678 Pine St, Othertown, USA
25	abigail.peterson@example.com	567-890-1234	901 Cedar St, Newcity, USA
26	alexander.gray@example.com	678-901-2345	234 Elm St, Anytown, USA
27	sofia.ramirez@example.com	789-012-3456	567 Oak St, Anothertown, USA
28	evelyn.james@example.com	890-123-4567	890 Pine St, Somewhere, USA
29	matthew.watson@example.com	901-234-5678	123 Cedar St, Nowhere, USA
30	victoria.brooks@example.com	012-345-6789	456 Elm St, Anotherplace, USA
31	avery.kelly@example.com	123-456-7890	789 Oak St, Citytown, USA
32	david.reed@example.com	234-567-8901	012 Pine St, Othertown, USA
33	madison.cook@example.com	345-678-9012	345 Cedar St, Newcity, USA
34	joseph.bailey@example.com	456-789-0123	678 Maple St, Anytown, USA
35	penelope.sanders@example.com	567-890-1234	901 Oak St, Anothertown, USA
36	dylan.murphy@example.com	678-901-2345	234 Pine St, Somewhere, USA
37	ella.ortiz@example.com	789-012-3456	567 Cedar St, Nowhere, USA
38	logan.nelson@example.com	890-123-4567	890 Elm St, Anotherplace, USA
39	grace.green@example.com	901-234-5678	123 Oak St, Citytown, USA
40	ryan.evans@example.com	012-345-6789	456 Pine St, Othertown, USA
41	nora.baker@example.com	123-456-7890	789 Cedar St, Newcity, USA
42	carter.morris@example.com	234-567-8901	012 Elm St, Anytown, USA
43	chloe.ward@example.com	345-678-9012	345 Oak St, Anothertown, USA
44	gabriel.stewart@example.com	456-789-0123	678 Pine St, Somewhere, USA
45	aubrey.murphy@example.com	567-890-1234	901 Cedar St, Nowhere, USA
46	samuel.king@example.com	678-901-2345	234 Elm St, Anotherplace, USA
47	luna.russell@example.com	789-012-3456	567 Oak St, Citytown, USA
48	luke.long@example.com	890-123-4567	890 Pine St, Othertown, USA
49	hannah.turner@example.com	901-234-5678	123 Cedar St, Newcity, USA
50	isaac.hughes@example.com	012-345-6789	456 Elm St, Anytown, USA
51	lily.foster@example.com	123-456-7890	789 Oak St, Anothertown, USA
52	henry.bryant@example.com	234-567-8901	012 Pine St, Somewhere, USA
53	zoe.alexander@example.com	345-678-9012	345 Cedar St, Nowhere, USA
\.


--
-- Data for Name: employees; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employees (employee_id, first_name, last_name, department_id, hire_date, salary) FROM stdin;
1	John	Doe	1	2020-01-15	60000.00
2	Jane	Smith	2	2019-05-20	55000.00
3	Alice	Johnson	1	2021-03-10	65000.00
4	Bob	Williams	3	2018-11-28	70000.00
5	Michael	Brown	1	2022-02-05	62000.00
6	Emily	Johnson	2	2020-07-15	60000.00
7	Daniel	Martinez	1	2019-09-20	55000.00
8	Olivia	Garcia	3	2021-11-10	65000.00
9	Liam	Rodriguez	1	2018-08-28	70000.00
10	Sophia	Hernandez	2	2022-04-05	62000.00
11	Mason	Lopez	3	2020-06-15	58000.00
12	Ava	Gonzalez	1	2021-12-20	60000.00
13	Ethan	Perez	2	2019-10-10	56000.00
14	Isabella	Torres	3	2018-07-28	63000.00
15	Jacob	Rivera	1	2020-03-05	68000.00
16	Mia	Sanders	2	2021-02-15	59000.00
17	William	Scott	3	2019-05-20	64000.00
18	James	Price	1	2020-09-10	67000.00
19	Charlotte	Bennett	2	2018-11-28	60000.00
20	Benjamin	Wood	3	2022-01-05	62000.00
21	Harper	Barnes	1	2019-04-15	55000.00
22	Elijah	Ross	2	2021-06-20	63000.00
23	Amelia	Morales	3	2018-10-10	66000.00
24	Michael	Cooper	1	2020-02-28	59000.00
25	Abigail	Peterson	2	2022-08-15	60000.00
26	Alexander	Gray	3	2019-03-20	67000.00
27	Sofia	Ramirez	1	2020-01-05	61000.00
28	Evelyn	James	2	2021-04-10	57000.00
29	Matthew	Watson	3	2018-12-28	64000.00
30	Victoria	Brooks	1	2022-03-15	66000.00
31	Avery	Kelly	2	2019-07-20	60000.00
32	David	Reed	3	2020-10-05	62000.00
33	Madison	Cook	1	2018-06-15	54000.00
34	Joseph	Bailey	2	2022-02-20	65000.00
35	Penelope	Sanders	3	2019-01-10	63000.00
36	Dylan	Murphy	1	2020-05-28	68000.00
37	Ella	Ortiz	2	2021-09-05	59000.00
38	Logan	Nelson	3	2018-08-10	64000.00
39	Grace	Green	1	2021-07-15	67000.00
40	Ryan	Evans	2	2019-11-20	58000.00
41	Nora	Baker	3	2020-04-10	62000.00
42	Carter	Morris	1	2018-10-28	55000.00
43	Chloe	Ward	2	2022-03-20	60000.00
44	Gabriel	Stewart	3	2019-06-05	63000.00
45	Aubrey	Murphy	1	2020-12-15	67000.00
46	Samuel	King	2	2018-09-20	59000.00
47	Luna	Russell	3	2021-01-05	64000.00
48	Luke	Long	1	2019-08-15	66000.00
49	Hannah	Turner	2	2020-05-20	60000.00
50	Isaac	Hughes	3	2021-02-10	62000.00
51	Lily	Foster	1	2018-07-28	56000.00
52	Henry	Bryant	2	2022-04-05	65000.00
53	Zoe	Alexander	3	2019-09-10	63000.00
\.


--
-- Data for Name: exemple; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.exemple (id, texte_texte, texte_varchar, nombre_entier, nombre_decimal, nombre_double, date_col, heure_col, timestamp_col, bool_col) FROM stdin;
2	Voici un autre exemple de texte.	Voici un autre exemple de texte.	123	1.62	2.71828	2024-05-07	15:45:00	2024-05-07 15:45:00	f
5	Texte 5	Varchar 5	99	4.56	1.2345	2024-05-10	10:30:00	2024-05-10 10:30:00	t
13	Texte 13	Varchar 13	888	2.34	1.234	2024-05-18	19:15:00	2024-05-18 19:15:00	t
14	Texte 14	Varchar 14	999	6.78	7.89	2024-05-19	10:00:00	2024-05-19 10:00:00	f
15	Texte 15	Varchar 15	1111	1.11	2.345	2024-05-20	18:35:00	2024-05-20 18:35:00	t
16	La pluie commence … tomber doucement.	Il est temps de sortir le parapluie.	42	3.14	3.14159	2024-05-06	12:30:00	2024-05-06 12:30:00	t
17	Les enfants jouent dans le jardin.	Ils rient et s amusent.	123	1.62	2.71828	2024-05-07	15:45:00	2024-05-07 15:45:00	f
18	Les feuilles d automne virevoltent.	Le vent murmure des secrets.	55	7.89	4.567	2024-05-08	09:15:00	2024-05-08 09:15:00	t
19	Le silence de la nuit est paisible.	Les ‚toiles brillent dans le ciel.	77	0.12	6.789	2024-05-09	18:00:00	2024-05-09 18:00:00	f
20	Un caf‚ chaud r‚chauffe le cour.	Son ar“me embaume la piŠce.	99	4.56	1.2345	2024-05-10	10:30:00	2024-05-10 10:30:00	t
21	Le temps passe trop vite.	Profitez de chaque instant.	111	0.99	9.876	2024-05-11	14:20:00	2024-05-11 14:20:00	f
22	Les fleurs ‚closent au printemps.	Leur beaut‚ ‚gaye le jardin.	222	6.54	3.2109	2024-05-12	08:45:00	2024-05-12 08:45:00	t
23	Le parfum des roses embaume l air.	Il ‚voque des souvenirs lointains.	333	1.23	7.8901	2024-05-13	17:10:00	2024-05-13 17:10:00	f
24	La mer est calme au coucher du soleil.	Ses vagues chuchotent des secrets.	444	5.67	2.3456	2024-05-14	11:55:00	2024-05-14 11:55:00	t
25	Les montagnes sont majestueuses.	Leur beaut‚ est indescriptible.	555	9.87	8.7654	2024-05-15	16:40:00	2024-05-15 16:40:00	f
26	Le chant des oiseaux annonce le matin.	La nature s ‚veille doucement.	666	3.21	5.4321	2024-05-16	13:25:00	2024-05-16 13:25:00	t
27	Les ‚toiles scintillent dans le ciel nocturne.	Elles ‚clairent notre chemin.	777	8.76	9.8765	2024-05-17	07:50:00	2024-05-17 07:50:00	f
28	Le parfum du caf‚ r‚veille les sens.	C est le d‚but d une nouvelle journ‚e.	888	2.34	1.234	2024-05-18	19:15:00	2024-05-18 19:15:00	t
29	Le vent souffle … travers les arbres.	Il murmure des histoires anciennes.	999	6.78	7.89	2024-05-19	10:00:00	2024-05-19 10:00:00	f
30	Le soleil brille aprŠs la pluie.	Les arcs-en-ciel illuminent le ciel.	1111	1.11	2.345	2024-05-20	18:35:00	2024-05-20 18:35:00	t
3	Texte 3	Varchar 3	55	7.89	4.567	2024-02-12	09:15:00	2024-05-08 09:15:00	t
4	Texte 4	Varchar 4	77	0.12	6.789	2024-04-12	18:00:00	2024-05-09 18:00:00	f
1	Ceci est un exemple de texte.	Ceci est un exemple de texte.	42	3.14	3.14159	2024-01-12	12:30:00	2024-05-06 12:30:00	t
6	Texte 6	Varchar 6	111	0.99	9.876	2024-06-12	14:20:00	2024-05-11 14:20:00	f
7	Texte 7	Varchar 7	222	6.54	3.2109	2024-07-12	08:45:00	2024-05-12 08:45:00	t
8	Texte 8	Varchar 8	333	1.23	7.8901	2024-08-12	17:10:00	2024-05-13 17:10:00	f
9	Texte 9	Varchar 9	444	5.67	2.3456	2024-09-12	11:55:00	2024-05-14 11:55:00	t
10	Texte 10	Varchar 10	555	9.87	8.7654	2024-10-12	16:40:00	2024-05-15 16:40:00	f
11	Texte 11	Varchar 11	666	3.21	5.4321	2024-11-12	13:25:00	2024-05-16 13:25:00	t
12	Texte 12	Varchar 12	777	8.76	9.8765	2024-12-12	07:50:00	2024-05-17 07:50:00	f
\.


--
-- Data for Name: film; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film (id, titre, annee_sortie, categorie_id) FROM stdin;
\.


--
-- Data for Name: packs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.packs (id_pack, name, price, picture, state) FROM stdin;
PACK002	MILAY BE	30000	storage/images/1712390858_ann.png	10
PACK003	Mety	2300	storage/images/1712390858_ann.png	0
PACK004	Test	4556	storage/images/1712390858_ann.png	0
PACK005	Test	12000	storage/images/1712431987_logo.jpg	0
P020	P020	40000	storage/images/1714885478_eugFacture.png	10
P030	P030	40000	storage/images/1714885495_balanceEu.png	10
PACK006	Testhh	27500	storage/images/1715398940_cv.jpg	10
PACK001	MILAY	20000	image/1715402549_lire.png	10
PACK021	Hasinjo	2	image1715403053_fanyah.png	0
PACK020	Hasinjo	2	image1715403023_fanyah.png	0
PACK019	Hasinjo	2	image1715403006_fanyah.png	0
PACK022	Hasinjo	3	image1715403107_fanyah.png	0
PACK023	Hasinjo	5	image1715403194_fanyah.png	0
PACK024	Hasinjo	14	image/1715403350_cv2.JPG	10
\.


--
-- Data for Name: place; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.place (id_place, place) FROM stdin;
1	Andoharanofotsy
2	Tanjombato
3	Iavoloha
4	Analakely
5	Anosy
6	Ambojatovo
\.


--
-- Data for Name: place_axe; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.place_axe (id_place_axe, axe_id, place_id) FROM stdin;
1	AXE001	1
2	AXE001	2
3	AXE001	3
4	AXE002	4
5	AXE002	5
6	AXE002	6
\.


--
-- Data for Name: place_delivery; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.place_delivery (id_place_delivery, place) FROM stdin;
\.


--
-- Data for Name: product_units; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_units (id_unit, unite) FROM stdin;
UNI001	Kg
UNI002	Piece
UNI003	g
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.products (id_product, unit_id, unitary_quantity, cost_price, product) FROM stdin;
PRD001	UNI003	100	10000	Tsatsiou
PRD002	UNI002	1	300	Begniet de crevette
PRD003	UNI002	1	1000	Embalage
PRD004	UNI002	1	7000	Pistolet
PRD005	UNI002	1	1500	Croquet de poulet
\.


--
-- Data for Name: seance; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seance (id, id_film, date, heure) FROM stdin;
\.


--
-- Data for Name: temp_table_seance; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.temp_table_seance (idseance, nom_film, categorie_film, date, heure) FROM stdin;
\.


--
-- Data for Name: tickets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tickets (id_ticket, student, pack_id, state, date, payment_date, payment, customer_id, place_id) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id_user, name, first_names, date_birth, email, passwords, role) FROM stdin;
TS_013	admin	admin	2000-06-09	admin@gmail.com	$2y$10$1F7SjDKm/Yg8RQS2BliNZO/4c8JsWTM7nov3/DKntflcLjfbadEi6	1
TS_014	Toavina	Toavina	2001-02-12	toavinahasnii02@gmail.com	$2y$10$FM6angcaKkhStIHP8bNuE.WFZkycOC/LBUVljH3AcVdcmruKRFWTm	0
\.


--
-- Data for Name: vaovao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vaovao (id_vaovao, name) FROM stdin;
\.


--
-- Name: axe_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.axe_seq', 2, true);


--
-- Name: categorie_film_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categorie_film_id_seq', 84, true);


--
-- Name: customer_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.customer_seq', 4, true);


--
-- Name: departments_department_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.departments_department_id_seq', 3, true);


--
-- Name: detail_pack_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detail_pack_seq', 18, true);


--
-- Name: employees_employee_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employees_employee_id_seq', 53, true);


--
-- Name: exemple_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.exemple_id_seq', 30, true);


--
-- Name: film_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_id_seq', 153, true);


--
-- Name: id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.id_user_seq', 14, true);


--
-- Name: pack_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pack_seq', 24, true);


--
-- Name: place_axe_id_place_axe_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_axe_id_place_axe_seq', 6, true);


--
-- Name: place_delivery_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_delivery_seq', 1, false);


--
-- Name: place_id_place_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_id_place_seq', 6, true);


--
-- Name: product_purchase_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_purchase_seq', 1, false);


--
-- Name: product_sequence; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_sequence', 5, true);


--
-- Name: seance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seance_id_seq', 1, false);


--
-- Name: stock_product_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.stock_product_seq', 1, false);


--
-- Name: temp_table_seance_idseance_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.temp_table_seance_idseance_seq', 1, false);


--
-- Name: ticket_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ticket_seq', 89, true);


--
-- Name: unit_sequence; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.unit_sequence', 3, true);


--
-- Name: vaovao_id_vaovao_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vaovao_id_vaovao_seq', 1, false);


--
-- Name: categorie_film categorie_film_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorie_film
    ADD CONSTRAINT categorie_film_pkey PRIMARY KEY (id);


--
-- Name: departments departments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (department_id);


--
-- Name: employee_details employee_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_details
    ADD CONSTRAINT employee_details_pkey PRIMARY KEY (employee_id);


--
-- Name: employees employees_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (employee_id);


--
-- Name: exemple exemple_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exemple
    ADD CONSTRAINT exemple_pkey PRIMARY KEY (id);


--
-- Name: film film_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film
    ADD CONSTRAINT film_pkey PRIMARY KEY (id);


--
-- Name: axe pk_axe; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.axe
    ADD CONSTRAINT pk_axe PRIMARY KEY (id_axe);


--
-- Name: customers pk_customer; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT pk_customer PRIMARY KEY (id_customer);


--
-- Name: detail_packs pk_detail_pack; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detail_packs
    ADD CONSTRAINT pk_detail_pack PRIMARY KEY (id_detail_pack);


--
-- Name: packs pk_pack; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.packs
    ADD CONSTRAINT pk_pack PRIMARY KEY (id_pack);


--
-- Name: place pk_place; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place
    ADD CONSTRAINT pk_place PRIMARY KEY (id_place);


--
-- Name: place_axe pk_place_axe; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_axe
    ADD CONSTRAINT pk_place_axe PRIMARY KEY (id_place_axe);


--
-- Name: place_delivery pk_place_delivery; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_delivery
    ADD CONSTRAINT pk_place_delivery PRIMARY KEY (id_place_delivery);


--
-- Name: products pk_product; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT pk_product PRIMARY KEY (id_product);


--
-- Name: product_units pk_product_unit; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_units
    ADD CONSTRAINT pk_product_unit PRIMARY KEY (id_unit);


--
-- Name: tickets pk_ticket; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT pk_ticket PRIMARY KEY (id_ticket);


--
-- Name: users pk_users; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT pk_users PRIMARY KEY (id_user);


--
-- Name: vaovao pk_vaovao; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vaovao
    ADD CONSTRAINT pk_vaovao PRIMARY KEY (id_vaovao);


--
-- Name: seance seance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seance
    ADD CONSTRAINT seance_pkey PRIMARY KEY (id);


--
-- Name: idx_fulltext_search; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_fulltext_search ON public.exemple USING gin (to_tsvector('french'::regconfig, public.generate_full_text(texte_texte, texte_varchar, nombre_entier, nombre_decimal, nombre_double, date_col, heure_col, timestamp_col, bool_col)));


--
-- Name: v_ticket_packs _RETURN; Type: RULE; Schema: public; Owner: postgres
--

CREATE OR REPLACE VIEW public.v_ticket_packs AS
 SELECT p.id_pack,
    p.name,
    count(t.pack_id) AS number,
    ((count(t.pack_id))::double precision * p.price) AS montant
   FROM (public.tickets t
     RIGHT JOIN public.packs p ON (((p.id_pack)::text = (t.pack_id)::text)))
  WHERE (p.state = 10)
  GROUP BY p.id_pack, p.name;


--
-- Name: axe trigger_format_id_axe; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_axe BEFORE INSERT ON public.axe FOR EACH ROW EXECUTE FUNCTION public.format_id_axe();


--
-- Name: customers trigger_format_id_customer; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_customer BEFORE INSERT ON public.customers FOR EACH ROW EXECUTE FUNCTION public.format_id_customer();


--
-- Name: detail_packs trigger_format_id_detail_pack; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_detail_pack BEFORE INSERT ON public.detail_packs FOR EACH ROW EXECUTE FUNCTION public.format_id_detail_pack();


--
-- Name: packs trigger_format_id_pack; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_pack BEFORE INSERT ON public.packs FOR EACH ROW EXECUTE FUNCTION public.format_id_pack();


--
-- Name: place_delivery trigger_format_id_place_delivery; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_place_delivery BEFORE INSERT ON public.place_delivery FOR EACH ROW EXECUTE FUNCTION public.format_id_place_delivery();


--
-- Name: products trigger_format_id_product; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_product BEFORE INSERT ON public.products FOR EACH ROW EXECUTE FUNCTION public.format_id_product();


--
-- Name: tickets trigger_format_id_ticket; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_ticket BEFORE INSERT ON public.tickets FOR EACH ROW EXECUTE FUNCTION public.format_id_ticket();


--
-- Name: product_units trigger_format_id_unit; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_unit BEFORE INSERT ON public.product_units FOR EACH ROW EXECUTE FUNCTION public.format_id_unit();


--
-- Name: users trigger_generate_id_user; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_generate_id_user BEFORE INSERT ON public.users FOR EACH ROW WHEN ((new.id_user IS NULL)) EXECUTE FUNCTION public.generate_id_user();


--
-- Name: place_axe axe_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_axe
    ADD CONSTRAINT axe_id FOREIGN KEY (axe_id) REFERENCES public.axe(id_axe);


--
-- Name: employee_details employee_details_employee_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_details
    ADD CONSTRAINT employee_details_employee_id_fkey FOREIGN KEY (employee_id) REFERENCES public.employees(employee_id);


--
-- Name: employees employees_department_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_department_id_fkey FOREIGN KEY (department_id) REFERENCES public.departments(department_id);


--
-- Name: film film_categorie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film
    ADD CONSTRAINT film_categorie_id_fkey FOREIGN KEY (categorie_id) REFERENCES public.categorie_film(id);


--
-- Name: tickets fk_ticket_pack; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT fk_ticket_pack FOREIGN KEY (pack_id) REFERENCES public.packs(id_pack);


--
-- Name: tickets fk_ticket_users; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT fk_ticket_users FOREIGN KEY (student) REFERENCES public.users(id_user) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: detail_packs pack_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detail_packs
    ADD CONSTRAINT pack_id FOREIGN KEY (pack_id) REFERENCES public.packs(id_pack);


--
-- Name: place_axe place_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_axe
    ADD CONSTRAINT place_id FOREIGN KEY (place_id) REFERENCES public.place(id_place);


--
-- Name: tickets place_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT place_id FOREIGN KEY (place_id) REFERENCES public.place(id_place) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: detail_packs product_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detail_packs
    ADD CONSTRAINT product_id FOREIGN KEY (product_id) REFERENCES public.products(id_product);


--
-- Name: seance seance_id_film_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seance
    ADD CONSTRAINT seance_id_film_fkey FOREIGN KEY (id_film) REFERENCES public.film(id);


--
-- Name: products unite_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT unite_id FOREIGN KEY (unit_id) REFERENCES public.product_units(id_unit);


--
-- PostgreSQL database dump complete
--

