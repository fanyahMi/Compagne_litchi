use io;

----Magasin
select 
    e.navire_id, 
    e.date_entrant, 
    sum(e.quantite_palette) as quantite_palette
from 
entree_magasin e
join mouvement_navire m 
    on e.navire_id = m.navire_id
where m.date_depart is null
group by e.navire_id, e.date_entrant;

--- sortie
select 
    e.navire_id, 
    sr.date_sortie, 
    sum(sr.quantite_sortie) as quantite_palette
from 
sortant_magasin sr
join entree_magasin e
    on sr.entree_magasin_id = e.id_entree_magasin  
join mouvement_navire m 
    on e.navire_id = m.navire_id
where m.date_depart is null
group by e.navire_id, sr.date_sortie;

---shift entree
select 
    e.navire_id, 
    e.date_entrant, 
    e.shift_id, s.debut, s.fin,
    sum(e.quantite_palette) as quantite_palette
from 
entree_magasin e
join shift s 
    on e.shift_id = s.id_shift
join mouvement_navire m 
    on e.navire_id = m.navire_id
where m.date_depart is null
group by e.navire_id, e.shift_id, s.debut, s.fin;

---shift sortie
select 
    e.navire_id, 
    sr.date_sortie, 
sr.shift_id, s.debut, s.fin,
    sum(sr.quantite_sortie) as quantite_palette
from 
sortant_magasin sr
join shift s
    on sr.shift_id = s.id_shift
join entree_magasin e
    on sr.entree_magasin_id = e.id_entree_magasin  
join mouvement_navire m 
    on e.navire_id = m.navire_id
where m.date_depart is null
group by e.navire_id, sr.date_sortie, sr.shift_id, s.debut, s.fin;


----embraquement 
select 
    b.navire_id, 
    b.date_embarquement, 
    b.shift_id, s.debut, s.fin, 
    sum(b.nombre_pallets) as nombre_pallets
from embarquement b
join mouvement_navire m 
    on b.navire_id = m.navire_id
join shift s
    on b.shift_id = s.id_shift
where m.date_depart is null
group by b.navire_id, 
    b.date_embarquement, 
    b.shift_id, s.debut, s.fin;

---- call 
select 
    b.navire_id, 
    b.numero_cal, 
    sum(b.nombre_pallets) as nombre_pallets
from embarquement b
join mouvement_navire m 
    on b.navire_id = m.navire_id
where m.date_depart is null
group by b.navire_id, b.numero_cal;


---- 
SELECT v.navire, v.id_navire, v.quotas_navire,
               SUM(e.nombre_pallets) AS total_pallets,
               ROUND((SUM(e.nombre_pallets) / NULLIF(v.quotas_navire, 0) * 100), 2) AS pourcentage_quota
        FROM v_quotas_navire_compagne AS v
        LEFT JOIN embarquement AS e ON v.id_navire = e.navire_id
        WHERE v.id_compagne = (
            select c.id_compagne 
                from compagne c
                where c.etat = 0
) AND v.id_navire = (
    select mn.navire_id
from mouvement_navire mn 
where mn.date_depart is null
)
      GROUP BY v.navire, v.id_navire, v.quotas_navire;

--- Chart 
WITH heures AS (
    SELECT h.heure
    FROM (
        SELECT 0 AS heure UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION 
        SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION 
        SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION 
        SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION 
        SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23
    ) h
),
dates AS (
    SELECT DISTINCT date_embarquement AS date
    FROM embarquement
),
combinaisons AS (
    SELECT d.date, h.heure, s.id_shift, s.description AS shift_description
    FROM dates d
    CROSS JOIN heures h
    CROSS JOIN shift s
)
SELECT 
    c.date,
    c.heure,
    c.id_shift,
    c.shift_description,
    COALESCE(COUNT(e.id_embarquement), 0) AS nombre_mouvements
FROM 
    combinaisons c
LEFT JOIN 
    embarquement e 
    ON e.date_embarquement = c.date 
    AND HOUR(e.heure_embarquement) = c.heure 
    AND e.shift_id = c.id_shift
GROUP BY 
    c.date, c.heure, c.id_shift, c.shift_description
ORDER BY 
    c.date, c.id_shift, c.heure;