CREATE TABLE situation_familial(
   id_situation_familial INT AUTO_INCREMENT,
   situation_familial CHAR(60) NOT NULL,
   PRIMARY KEY(id_situation_familial),
   UNIQUE(situation_familial)
);

CREATE TABLE sexe(
   id_sexe INT AUTO_INCREMENT,
   sexe VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_sexe),
   UNIQUE(sexe)
);

CREATE TABLE role(
   id_role INT AUTO_INCREMENT,
   role VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_role),
   UNIQUE(role)
);

CREATE TABLE type_navire(
   id_type_navire INT AUTO_INCREMENT,
   type_navire VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_type_navire),
   UNIQUE(type_navire)
);

CREATE TABLE compagne(
   id_compagne INT AUTO_INCREMENT,
   annee int NOT NULL,
   debut date not null,
   fin date,
   etat int default 0,
   PRIMARY KEY(id_compagne),
   UNIQUE(annee)
);

CREATE TABLE station(
   id_station INT AUTO_INCREMENT,
   station VARCHAR(50) NOT NULL,
   nif_stat VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_station),
   UNIQUE(station)
);

create table numero_station(
    id_numero_station Int AUTO_INCREMENT,
    compagne_id INt not null REFERENCES compagne(id_compagne),
    station_id int not null REFERENCES station(id_station),
    numero_station INT not null,
    PRIMARY KEY(id_numero_station),
    UNIQUE(compagne_id,numero_station)
);

CREATE TABLE magasin(
   id_magasin INT AUTO_INCREMENT,
   magasin VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_magasin),
   UNIQUE(magasin)
);

CREATE TABLE utilisateur(
   id_utilisateur INT AUTO_INCREMENT,
   matricule VARCHAR(20) NOT NULL,
   nom VARCHAR(70) NOT NULL,
   prenom VARCHAR(70),
   date_naissance DATE NOT NULL,
   cin VARCHAR(50) NOT NULL,
   mot_passe TEXT NOT NULL,
   sexe_id INT NOT NULL,
   role_id INT NOT NULL,
   situation_familial_id INT NOT NULL,
   created_at timestamp not null,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(matricule),
   UNIQUE(cin),
   UNIQUE(mot_passe),
   FOREIGN KEY(sexe_id) REFERENCES sexe(id_sexe),
   FOREIGN KEY(role_id) REFERENCES role(id_role),
   FOREIGN KEY(situation_familial_id) REFERENCES situation_familial(id_situation_familial)
);

CREATE TABLE navire(
   id_navire INT AUTO_INCREMENT,
   navire VARCHAR(50) NOT NULL,
   nb_compartiment INT NOT NULL,
   quantite_max DECIMAL(10,2),
   type_navire_id INT NOT NULL,
   PRIMARY KEY(id_navire),
   UNIQUE(navire),
   FOREIGN KEY(type_navire_id) REFERENCES type_navire(id_type_navire)
);

CREATE TABLE quotas (
    id_quotas INT AUTO_INCREMENT,
    navire_id INT NOT NULL,
    numero_station_id INT NOT NULL,
    quotas DECIMAL(30,2) NOT NULL,
    PRIMARY KEY (id_quotas),
    FOREIGN KEY (navire_id) REFERENCES navire(id_navire),
    FOREIGN KEY (numero_station_id) REFERENCES numero_station(id_numero_station)
) ;

CREATE TABLE mouvement_navire(
   id_mouvement_navire INT AUTO_INCREMENT,
   compagne_id int not null,
   date_arriver DATE NOT NULL,
   date_depart VARCHAR(50),
   navire_id INT NOT NULL,
   PRIMARY KEY(id_mouvement_navire),
   FOREIGN KEY(compagne_id) REFERENCES compagne(id_compagne),
   FOREIGN KEY(navire_id) REFERENCES navire(id_navire)
);

