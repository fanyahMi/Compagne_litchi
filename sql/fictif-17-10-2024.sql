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
('Admin'),
('Utilisateur'),
('Gestionnaire');

-- Table type_navire
INSERT INTO type_navire (type_navire) VALUES
('Pêcheur'),
('Transporteur'),
('Remorqueur');

-- Table compagne
INSERT INTO compagne (annee, debut, fin, etat) VALUES
(2023, '2023-01-01', '2023-12-31', 1),
(2024, '2024-01-01', '2024-12-31', 0);

-- Table station
INSERT INTO station (station, nif_stat) VALUES
('Station Alpha', 'NIF12345'),
('Station Beta', 'NIF67890');

-- Table numero_station
INSERT INTO numero_station (compagne_id, station_id, numero_station) VALUES
(1, 1, 101),
(1, 2, 102),
(2, 1, 201);

-- Table magasin
INSERT INTO magasin (magasin) VALUES
('Magasin Principal'),
('Magasin Secondaire');

-- Table utilisateur
INSERT INTO utilisateur (matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id, created_at) VALUES
('M1234', 'Dupont', 'Jean', '1990-05-15', 'CIN1234', 'password123', 1, 1, 1, CURRENT_TIMESTAMP),
('M5678', 'Durand', 'Marie', '1985-03-22', 'CIN5678', 'password456', 2, 2, 2, CURRENT_TIMESTAMP);

-- Table navire
INSERT INTO navire (navire, nb_compartiment, quantite_max, type_navire_id) VALUES
('Navire Alpha', 5, 100.50, 1),
('Navire Beta', 10, 200.75, 2);

-- Table quotas
INSERT INTO quotas (navire_id, numero_station_id, quotas) VALUES
(1, 1, 500.00),
(2, 2, 750.50);

-- Table mouvement_navire
INSERT INTO mouvement_navire (compagne_id, date_arriver, date_depart, navire_id) VALUES
(1, '2023-02-15', '2023-02-20', 1),
(2, '2024-03-01', NULL, 2);
