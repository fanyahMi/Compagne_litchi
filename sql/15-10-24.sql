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
   fin date not null,
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
    compagne_id INt not null,
    station_id int not null,
    numero_station INT not null,
    PRIMARY KEY(id_numero_station),
    UNIQUE(compagne_id,numero_station),
    FOREIGN KEY(station_id) REFERENCES station(id_station),
    FOREIGN KEY(compagne_id) REFERENCES compagne(id_compagne)
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
