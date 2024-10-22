create or replace view v_utilisateur_global as
select
    u.id_utilisateur, u.matricule, u.nom, u.prenom, u.date_naissance, u.cin, u.mot_passe,
    u.sexe_id, s.sexe,
    u.role_id, r.role,
    u.situation_familial_id, st.situation_familial
from utilisateur u
join sexe s on s.id_sexe = u.sexe_id
join role r on r.id_role = u.role_id
join situation_familial st on st.id_situation_familial = u.situation_familial_id ;

CREATE or replace VIEW v_numero_station AS
SELECT
    s.id_station,
    s.station,
    c.id_compagne,
    c.annee,
    c.debut,
    c.fin,
    c.etat,
    ns.numero_station
FROM
    station s
CROSS JOIN
    compagne c
LEFT JOIN
    numero_station ns
ON
    s.id_station = ns.station_id
    AND c.id_compagne = ns.compagne_id
ORDER BY
    c.annee;
