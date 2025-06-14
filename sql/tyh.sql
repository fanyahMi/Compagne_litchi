CREATE SCHEMA soutenance;

CREATE  TABLE soutenance.compagne (
	id_compagne          INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	annee                INT    NOT NULL   ,
	debut                DATE    NOT NULL   ,
	fin                  DATE       ,
	etat                 INT  DEFAULT 0     ,
	CONSTRAINT annee UNIQUE ( annee )
 ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.embarquement (
	id_embarquement      INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	utilisateur_id       INT    NOT NULL   ,
	shift_id             INT    NOT NULL   ,
	navire_id            INT    NOT NULL   ,
	numero_cal           INT    NOT NULL   ,
	nombre_pallets       INT    NOT NULL   ,
	numero_station_id    INT    NOT NULL   ,
	date_embarquement    DATE  DEFAULT curdate()     ,
	heure_embarquement   TIME  DEFAULT curtime()
 ) ENGINE=MyISAM AUTO_INCREMENT=532 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX utilisateur_id ON soutenance.embarquement ( utilisateur_id );

CREATE INDEX shift_id ON soutenance.embarquement ( shift_id );

CREATE INDEX navire_id ON soutenance.embarquement ( navire_id );

CREATE INDEX numero_station_id ON soutenance.embarquement ( numero_station_id );

CREATE  TABLE soutenance.entree_magasin (
	id_entree_magasin    INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	numero_camion        VARCHAR(50)    NOT NULL   ,
	bon_livraison        VARCHAR(50)    NOT NULL   ,
	path_bon_livraison   TEXT    NOT NULL   ,
	chauffeur            VARCHAR(60)    NOT NULL   ,
	quantite_palette     DOUBLE    NOT NULL   ,
	date_entrant         DATE    NOT NULL   ,
	agent_id             INT    NOT NULL   ,
	numero_station_id    INT    NOT NULL   ,
	magasin_id           INT    NOT NULL   ,
	navire_id            INT    NOT NULL   ,
	shift_id             INT    NOT NULL   ,
	CONSTRAINT bon_livraison UNIQUE ( bon_livraison )
 ) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX agent_id ON soutenance.entree_magasin ( agent_id );

CREATE INDEX numero_station_id ON soutenance.entree_magasin ( numero_station_id );

CREATE INDEX navire_id ON soutenance.entree_magasin ( navire_id );

CREATE INDEX shift_id ON soutenance.entree_magasin ( shift_id );

CREATE INDEX magasin_id ON soutenance.entree_magasin ( magasin_id );

CREATE  TABLE soutenance.importation_quotas (
	station              VARCHAR(50)       ,
	compagne_id          INT       ,
	numero_station       INT       ,
	navire               VARCHAR(50)       ,
	quotas               DECIMAL(30,2)
 ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.magasin (
	id_magasin           INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	magasin              VARCHAR(50)    NOT NULL   ,
	CONSTRAINT magasin UNIQUE ( magasin )
 ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.mouvement_navire (
	id_mouvement_navire  INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	compagne_id          INT    NOT NULL   ,
	date_arriver         DATE    NOT NULL   ,
	date_depart          VARCHAR(50)       ,
	navire_id            INT    NOT NULL
 ) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX compagne_id ON soutenance.mouvement_navire ( compagne_id );

CREATE INDEX navire_id ON soutenance.mouvement_navire ( navire_id );

CREATE  TABLE soutenance.navire (
	id_navire            INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	navire               VARCHAR(50)    NOT NULL   ,
	nb_compartiment      INT    NOT NULL   ,
	quantite_max         DECIMAL(10,2)       ,
	type_navire_id       INT    NOT NULL   ,
	CONSTRAINT navire UNIQUE ( navire )
 ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX type_navire_id ON soutenance.navire ( type_navire_id );

CREATE  TABLE soutenance.numero_station (
	id_numero_station    INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	compagne_id          INT    NOT NULL   ,
	station_id           INT    NOT NULL   ,
	numero_station       INT    NOT NULL   ,
	CONSTRAINT compagne_id UNIQUE ( compagne_id, numero_station )
 ) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX station_id ON soutenance.numero_station ( station_id );

CREATE  TABLE soutenance.quotas (
	id_quotas            INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	navire_id            INT    NOT NULL   ,
	numero_station_id    INT    NOT NULL   ,
	quotas               DECIMAL(30,2)    NOT NULL
 ) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX navire_id ON soutenance.quotas ( navire_id );

CREATE INDEX numero_station_id ON soutenance.quotas ( numero_station_id );

CREATE  TABLE soutenance.role (
	id_role              INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	role                 VARCHAR(50)    NOT NULL   ,
	CONSTRAINT role UNIQUE ( role )
 ) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.sexe (
	id_sexe              INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	sexe                 VARCHAR(50)    NOT NULL   ,
	CONSTRAINT sexe UNIQUE ( sexe )
 ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.shift (
	id_shift             INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	description          TEXT    NOT NULL   ,
	debut                TIME       ,
	fin                  TIME
 ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.situation_familial (
	id_situation_familial INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	situation_familial   CHAR(60)    NOT NULL   ,
	CONSTRAINT situation_familial UNIQUE ( situation_familial )
 ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.sortant_magasin (
	id_sortant_magasin   INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	quantite_sortie      INT    NOT NULL   ,
	date_sortie          DATE    NOT NULL   ,
	entree_magasin_id    INT    NOT NULL   ,
	agent_id             INT    NOT NULL   ,
	shift_id             INT    NOT NULL
 ) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX entree_magasin_id ON soutenance.sortant_magasin ( entree_magasin_id );

CREATE INDEX shift_id ON soutenance.sortant_magasin ( shift_id );

CREATE INDEX agent_id ON soutenance.sortant_magasin ( agent_id );

CREATE  TABLE soutenance.station (
	id_station           INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	station              VARCHAR(50)    NOT NULL   ,
	nif_stat             VARCHAR(50)    NOT NULL   ,
	CONSTRAINT station UNIQUE ( station )
 ) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.type_navire (
	id_type_navire       INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	type_navire          VARCHAR(50)    NOT NULL   ,
	CONSTRAINT type_navire UNIQUE ( type_navire )
 ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE  TABLE soutenance.utilisateur (
	id_utilisateur       INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	matricule            VARCHAR(20)    NOT NULL   ,
	nom                  VARCHAR(70)    NOT NULL   ,
	prenom               VARCHAR(70)       ,
	date_naissance       DATE    NOT NULL   ,
	cin                  VARCHAR(50)    NOT NULL   ,
	mot_passe            TEXT    NOT NULL   ,
	sexe_id              INT    NOT NULL   ,
	role_id              INT    NOT NULL   ,
	situation_familial_id INT    NOT NULL   ,
	created_at           TIMESTAMP    NOT NULL   ,
	CONSTRAINT matricule UNIQUE ( matricule ) ,
	CONSTRAINT cin UNIQUE ( cin ) ,
	CONSTRAINT mot_passe UNIQUE ( mot_passe ) USING HASH
 ) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE INDEX sexe_id ON soutenance.utilisateur ( sexe_id );

CREATE INDEX role_id ON soutenance.utilisateur ( role_id );

CREATE INDEX situation_familial_id ON soutenance.utilisateur ( situation_familial_id );

CREATE VIEW soutenance.v_liste_numero_cale_navire AS with recursive number_series as (select 1 AS `num` union all select `number_series`.`num` + 1 AS `num + 1` from `number_series` where `number_series`.`num` <= (select max(`soutenance`.`navire`.`nb_compartiment`) from `soutenance`.`navire`))select `n`.`id_navire` AS `id_navire`,`n`.`navire` AS `navire`,`ns`.`num` AS `numero_cale` from (`soutenance`.`navire` `n` join `number_series` `ns` on(`ns`.`num` <= `n`.`nb_compartiment`)) order by `n`.`id_navire`,`n`.`navire`,`ns`.`num`;

CREATE VIEW soutenance.v_palette_entree AS select `e`.`numero_station_id` AS `numero_station_id`,`e`.`navire_id` AS `navire_id`,sum(`e`.`quantite_palette`) AS `somme_quantite_palette` from `soutenance`.`entree_magasin` `e` group by `e`.`numero_station_id`,`e`.`navire_id`;

CREATE VIEW soutenance.v_quotas_navire_compagne AS select `c`.`id_compagne` AS `id_compagne`,`c`.`annee` AS `annee`,`nv`.`id_navire` AS `id_navire`,`nv`.`navire` AS `navire`,`nv`.`nb_compartiment` AS `nb_compartiment`,`nv`.`quantite_max` AS `quantite_max`,sum(`q`.`quotas`) AS `quotas_navire` from (((`soutenance`.`quotas` `q` join `soutenance`.`navire` `nv` on(`q`.`navire_id` = `nv`.`id_navire`)) join `soutenance`.`numero_station` `n` on(`q`.`numero_station_id` = `n`.`id_numero_station`)) join `soutenance`.`compagne` `c` on(`n`.`compagne_id` = `c`.`id_compagne`)) group by `c`.`id_compagne`,`c`.`annee`,`nv`.`id_navire`,`nv`.`navire`,`nv`.`nb_compartiment`,`nv`.`quantite_max`;

CREATE VIEW soutenance.v_station_numero_compagne AS select `s`.`id_station` AS `id_station`,`s`.`station` AS `station`,`c`.`id_compagne` AS `id_compagne`,`c`.`annee` AS `annee`,`c`.`debut` AS `debut`,`c`.`fin` AS `fin`,`c`.`etat` AS `etat`,`ns`.`id_numero_station` AS `id_numero_station`,`ns`.`numero_station` AS `numero_station` from ((`soutenance`.`numero_station` `ns` join `soutenance`.`station` `s` on(`s`.`id_station` = `ns`.`station_id`)) join `soutenance`.`compagne` `c` on(`c`.`id_compagne` = `ns`.`compagne_id`));

CREATE VIEW soutenance.v_utilisateur_global AS select `u`.`id_utilisateur` AS `id_utilisateur`,`u`.`matricule` AS `matricule`,`u`.`nom` AS `nom`,`u`.`prenom` AS `prenom`,`u`.`date_naissance` AS `date_naissance`,`u`.`cin` AS `cin`,`u`.`mot_passe` AS `mot_passe`,`u`.`sexe_id` AS `sexe_id`,`s`.`sexe` AS `sexe`,`u`.`role_id` AS `role_id`,`r`.`role` AS `role`,`u`.`situation_familial_id` AS `situation_familial_id`,`st`.`situation_familial` AS `situation_familial` from (((`soutenance`.`utilisateur` `u` join `soutenance`.`sexe` `s` on(`s`.`id_sexe` = `u`.`sexe_id`)) join `soutenance`.`role` `r` on(`r`.`id_role` = `u`.`role_id`)) join `soutenance`.`situation_familial` `st` on(`st`.`id_situation_familial` = `u`.`situation_familial_id`));

CREATE VIEW soutenance.v_historique_embarquement AS select `e`.`id_embarquement` AS `id_embarquement`,`c`.`id_compagne` AS `id_compagne`,`c`.`annee` AS `annee`,`c`.`etat` AS `etat_campagne`,`s`.`id_shift` AS `id_shift`,`s`.`description` AS `description`,`n`.`id_navire` AS `id_navire`,`n`.`navire` AS `navire`,`n`.`nb_compartiment` AS `nb_compartiment`,`e`.`numero_cal` AS `numero_cal`,`u`.`id_utilisateur` AS `id_utilisateur`,`u`.`matricule` AS `matricule`,concat(`u`.`nom`,'-',`u`.`prenom`) AS `agent`,`c`.`station` AS `station`,`c`.`id_station` AS `id_station`,`c`.`numero_station` AS `numero_station`,`e`.`date_embarquement` AS `date_embarquement`,`e`.`heure_embarquement` AS `heure_embarquement`,`e`.`nombre_pallets` AS `nombre_pallets`,`e`.`nombre_pallets` * 1000 AS `quantite` from ((((`soutenance`.`embarquement` `e` join `soutenance`.`v_utilisateur_global` `u` on(`u`.`id_utilisateur` = `e`.`utilisateur_id`)) join `soutenance`.`v_station_numero_compagne` `c` on(`c`.`id_numero_station` = `e`.`numero_station_id`)) join `soutenance`.`shift` `s` on(`s`.`id_shift` = `e`.`shift_id`)) join `soutenance`.`navire` `n` on(`n`.`id_navire` = `e`.`navire_id`));

CREATE VIEW soutenance.v_historique_embarquement_navire AS select `h`.`id_compagne` AS `id_compagne`,`h`.`annee` AS `annee`,`h`.`etat_campagne` AS `etat_campagne`,`h`.`id_navire` AS `id_navire`,`h`.`navire` AS `navire`,`h`.`numero_cal` AS `numero_cal`,`h`.`station` AS `station`,`h`.`id_station` AS `id_station`,`h`.`numero_station` AS `numero_station`,sum(`h`.`nombre_pallets`) AS `totat_pallets`,sum(`h`.`quantite`) AS `total_quantite` from `soutenance`.`v_historique_embarquement` `h` group by `h`.`id_compagne`,`h`.`annee`,`h`.`etat_campagne`,`h`.`id_navire`,`h`.`navire`,`h`.`station`,`h`.`numero_station`,`h`.`numero_cal`;

CREATE VIEW soutenance.v_mouvement_magasin AS select `em`.`id_entree_magasin` AS `id_entree_magasin`,`em`.`chauffeur` AS `chauffeur`,`em`.`numero_camion` AS `numero_camion`,`em`.`bon_livraison` AS `bon_livraison`,`em`.`path_bon_livraison` AS `path_bon_livraison`,`em`.`quantite_palette` AS `quantite_palette`,`em`.`date_entrant` AS `date_entrant`,`em`.`agent_id` AS `id_ag_entrant`,`ag`.`matricule` AS `matricule_entrant`,`ag`.`nom` AS `nom_entrant`,`ns`.`id_station` AS `id_station`,`ns`.`station` AS `station`,`ns`.`numero_station` AS `numero_station`,`em`.`magasin_id` AS `magasin_id`,`m`.`magasin` AS `magasin`,`em`.`navire_id` AS `navire_id`,`n`.`navire` AS `navire`,`sm`.`id_sortant_magasin` AS `id_sortant_magasin`,`sm`.`quantite_sortie` AS `quantite_sortie`,`sm`.`date_sortie` AS `date_sortie`,`sm`.`agent_id` AS `id_ag_sortant`,`ag1`.`matricule` AS `matricule_sortant`,`ag1`.`nom` AS `nom_sortant`,`s`.`id_shift` AS `id_shift`,`s`.`description` AS `description`,`s`.`debut` AS `debut`,`s`.`fin` AS `fin`,`ns`.`id_compagne` AS `id_compagne`,`ns`.`annee` AS `annee`,`ns`.`etat` AS `etat`,`ss`.`id_shift` AS `id_shift_sortie`,`ss`.`description` AS `description_sortie`,`ss`.`debut` AS `debut_sortie`,`ss`.`fin` AS `fin_sortie` from ((((((((`soutenance`.`entree_magasin` `em` join `soutenance`.`v_station_numero_compagne` `ns` on(`em`.`numero_station_id` = `ns`.`id_numero_station`)) left join `soutenance`.`sortant_magasin` `sm` on(`sm`.`entree_magasin_id` = `em`.`id_entree_magasin`)) join `soutenance`.`magasin` `m` on(`m`.`id_magasin` = `em`.`magasin_id`)) left join `soutenance`.`v_utilisateur_global` `ag` on(`ag`.`id_utilisateur` = `em`.`agent_id`)) left join `soutenance`.`v_utilisateur_global` `ag1` on(`ag1`.`id_utilisateur` = `sm`.`agent_id`)) join `soutenance`.`navire` `n` on(`n`.`id_navire` = `em`.`navire_id`)) join `soutenance`.`shift` `s` on(`s`.`id_shift` = `em`.`shift_id`)) left join `soutenance`.`shift` `ss` on(`ss`.`id_shift` = `sm`.`shift_id`));

CREATE VIEW soutenance.v_mouvement_navire AS select `c`.`id_compagne` AS `id_compagne`,`c`.`annee` AS `annee`,`c`.`debut` AS `debut`,`c`.`fin` AS `fin`,`c`.`etat` AS `etat`,`n`.`id_navire` AS `id_navire`,`n`.`navire` AS `navire`,`n`.`nb_compartiment` AS `nb_compartiment`,`n`.`quantite_max` AS `quantite_max`,`mn`.`date_arriver` AS `date_arriver`,`mn`.`date_depart` AS `date_depart`,`mn`.`id_mouvement_navire` AS `id_mouvement_navire`,coalesce((select sum(`e`.`nombre_pallets`) from `soutenance`.`v_historique_embarquement` `e` where `e`.`id_compagne` = `c`.`id_compagne` and `e`.`id_navire` = `n`.`id_navire`),0) AS `quantite_embarque` from ((`soutenance`.`mouvement_navire` `mn` join `soutenance`.`compagne` `c` on(`c`.`id_compagne` = `mn`.`compagne_id`)) join `soutenance`.`navire` `n` on(`n`.`id_navire` = `mn`.`navire_id`));

CREATE VIEW soutenance.v_quantite_cales AS select `c`.`id_compagne` AS `id_compagne`,`c`.`annee` AS `annee`,`n`.`id_navire` AS `id_navire`,`n`.`navire` AS `navire`,`n`.`numero_cale` AS `numero_cale`,coalesce(sum(`h`.`totat_pallets`),0) AS `total_pallets` from ((`soutenance`.`compagne` `c` join `soutenance`.`v_liste_numero_cale_navire` `n`) left join `soutenance`.`v_historique_embarquement_navire` `h` on(`h`.`id_compagne` = `c`.`id_compagne` and `h`.`id_navire` = `n`.`id_navire` and `h`.`numero_cal` = `n`.`numero_cale`)) group by `c`.`id_compagne`,`c`.`annee`,`n`.`id_navire`,`n`.`navire`,`n`.`numero_cale`;

CREATE VIEW soutenance.v_quotas_station AS select `v`.`id_station` AS `id_station`,`v`.`station` AS `station`,`v`.`id_numero_station` AS `id_numero_station`,`v`.`numero_station` AS `numero_station`,`v`.`id_compagne` AS `id_compagne`,`v`.`annee` AS `annee`,`n`.`id_navire` AS `id_navire`,`n`.`navire` AS `navire`,`q`.`id_quotas` AS `id_quotas`,`q`.`quotas` AS `quotas` from ((`soutenance`.`quotas` `q` join `soutenance`.`v_station_numero_compagne` `v` on(`v`.`id_numero_station` = `q`.`numero_station_id`)) join `soutenance`.`navire` `n` on(`n`.`id_navire` = `q`.`navire_id`)) order by `v`.`annee` desc;

CREATE VIEW soutenance.v_reste_palette_station AS select `q`.`id_station` AS `id_station`,`q`.`station` AS `station`,`q`.`id_numero_station` AS `id_numero_station`,`q`.`numero_station` AS `numero_station`,`q`.`id_navire` AS `id_navire`,`q`.`navire` AS `navire`,`q`.`id_compagne` AS `id_compagne`,`q`.`annee` AS `annee`,sum(`q`.`quotas`) AS `quotas`,coalesce(`e`.`somme_quantite_palette`,0) AS `palette_entree`,sum(`q`.`quotas`) - coalesce(`e`.`somme_quantite_palette`,0) AS `reste` from (`soutenance`.`v_quotas_station` `q` left join `soutenance`.`v_palette_entree` `e` on(`e`.`numero_station_id` = `q`.`id_numero_station` and `e`.`navire_id` = `q`.`id_navire`)) group by `q`.`id_station`,`q`.`station`,`q`.`numero_station`,`q`.`id_navire`,`q`.`navire`,`q`.`id_compagne`,`q`.`annee`,`e`.`somme_quantite_palette`;

CREATE VIEW soutenance.v_date_hist_embarquement AS select `h`.`id_compagne` AS `id_compagne`,`h`.`annee` AS `annee`,`h`.`id_navire` AS `id_navire`,`h`.`navire` AS `navire`,`h`.`date_embarquement` AS `date_embarquement`,concat(`s`.`id_station`,' / ',`s`.`station`) AS `station`,`s`.`id_station` AS `id_station` from (`soutenance`.`v_historique_embarquement` `h` join `soutenance`.`v_station_numero_compagne` `s` on(`h`.`id_compagne` = `s`.`id_compagne` and `h`.`annee` = `s`.`annee`)) group by `h`.`id_compagne`,`h`.`annee`,`h`.`navire`,`h`.`date_embarquement`,`s`.`id_station`,`s`.`station` order by `h`.`navire`,`s`.`id_station`,`h`.`date_embarquement`;

CREATE VIEW soutenance.v_date_station_cale AS select `dh`.`id_compagne` AS `id_compagne`,`dh`.`annee` AS `annee`,`dh`.`id_navire` AS `id_navire`,`dh`.`navire` AS `navire`,`dh`.`date_embarquement` AS `date_embarquement`,`dh`.`station` AS `station`,`dh`.`id_station` AS `id_station`,`h`.`id_shift` AS `id_shift`,`h`.`description` AS `shift`,`num`.`numero_cale` AS `numero_cale` from ((`soutenance`.`v_date_hist_embarquement` `dh` join `soutenance`.`v_liste_numero_cale_navire` `num` on(`num`.`id_navire` = `dh`.`id_navire`)) join `soutenance`.`shift` `h`) order by `dh`.`id_navire`,`dh`.`navire`,`dh`.`date_embarquement`,`dh`.`station`,`dh`.`id_station`,`h`.`id_shift`,`num`.`numero_cale`;

CREATE VIEW soutenance.v_rapport_embarquement AS select `ds`.`id_compagne` AS `id_compagne`,`ds`.`annee` AS `annee`,`ds`.`id_navire` AS `id_navire`,`ds`.`navire` AS `navire`,`ds`.`date_embarquement` AS `date_embarquement`,`ds`.`id_station` AS `id_station`,`ds`.`station` AS `station`,`ds`.`id_shift` AS `id_shift`,`ds`.`shift` AS `shift`,`ds`.`numero_cale` AS `numero_cale`,coalesce(sum(`he`.`nombre_pallets`),0) AS `total_palettes` from (`soutenance`.`v_date_station_cale` `ds` left join `soutenance`.`v_historique_embarquement` `he` on(`he`.`id_compagne` = `ds`.`id_compagne` and `he`.`id_navire` = `ds`.`id_navire` and `he`.`date_embarquement` = `ds`.`date_embarquement` and `he`.`id_station` = `ds`.`id_station` and `he`.`id_shift` = `ds`.`id_shift` and `he`.`numero_cal` = `ds`.`numero_cale`)) group by `ds`.`id_compagne`,`ds`.`annee`,`ds`.`id_navire`,`ds`.`navire`,`ds`.`date_embarquement`,`ds`.`id_station`,`ds`.`station`,`ds`.`id_shift`,`ds`.`shift`,`ds`.`numero_cale`;

INSERT INTO soutenance.compagne( id_compagne, annee, debut, fin, etat ) VALUES ( 1, 2024, '2024-11-03', null, 0);
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 133, 1, 1, 1, 3, 4, 3, '2025-06-06', '23:24:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 134, 2, 1, 2, 2, 4, 1, '2025-06-06', '14:40:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 135, 2, 3, 1, 4, 4, 3, '2025-06-06', '14:39:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 136, 2, 3, 1, 1, 4, 3, '2025-06-06', '11:20:29');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 137, 2, 3, 1, 4, 4, 3, '2025-06-06', '16:12:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 138, 2, 3, 1, 3, 3, 3, '2025-06-06', '03:50:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 139, 2, 1, 2, 3, 2, 3, '2025-06-06', '18:32:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 140, 4, 2, 1, 2, 4, 3, '2025-06-06', '06:10:24');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 141, 4, 2, 1, 3, 1, 3, '2025-06-06', '21:17:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 142, 4, 2, 1, 5, 4, 2, '2025-06-06', '23:32:10');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 143, 4, 2, 1, 4, 4, 2, '2025-06-06', '19:32:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 144, 4, 2, 1, 4, 4, 2, '2025-06-06', '01:41:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 145, 4, 2, 1, 3, 1, 2, '2025-06-06', '17:12:53');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 146, 4, 3, 2, 2, 3, 1, '2025-06-06', '07:06:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 147, 2, 3, 2, 4, 4, 1, '2025-06-06', '01:28:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 148, 2, 3, 2, 3, 4, 1, '2025-06-06', '13:19:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 149, 2, 3, 2, 5, 4, 1, '2025-06-06', '04:57:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 150, 2, 3, 2, 1, 4, 1, '2025-06-06', '22:02:53');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 151, 1, 3, 2, 2, 2, 1, '2025-06-06', '15:37:29');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 152, 3, 3, 2, 2, 4, 3, '2025-06-06', '16:23:03');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 153, 3, 3, 2, 4, 4, 3, '2025-06-06', '03:26:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 154, 3, 3, 2, 1, 2, 3, '2025-06-06', '20:13:08');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 155, 2, 1, 2, 1, 4, 2, '2025-06-06', '03:15:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 156, 2, 1, 2, 4, 2, 2, '2025-06-06', '21:15:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 157, 1, 3, 2, 3, 3, 3, '2025-06-06', '09:57:37');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 158, 2, 3, 2, 3, 4, 1, '2025-06-06', '22:30:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 159, 2, 3, 2, 2, 4, 1, '2025-06-06', '20:31:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 160, 2, 3, 2, 1, 4, 1, '2025-06-06', '10:43:24');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 161, 3, 3, 1, 3, 4, 3, '2025-06-06', '15:52:55');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 162, 3, 3, 1, 2, 4, 3, '2025-06-06', '09:53:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 163, 2, 1, 1, 4, 2, 2, '2025-06-06', '07:32:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 164, 2, 1, 2, 5, 4, 2, '2025-06-06', '02:09:06');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 165, 2, 1, 2, 1, 2, 2, '2025-06-06', '21:49:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 166, 1, 2, 1, 2, 3, 2, '2025-06-06', '22:11:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 167, 2, 1, 2, 3, 4, 1, '2025-06-06', '15:08:13');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 168, 2, 1, 2, 2, 2, 1, '2025-06-06', '11:59:59');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 169, 3, 2, 1, 2, 4, 1, '2025-06-06', '12:59:37');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 170, 3, 2, 1, 4, 2, 1, '2025-06-06', '05:07:35');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 171, 4, 3, 1, 4, 2, 1, '2025-06-06', '09:24:19');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 172, 1, 3, 1, 2, 4, 3, '2025-06-06', '00:51:03');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 173, 1, 3, 1, 3, 4, 3, '2025-06-06', '11:29:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 174, 1, 3, 1, 4, 4, 3, '2025-06-06', '20:19:18');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 175, 1, 3, 1, 1, 4, 3, '2025-06-06', '04:53:42');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 176, 1, 3, 1, 5, 4, 3, '2025-06-06', '11:28:17');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 177, 1, 3, 1, 3, 2, 3, '2025-06-06', '16:53:13');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 178, 2, 2, 2, 1, 4, 1, '2025-06-06', '05:44:28');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 179, 3, 3, 1, 5, 4, 3, '2025-06-06', '23:19:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 180, 3, 3, 1, 5, 4, 3, '2025-06-06', '03:04:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 181, 1, 1, 2, 1, 4, 2, '2025-06-06', '01:03:10');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 182, 1, 1, 2, 4, 4, 2, '2025-06-06', '04:02:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 183, 1, 1, 2, 3, 3, 2, '2025-06-06', '03:35:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 184, 3, 1, 1, 1, 2, 2, '2025-06-06', '05:37:11');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 185, 3, 1, 1, 1, 4, 3, '2025-06-06', '16:14:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 186, 3, 1, 1, 5, 4, 3, '2025-06-06', '18:27:36');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 187, 3, 1, 1, 3, 3, 1, '2025-06-06', '23:41:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 188, 3, 3, 1, 4, 4, 3, '2025-06-06', '08:31:45');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 189, 3, 3, 1, 4, 4, 3, '2025-06-06', '03:50:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 190, 3, 3, 1, 2, 2, 3, '2025-06-06', '04:12:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 191, 2, 1, 1, 4, 4, 3, '2025-06-06', '13:43:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 192, 2, 1, 1, 1, 4, 3, '2025-06-06', '19:43:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 193, 2, 1, 1, 3, 2, 3, '2025-06-06', '00:27:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 194, 2, 2, 1, 1, 1, 1, '2025-06-06', '09:12:12');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 195, 3, 2, 2, 4, 4, 3, '2025-06-06', '05:47:03');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 196, 3, 2, 2, 5, 1, 3, '2025-06-06', '21:54:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 197, 4, 3, 2, 2, 2, 1, '2025-06-06', '17:53:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 198, 3, 1, 2, 3, 4, 1, '2025-06-06', '09:14:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 199, 3, 1, 2, 3, 4, 1, '2025-06-06', '14:24:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 200, 3, 1, 2, 1, 3, 1, '2025-06-06', '12:03:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 201, 3, 1, 2, 4, 4, 2, '2025-06-06', '00:45:19');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 202, 3, 1, 2, 4, 3, 2, '2025-06-06', '22:14:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 203, 3, 1, 1, 4, 2, 2, '2025-06-06', '18:27:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 204, 3, 3, 2, 4, 4, 1, '2025-06-06', '14:39:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 205, 3, 3, 2, 1, 4, 1, '2025-06-06', '17:50:42');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 206, 3, 3, 2, 4, 4, 1, '2025-06-06', '03:47:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 207, 3, 3, 2, 5, 1, 1, '2025-06-06', '22:34:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 208, 2, 1, 2, 1, 1, 2, '2025-06-06', '17:14:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 209, 1, 3, 2, 3, 4, 3, '2025-06-06', '12:39:36');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 210, 1, 3, 2, 3, 4, 3, '2025-06-06', '14:21:55');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 211, 1, 3, 2, 4, 4, 3, '2025-06-06', '15:34:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 212, 1, 3, 2, 5, 3, 3, '2025-06-06', '13:15:02');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 213, 4, 1, 1, 4, 4, 3, '2025-06-06', '15:44:13');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 214, 4, 1, 1, 3, 1, 3, '2025-06-06', '23:29:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 215, 4, 1, 1, 3, 4, 3, '2025-06-06', '15:34:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 216, 4, 1, 1, 5, 1, 3, '2025-06-06', '13:31:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 217, 4, 1, 2, 1, 4, 3, '2025-06-06', '20:15:03');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 218, 4, 1, 2, 1, 1, 3, '2025-06-06', '17:20:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 219, 4, 2, 2, 2, 4, 3, '2025-06-06', '05:05:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 220, 1, 1, 1, 4, 4, 3, '2025-06-06', '02:59:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 221, 1, 1, 1, 1, 4, 3, '2025-06-06', '17:46:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 222, 2, 1, 1, 3, 4, 1, '2025-06-06', '01:30:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 223, 2, 1, 1, 3, 1, 1, '2025-06-06', '17:00:19');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 224, 4, 3, 1, 2, 4, 3, '2025-06-06', '07:39:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 225, 4, 3, 1, 4, 4, 3, '2025-06-06', '06:04:50');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 226, 4, 3, 1, 3, 1, 3, '2025-06-06', '19:45:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 227, 3, 2, 2, 5, 4, 1, '2025-06-06', '03:50:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 228, 3, 2, 2, 2, 2, 1, '2025-06-06', '06:01:28');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 229, 3, 3, 2, 3, 4, 2, '2025-06-06', '02:07:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 230, 3, 3, 2, 2, 4, 2, '2025-06-06', '01:05:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 231, 1, 2, 1, 2, 4, 3, '2025-06-06', '09:44:19');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 232, 1, 2, 1, 4, 4, 3, '2025-06-06', '16:45:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 233, 1, 2, 1, 5, 4, 3, '2025-06-06', '19:56:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 234, 1, 2, 1, 4, 2, 3, '2025-06-06', '19:14:10');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 235, 1, 3, 2, 4, 4, 2, '2025-06-06', '14:55:02');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 236, 1, 3, 2, 2, 4, 2, '2025-06-06', '01:23:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 237, 1, 3, 2, 5, 4, 2, '2025-06-06', '03:11:06');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 238, 1, 3, 2, 3, 4, 2, '2025-06-06', '07:32:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 239, 1, 3, 2, 4, 4, 2, '2025-06-06', '20:34:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 240, 1, 3, 2, 2, 1, 2, '2025-06-06', '12:58:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 241, 1, 3, 1, 4, 2, 1, '2025-06-06', '12:12:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 242, 2, 2, 2, 3, 4, 1, '2025-06-06', '13:25:59');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 243, 2, 2, 2, 3, 4, 1, '2025-06-06', '11:53:32');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 244, 2, 2, 2, 1, 4, 1, '2025-06-06', '04:58:36');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 245, 2, 2, 2, 5, 1, 1, '2025-06-06', '07:38:08');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 246, 3, 1, 2, 2, 1, 1, '2025-06-06', '11:21:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 247, 3, 2, 1, 2, 3, 1, '2025-06-06', '15:41:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 248, 2, 2, 1, 1, 4, 2, '2025-06-06', '12:40:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 249, 2, 2, 1, 3, 4, 2, '2025-06-06', '10:19:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 250, 2, 2, 1, 5, 4, 2, '2025-06-06', '06:07:17');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 251, 2, 2, 1, 5, 4, 2, '2025-06-06', '01:28:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 252, 2, 2, 1, 3, 2, 2, '2025-06-06', '17:21:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 253, 4, 1, 1, 1, 4, 3, '2025-06-06', '03:47:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 254, 4, 1, 1, 1, 1, 3, '2025-06-06', '12:57:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 255, 3, 1, 2, 4, 4, 3, '2025-06-06', '23:08:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 256, 3, 1, 2, 5, 4, 3, '2025-06-06', '15:53:40');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 257, 3, 1, 2, 4, 2, 3, '2025-06-06', '02:15:18');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 258, 4, 3, 1, 3, 4, 1, '2025-06-06', '12:14:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 259, 4, 3, 1, 1, 1, 1, '2025-06-06', '19:43:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 260, 4, 2, 2, 5, 1, 3, '2025-06-06', '18:38:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 261, 3, 2, 1, 5, 4, 3, '2025-06-06', '23:29:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 262, 3, 2, 1, 2, 4, 3, '2025-06-06', '14:54:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 263, 3, 2, 1, 2, 4, 3, '2025-06-06', '16:08:13');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 264, 3, 2, 1, 4, 4, 3, '2025-06-06', '12:16:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 265, 3, 2, 1, 5, 4, 3, '2025-06-06', '13:45:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 266, 3, 2, 1, 1, 4, 3, '2025-06-06', '10:15:13');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 267, 1, 1, 1, 2, 3, 2, '2025-06-06', '10:42:41');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 268, 2, 3, 2, 2, 4, 3, '2025-06-06', '10:59:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 269, 2, 3, 2, 3, 4, 3, '2025-06-06', '05:43:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 270, 2, 3, 2, 5, 2, 3, '2025-06-06', '09:24:40');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 271, 3, 2, 1, 2, 4, 2, '2025-06-06', '04:34:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 272, 3, 2, 1, 5, 1, 2, '2025-06-06', '18:37:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 273, 3, 2, 1, 3, 1, 3, '2025-06-06', '11:49:08');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 274, 1, 2, 1, 5, 4, 3, '2025-06-06', '11:29:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 275, 1, 2, 1, 2, 4, 3, '2025-06-06', '14:49:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 276, 1, 2, 1, 2, 4, 3, '2025-06-06', '08:54:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 277, 1, 2, 1, 5, 3, 3, '2025-06-06', '10:21:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 278, 3, 2, 1, 1, 4, 1, '2025-06-06', '06:38:50');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 279, 3, 2, 1, 1, 4, 1, '2025-06-06', '19:34:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 280, 3, 3, 1, 4, 4, 3, '2025-06-06', '08:17:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 281, 3, 3, 1, 5, 4, 3, '2025-06-06', '07:41:10');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 282, 3, 3, 1, 1, 3, 3, '2025-06-06', '07:15:16');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 283, 4, 1, 2, 3, 4, 3, '2025-06-06', '20:39:50');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 284, 4, 1, 2, 4, 2, 3, '2025-06-06', '00:42:10');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 285, 2, 1, 2, 4, 1, 2, '2025-06-06', '23:48:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 286, 1, 1, 1, 4, 4, 1, '2025-06-06', '14:34:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 287, 1, 1, 1, 4, 2, 1, '2025-06-06', '09:42:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 288, 4, 3, 2, 3, 4, 1, '2025-06-06', '17:49:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 289, 4, 3, 2, 5, 4, 1, '2025-06-06', '05:55:12');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 290, 2, 1, 2, 3, 2, 3, '2025-06-06', '08:22:40');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 291, 3, 3, 2, 3, 4, 1, '2025-06-06', '02:55:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 292, 3, 3, 2, 5, 4, 1, '2025-06-06', '20:37:11');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 293, 3, 3, 2, 5, 4, 1, '2025-06-06', '20:58:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 294, 3, 3, 2, 1, 4, 1, '2025-06-06', '04:30:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 295, 3, 3, 2, 3, 4, 1, '2025-06-06', '15:14:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 296, 3, 3, 2, 2, 2, 1, '2025-06-06', '00:53:29');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 297, 4, 3, 1, 4, 4, 2, '2025-06-06', '16:04:17');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 298, 4, 3, 1, 2, 4, 2, '2025-06-06', '20:02:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 299, 4, 3, 1, 2, 4, 2, '2025-06-06', '16:02:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 300, 4, 3, 1, 1, 1, 2, '2025-06-06', '07:20:41');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 301, 1, 2, 2, 5, 1, 2, '2025-06-06', '17:11:17');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 302, 4, 3, 1, 3, 4, 1, '2025-06-06', '09:29:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 303, 4, 3, 1, 5, 4, 1, '2025-06-06', '06:29:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 304, 4, 3, 1, 3, 4, 1, '2025-06-06', '01:48:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 305, 4, 3, 1, 2, 4, 1, '2025-06-06', '16:53:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 306, 2, 3, 2, 4, 4, 3, '2025-06-06', '17:28:08');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 307, 2, 3, 2, 4, 1, 3, '2025-06-06', '03:04:46');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 308, 3, 2, 2, 1, 2, 1, '2025-06-06', '09:59:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 309, 4, 1, 2, 2, 4, 1, '2025-06-06', '03:39:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 310, 4, 1, 2, 5, 2, 1, '2025-06-06', '01:26:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 311, 3, 1, 1, 3, 4, 1, '2025-06-06', '16:46:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 312, 3, 1, 1, 4, 4, 1, '2025-06-06', '01:37:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 313, 3, 1, 1, 5, 2, 1, '2025-06-06', '06:34:18');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 314, 4, 2, 2, 1, 4, 3, '2025-06-06', '23:01:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 315, 4, 2, 2, 1, 4, 3, '2025-06-06', '05:07:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 316, 4, 2, 2, 4, 3, 3, '2025-06-06', '00:08:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 317, 2, 2, 2, 3, 4, 3, '2025-06-06', '05:49:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 318, 2, 2, 2, 4, 4, 3, '2025-06-06', '19:22:35');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 319, 2, 2, 2, 3, 4, 3, '2025-06-06', '15:38:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 320, 2, 2, 2, 1, 4, 3, '2025-06-06', '20:08:37');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 321, 4, 2, 1, 5, 4, 3, '2025-06-06', '06:27:45');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 322, 2, 3, 2, 3, 4, 3, '2025-06-06', '21:10:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 323, 2, 3, 2, 1, 4, 3, '2025-06-06', '15:16:16');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 324, 2, 3, 2, 4, 4, 3, '2025-06-06', '18:46:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 325, 2, 3, 2, 5, 4, 3, '2025-06-06', '03:07:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 326, 2, 3, 2, 4, 4, 3, '2025-06-06', '01:16:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 327, 2, 3, 2, 5, 2, 3, '2025-06-06', '18:42:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 328, 3, 1, 1, 1, 2, 1, '2025-06-06', '11:45:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 329, 4, 3, 2, 5, 4, 2, '2025-06-06', '15:58:46');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 330, 4, 3, 2, 3, 1, 2, '2025-06-06', '20:24:46');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 331, 2, 2, 1, 5, 2, 3, '2025-06-06', '07:59:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 332, 4, 1, 1, 1, 4, 1, '2025-06-06', '05:09:12');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 333, 4, 1, 1, 2, 4, 1, '2025-06-06', '14:18:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 334, 4, 1, 1, 3, 2, 1, '2025-06-06', '15:31:18');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 335, 4, 3, 2, 5, 4, 1, '2025-06-06', '21:04:23');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 336, 2, 1, 2, 3, 4, 3, '2025-06-06', '15:20:11');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 337, 2, 1, 2, 2, 4, 3, '2025-06-06', '00:41:41');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 338, 2, 1, 2, 4, 4, 3, '2025-06-06', '10:42:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 339, 2, 1, 2, 5, 4, 3, '2025-06-06', '15:17:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 340, 2, 1, 2, 3, 1, 3, '2025-06-06', '08:59:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 341, 3, 1, 2, 5, 3, 3, '2025-06-06', '20:12:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 342, 3, 2, 2, 3, 4, 1, '2025-06-06', '13:01:12');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 343, 3, 2, 2, 3, 4, 1, '2025-06-06', '15:36:59');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 344, 3, 2, 2, 1, 4, 1, '2025-06-06', '11:36:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 345, 3, 2, 2, 4, 4, 1, '2025-06-06', '07:40:35');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 346, 3, 2, 1, 4, 2, 3, '2025-06-06', '10:46:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 347, 3, 2, 1, 1, 4, 3, '2025-06-06', '15:14:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 348, 3, 2, 1, 5, 4, 3, '2025-06-06', '06:22:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 349, 3, 2, 1, 4, 2, 3, '2025-06-06', '04:08:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 350, 2, 3, 2, 2, 4, 1, '2025-06-06', '16:08:37');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 351, 2, 3, 2, 1, 2, 1, '2025-06-06', '18:59:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 352, 1, 1, 1, 4, 4, 1, '2025-06-06', '20:32:32');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 353, 1, 1, 1, 3, 4, 1, '2025-06-06', '09:18:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 354, 1, 1, 1, 4, 4, 1, '2025-06-06', '17:37:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 355, 1, 1, 1, 2, 2, 1, '2025-06-06', '18:14:40');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 356, 4, 1, 1, 5, 2, 2, '2025-06-06', '20:37:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 357, 4, 3, 1, 2, 4, 3, '2025-06-06', '12:50:32');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 358, 2, 2, 2, 4, 4, 3, '2025-06-06', '23:41:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 359, 2, 2, 2, 5, 3, 3, '2025-06-06', '09:20:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 360, 4, 3, 2, 4, 4, 1, '2025-06-06', '13:10:36');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 361, 4, 3, 2, 5, 4, 1, '2025-06-06', '13:19:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 362, 4, 3, 2, 3, 3, 1, '2025-06-06', '07:31:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 363, 3, 2, 2, 4, 3, 3, '2025-06-06', '21:15:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 364, 2, 3, 1, 5, 4, 2, '2025-06-06', '13:48:50');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 365, 2, 3, 1, 3, 4, 2, '2025-06-06', '23:40:23');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 366, 2, 3, 1, 2, 1, 2, '2025-06-06', '15:35:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 367, 3, 2, 2, 2, 4, 3, '2025-06-06', '17:00:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 368, 3, 2, 2, 4, 1, 3, '2025-06-06', '05:14:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 369, 3, 2, 2, 5, 1, 2, '2025-06-06', '03:45:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 370, 3, 3, 2, 5, 3, 1, '2025-06-06', '08:42:13');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 371, 4, 1, 2, 2, 4, 2, '2025-06-06', '23:50:08');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 372, 4, 1, 2, 3, 1, 2, '2025-06-06', '10:15:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 373, 1, 1, 2, 1, 4, 3, '2025-06-06', '00:22:35');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 374, 1, 1, 2, 3, 4, 3, '2025-06-06', '10:17:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 375, 1, 1, 2, 4, 4, 3, '2025-06-06', '17:16:02');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 376, 1, 1, 2, 3, 4, 3, '2025-06-06', '18:55:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 377, 1, 1, 2, 4, 1, 3, '2025-06-06', '08:45:40');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 378, 2, 1, 1, 3, 4, 3, '2025-06-06', '13:55:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 379, 2, 1, 1, 5, 2, 3, '2025-06-06', '08:29:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 380, 3, 2, 1, 5, 2, 1, '2025-06-06', '14:44:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 381, 2, 1, 1, 5, 4, 1, '2025-06-06', '05:20:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 382, 2, 1, 1, 2, 4, 1, '2025-06-06', '14:50:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 383, 2, 1, 1, 2, 1, 1, '2025-06-06', '14:23:12');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 384, 1, 3, 1, 3, 4, 2, '2025-06-06', '23:01:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 385, 1, 3, 1, 4, 1, 2, '2025-06-06', '10:39:37');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 386, 1, 1, 1, 5, 2, 1, '2025-06-06', '14:31:53');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 387, 2, 3, 2, 4, 4, 3, '2025-06-06', '10:49:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 388, 2, 3, 2, 4, 3, 3, '2025-06-06', '20:28:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 389, 2, 1, 2, 3, 4, 2, '2025-06-06', '13:59:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 390, 2, 1, 2, 1, 1, 2, '2025-06-06', '17:16:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 391, 1, 3, 1, 1, 1, 3, '2025-06-06', '03:40:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 392, 2, 1, 2, 1, 4, 1, '2025-06-06', '15:11:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 393, 2, 1, 2, 4, 1, 1, '2025-06-06', '13:48:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 394, 4, 2, 1, 3, 4, 3, '2025-06-06', '22:39:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 395, 4, 2, 1, 1, 4, 3, '2025-06-06', '04:29:35');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 396, 4, 2, 1, 1, 4, 3, '2025-06-06', '22:56:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 397, 3, 3, 1, 3, 1, 2, '2025-06-06', '01:37:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 398, 4, 2, 2, 5, 4, 1, '2025-06-06', '14:13:29');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 399, 4, 2, 2, 4, 4, 1, '2025-06-06', '14:22:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 400, 4, 2, 2, 3, 3, 1, '2025-06-06', '23:53:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 401, 2, 2, 1, 2, 2, 2, '2025-06-06', '05:07:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 402, 4, 1, 2, 2, 4, 3, '2025-06-06', '10:28:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 403, 4, 1, 2, 1, 1, 3, '2025-06-06', '22:47:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 404, 3, 1, 2, 2, 4, 3, '2025-06-06', '07:37:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 405, 3, 1, 2, 2, 2, 3, '2025-06-06', '13:28:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 406, 4, 1, 2, 3, 4, 3, '2025-06-06', '04:19:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 407, 4, 1, 2, 1, 4, 3, '2025-06-06', '03:06:06');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 408, 4, 1, 2, 4, 3, 3, '2025-06-06', '04:43:50');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 409, 1, 3, 1, 4, 3, 1, '2025-06-06', '20:48:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 410, 3, 2, 1, 3, 4, 1, '2025-06-06', '10:21:36');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 411, 3, 2, 1, 4, 4, 1, '2025-06-06', '07:44:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 412, 2, 3, 2, 3, 1, 2, '2025-06-06', '00:26:17');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 413, 3, 2, 1, 3, 4, 2, '2025-06-06', '16:04:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 414, 3, 2, 1, 2, 2, 2, '2025-06-06', '19:20:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 415, 1, 1, 1, 3, 1, 2, '2025-06-06', '20:30:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 416, 2, 3, 2, 5, 4, 3, '2025-06-06', '00:22:23');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 417, 3, 2, 1, 3, 4, 3, '2025-06-06', '07:47:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 418, 3, 2, 1, 3, 4, 3, '2025-06-06', '07:15:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 419, 3, 2, 1, 5, 4, 3, '2025-06-06', '14:42:46');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 420, 3, 2, 1, 2, 1, 3, '2025-06-06', '01:31:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 421, 2, 3, 1, 2, 3, 2, '2025-06-06', '23:08:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 422, 4, 1, 2, 5, 4, 2, '2025-06-06', '19:39:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 423, 4, 1, 2, 4, 4, 2, '2025-06-06', '05:58:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 424, 4, 1, 2, 5, 1, 2, '2025-06-06', '13:49:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 425, 2, 1, 1, 5, 4, 3, '2025-06-06', '23:44:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 426, 2, 1, 1, 1, 3, 3, '2025-06-06', '07:43:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 427, 4, 3, 2, 5, 4, 1, '2025-06-06', '23:19:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 428, 4, 3, 2, 1, 1, 1, '2025-06-06', '05:56:16');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 429, 1, 1, 1, 5, 2, 3, '2025-06-06', '12:36:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 430, 2, 2, 1, 5, 4, 2, '2025-06-06', '05:27:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 431, 4, 3, 1, 2, 4, 3, '2025-06-06', '03:04:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 432, 4, 3, 1, 5, 4, 3, '2025-06-06', '13:54:16');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 433, 4, 3, 1, 4, 4, 3, '2025-06-06', '03:16:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 434, 4, 3, 1, 1, 4, 3, '2025-06-06', '23:43:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 435, 4, 3, 1, 5, 1, 3, '2025-06-06', '22:02:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 436, 4, 3, 1, 2, 2, 2, '2025-06-06', '22:16:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 437, 4, 2, 2, 1, 4, 3, '2025-06-06', '02:34:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 438, 4, 2, 2, 5, 3, 3, '2025-06-06', '09:44:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 439, 4, 2, 2, 1, 2, 3, '2025-06-06', '20:15:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 440, 4, 2, 2, 2, 4, 1, '2025-06-06', '10:23:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 441, 4, 2, 2, 5, 2, 1, '2025-06-06', '02:06:45');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 442, 1, 2, 1, 3, 1, 2, '2025-06-06', '03:35:19');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 443, 1, 2, 1, 4, 4, 1, '2025-06-06', '10:15:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 444, 1, 2, 1, 1, 4, 1, '2025-06-06', '05:08:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 445, 1, 2, 1, 3, 4, 1, '2025-06-06', '20:56:55');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 446, 1, 2, 1, 4, 1, 1, '2025-06-06', '10:42:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 447, 2, 2, 1, 4, 3, 3, '2025-06-06', '06:10:41');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 448, 3, 2, 2, 4, 4, 2, '2025-06-06', '12:53:38');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 449, 3, 2, 2, 4, 1, 2, '2025-06-06', '10:16:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 450, 1, 3, 1, 3, 4, 3, '2025-06-06', '07:07:37');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 451, 1, 3, 1, 1, 4, 3, '2025-06-06', '19:45:51');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 452, 1, 3, 1, 2, 1, 3, '2025-06-06', '06:05:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 453, 4, 3, 1, 2, 3, 3, '2025-06-06', '06:51:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 454, 1, 2, 1, 4, 4, 2, '2025-06-06', '03:56:19');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 455, 1, 2, 1, 5, 4, 2, '2025-06-06', '13:43:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 456, 1, 2, 1, 4, 4, 2, '2025-06-06', '22:03:05');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 457, 1, 2, 1, 5, 4, 2, '2025-06-06', '22:14:05');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 458, 1, 2, 1, 4, 4, 2, '2025-06-06', '23:38:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 459, 1, 2, 1, 2, 1, 2, '2025-06-06', '16:36:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 460, 2, 2, 2, 2, 4, 2, '2025-06-06', '19:22:44');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 461, 2, 2, 2, 3, 4, 2, '2025-06-06', '20:09:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 462, 2, 2, 2, 2, 1, 2, '2025-06-06', '22:32:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 463, 1, 2, 1, 4, 2, 3, '2025-06-06', '15:35:40');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 464, 1, 3, 1, 1, 4, 1, '2025-06-06', '03:10:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 465, 1, 3, 1, 1, 4, 1, '2025-06-06', '09:25:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 466, 1, 3, 1, 5, 1, 1, '2025-06-06', '03:46:06');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 467, 1, 1, 2, 1, 2, 3, '2025-06-06', '22:20:45');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 468, 2, 2, 1, 4, 4, 2, '2025-06-06', '23:16:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 469, 2, 2, 1, 2, 4, 2, '2025-06-06', '14:04:54');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 470, 2, 3, 1, 5, 1, 1, '2025-06-06', '18:29:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 471, 3, 1, 1, 5, 4, 3, '2025-06-06', '08:24:42');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 472, 3, 1, 1, 3, 4, 3, '2025-06-06', '21:32:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 473, 3, 1, 1, 5, 4, 3, '2025-06-06', '11:31:21');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 474, 3, 1, 1, 5, 4, 3, '2025-06-06', '12:43:26');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 475, 3, 1, 1, 3, 4, 3, '2025-06-06', '05:49:16');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 476, 3, 1, 1, 2, 4, 3, '2025-06-06', '15:55:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 477, 3, 1, 1, 3, 1, 3, '2025-06-06', '19:10:12');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 478, 2, 3, 1, 3, 2, 2, '2025-06-06', '11:24:24');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 479, 3, 3, 1, 5, 4, 3, '2025-06-06', '05:37:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 480, 3, 3, 1, 2, 4, 3, '2025-06-06', '03:50:00');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 481, 3, 3, 1, 4, 4, 3, '2025-06-06', '18:49:03');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 482, 4, 2, 1, 4, 4, 2, '2025-06-06', '20:01:41');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 483, 4, 2, 1, 5, 3, 2, '2025-06-06', '21:59:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 484, 3, 2, 2, 2, 4, 2, '2025-06-06', '01:54:35');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 485, 3, 2, 2, 3, 4, 2, '2025-06-06', '15:33:45');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 486, 3, 2, 2, 4, 4, 2, '2025-06-06', '04:52:55');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 487, 3, 2, 2, 2, 4, 2, '2025-06-06', '11:10:22');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 488, 4, 3, 1, 3, 4, 1, '2025-06-06', '01:54:45');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 489, 4, 3, 1, 2, 4, 1, '2025-06-06', '23:04:14');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 490, 4, 3, 1, 4, 2, 3, '2025-06-06', '10:04:22');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 491, 4, 1, 1, 2, 4, 2, '2025-06-06', '03:08:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 492, 4, 1, 1, 3, 4, 2, '2025-06-06', '21:13:39');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 493, 4, 1, 1, 2, 4, 2, '2025-06-06', '03:32:24');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 494, 4, 1, 1, 3, 4, 2, '2025-06-06', '06:06:23');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 495, 4, 1, 1, 1, 4, 2, '2025-06-06', '22:15:15');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 496, 4, 1, 1, 4, 4, 2, '2025-06-06', '12:03:50');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 497, 4, 1, 1, 3, 1, 2, '2025-06-06', '06:10:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 498, 1, 3, 1, 3, 4, 1, '2025-06-06', '18:27:56');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 499, 1, 3, 1, 4, 4, 1, '2025-06-06', '15:08:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 500, 1, 3, 1, 5, 2, 1, '2025-06-06', '02:32:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 501, 1, 2, 1, 5, 4, 1, '2025-06-06', '13:43:46');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 502, 1, 2, 1, 5, 1, 1, '2025-06-06', '20:25:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 503, 2, 2, 2, 3, 4, 1, '2025-06-06', '11:51:30');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 504, 2, 2, 2, 3, 4, 1, '2025-06-06', '05:17:25');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 505, 2, 2, 2, 1, 2, 1, '2025-06-06', '21:22:49');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 506, 2, 2, 1, 1, 4, 3, '2025-06-06', '02:59:33');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 507, 2, 2, 1, 4, 2, 3, '2025-06-06', '05:12:48');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 508, 2, 1, 1, 2, 4, 2, '2025-06-06', '08:11:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 509, 2, 1, 1, 5, 3, 2, '2025-06-06', '16:59:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 510, 3, 2, 2, 4, 1, 2, '2025-06-06', '14:22:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 511, 3, 3, 2, 3, 4, 2, '2025-06-06', '06:05:09');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 512, 3, 3, 2, 5, 4, 2, '2025-06-06', '20:02:01');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 513, 3, 3, 2, 4, 4, 2, '2025-06-06', '18:21:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 514, 3, 3, 2, 4, 4, 2, '2025-06-06', '21:58:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 515, 3, 3, 2, 1, 4, 2, '2025-06-06', '23:46:43');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 516, 3, 3, 2, 4, 2, 2, '2025-06-06', '05:50:32');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 517, 3, 1, 1, 3, 2, 2, '2025-06-06', '18:02:02');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 518, 4, 3, 1, 2, 4, 3, '2025-06-06', '08:17:16');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 519, 4, 3, 1, 2, 4, 3, '2025-06-06', '14:47:10');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 520, 4, 3, 1, 1, 4, 3, '2025-06-06', '20:27:52');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 521, 4, 3, 1, 3, 3, 3, '2025-06-06', '17:18:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 522, 4, 3, 2, 2, 1, 1, '2025-06-06', '20:22:27');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 523, 3, 2, 1, 5, 4, 2, '2025-06-06', '18:10:47');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 524, 3, 2, 1, 2, 4, 2, '2025-06-06', '14:24:58');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 525, 3, 2, 1, 4, 2, 2, '2025-06-06', '15:56:34');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 526, 3, 1, 2, 4, 4, 2, '2025-06-06', '12:27:57');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 527, 3, 1, 2, 4, 3, 2, '2025-06-06', '15:34:04');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 528, 2, 2, 2, 2, 1, 1, '2025-06-06', '10:12:31');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 529, 4, 1, 1, 1, 4, 3, '2025-06-06', '13:45:07');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 530, 4, 1, 1, 5, 2, 3, '2025-06-06', '09:13:20');
INSERT INTO soutenance.embarquement( id_embarquement, utilisateur_id, shift_id, navire_id, numero_cal, nombre_pallets, numero_station_id, date_embarquement, heure_embarquement ) VALUES ( 531, 1, 1, 1, 1, 2, 3, '2025-06-06', '13:45:20');
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 37, 'CY-677-HF', 'Q90_1000', 'bon_livraison/Q90_1000.pdf', 'Marcel', 25.0, '2025-06-06', 2, 1, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 38, '064-BFM-74', 'Q90_1001', 'bon_livraison/Q90_1001.pdf', 'Audrey', 9.0, '2025-06-06', 1, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 39, '309-EGJ-80', 'Q90_1002', 'bon_livraison/Q90_1002.pdf', 'Océane', 25.0, '2025-06-06', 1, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 40, '788-BBS-20', 'Q90_1003', 'bon_livraison/Q90_1003.pdf', 'Danielle', 36.0, '2025-06-06', 2, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 41, 'FC-361-TC', 'Q90_1004', 'bon_livraison/Q90_1004.pdf', 'Hélène', 34.0, '2025-06-06', 1, 1, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 42, 'ST-169-BT', 'Q90_1005', 'bon_livraison/Q90_1005.pdf', 'Geneviève', 13.0, '2025-06-06', 1, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 43, '534-IGV-62', 'Q90_1006', 'bon_livraison/Q90_1006.pdf', 'Marguerite', 40.0, '2025-06-06', 2, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 44, '107-OKY-99', 'Q90_1007', 'bon_livraison/Q90_1007.pdf', 'Eugène', 32.0, '2025-06-06', 2, 1, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 45, 'RG-251-QI', 'Q90_1008', 'bon_livraison/Q90_1008.pdf', 'Patrick', 19.0, '2025-06-06', 1, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 46, '849-JFO-80', 'Q90_1009', 'bon_livraison/Q90_1009.pdf', 'Margot', 36.0, '2025-06-06', 1, 1, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 47, '411-VDE-82', 'Q90_1010', 'bon_livraison/Q90_1010.pdf', 'Richard', 12.0, '2025-06-06', 1, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 48, '534-TGW-87', 'Q90_1011', 'bon_livraison/Q90_1011.pdf', 'Philippe', 15.0, '2025-06-06', 2, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 49, 'CU-005-NI', 'Q90_1012', 'bon_livraison/Q90_1012.pdf', 'Pénélope', 9.0, '2025-06-06', 2, 1, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 50, 'UI-786-FX', 'Q90_1013', 'bon_livraison/Q90_1013.pdf', 'Gabrielle', 34.0, '2025-06-06', 2, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 51, 'DC-805-WE', 'Q90_1014', 'bon_livraison/Q90_1014.pdf', 'Isabelle', 5.0, '2025-06-06', 1, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 52, 'NE-505-BJ', 'Q90_1015', 'bon_livraison/Q90_1015.pdf', 'Marc', 22.0, '2025-06-06', 2, 1, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 53, 'VD-869-LY', 'Q90_1016', 'bon_livraison/Q90_1016.pdf', 'Océane', 1.0, '2025-06-06', 2, 1, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 54, 'HF-260-ZZ', 'Q90_1017', 'bon_livraison/Q90_1017.pdf', 'Joseph', 23.0, '2025-06-06', 2, 1, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 55, '342-ZNZ-16', 'Q90_1018', 'bon_livraison/Q90_1018.pdf', 'Auguste', 34.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 56, '543-HGO-30', 'Q90_1019', 'bon_livraison/Q90_1019.pdf', 'Margaux', 21.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 57, 'MK-458-IC', 'Q90_1020', 'bon_livraison/Q90_1020.pdf', 'Andrée', 11.0, '2025-06-06', 2, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 58, '294-ADI-01', 'Q90_1021', 'bon_livraison/Q90_1021.pdf', 'Jeannine', 37.0, '2025-06-06', 1, 1, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 59, '569-LXZ-81', 'Q90_1022', 'bon_livraison/Q90_1022.pdf', 'Alice', 28.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 60, 'IB-088-WN', 'Q90_1023', 'bon_livraison/Q90_1023.pdf', 'Marianne', 38.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 61, 'LN-595-CV', 'Q90_1024', 'bon_livraison/Q90_1024.pdf', 'Margaud', 25.0, '2025-06-06', 2, 1, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 62, 'XJ-656-QJ', 'Q90_1025', 'bon_livraison/Q90_1025.pdf', 'Marthe', 12.0, '2025-06-06', 2, 1, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 63, '662-REG-99', 'Q90_1026', 'bon_livraison/Q90_1026.pdf', 'Thibaut', 20.0, '2025-06-06', 1, 1, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 64, '436-RAJ-99', 'Q90_1027', 'bon_livraison/Q90_1027.pdf', 'Marcelle', 10.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 65, '387-OOO-21', 'Q90_1028', 'bon_livraison/Q90_1028.pdf', 'Roland', 36.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 66, '433-CYH-20', 'Q90_1029', 'bon_livraison/Q90_1029.pdf', 'Benjamin', 9.0, '2025-06-06', 1, 1, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 67, 'PT-769-YC', 'Q90_1030', 'bon_livraison/Q90_1030.pdf', 'Léon', 12.0, '2025-06-06', 1, 1, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 68, '201-PMH-63', 'Q90_1031', 'bon_livraison/Q90_1031.pdf', 'Joseph', 38.0, '2025-06-06', 2, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 69, '172-BRH-78', 'Q90_1032', 'bon_livraison/Q90_1032.pdf', 'Gabrielle', 39.0, '2025-06-06', 1, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 70, '868-YOT-72', 'Q90_1033', 'bon_livraison/Q90_1033.pdf', 'Noémi', 24.0, '2025-06-06', 2, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 71, '348-OIY-73', 'Q90_1034', 'bon_livraison/Q90_1034.pdf', 'Robert', 28.0, '2025-06-06', 2, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 72, '345-CWJ-58', 'Q90_1035', 'bon_livraison/Q90_1035.pdf', 'Édouard', 33.0, '2025-06-06', 1, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 73, 'EH-231-MW', 'Q90_1036', 'bon_livraison/Q90_1036.pdf', 'Arnaude', 19.0, '2025-06-06', 1, 2, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 74, '603-KRO-66', 'Q90_1037', 'bon_livraison/Q90_1037.pdf', 'Pénélope', 6.0, '2025-06-06', 1, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 75, 'YS-054-MP', 'Q90_1038', 'bon_livraison/Q90_1038.pdf', 'Odette', 19.0, '2025-06-06', 1, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 76, '893-NRX-73', 'Q90_1039', 'bon_livraison/Q90_1039.pdf', 'Richard', 8.0, '2025-06-06', 1, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 77, '562-PAM-72', 'Q90_1040', 'bon_livraison/Q90_1040.pdf', 'Laurence', 7.0, '2025-06-06', 2, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 78, 'MS-016-SV', 'Q90_1041', 'bon_livraison/Q90_1041.pdf', 'Grégoire', 37.0, '2025-06-06', 1, 2, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 79, '653-FBI-75', 'Q90_1042', 'bon_livraison/Q90_1042.pdf', 'Yves', 36.0, '2025-06-06', 1, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 80, '417-IYN-08', 'Q90_1043', 'bon_livraison/Q90_1043.pdf', 'Bernard', 13.0, '2025-06-06', 2, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 81, '003-HUC-30', 'Q90_1044', 'bon_livraison/Q90_1044.pdf', 'Laurence', 35.0, '2025-06-06', 2, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 82, 'HE-193-PV', 'Q90_1045', 'bon_livraison/Q90_1045.pdf', 'Chantal', 11.0, '2025-06-06', 1, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 83, '991-YLF-24', 'Q90_1046', 'bon_livraison/Q90_1046.pdf', 'Franck', 32.0, '2025-06-06', 2, 2, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 84, 'JS-631-VM', 'Q90_1047', 'bon_livraison/Q90_1047.pdf', 'Jeanne', 31.0, '2025-06-06', 2, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 85, 'DW-919-YJ', 'Q90_1048', 'bon_livraison/Q90_1048.pdf', 'Sabine', 5.0, '2025-06-06', 1, 2, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 86, 'LR-518-NV', 'Q90_1049', 'bon_livraison/Q90_1049.pdf', 'Madeleine', 4.0, '2025-06-06', 2, 2, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 87, '165-ANP-72', 'Q90_1050', 'bon_livraison/Q90_1050.pdf', 'Bernadette', 26.0, '2025-06-06', 1, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 88, 'XQ-987-UI', 'Q90_1051', 'bon_livraison/Q90_1051.pdf', 'Chantal', 17.0, '2025-06-06', 1, 2, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 89, '531-XSI-47', 'Q90_1052', 'bon_livraison/Q90_1052.pdf', 'Patrick', 33.0, '2025-06-06', 1, 2, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 90, '650-STV-75', 'Q90_1053', 'bon_livraison/Q90_1053.pdf', 'Jules', 16.0, '2025-06-06', 2, 2, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 91, '454-GLZ-94', 'Q90_1054', 'bon_livraison/Q90_1054.pdf', 'Frédérique', 20.0, '2025-06-06', 1, 2, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 92, 'QG-678-CH', 'Q90_1055', 'bon_livraison/Q90_1055.pdf', 'Patricia', 40.0, '2025-06-06', 1, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 93, 'WP-770-UW', 'Q90_1056', 'bon_livraison/Q90_1056.pdf', 'Éric', 39.0, '2025-06-06', 1, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 94, '349-HMW-57', 'Q90_1057', 'bon_livraison/Q90_1057.pdf', 'Françoise', 20.0, '2025-06-06', 1, 2, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 95, '557-NXR-44', 'Q90_1058', 'bon_livraison/Q90_1058.pdf', 'Philippe', 36.0, '2025-06-06', 2, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 96, 'DX-182-GK', 'Q90_1059', 'bon_livraison/Q90_1059.pdf', 'Léon', 30.0, '2025-06-06', 1, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 97, 'XP-989-IX', 'Q90_1060', 'bon_livraison/Q90_1060.pdf', 'Roland', 29.0, '2025-06-06', 1, 2, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 98, 'GJ-240-HL', 'Q90_1061', 'bon_livraison/Q90_1061.pdf', 'Mathilde', 21.0, '2025-06-06', 2, 2, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 99, 'IB-427-BR', 'Q90_1062', 'bon_livraison/Q90_1062.pdf', 'François', 32.0, '2025-06-06', 2, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 100, 'SJ-752-PP', 'Q90_1063', 'bon_livraison/Q90_1063.pdf', 'Bernard', 17.0, '2025-06-06', 2, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 101, '671-PDC-90', 'Q90_1064', 'bon_livraison/Q90_1064.pdf', 'Henri', 8.0, '2025-06-06', 1, 2, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 102, 'ZS-318-JC', 'Q90_1065', 'bon_livraison/Q90_1065.pdf', 'Paulette', 25.0, '2025-06-06', 1, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 103, '938-TTZ-67', 'Q90_1066', 'bon_livraison/Q90_1066.pdf', 'Capucine', 14.0, '2025-06-06', 2, 2, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 104, '990-SNJ-91', 'Q90_1067', 'bon_livraison/Q90_1067.pdf', 'Paulette', 2.0, '2025-06-06', 1, 2, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 105, 'UG-123-IV', 'Q90_1068', 'bon_livraison/Q90_1068.pdf', 'Jérôme', 37.0, '2025-06-06', 1, 3, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 106, 'FA-974-NO', 'Q90_1069', 'bon_livraison/Q90_1069.pdf', 'Arthur', 9.0, '2025-06-06', 1, 3, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 107, 'JW-713-JW', 'Q90_1070', 'bon_livraison/Q90_1070.pdf', 'Rémy', 20.0, '2025-06-06', 2, 3, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 108, 'ND-242-RH', 'Q90_1071', 'bon_livraison/Q90_1071.pdf', 'David', 20.0, '2025-06-06', 1, 3, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 109, 'FZ-947-JT', 'Q90_1072', 'bon_livraison/Q90_1072.pdf', 'Gérard', 10.0, '2025-06-06', 2, 3, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 110, '648-WJW-87', 'Q90_1073', 'bon_livraison/Q90_1073.pdf', 'Brigitte', 38.0, '2025-06-06', 2, 3, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 111, 'TB-594-NX', 'Q90_1074', 'bon_livraison/Q90_1074.pdf', 'André', 18.0, '2025-06-06', 2, 3, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 112, 'HV-049-SS', 'Q90_1075', 'bon_livraison/Q90_1075.pdf', 'Augustin', 21.0, '2025-06-06', 2, 3, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 113, 'PQ-429-UO', 'Q90_1076', 'bon_livraison/Q90_1076.pdf', 'Bernadette', 24.0, '2025-06-06', 2, 3, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 114, '655-CPL-12', 'Q90_1077', 'bon_livraison/Q90_1077.pdf', 'Vincent', 29.0, '2025-06-06', 1, 3, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 115, '680-WPJ-71', 'Q90_1078', 'bon_livraison/Q90_1078.pdf', 'Thomas', 34.0, '2025-06-06', 1, 3, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 116, '680-KDY-87', 'Q90_1079', 'bon_livraison/Q90_1079.pdf', 'Antoinette', 39.0, '2025-06-06', 1, 3, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 117, 'GQ-770-LT', 'Q90_1080', 'bon_livraison/Q90_1080.pdf', 'Lucas', 21.0, '2025-06-06', 1, 3, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 118, '771-REJ-09', 'Q90_1081', 'bon_livraison/Q90_1081.pdf', 'Susanne', 9.0, '2025-06-06', 1, 3, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 119, 'WF-086-JR', 'Q90_1082', 'bon_livraison/Q90_1082.pdf', 'Éric', 23.0, '2025-06-06', 1, 3, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 120, 'DO-274-DU', 'Q90_1083', 'bon_livraison/Q90_1083.pdf', 'Danielle', 39.0, '2025-06-06', 2, 3, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 121, '378-NPP-26', 'Q90_1084', 'bon_livraison/Q90_1084.pdf', 'Laurent', 2.0, '2025-06-06', 1, 3, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 122, 'CI-658-YZ', 'Q90_1085', 'bon_livraison/Q90_1085.pdf', 'René', 40.0, '2025-06-06', 2, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 123, 'JX-972-JS', 'Q90_1086', 'bon_livraison/Q90_1086.pdf', 'Caroline', 11.0, '2025-06-06', 1, 4, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 124, '867-LKR-53', 'Q90_1087', 'bon_livraison/Q90_1087.pdf', 'Marthe', 12.0, '2025-06-06', 1, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 125, 'SM-605-HY', 'Q90_1088', 'bon_livraison/Q90_1088.pdf', 'Noémi', 40.0, '2025-06-06', 1, 4, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 126, '627-WZM-02', 'Q90_1089', 'bon_livraison/Q90_1089.pdf', 'Constance', 23.0, '2025-06-06', 1, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 127, '870-DOD-26', 'Q90_1090', 'bon_livraison/Q90_1090.pdf', 'Marcelle', 26.0, '2025-06-06', 1, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 128, 'CP-596-ZI', 'Q90_1091', 'bon_livraison/Q90_1091.pdf', 'Manon', 21.0, '2025-06-06', 2, 4, 1, 1, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 129, 'KV-578-RM', 'Q90_1092', 'bon_livraison/Q90_1092.pdf', 'Auguste', 8.0, '2025-06-06', 1, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 130, 'HU-316-VJ', 'Q90_1093', 'bon_livraison/Q90_1093.pdf', 'Eugène', 32.0, '2025-06-06', 2, 4, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 131, 'OF-005-WJ', 'Q90_1094', 'bon_livraison/Q90_1094.pdf', 'Stéphanie', 5.0, '2025-06-06', 2, 4, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 132, 'JL-238-LN', 'Q90_1095', 'bon_livraison/Q90_1095.pdf', 'Antoinette', 21.0, '2025-06-06', 1, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 133, 'FF-693-CT', 'Q90_1096', 'bon_livraison/Q90_1096.pdf', 'Colette', 33.0, '2025-06-06', 2, 4, 1, 1, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 134, 'HO-740-UI', 'Q90_1097', 'bon_livraison/Q90_1097.pdf', 'Suzanne', 4.0, '2025-06-06', 1, 4, 1, 1, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 135, '217-JVR-59', 'Q90_1098', 'bon_livraison/Q90_1098.pdf', 'Théophile', 9.0, '2025-06-06', 1, 4, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 136, '436-WIO-71', 'Q90_1099', 'bon_livraison/Q90_1099.pdf', 'Noël', 7.0, '2025-06-06', 2, 4, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 137, '440-SLS-64', 'Q90_1100', 'bon_livraison/Q90_1100.pdf', 'Alain', 40.0, '2025-06-06', 1, 4, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 138, 'TX-395-PJ', 'Q90_1101', 'bon_livraison/Q90_1101.pdf', 'Matthieu', 13.0, '2025-06-06', 1, 4, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 139, 'TI-210-VY', 'Q90_1102', 'bon_livraison/Q90_1102.pdf', 'Thierry', 28.0, '2025-06-06', 1, 4, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 140, '214-BSL-56', 'Q90_1103', 'bon_livraison/Q90_1103.pdf', 'Jérôme', 18.0, '2025-06-06', 1, 4, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 141, 'EZ-884-RL', 'Q90_1104', 'bon_livraison/Q90_1104.pdf', 'Véronique', 11.0, '2025-06-06', 2, 4, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 142, 'IP-517-ZJ', 'Q90_1105', 'bon_livraison/Q90_1105.pdf', 'Denis', 31.0, '2025-06-06', 1, 4, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 143, 'YH-685-VX', 'Q90_1106', 'bon_livraison/Q90_1106.pdf', 'Éric', 15.0, '2025-06-06', 1, 4, 1, 2, 2);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 144, '175-AIR-49', 'Q90_1107', 'bon_livraison/Q90_1107.pdf', 'Alex', 6.0, '2025-06-06', 1, 4, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 145, '709-DVH-85', 'Q90_1108', 'bon_livraison/Q90_1108.pdf', 'Juliette', 26.0, '2025-06-06', 2, 4, 1, 2, 3);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 146, 'UC-461-UO', 'Q90_1109', 'bon_livraison/Q90_1109.pdf', 'Guillaume', 20.0, '2025-06-06', 2, 4, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 147, 'BJ-138-PD', 'Q90_1110', 'bon_livraison/Q90_1110.pdf', 'Grégoire', 11.0, '2025-06-06', 2, 4, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 148, '869-OLV-26', 'Q90_1111', 'bon_livraison/Q90_1111.pdf', 'Marcelle', 35.0, '2025-06-06', 1, 4, 1, 2, 1);
INSERT INTO soutenance.entree_magasin( id_entree_magasin, numero_camion, bon_livraison, path_bon_livraison, chauffeur, quantite_palette, date_entrant, agent_id, numero_station_id, magasin_id, navire_id, shift_id ) VALUES ( 149, 'PT-053-NI', 'Q90_1112', 'bon_livraison/Q90_1112.pdf', 'Capucine', 5.0, '2025-06-06', 2, 4, 1, 2, 2);
INSERT INTO soutenance.magasin( id_magasin, magasin ) VALUES ( 1, 'Magasin B1');
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 1, 1, '2024-11-12', null, 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 7, 1, '2025-05-10', '2025-06-15', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 8, 1, '2025-05-12', '2025-05-13', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 9, 1, '2025-05-04', '2025-06-19', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 10, 1, '2025-05-16', '2025-06-08', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 11, 1, '2025-05-11', '2025-06-18', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 12, 1, '2025-05-06', '2025-05-29', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 13, 1, '2025-05-09', '2025-06-06', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 14, 1, '2025-05-02', '2025-06-20', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 15, 1, '2025-04-28', '2025-05-25', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 16, 1, '2025-04-28', '2025-05-07', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 17, 1, '2025-05-22', '2025-06-03', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 18, 1, '2025-05-17', '2025-06-20', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 19, 1, '2025-05-21', '2025-05-28', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 20, 1, '2025-05-07', '2025-05-11', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 21, 1, '2025-04-25', '2025-05-27', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 22, 1, '2025-05-14', '2025-06-10', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 23, 1, '2025-04-26', '2025-05-30', 1);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 24, 1, '2025-05-13', '2025-05-28', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 25, 1, '2025-05-21', '2025-05-30', 2);
INSERT INTO soutenance.mouvement_navire( id_mouvement_navire, compagne_id, date_arriver, date_depart, navire_id ) VALUES ( 26, 1, '2025-05-18', '2025-06-10', 1);
INSERT INTO soutenance.navire( id_navire, navire, nb_compartiment, quantite_max, type_navire_id ) VALUES ( 1, 'Atlantic klipper', 5, 4700, 1);
INSERT INTO soutenance.navire( id_navire, navire, nb_compartiment, quantite_max, type_navire_id ) VALUES ( 2, 'Trust', 4, 4000, 1);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 1, 1, 27, 1);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 2, 1, 28, 2);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 3, 1, 29, 3);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 4, 1, 30, 4);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 5, 1, 31, 5);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 6, 1, 32, 6);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 7, 1, 33, 7);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 8, 1, 34, 8);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 9, 1, 35, 9);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 10, 1, 36, 10);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 11, 1, 37, 12);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 12, 1, 38, 13);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 13, 1, 39, 14);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 14, 1, 40, 15);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 15, 1, 41, 16);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 16, 1, 42, 17);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 17, 1, 43, 18);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 18, 1, 44, 20);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 19, 1, 45, 21);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 20, 1, 46, 22);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 21, 1, 47, 23);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 22, 1, 48, 27);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 23, 1, 49, 32);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 24, 1, 50, 33);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 25, 1, 51, 35);
INSERT INTO soutenance.numero_station( id_numero_station, compagne_id, station_id, numero_station ) VALUES ( 26, 1, 52, 41);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 1, 1, 1, 408);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 2, 2, 1, 352);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 3, 1, 2, 473);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 4, 2, 2, 473);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 5, 1, 3, 252);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 6, 2, 3, 186);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 7, 1, 4, 307);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 8, 2, 4, 306);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 9, 1, 5, 50);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 10, 2, 5, 110);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 11, 1, 6, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 12, 2, 6, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 13, 1, 7, 175);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 14, 2, 7, 175);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 15, 1, 8, 186);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 16, 2, 8, 160);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 17, 1, 9, 230);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 18, 2, 9, 230);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 19, 1, 10, 223);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 20, 2, 10, 220);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 21, 1, 11, 60);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 22, 2, 11, 40);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 23, 1, 12, 205);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 24, 2, 12, 205);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 25, 1, 13, 170);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 26, 2, 13, 171);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 27, 1, 14, 435);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 28, 2, 14, 475);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 29, 1, 15, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 30, 2, 15, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 31, 1, 16, 611);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 32, 2, 16, 612);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 33, 1, 17, 130);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 34, 2, 17, 0);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 35, 1, 18, 494);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 36, 2, 18, 494);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 37, 1, 19, 290);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 38, 2, 19, 287);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 39, 1, 20, 375);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 40, 2, 20, 370);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 41, 1, 21, 45);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 42, 2, 21, 45);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 43, 1, 22, 560);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 44, 2, 22, 563);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 45, 1, 23, 179);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 46, 2, 23, 180);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 47, 1, 24, 707);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 48, 2, 24, 785);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 49, 1, 25, 80);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 50, 2, 25, 93);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 51, 1, 26, 320);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 52, 2, 26, 306);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 53, 1, 1, 408);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 54, 2, 1, 352);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 55, 1, 2, 473);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 56, 2, 2, 473);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 57, 1, 3, 252);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 58, 2, 3, 186);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 59, 1, 4, 307);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 60, 2, 4, 306);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 61, 1, 5, 50);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 62, 2, 5, 110);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 63, 1, 6, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 64, 2, 6, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 65, 1, 7, 175);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 66, 2, 7, 175);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 67, 1, 8, 186);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 68, 2, 8, 160);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 69, 1, 9, 230);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 70, 2, 9, 230);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 71, 1, 10, 223);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 72, 2, 10, 220);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 73, 1, 11, 60);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 74, 2, 11, 40);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 75, 1, 12, 205);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 76, 2, 12, 205);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 77, 1, 13, 170);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 78, 2, 13, 171);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 79, 1, 14, 435);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 80, 2, 14, 475);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 81, 1, 15, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 82, 2, 15, 173);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 83, 1, 16, 611);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 84, 2, 16, 612);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 85, 1, 17, 130);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 86, 2, 17, 0);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 87, 1, 18, 494);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 88, 2, 18, 494);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 89, 1, 19, 290);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 90, 2, 19, 287);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 91, 1, 20, 375);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 92, 2, 20, 370);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 93, 1, 21, 45);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 94, 2, 21, 45);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 95, 1, 22, 560);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 96, 2, 22, 563);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 97, 1, 23, 179);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 98, 2, 23, 180);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 99, 1, 24, 707);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 100, 2, 24, 785);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 101, 1, 25, 80);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 102, 2, 25, 93);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 103, 1, 26, 320);
INSERT INTO soutenance.quotas( id_quotas, navire_id, numero_station_id, quotas ) VALUES ( 104, 2, 26, 306);
INSERT INTO soutenance.role( id_role, role ) VALUES ( 1, 'Administrateur');
INSERT INTO soutenance.role( id_role, role ) VALUES ( 2, 'Agent_entree');
INSERT INTO soutenance.role( id_role, role ) VALUES ( 3, 'Agent_sortie');
INSERT INTO soutenance.role( id_role, role ) VALUES ( 4, 'Agent_embarquement');
INSERT INTO soutenance.sexe( id_sexe, sexe ) VALUES ( 1, 'Homme');
INSERT INTO soutenance.sexe( id_sexe, sexe ) VALUES ( 2, 'Femme');
INSERT INTO soutenance.shift( id_shift, description, debut, fin ) VALUES ( 1, '1', '06:00:00', '13:59:00');
INSERT INTO soutenance.shift( id_shift, description, debut, fin ) VALUES ( 2, '2', '14:00:00', '21:59:00');
INSERT INTO soutenance.shift( id_shift, description, debut, fin ) VALUES ( 3, '3', '22:00:00', '05:59:00');
INSERT INTO soutenance.situation_familial( id_situation_familial, situation_familial ) VALUES ( 1, 'Célibataire');
INSERT INTO soutenance.situation_familial( id_situation_familial, situation_familial ) VALUES ( 2, 'Marié');
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 35, 4, '2025-06-06', 37, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 36, 4, '2025-06-06', 38, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 37, 15, '2025-06-06', 39, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 38, 2, '2025-06-06', 39, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 39, 5, '2025-06-06', 40, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 40, 13, '2025-06-06', 41, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 41, 3, '2025-06-06', 41, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 42, 16, '2025-06-06', 42, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 43, 2, '2025-06-06', 42, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 44, 10, '2025-06-06', 43, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 45, 6, '2025-06-06', 43, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 46, 3, '2025-06-06', 43, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 47, 12, '2025-06-06', 44, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 48, 8, '2025-06-06', 44, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 49, 2, '2025-06-06', 44, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 50, 6, '2025-06-06', 45, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 51, 3, '2025-06-06', 45, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 52, 6, '2025-06-06', 46, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 53, 6, '2025-06-06', 46, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 54, 2, '2025-06-06', 46, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 55, 22, '2025-06-06', 47, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 56, 4, '2025-06-06', 47, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 57, 8, '2025-06-06', 48, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 58, 11, '2025-06-06', 48, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 59, 2, '2025-06-06', 48, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 60, 8, '2025-06-06', 49, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 61, 3, '2025-06-06', 49, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 62, 10, '2025-06-06', 50, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 63, 10, '2025-06-06', 51, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 64, 1, '2025-06-06', 51, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 65, 5, '2025-06-06', 52, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 66, 2, '2025-06-06', 52, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 67, 11, '2025-06-06', 53, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 68, 7, '2025-06-06', 53, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 69, 2, '2025-06-06', 53, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 70, 13, '2025-06-06', 54, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 71, 1, '2025-06-06', 54, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 72, 15, '2025-06-06', 55, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 73, 5, '2025-06-06', 55, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 74, 5, '2025-06-06', 55, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 75, 5, '2025-06-06', 56, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 76, 4, '2025-06-06', 56, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 77, 8, '2025-06-06', 57, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 78, 5, '2025-06-06', 57, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 79, 9, '2025-06-06', 58, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 80, 6, '2025-06-06', 58, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 81, 8, '2025-06-06', 58, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 82, 14, '2025-06-06', 59, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 83, 21, '2025-06-06', 60, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 84, 2, '2025-06-06', 60, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 85, 13, '2025-06-06', 61, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 86, 1, '2025-06-06', 61, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 87, 3, '2025-06-06', 62, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 88, 18, '2025-06-06', 63, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 89, 5, '2025-06-06', 63, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 90, 10, '2025-06-06', 64, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 91, 5, '2025-06-06', 64, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 92, 1, '2025-06-06', 64, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 93, 24, '2025-06-06', 65, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 94, 3, '2025-06-06', 65, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 95, 10, '2025-06-06', 66, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 96, 5, '2025-06-06', 67, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 97, 1, '2025-06-06', 67, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 98, 15, '2025-06-06', 68, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 99, 8, '2025-06-06', 68, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 100, 11, '2025-06-06', 69, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 101, 6, '2025-06-06', 69, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 102, 1, '2025-06-06', 69, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 103, 6, '2025-06-06', 70, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 104, 8, '2025-06-06', 70, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 105, 2, '2025-06-06', 70, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 106, 22, '2025-06-06', 71, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 107, 13, '2025-06-06', 72, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 108, 1, '2025-06-06', 72, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 109, 16, '2025-06-06', 73, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 110, 5, '2025-06-06', 73, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 111, 2, '2025-06-06', 73, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 112, 6, '2025-06-06', 74, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 113, 10, '2025-06-06', 74, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 114, 11, '2025-06-06', 75, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 115, 16, '2025-06-06', 76, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 116, 4, '2025-06-06', 76, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 117, 22, '2025-06-06', 77, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 118, 2, '2025-06-06', 77, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 119, 5, '2025-06-06', 78, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 120, 2, '2025-06-06', 78, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 121, 10, '2025-06-06', 79, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 122, 4, '2025-06-06', 79, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 123, 17, '2025-06-06', 80, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 124, 3, '2025-06-06', 80, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 125, 16, '2025-06-06', 81, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 126, 2, '2025-06-06', 81, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 127, 10, '2025-06-06', 82, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 128, 6, '2025-06-06', 82, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 129, 14, '2025-06-06', 83, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 130, 2, '2025-06-06', 83, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 131, 4, '2025-06-06', 84, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 132, 7, '2025-06-06', 85, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 133, 11, '2025-06-06', 85, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 134, 3, '2025-06-06', 85, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 135, 9, '2025-06-06', 86, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 136, 5, '2025-06-06', 86, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 137, 1, '2025-06-06', 86, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 138, 3, '2025-06-06', 87, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 139, 5, '2025-06-06', 88, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 140, 17, '2025-06-06', 89, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 141, 6, '2025-06-06', 89, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 142, 2, '2025-06-06', 89, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 143, 9, '2025-06-06', 90, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 144, 5, '2025-06-06', 90, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 145, 2, '2025-06-06', 90, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 146, 7, '2025-06-06', 91, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 147, 5, '2025-06-06', 91, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 148, 1, '2025-06-06', 91, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 149, 5, '2025-06-06', 92, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 150, 12, '2025-06-06', 92, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 151, 1, '2025-06-06', 92, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 152, 11, '2025-06-06', 93, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 153, 2, '2025-06-06', 93, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 154, 5, '2025-06-06', 94, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 155, 6, '2025-06-06', 94, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 156, 11, '2025-06-06', 95, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 157, 3, '2025-06-06', 95, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 158, 8, '2025-06-06', 96, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 159, 1, '2025-06-06', 96, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 160, 6, '2025-06-06', 97, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 161, 1, '2025-06-06', 97, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 162, 4, '2025-06-06', 98, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 163, 13, '2025-06-06', 99, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 164, 3, '2025-06-06', 99, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 165, 9, '2025-06-06', 100, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 166, 7, '2025-06-06', 100, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 167, 5, '2025-06-06', 100, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 168, 2, '2025-06-06', 100, 1, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 169, 4, '2025-06-06', 101, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 170, 17, '2025-06-06', 102, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 171, 2, '2025-06-06', 102, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 172, 7, '2025-06-06', 103, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 173, 2, '2025-06-06', 103, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 174, 6, '2025-06-06', 104, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 175, 1, '2025-06-06', 104, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 176, 13, '2025-06-06', 105, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 177, 3, '2025-06-06', 105, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 178, 5, '2025-06-06', 106, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 179, 9, '2025-06-06', 106, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 180, 3, '2025-06-06', 106, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 181, 21, '2025-06-06', 107, 4, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 182, 9, '2025-06-06', 108, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 183, 2, '2025-06-06', 108, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 184, 9, '2025-06-06', 109, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 185, 2, '2025-06-06', 109, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 186, 8, '2025-06-06', 110, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 187, 1, '2025-06-06', 110, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 188, 25, '2025-06-06', 111, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 189, 2, '2025-06-06', 111, 2, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 190, 12, '2025-06-06', 112, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 191, 7, '2025-06-06', 112, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 192, 16, '2025-06-06', 113, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 193, 8, '2025-06-06', 113, 3, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 194, 2, '2025-06-06', 113, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 195, 25, '2025-06-06', 114, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 196, 10, '2025-06-06', 115, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 197, 5, '2025-06-06', 115, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 198, 10, '2025-06-06', 116, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 199, 6, '2025-06-06', 117, 2, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 200, 7, '2025-06-06', 117, 4, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 201, 1, '2025-06-06', 117, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 202, 22, '2025-06-06', 118, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 203, 2, '2025-06-06', 118, 3, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 204, 15, '2025-06-06', 119, 1, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 205, 1, '2025-06-06', 119, 4, 3);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 206, 10, '2025-06-06', 120, 1, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 207, 7, '2025-06-06', 120, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 208, 1, '2025-06-06', 120, 3, 2);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 209, 6, '2025-06-06', 121, 2, 1);
INSERT INTO soutenance.sortant_magasin( id_sortant_magasin, quantite_sortie, date_sortie, entree_magasin_id, agent_id, shift_id ) VALUES ( 210, 2, '2025-06-06', 121, 2, 1);
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 27, 'EXA Trading', '4001234567');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 28, 'CFM', '4003456789');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 29, 'MON LITCHI', '4011234560');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 30, 'COMEX', '4012345671');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 31, 'MCO TRADE', '4013456782');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 32, 'MADAPRO', '4014567893');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 33, 'GETCO', '4021234564');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 34, 'SKCC', '4022345675');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 35, 'GASYFRUITS', '4023456786');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 36, 'Fruit de Caresse', '4031234567');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 37, 'GDM FARAKA', '4032345678');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 38, 'ROSIN', '4033456789');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 39, 'SODIFRUITS', '4041234560');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 40, 'LITE', '4042345671');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 41, 'QUALITYMAD', '4043456782');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 42, 'TROPICAL FRUIT', '4044567893');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 43, 'FALLY', '4051234564');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 44, 'RASSETA', '4053456786');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 45, 'SCIM', '4061234567');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 46, 'FRUIT ILES 142', '4062345678');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 47, 'SAMEVAH', '4071234560');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 48, 'MLE', '4072345671');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 49, 'SCRIMAD', '4073456782');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 50, 'SODIAT', '4074567893');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 51, 'MIRA', '4081234564');
INSERT INTO soutenance.station( id_station, station, nif_stat ) VALUES ( 52, 'EMEXAL', '4082345675');
INSERT INTO soutenance.type_navire( id_type_navire, type_navire ) VALUES ( 1, 'Transporteur');
INSERT INTO soutenance.utilisateur( id_utilisateur, matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at ) VALUES ( 1, '20240901', 'Greg', 'Johnson', '1985-06-15', '12345678', 'Doe', 1, 1, 1, '2025-05-21 11.24.23 PM');
INSERT INTO soutenance.utilisateur( id_utilisateur, matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at ) VALUES ( 2, '20240902', 'Smith', 'Jane', '1990-04-22', '87654321', 'Smith', 2, 2, 2, '2025-05-21 11.24.23 PM');
INSERT INTO soutenance.utilisateur( id_utilisateur, matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at ) VALUES ( 3, '20250902', 'Mirantsoa', 'Fanyah', '2006-03-22', '89694321', 'Fanyah', 2, 3, 2, '2025-05-21 11.28.00 PM');
INSERT INTO soutenance.utilisateur( id_utilisateur, matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at ) VALUES ( 4, '20251902', 'Fanomezantsoa', 'Mario', '2002-03-09', '80694321', 'Mario', 2, 4, 2, '2025-06-01 12.13.02 AM');