CREATE TABLE entree_magasin(
   id_entree_magasin INT AUTO_INCREMENT,
   numero_camion VARCHAR(50) NOT NULL,
   bon_livraison VARCHAR(50) NOT NULL,
   path_bon_livraison text NOT NULL,
   chauffeur VARCHAR(60) NOT NULL,
   quantite_palette real NOT NULL,
   date_entrant DATE NOT NULL,
   agent_id INT NOT NULL,
   numero_station_id INT NOT NULL,
   magasin_id INT NOT NULL,
   navire_id INT NOT NULL,
   PRIMARY KEY(id_entree_magasin),
   UNIQUE(bon_livraison),
   FOREIGN KEY(agent_id) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY( numero_station_id) REFERENCES  numero_station(id_numero_station),
    FOREIGN KEY ( navire_id ) REFERENCES navire( id_navire ),
   FOREIGN KEY(magasin_id) REFERENCES magasin(id_magasin)
);

CREATE TABLE sortant_magasin(
   id_sortant_magasin INT AUTO_INCREMENT,
   quantite_sortie INT NOT NULL,
   date_sortie DATE NOT NULL,
   entree_magasin_id INT NOT NULL,
   agent_id INT NOT NULL,
   PRIMARY KEY(id_sortant_magasin),
   FOREIGN KEY(entree_magasin_id) REFERENCES entree_magasin(id_entree_magasin),
   FOREIGN KEY(agent_id) REFERENCES utilisateur(id_utilisateur)
);

-- Table situation_familial
INSERT INTO situation_familial (situation_familial) VALUES
('Célibataire'),
('Marié'),
('Divorcé'),
('Veuf');

-- Table sexe
INSERT INTO sexe (sexe) VALUES
('Homme'),
('Femme');

-- Table role
INSERT INTO role (role) VALUES
('Administrateur'),
('Agent_entree'),
('Agent_sortie'),
('Agent_embarquement');

-- Table type_navire
INSERT INTO type_navire (type_navire) VALUES
('Pêcheur'),
('Transporteur'),
('Remorqueur');


-- Table magasin
INSERT INTO magasin (magasin) VALUES
('Magasin Principal'),
('Magasin Secondaire');

-- Table utilisateur
INSERT INTO utilisateur (matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at) VALUES
('M1234', 'Dupont', 'Jean', '1990-05-15', 'CIN1234', 'password123', 1, 1, 1, CURRENT_TIMESTAMP),
('M5678', 'Durand', 'Marie', '1985-03-22', 'CIN5678', 'password456', 2, 2, 2, CURRENT_TIMESTAMP);

INSERT INTO utilisateur (matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at) VALUES
('M1236', 'Luc', 'Jean', '1990-05-15', 'CIN1234345', 'password123234', 1, 4, 1, CURRENT_TIMESTAMP),
('M5671', 'Mathieu', 'Marie', '1985-03-22', 'CIN56783144', 'password45642', 2, 3, 2, CURRENT_TIMESTAMP);




create or replace view v_utilisateur_global as
select
    u.id_utilisateur, u.matricule, u.nom, u.prenom, u.date_naissance, u.cin, u.mot_passe,
    u.sexe_id, s.sexe,
    u.role_id, r.role,
    u.situation_familial_id, st.situation_familial
from utilisateur u
join sexe s on s.id_sexe = u.sexe_id
join role r on r.id_role = u.role_id
join situation_familial st on st.id_situation_familial = u.situation_familial_id ;




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
     n.id_navire, n.navire,q.id_quotas, q.quotas
from quotas q
join v_station_numero_compagne v on v.id_numero_station = q.numero_station_id
join navire n on n.id_navire = q.navire_id;

CREATE  TABLE importation_quotas (
    station VARCHAR(50),
    compagne_id  int,
    numero_station int,
    navire VARCHAR(50),
    quotas  DECIMAL(30,2)
);

create table shift(
    id_shift int AUTO_INCREMENT PRIMARY key,
    description text not null,
    debut time,
    fin time
);



