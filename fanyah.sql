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

CREATE TABLE station(
   id_station INT AUTO_INCREMENT,
   station VARCHAR(50) NOT NULL,
   nif_stat VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_station),
   UNIQUE(station)
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
   prenoms VARCHAR(70),
   date_naissance DATE NOT NULL,
   cin VARCHAR(50) NOT NULL,
   mot_passe TEXT NOT NULL,
   id_sexe INT NOT NULL,
   id_role INT NOT NULL,
   id_situation_familial INT NOT NULL,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(matricule),
   UNIQUE(cin),
   UNIQUE(mot_passe),
   FOREIGN KEY(id_sexe) REFERENCES sexe(id_sexe),
   FOREIGN KEY(id_role) REFERENCES role(id_role),
   FOREIGN KEY(id_situation_familial) REFERENCES situation_familial(id_situation_familial)
);

CREATE TABLE navire(
   id_navire INT AUTO_INCREMENT,
   navire VARCHAR(50) NOT NULL,
   nb_compartiment INT NOT NULL,
   quantite_max DECIMAL(10,2),
   id_type_navire INT NOT NULL,
   PRIMARY KEY(id_navire),
   UNIQUE(navire),
   FOREIGN KEY(id_type_navire) REFERENCES type_navire(id_type_navire)
);

CREATE TABLE mouvement_navire(
   id_mouvement_navire INT AUTO_INCREMENT,
   date_arriver DATE NOT NULL,
   date_depart VARCHAR(50),
   id_navire INT NOT NULL,
   PRIMARY KEY(id_mouvement_navire),
   FOREIGN KEY(id_navire) REFERENCES navire(id_navire)
);

CREATE TABLE prevision(
   id_prevision INT AUTO_INCREMENT,
   annee INT NOT NULL,
   quota INT,
   id_station INT NOT NULL,
   id_navire INT NOT NULL,
   PRIMARY KEY(id_prevision),
   FOREIGN KEY(id_station) REFERENCES station(id_station),
   FOREIGN KEY(id_navire) REFERENCES navire(id_navire)
);

CREATE TABLE entree_magasin(
   id_entree_magasin INT AUTO_INCREMENT,
   numero_camion VARCHAR(50) NOT NULL,
   bon_livraison VARCHAR(50) NOT NULL,
   chauffeur VARCHAR(60) NOT NULL,
   quantite_palette INT NOT NULL,
   date_entrant DATE NOT NULL,
   id_utilisateur INT NOT NULL,
   id_station INT NOT NULL,
   id_magasin INT NOT NULL,
   PRIMARY KEY(id_entree_magasin),
   UNIQUE(bon_livraison),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_station) REFERENCES station(id_station),
   FOREIGN KEY(id_magasin) REFERENCES magasin(id_magasin)
);

CREATE TABLE sortant_magasin(
   id_sortant_magasin INT AUTO_INCREMENT,
   quantite_sortie INT NOT NULL,
   date_sortie DATE NOT NULL,
   id_entree_magasin INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_sortant_magasin),
   FOREIGN KEY(id_entree_magasin) REFERENCES entree_magasin(id_entree_magasin),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE compartiment_navire(
   id_compartiment_navire INT AUTO_INCREMENT,
   quantite_max DECIMAL(15,2) NOT NULL,
   id_navire INT NOT NULL,
   PRIMARY KEY(id_compartiment_navire),
   FOREIGN KEY(id_navire) REFERENCES navire(id_navire)
);

CREATE TABLE palette_navire(
   id_palette_navire INT AUTO_INCREMENT,
   quantite INT NOT NULL,
   id_utilisateur INT NOT NULL,
   id_mouvement_navire INT NOT NULL,
   id_compartiment_navire INT NOT NULL,
   id_station INT NOT NULL,
   PRIMARY KEY(id_palette_navire),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id_utilisateur),
   FOREIGN KEY(id_mouvement_navire) REFERENCES mouvement_navire(id_mouvement_navire),
   FOREIGN KEY(id_compartiment_navire) REFERENCES compartiment_navire(id_compartiment_navire),
   FOREIGN KEY(id_station) REFERENCES station(id_station)
);