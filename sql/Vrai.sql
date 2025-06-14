INSERT INTO situation_familial (situation_familial) VALUES
('Célibataire'),
('Marié');

INSERT INTO sexe (sexe) VALUES
('Homme'),
('Femme');

INSERT INTO role (role) VALUES
('Administrateur'),
('Agent_entree'),
('Agent_sortie'),
('Agent_embarquement');

INSERT INTO type_navire (type_navire) VALUES
('Transporteur');

INSERT INTO station (station, nif_stat) VALUES
('EXA Trading', '4001234567'),
('CFM', '4003456789'),
('MON LITCHI', '4011234560'),
('COMEX', '4012345671'),
('MCO TRADE', '4013456782'),
('MADAPRO', '4014567893'),
('GETCO', '4021234564'),
('SKCC', '4022345675'),
('GASYFRUITS', '4023456786'),
('Fruit de Caresse', '4031234567'),
('GDM FARAKA', '4032345678'),
('ROSIN', '4033456789'),
('SODIFRUITS', '4041234560'),
('LITE', '4042345671'),
('QUALITYMAD', '4043456782'),
('TROPICAL FRUIT', '4044567893'),
('FALLY', '4051234564'),
('RASSETA', '4053456786'),
('SCIM', '4061234567'),
('FRUIT ILES 142', '4062345678'),
('SAMEVAH', '4071234560'),
('MLE', '4072345671'),
('SCRIMAD', '4073456782'),
('SODIAT', '4074567893'),
('MIRA', '4081234564'),
('EMEXAL', '4082345675');

INSERT INTO magasin (magasin) VALUES
('Magasin B1');

INSERT INTO utilisateur (matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id,created_at)
VALUES
('20240901', 'Greg', 'Johnson', '1985-06-15', '12345678', 'Doe', 1, 1, 1,now()),
('20240902', 'Smith', 'Jane', '1990-04-22', '87654321', 'Smith', 2, 2, 2,now()),
('20250902', 'Mirantsoa', 'Fanyah', '2006-03-22', '89694321', 'Fanyah', 2, 3, 2,now()),
('20251902', 'Fanomezantsoa', 'Mario', '2002-03-09', '80694321', 'Mario', 2, 4, 2,now());

INSERT INTO compagne (annee, debut, fin, etat) VALUES
(2024, '2024-11-03', null, 0);

INSERT INTO navire (navire, nb_compartiment, quantite_max, type_navire_id) VALUES
('Atlantic klipper', 5, 4700 , 1),
('Trust', 4, 4000, 1);

INSERT INTO mouvement_navire (compagne_id, date_arriver, date_depart, navire_id) VALUES
(1, '2024-11-12', '', 1);
