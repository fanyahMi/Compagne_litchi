create or replace view v_utilisateur_global as
select
    u.id_utilisateur, u.matricule, u.nom, u.prenom, u.date_naissance, u.cin, u.mot_passe,
    s.id_sexe, s.sexe,
    r.id_role, r.role,
    st.id_situation_familial, st.situation_familial
from utilisateur u
join sexe s on s.id_sexe = u.sexe_id
join role r on r.id_role = u.role_id
join situation_familial st on st.id_situation_familial = u.situation_familial_id ;
