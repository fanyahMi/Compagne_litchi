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
-- Name: product_purchases; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_purchases (
    id_product_purchase character varying(8) NOT NULL,
    product_id character varying(8) NOT NULL,
    quantity double precision DEFAULT 0 NOT NULL,
    price_unit double precision DEFAULT 0 NOT NULL
);


ALTER TABLE public.product_purchases OWNER TO postgres;

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
-- Name: stock_products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.stock_products (
    id_stock_product character varying(8) NOT NULL,
    product_id character varying(8) NOT NULL,
    incoming double precision DEFAULT 0,
    outgoing double precision DEFAULT 0
);


ALTER TABLE public.stock_products OWNER TO postgres;

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
    passwords character varying(20),
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
-- Name: place id_place; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place ALTER COLUMN id_place SET DEFAULT nextval('public.place_id_place_seq'::regclass);


--
-- Name: place_axe id_place_axe; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_axe ALTER COLUMN id_place_axe SET DEFAULT nextval('public.place_axe_id_place_axe_seq'::regclass);


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
-- Name: product_purchases pk_product_purchase; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_purchases
    ADD CONSTRAINT pk_product_purchase PRIMARY KEY (id_product_purchase);


--
-- Name: product_units pk_product_unit; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_units
    ADD CONSTRAINT pk_product_unit PRIMARY KEY (id_unit);


--
-- Name: stock_products pk_stock_product; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.stock_products
    ADD CONSTRAINT pk_stock_product PRIMARY KEY (id_stock_product);


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
-- Name: product_purchases trigger_format_id_product_purchase; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_product_purchase BEFORE INSERT ON public.product_purchases FOR EACH ROW EXECUTE FUNCTION public.format_id_product_purchase();


--
-- Name: stock_products trigger_format_id_stock_product; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_format_id_stock_product BEFORE INSERT ON public.stock_products FOR EACH ROW EXECUTE FUNCTION public.format_id_stock_product();


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
-- Name: product_purchases fk_product_purchase_product; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_purchases
    ADD CONSTRAINT fk_product_purchase_product FOREIGN KEY (product_id) REFERENCES public.products(id_product);


--
-- Name: stock_products fk_stock_product_product; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.stock_products
    ADD CONSTRAINT fk_stock_product_product FOREIGN KEY (product_id) REFERENCES public.products(id_product);


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
-- Name: products unite_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT unite_id FOREIGN KEY (unit_id) REFERENCES public.product_units(id_unit);


--
-- PostgreSQL database dump complete
--

