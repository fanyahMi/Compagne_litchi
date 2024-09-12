INSERT INTO situation_familial (situation_familial) VALUES
('Célibataire'),
('Marié');

INSERT INTO sexe (sexe) VALUES
('Homme'),
('Femme');

INSERT INTO role (role) VALUES
('Administrateur'),
('Utilisateur');

INSERT INTO type_navire (type_navire) VALUES
('Cargo'),
('Pétrolier');

INSERT INTO station (station, nif_stat) VALUES
('Station A', '1234567890'),
('Station B', '0987654321');

INSERT INTO magasin (magasin) VALUES
('Magasin B1');

-- Exemple de données pour la table 'utilisateur' avec bcrypt
INSERT INTO utilisateur (matricule, nom, prenom, date_naissance, cin, mot_passe, sexe_id, role_id, situation_familial_id)
VALUES
('20240901', 'Doe', 'John', '1985-06-15', '12345678', 'Doe', 1, 1, 1),
('20240902', 'Smith', 'Jane', '1990-04-22', '87654321', 'Smith', 2, 2, 2);
