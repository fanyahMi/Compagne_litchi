INSERT INTO station (station, nif_stat) VALUES
('TotalEnergies', 'NIF001'),
('Shell', 'NIF002'),
('BP', 'NIF003'),
('Esso', 'NIF004'),
('Mobil', 'NIF005'),
('Chevron', 'NIF006');



CREATE  TABLE importation_quotas (
    station VARCHAR(50),
    compagne_id  int,
    numero_station int,
    navire VARCHAR(50),
    quotas  DECIMAL(30,2)
);

