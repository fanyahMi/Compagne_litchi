create or replace view v_mouvement_navire as
select
    c.id_compagne, c.annee, c.debut, c.fin, c.etat,
    n.id_navire, n.navire, n.nb_compartiment, n.quantite_max,
    mn.date_arriver, mn.date_depart
from
    mouvement_navire mn
join compagne c on c.id_compagne = mn.compagne_id
join navire n on n.id_navire = mn.navire_id;


CREATE TABLE embarquement(
   id_embarquement INT AUTO_INCREMENT,
   utilisateur_id int not null,
   compagne_id int not null,
   shift_id int not null,
   station_id int not null,
   navire_id int not null,
   numero_cal int not null,
   nombre_pallets int not null,
   PRIMARY KEY(id_embarquement),
   FOREIGN KEY(utilisateur_id) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(compagne_id) REFERENCES compagne(id_compagne),
   FOREIGN KEY(shift_id) REFERENCES shift(id_shift),
   FOREIGN KEY(station_id) REFERENCES station(id_station),
   FOREIGN KEY(navire_id) REFERENCES navire(id_navire)
);

ALTER TABLE embarquement
ADD COLUMN date_embarquement DATE DEFAULT CURRENT_DATE,
ADD COLUMN heure_embarquement TIME DEFAULT CURRENT_TIME;


create or replace view  v_historique_embarquement as
select
    e.id_embarquement,
    c.id_compagne, c.annee, c.etat as etat_campagne,
    s.id_shift, s.description,
    n.id_navire, n.navire, n.nb_compartiment,  e.numero_cal,
    u.id_utilisateur, u.matricule, (u.nom || '-' || u.prenom) as agent,
    st.station, st.id_station, st.numero_station,
    e.date_embarquement, e.heure_embarquement,
    (e.nombre_pallets), (e.nombre_pallets * 1000) as quantite
from embarquement e
join v_utilisateur_global u on u.id_utilisateur = e.utilisateur_id
join compagne c on c.id_compagne = e.compagne_id
join shift s on s.id_shift = e.shift_id
join v_station_numero_compagne st
    on st.id_station = e.station_id
    and st.id_compagne = e.compagne_id
join navire n on n.navire = e.navire_id;

create or replace view v_historique_embarquement_navire as
select
    h.id_compagne, h.annee, h.etat_campagne,
    h.id_navire, h.navire, h.numero_cal,
    h.station, h.id_station,
    h.numero_station,
    h.date_embarquement, h.heure_embarquement,
    sum(h.nombre_pallets) as totat_pallets,
    sum(h.quantite) as total_quantite
from v_historique_embarquement h
group by
     h.id_compagne, h.annee, h.etat_campagne,
    h.id_navire, h.navire,
    h.station, h.numero_station,
    h.date_embarquement, h.heure_embarquement;

