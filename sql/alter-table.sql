alter table
    entree_magasin
    add column path_bon_livraison text default "";

alter table
    entree_magasin
    add column 	navire_id int;

ALTER TABLE
    entree_magasin
    ADD CONSTRAINT fk_entree_magasin_navire
    FOREIGN KEY ( navire_id ) REFERENCES navire( id_navire );
