DROP DATABASE IF EXISTS ProjetIO2;
CREATE DATABASE ProjetIO2;
USE ProjetIO2;

DROP TABLE IF EXISTS membres;
CREATE TABLE IF NOT EXISTS membres (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pseudo VARCHAR(255) NOT NULL DEFAULT '',
  mail VARCHAR(255) NOT NULL DEFAULT '',
  motdepasse TEXT NOT NULL ,
  bio VARCHAR(520) NOT NULL DEFAULT 'Ceci est la bio vous pouvez la modifier',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO  membres (pseudo , mail , motdepasse , bio)
     VALUES  ('admin' , 'admin@mail.com' , 'd033e22ae348aeb5660fc2140aec35850c4da997' , 'Compte administrateur'),
     -- creation de deux utilisateur de base un qui sera un administrateur avec des droits supplementaires
     -- et un qui simule un utilisateur lambda
     -- mdp admin : admin
     -- mdp dftusr : 1234
     ('dftusr' , 'usr@mail.com' , '7110eda4d09e062aa5e4a390b0a572ac0d2c0220' , 'Ceci est la bio d\'un utilisateur type'),
     ('dftusr2' , 'usr2@mail.com' , '7110eda4d09e062aa5e4a390b0a572ac0d2c0220' , 'Ceci est la bio d\'un utilisateur type');
     ;

DROP TABLE IF EXISTS adminliste;
CREATE TABLE IF NOT EXISTS adminliste (
  id INT UNSIGNED NOT NULL,
  pseudo VARCHAR(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO adminliste (id , pseudo)
  VALUES (1 , 'admin');

  DROP TABLE IF EXISTS mini_golf;
  CREATE TABLE IF NOT EXISTS mini_golf (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL DEFAULT '',
    region VARCHAR(255) NOT NULL DEFAULT '',
    adresse TEXT NOT NULL,
    htmlmaps BLOB NOT NULL,
    nom_image TEXT NOT NULL ,
    image_path VARCHAR(255) DEFAULT 'photo_mini_golf',
      PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  INSERT INTO mini_golf (nom, region, nom_image , htmlmaps , adresse) VALUES
('Mini golf exotique du Lavandou', 'PACA', 'Mini-golf-exotique-du-Lavandou.jpg', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11646.376047164718!2d6.359448!3d43.1340542!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9cfed9997810f33f!2sMini-Golf%20Exotique%20du%20Lavandou!5e0!3m2!1sfr!2sfr!4v1649746281600!5m2!1sfr!2sfr' , 'Av. du Grand Jardin, 83980 Le Lavandou'),
('Baby Golf' , 'Nouvelle-Aquitaine' , 'Baby_Golf.jpg' , 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2894.199409490986!2d-1.5390919845072983!3d43.49817547912702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd516a938c770c51%3A0xd7cd591273c67ecb!2sBaby%20Golf!5e0!3m2!1sfr!2sfr!4v1649751588063!5m2!1sfr!2sfr' , '13 Rue de Bouney, 64600 Anglet'),
('Jungle Golf' , 'Nouvelle-Aquitaine' , 'Jungle_Golf.jpg' , 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2825.4318229665114!2d0.9296429155391189!3d44.91455327909837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12ab498efe9eec0f%3A0x82da19b9f76f89d6!2sJungle%20Golf!5e0!3m2!1sfr!2sfr!4v1649751889328!5m2!1sfr!2sfr' , '99 All. Paul-Jean Souriau, 24260 Le Bugue'),
('Fanstasti Golf' , 'Grand Est' , 'Fantasti_Golf.jpg' , 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2641.0458230463296!2d4.770117615663543!3d48.55151517925863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47ec772792807ddb%3A0xc7ffe3eaaff674f7!2sFantasti%20Golf!5e0!3m2!1sfr!2sfr!4v1649752038226!5m2!1sfr!2sfr' , ' Port Giffaumont rue, Les Marnes Graviers, 51290 Giffaumont-Champaubert'),
('Mini Golf Du Lac' , 'Auvergne-Rhône-Alpes' , 'Mini_Golf_Du_Lac.jpg' ,  'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2821.120241511313!2d4.892397115542046!3d45.00218007909821!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f55a66aa6b93d1%3A0x79b60b4521ff093c!2sMini-Golf%20du%20Lac!5e0!3m2!1sfr!2sfr!4v1649778204490!5m2!1sfr!2sfr' , 'Quartier Les Iles, 26300 Châteauneuf-sur-Isère'),
('Mini GOLF des bords de Saône' , 'Auvergne-Rhône-Alpes' , 'MINI_GOLF_des_bords_de_Saône.jpg' , 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2779.759909396833!2d4.833855615569951!3d45.83608877910703!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f494f949726595%3A0xc78f394463eaa138!2sMINI%20GOLF%20des%20bords%20de%20Sa%C3%B4ne%20(ROCHETAILLEE)!5e0!3m2!1sfr!2sfr!4v1649778460882!5m2!1sfr!2sfr' , '565 Chem. de la Plage, 69270 Rochetaillée-sur-Saône'),
('L\'aventure MINO GOLF' , 'Occitanie', 'Aventure_Mini_Golf.jpeg', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11571.26146243579!2d4.1408207!3d43.5270428!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x667f98d4fbfc50d8!2sL&#39;Aventure%20Mini%20Golf!5e0!3m2!1sfr!2sfr!4v1650969169113!5m2!1sfr!2sfr', '675 avenue du Palais de la Mer, Le Grau-du-Roi'),
('Minigolf Californien', 'Occitanie', 'Mini_golf_Califonien.jpeg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5946782.584297918!2d0.5083018858524556!3d43.299552899999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b117de5007f539%3A0x61d390eea77688c6!2sMinigolf%20Californien%20Vias%20Plage!5e0!3m2!1sfr!2sfr!4v1650723667739!5m2!1sfr!2sfr', '283 Av. de la Méditerranée, 34450 Vias'),
('Mini Golf de Calvi', 'Corse', 'Mini_golf_Calvi.jpg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d378440.2344360052!2d8.796474891814926!3d42.18099982785027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d0eb6f9abd6767%3A0x3fa83e795245d7cd!2sMini%20Golf!5e0!3m2!1sfr!2sfr!4v1650730557868!5m2!1sfr!2sfr', '20260 Calvi'),
('Mini-Golf de la Citadelle' , 'Bretagne', 'Mini_golf_de_la_Citadelle.jpeg', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d128738.78001130231!2d-3.354626822215303!3d47.70211722118865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48106084730a2a89%3A0x5d061f312c3e3e8a!2sMini-Golf%20de%20la%20Citadelle!5e0!3m2!1sfr!2sfr!4v1650903906169!5m2!1sfr!2sfr', 'Rue des Bains, 56290 Port-Louis')
;
;


DROP TABLE IF EXISTS avis;
CREATE TABLE avis(
  id_user INT NOT NULL ,
   note INT(5) NOT NULL ,
    com VARCHAR(420) NOT NULL DEFAULT 'N\'a pas commenté' ,
     id_golf INT NOT NULL ,
     report INT NOT NULL DEFAULT 0
   ) ENGINE = InnoDB;
INSERT INTO avis (id_user , note , id_golf ,  com, report) VALUES ( 2 , 4 , 2 , 'C\'est le meillieur golf de l\'univers', 0),(2 , 4 , 4 , 'J\'ai perdue contre mon petit frère mais j\'ai passé un temps super le staff est excellent' , 1),(3, 0 , 5, 'Woah comment ça à l\'air nulle jamais j\'y vais', 1);;


DROP TABLE IF EXISTS add_mini_golf;
CREATE TABLE add_mini_golf (
  nom VARCHAR(500) NOT NULL ,
  adresse VARCHAR(500) NOT NULL ,
  id_user INT NOT NULL
) ENGINE = InnoDB;
INSERT INTO add_mini_golf ( nom , adresse , id_user) VALUES ('POUETTE' , '46 rue de c\'est null les minigolf', 3), ('Goolfy' , 'à l\'intérieur du Kinépolis, 1 Rue du Château d\'Isenghien, 59160 Lille' , 2);;
