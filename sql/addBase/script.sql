create or replace view v_mouvement_navire as
select
    c.id_compagne, c.annee, c.debut, c.fin, c.etat,
    n.id_navire, n.navire, n.nb_compartiment, n.quantite_max,
    mn.date_arriver, mn.date_depart, mn.id_mouvement_navire
from
    mouvement_navire mn
join compagne c on c.id_compagne = mn.compagne_id
join navire n on n.id_navire = mn.navire_id;


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