CREATE TABLE embarquement(
   id_embarquement INT AUTO_INCREMENT,
   utilisateur_id int not null,
   shift_id int not null,
   navire_id int not null,
   numero_cal int not null,
   nombre_pallets int not null,
   numero_station_id int not null,
   PRIMARY KEY(id_embarquement),
   FOREIGN KEY(utilisateur_id) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(shift_id) REFERENCES shift(id_shift),
   FOREIGN KEY(numero_station_id) REFERENCES numero_station(id_numero_station),
   FOREIGN KEY(navire_id) REFERENCES navire(id_navire)
);

ALTER TABLE embarquement
ADD COLUMN date_embarquement DATE DEFAULT CURRENT_DATE,
ADD COLUMN heure_embarquement TIME DEFAULT CURRENT_TIME;


create or replace view  v_historique_embarquement as
select
    e.id_embarquement,
    c.id_compagne , c.annee, c.etat as etat_campagne,
    s.id_shift, s.description,
    n.id_navire, n.navire, n.nb_compartiment,  e.numero_cal,
    u.id_utilisateur, u.matricule, CONCAT(u.nom, '-' , u.prenom) as agent,
    c.station, c.id_station, c.numero_station,
    e.date_embarquement, e.heure_embarquement,
    (e.nombre_pallets), (e.nombre_pallets * 1000) as quantite
from embarquement e
join v_utilisateur_global u on u.id_utilisateur = e.utilisateur_id
join v_station_numero_compagne c on c.id_numero_station = e.numero_station_id
join shift s on s.id_shift = e.shift_id
join navire n on n.id_navire = e.navire_id;

create or replace view v_historique_embarquement_navire as
select
    h.id_compagne, h.annee, h.etat_campagne,
    h.id_navire, h.navire, h.numero_cal,
    h.station, h.id_station,
    h.numero_station,
    sum(h.nombre_pallets) as totat_pallets,
    sum(h.quantite) as total_quantite
from v_historique_embarquement h
group by
     h.id_compagne, h.annee, h.etat_campagne,
    h.id_navire, h.navire,
    h.station, h.numero_station,  h.numero_cal;

create or replace view v_liste_numero_cale_navire as
WITH RECURSIVE number_series AS (
    SELECT 1 AS num
    UNION ALL
    SELECT num + 1
    FROM number_series
    WHERE num <= (SELECT MAX(nb_compartiment) FROM navire)
)
SELECT
    n.id_navire,
    n.navire,
    ns.num AS numero_cale
FROM
    navire n
JOIN
    number_series ns
    ON ns.num <= n.nb_compartiment
ORDER BY
    n.id_navire, n.navire,ns.num;


create or replace view v_quantite_cales as
SELECT
    c.id_navire,
    c.navire,
    c.numero_cale,
    COALESCE(SUM(eh.nombre_pallets), 0) AS total_pallets,
    COALESCE(SUM(eh.quantite), 0) AS total_quantite
FROM
    v_liste_numero_cale_navire c
LEFT JOIN
    v_historique_embarquement eh
    ON eh.id_navire = c.id_navire
    AND eh.numero_cal = c.numero_cale  -- Correction ici
GROUP BY
    c.id_navire,
    c.navire,
    c.numero_cale;


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


create or replace view v_mouvement_navire as
select
    c.id_compagne, c.annee, c.debut, c.fin, c.etat,
    n.id_navire, n.navire, n.nb_compartiment, n.quantite_max,
    mn.date_arriver, mn.date_depart, mn.id_mouvement_navire,
    coalesce(
       ( select sum(e.nombre_pallets)
        from v_historique_embarquement e
        where e.id_compagne = c.id_compagne
            and e.id_navire = n.id_navire), 0
    ) as quantite_embarque
from
    mouvement_navire mn
join compagne c on c.id_compagne = mn.compagne_id
join navire n on n.id_navire = mn.navire_id;
