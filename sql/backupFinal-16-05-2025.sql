CREATE SCHEMA hasinjo;

CREATE  TABLE  compagne ( 
	id_compagne          INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	annee                INT  NOT NULL     ,
	debut                DATE  NOT NULL     ,
	fin                  DATE       ,
	etat                 INT   DEFAULT 0    ,
	CONSTRAINT annee UNIQUE ( annee ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  importation_quotas ( 
	station              VARCHAR(50)       ,
	compagne_id          INT       ,
	numero_station       INT       ,
	navire               VARCHAR(50)       ,
	quotas               DECIMAL(30,2)       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  magasin ( 
	id_magasin           INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	magasin              VARCHAR(50)  NOT NULL     ,
	CONSTRAINT magasin UNIQUE ( magasin ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  role ( 
	id_role              INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	role                 VARCHAR(50)  NOT NULL     ,
	CONSTRAINT role UNIQUE ( role ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  sexe ( 
	id_sexe              INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	sexe                 VARCHAR(50)  NOT NULL     ,
	CONSTRAINT sexe UNIQUE ( sexe ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  shift ( 
	id_shift             INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	description          TEXT  NOT NULL     ,
	debut                TIME       ,
	fin                  TIME       
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  situation_familial ( 
	id_situation_familial INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	situation_familial   CHAR(60)  NOT NULL     ,
	CONSTRAINT situation_familial UNIQUE ( situation_familial ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  station ( 
	id_station           INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	station              VARCHAR(50)  NOT NULL     ,
	nif_stat             VARCHAR(50)  NOT NULL     ,
	CONSTRAINT station UNIQUE ( station ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  type_navire ( 
	id_type_navire       INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	type_navire          VARCHAR(50)  NOT NULL     ,
	CONSTRAINT type_navire UNIQUE ( type_navire ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE  TABLE  utilisateur ( 
	id_utilisateur       INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	matricule            VARCHAR(20)  NOT NULL     ,
	nom                  VARCHAR(70)  NOT NULL     ,
	prenom               VARCHAR(70)       ,
	date_naissance       DATE  NOT NULL     ,
	cin                  VARCHAR(50)  NOT NULL     ,
	mot_passe            TEXT  NOT NULL     ,
	sexe_id              INT  NOT NULL     ,
	role_id              INT  NOT NULL     ,
	situation_familial_id INT  NOT NULL     ,
	created_at           TIMESTAMP  NOT NULL     ,
	CONSTRAINT matricule UNIQUE ( matricule ) ,
	CONSTRAINT cin UNIQUE ( cin ) ,
	CONSTRAINT mot_passe UNIQUE ( mot_passe ) USING HASH
 ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX sexe_id ON  utilisateur ( sexe_id );

CREATE INDEX role_id ON  utilisateur ( role_id );

CREATE INDEX situation_familial_id ON  utilisateur ( situation_familial_id );

CREATE  TABLE  wp_commentmeta ( 
	meta_id              BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	comment_id           BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	meta_key             VARCHAR(255)       ,
	meta_value           LONGTEXT       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX comment_id ON  wp_commentmeta ( comment_id );

CREATE INDEX meta_key ON  wp_commentmeta ( meta_key (191) );

CREATE  TABLE  wp_comments ( 
	`comment_ID`         BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	`comment_post_ID`    BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	comment_author       TINYTEXT  NOT NULL     ,
	comment_author_email VARCHAR(100)  NOT NULL DEFAULT ''    ,
	comment_author_url   VARCHAR(200)  NOT NULL DEFAULT ''    ,
	`comment_author_IP`  VARCHAR(100)  NOT NULL DEFAULT ''    ,
	comment_date         DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	comment_date_gmt     DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	comment_content      TEXT  NOT NULL     ,
	comment_karma        INT  NOT NULL DEFAULT 0    ,
	comment_approved     VARCHAR(20)  NOT NULL DEFAULT '1'    ,
	comment_agent        VARCHAR(255)  NOT NULL DEFAULT ''    ,
	comment_type         VARCHAR(20)  NOT NULL DEFAULT 'comment'    ,
	comment_parent       BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	user_id              BIGINT UNSIGNED NOT NULL DEFAULT 0    
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX `comment_post_ID` ON  wp_comments ( `comment_post_ID` );

CREATE INDEX comment_approved_date_gmt ON  wp_comments ( comment_approved, comment_date_gmt );

CREATE INDEX comment_date_gmt ON  wp_comments ( comment_date_gmt );

CREATE INDEX comment_parent ON  wp_comments ( comment_parent );

CREATE INDEX comment_author_email ON  wp_comments ( comment_author_email (10) );

CREATE  TABLE  wp_links ( 
	link_id              BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	link_url             VARCHAR(255)  NOT NULL DEFAULT ''    ,
	link_name            VARCHAR(255)  NOT NULL DEFAULT ''    ,
	link_image           VARCHAR(255)  NOT NULL DEFAULT ''    ,
	link_target          VARCHAR(25)  NOT NULL DEFAULT ''    ,
	link_description     VARCHAR(255)  NOT NULL DEFAULT ''    ,
	link_visible         VARCHAR(20)  NOT NULL DEFAULT 'Y'    ,
	link_owner           BIGINT UNSIGNED NOT NULL DEFAULT 1    ,
	link_rating          INT  NOT NULL DEFAULT 0    ,
	link_updated         DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	link_rel             VARCHAR(255)  NOT NULL DEFAULT ''    ,
	link_notes           MEDIUMTEXT  NOT NULL     ,
	link_rss             VARCHAR(255)  NOT NULL DEFAULT ''    
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX link_visible ON  wp_links ( link_visible );

CREATE  TABLE  wp_options ( 
	option_id            BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	option_name          VARCHAR(191)  NOT NULL DEFAULT ''    ,
	option_value         LONGTEXT  NOT NULL     ,
	autoload             VARCHAR(20)  NOT NULL DEFAULT 'yes'    ,
	CONSTRAINT option_name UNIQUE ( option_name ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX autoload ON  wp_options ( autoload );

CREATE  TABLE  wp_postmeta ( 
	meta_id              BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	post_id              BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	meta_key             VARCHAR(255)       ,
	meta_value           LONGTEXT       
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX post_id ON  wp_postmeta ( post_id );

CREATE INDEX meta_key ON  wp_postmeta ( meta_key (191) );

CREATE  TABLE  wp_posts ( 
	`ID`                 BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	post_author          BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	post_date            DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	post_date_gmt        DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	post_content         LONGTEXT  NOT NULL     ,
	post_title           TEXT  NOT NULL     ,
	post_excerpt         TEXT  NOT NULL     ,
	post_status          VARCHAR(20)  NOT NULL DEFAULT 'publish'    ,
	comment_status       VARCHAR(20)  NOT NULL DEFAULT 'open'    ,
	ping_status          VARCHAR(20)  NOT NULL DEFAULT 'open'    ,
	post_password        VARCHAR(255)  NOT NULL DEFAULT ''    ,
	post_name            VARCHAR(200)  NOT NULL DEFAULT ''    ,
	to_ping              TEXT  NOT NULL     ,
	pinged               TEXT  NOT NULL     ,
	post_modified        DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	post_modified_gmt    DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	post_content_filtered LONGTEXT  NOT NULL     ,
	post_parent          BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	guid                 VARCHAR(255)  NOT NULL DEFAULT ''    ,
	menu_order           INT  NOT NULL DEFAULT 0    ,
	post_type            VARCHAR(20)  NOT NULL DEFAULT 'post'    ,
	post_mime_type       VARCHAR(100)  NOT NULL DEFAULT ''    ,
	comment_count        BIGINT  NOT NULL DEFAULT 0    
 ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX post_name ON  wp_posts ( post_name (191) );

CREATE INDEX type_status_date ON  wp_posts ( post_type, post_status, post_date, `ID` );

CREATE INDEX post_parent ON  wp_posts ( post_parent );

CREATE INDEX post_author ON  wp_posts ( post_author );

CREATE  TABLE  wp_term_relationships ( 
	object_id            BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	term_taxonomy_id     BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	term_order           INT  NOT NULL DEFAULT 0    ,
	CONSTRAINT pk_wp_term_relationships PRIMARY KEY ( object_id, term_taxonomy_id )
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX term_taxonomy_id ON  wp_term_relationships ( term_taxonomy_id );

CREATE  TABLE  wp_term_taxonomy ( 
	term_taxonomy_id     BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	term_id              BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	taxonomy             VARCHAR(32)  NOT NULL DEFAULT ''    ,
	description          LONGTEXT  NOT NULL     ,
	parent               BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	count                BIGINT  NOT NULL DEFAULT 0    ,
	CONSTRAINT term_id_taxonomy UNIQUE ( term_id, taxonomy ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX taxonomy ON  wp_term_taxonomy ( taxonomy );

CREATE  TABLE  wp_termmeta ( 
	meta_id              BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	term_id              BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	meta_key             VARCHAR(255)       ,
	meta_value           LONGTEXT       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX term_id ON  wp_termmeta ( term_id );

CREATE INDEX meta_key ON  wp_termmeta ( meta_key (191) );

CREATE  TABLE  wp_terms ( 
	term_id              BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	name                 VARCHAR(200)  NOT NULL DEFAULT ''    ,
	slug                 VARCHAR(200)  NOT NULL DEFAULT ''    ,
	term_group           BIGINT  NOT NULL DEFAULT 0    
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX slug ON  wp_terms ( slug (191) );

CREATE INDEX name ON  wp_terms ( name (191) );

CREATE  TABLE  wp_usermeta ( 
	umeta_id             BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	user_id              BIGINT UNSIGNED NOT NULL DEFAULT 0    ,
	meta_key             VARCHAR(255)       ,
	meta_value           LONGTEXT       
 ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX user_id ON  wp_usermeta ( user_id );

CREATE INDEX meta_key ON  wp_usermeta ( meta_key (191) );

CREATE  TABLE  wp_users ( 
	`ID`                 BIGINT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	user_login           VARCHAR(60)  NOT NULL DEFAULT ''    ,
	user_pass            VARCHAR(255)  NOT NULL DEFAULT ''    ,
	user_nicename        VARCHAR(50)  NOT NULL DEFAULT ''    ,
	user_email           VARCHAR(100)  NOT NULL DEFAULT ''    ,
	user_url             VARCHAR(100)  NOT NULL DEFAULT ''    ,
	user_registered      DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00'    ,
	user_activation_key  VARCHAR(255)  NOT NULL DEFAULT ''    ,
	user_status          INT  NOT NULL DEFAULT 0    ,
	display_name         VARCHAR(250)  NOT NULL DEFAULT ''    
 ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE INDEX user_login_key ON  wp_users ( user_login );

CREATE INDEX user_nicename ON  wp_users ( user_nicename );

CREATE INDEX user_email ON  wp_users ( user_email );

CREATE  TABLE  navire ( 
	id_navire            INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	navire               VARCHAR(50)  NOT NULL     ,
	nb_compartiment      INT  NOT NULL     ,
	quantite_max         DECIMAL(10,2)       ,
	type_navire_id       INT  NOT NULL     ,
	CONSTRAINT navire UNIQUE ( navire ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX type_navire_id ON  navire ( type_navire_id );

CREATE  TABLE  numero_station ( 
	id_numero_station    INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	compagne_id          INT  NOT NULL     ,
	station_id           INT  NOT NULL     ,
	numero_station       INT  NOT NULL     ,
	CONSTRAINT compagne_id UNIQUE ( compagne_id, numero_station ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX station_id ON  numero_station ( station_id );

CREATE  TABLE  quotas ( 
	id_quotas            INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	navire_id            INT  NOT NULL     ,
	numero_station_id    INT  NOT NULL     ,
	quotas               DECIMAL(30,2)  NOT NULL     
 ) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX navire_id ON  quotas ( navire_id );

CREATE INDEX numero_station_id ON  quotas ( numero_station_id );

CREATE  TABLE  embarquement ( 
	id_embarquement      INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	utilisateur_id       INT  NOT NULL     ,
	shift_id             INT  NOT NULL     ,
	navire_id            INT  NOT NULL     ,
	numero_cal           INT  NOT NULL     ,
	nombre_pallets       INT  NOT NULL     ,
	numero_station_id    INT  NOT NULL     ,
	date_embarquement    DATE   DEFAULT curdate()    ,
	heure_embarquement   TIME   DEFAULT curtime()    
 ) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX utilisateur_id ON  embarquement ( utilisateur_id );

CREATE INDEX shift_id ON  embarquement ( shift_id );

CREATE INDEX numero_station_id ON  embarquement ( numero_station_id );

CREATE INDEX navire_id ON  embarquement ( navire_id );

CREATE  TABLE  entree_magasin ( 
	id_entree_magasin    INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	numero_camion        VARCHAR(50)  NOT NULL     ,
	bon_livraison        VARCHAR(50)  NOT NULL     ,
	path_bon_livraison   TEXT  NOT NULL     ,
	chauffeur            VARCHAR(60)  NOT NULL     ,
	quantite_palette     DOUBLE  NOT NULL     ,
	date_entrant         DATE  NOT NULL     ,
	agent_id             INT  NOT NULL     ,
	numero_station_id    INT  NOT NULL     ,
	magasin_id           INT  NOT NULL     ,
	navire_id            INT  NOT NULL     ,
	shift_id             INT       ,
	CONSTRAINT bon_livraison UNIQUE ( bon_livraison ) 
 ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX agent_id ON  entree_magasin ( agent_id );

CREATE INDEX numero_station_id ON  entree_magasin ( numero_station_id );

CREATE INDEX navire_id ON  entree_magasin ( navire_id );

CREATE INDEX magasin_id ON  entree_magasin ( magasin_id );

CREATE INDEX fk_shift_id ON  entree_magasin ( shift_id );

CREATE  TABLE  mouvement_navire ( 
	id_mouvement_navire  INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	compagne_id          INT  NOT NULL     ,
	date_arriver         DATE  NOT NULL     ,
	date_depart          VARCHAR(50)       ,
	navire_id            INT  NOT NULL     
 ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX compagne_id ON  mouvement_navire ( compagne_id );

CREATE INDEX navire_id ON  mouvement_navire ( navire_id );

CREATE  TABLE  sortant_magasin ( 
	id_sortant_magasin   INT  NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	quantite_sortie      INT  NOT NULL     ,
	date_sortie          DATE  NOT NULL     ,
	entree_magasin_id    INT  NOT NULL     ,
	agent_id             INT  NOT NULL     ,
	shift_id             INT       
 ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE INDEX entree_magasin_id ON  sortant_magasin ( entree_magasin_id );

CREATE INDEX agent_id ON  sortant_magasin ( agent_id );

CREATE INDEX fk_shift_id_sortant_magasin ON  sortant_magasin ( shift_id );

ALTER TABLE  embarquement ADD CONSTRAINT embarquement_ibfk_1 FOREIGN KEY ( utilisateur_id ) REFERENCES  utilisateur( id_utilisateur ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  embarquement ADD CONSTRAINT embarquement_ibfk_2 FOREIGN KEY ( shift_id ) REFERENCES  shift( id_shift ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  embarquement ADD CONSTRAINT embarquement_ibfk_3 FOREIGN KEY ( numero_station_id ) REFERENCES  numero_station( id_numero_station ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  embarquement ADD CONSTRAINT embarquement_ibfk_4 FOREIGN KEY ( navire_id ) REFERENCES  navire( id_navire ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  entree_magasin ADD CONSTRAINT entree_magasin_ibfk_1 FOREIGN KEY ( agent_id ) REFERENCES  utilisateur( id_utilisateur ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  entree_magasin ADD CONSTRAINT entree_magasin_ibfk_2 FOREIGN KEY ( numero_station_id ) REFERENCES  numero_station( id_numero_station ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  entree_magasin ADD CONSTRAINT entree_magasin_ibfk_3 FOREIGN KEY ( navire_id ) REFERENCES  navire( id_navire ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  entree_magasin ADD CONSTRAINT entree_magasin_ibfk_4 FOREIGN KEY ( magasin_id ) REFERENCES  magasin( id_magasin ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  entree_magasin ADD CONSTRAINT fk_shift_id FOREIGN KEY ( shift_id ) REFERENCES  shift( id_shift ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  mouvement_navire ADD CONSTRAINT mouvement_navire_ibfk_1 FOREIGN KEY ( compagne_id ) REFERENCES  compagne( id_compagne ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  mouvement_navire ADD CONSTRAINT mouvement_navire_ibfk_2 FOREIGN KEY ( navire_id ) REFERENCES  navire( id_navire ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  navire ADD CONSTRAINT navire_ibfk_1 FOREIGN KEY ( type_navire_id ) REFERENCES  type_navire( id_type_navire ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  numero_station ADD CONSTRAINT numero_station_ibfk_1 FOREIGN KEY ( compagne_id ) REFERENCES  compagne( id_compagne ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  numero_station ADD CONSTRAINT numero_station_ibfk_2 FOREIGN KEY ( station_id ) REFERENCES  station( id_station ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  quotas ADD CONSTRAINT quotas_ibfk_1 FOREIGN KEY ( navire_id ) REFERENCES  navire( id_navire ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  quotas ADD CONSTRAINT quotas_ibfk_2 FOREIGN KEY ( numero_station_id ) REFERENCES  numero_station( id_numero_station ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  sortant_magasin ADD CONSTRAINT fk_shift_id_sortant_magasin FOREIGN KEY ( shift_id ) REFERENCES  shift( id_shift ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  sortant_magasin ADD CONSTRAINT sortant_magasin_ibfk_1 FOREIGN KEY ( entree_magasin_id ) REFERENCES  entree_magasin( id_entree_magasin ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  sortant_magasin ADD CONSTRAINT sortant_magasin_ibfk_2 FOREIGN KEY ( agent_id ) REFERENCES  utilisateur( id_utilisateur ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  utilisateur ADD CONSTRAINT utilisateur_ibfk_1 FOREIGN KEY ( sexe_id ) REFERENCES  sexe( id_sexe ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  utilisateur ADD CONSTRAINT utilisateur_ibfk_2 FOREIGN KEY ( role_id ) REFERENCES  role( id_role ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE  utilisateur ADD CONSTRAINT utilisateur_ibfk_3 FOREIGN KEY ( situation_familial_id ) REFERENCES  situation_familial( id_situation_familial ) ON DELETE NO ACTION ON UPDATE NO ACTION;
