CREATE TABLE ENSEIGNANT (
	ID_enseignant int AUTO_INCREMENT PRIMARY KEY,
	nom_enseignant varchar(50) NOT NULL,
	prenom_enseignant varchar(50) NOT NULL,
	matricule varchar(50) NOT NULL,
	email varchar(50) NOT NULL UNIQUE
);

CREATE TABLE UTILISATEUR(
	ID_connexion int AUTO_INCREMENT PRIMARY KEY,
	mot_de_passe varchar(255) NOT NULL,
	role_user varchar(50) NOT NULL check (role_user = "directeur" or role_user = "enseignant"),
	fk_id_enseignant int,
	FOREIGN KEY(fk_id_enseignant) REFERENCES ENSEIGNANT(ID_enseignant)
);
INSERT INTO UTILISATEUR(mot_de_passe, role_user, fk_id_enseignant)
VALUES ('$2y$10$EJ/pYuI/NjQSzDwL5wbesOZT8X0KQZrelz1z.cn4B9m0Jfp0AQAKO', "directrice", );

CREATE TABLE MATIERE (
	ID_matiere int AUTO_INCREMENT PRIMARY KEY,
	nom_matiere varchar(50) NOT NULL
);

CREATE TABLE ELEVE(
	Id_eleve int AUTO_INCREMENT PRIMARY KEY,
	nom_eleve varchar(50) NOT NULL,
	prenom_eleve varchar(50) NOT NULL,
	sexe_eleve varchar(10) NOT NULL,
	adresse_eleve varchar(50) NOT NULL,
	date_naissance DATE NOT NULL
);

CREATE TABLE ANNEE_SCOLAIRE(
	Id_anneeScolaire int AUTO_INCREMENT PRIMARY KEY,
	annee varchar(50) NOT NULL
);

CREATE TABLE COMPOSITION (
	ID_composition int AUTO_INCREMENT PRIMARY KEY,
	numero int NOT NULL check (numero BETWEEN 1 AND 3),
	date_composition DATE NOT NULL,
	trimestre int NOT NULL check (trimestre BETWEEN 1 AND 3),
	fk_id_anneeScolaire INT NOT NULL,
	FOREIGN KEY(fk_id_anneeScolaire) REFERENCES ANNEE_SCOLAIRE(Id_anneeScolaire)
);

CREATE TABLE CLASSE	(
	Id_classe int AUTO_INCREMENT PRIMARY KEY,
	nom_classe varchar(50) NOT NULL,
	fk_id_enseignant int,
	FOREIGN KEY (fk_id_enseignant) REFERENCES ENSEIGNANT(ID_enseignant)
);

CREATE TABLE INSCRIPTION(
	fk_id_eleve int,
	fk_id_classe int,
	fk_id_anneeScolaire int,
	statut varchar(10) NOT NULL check (statut IN ('admis', 'ajourne')),
	PRIMARY KEY (fk_id_eleve, fk_id_classe, fk_id_anneeScolaire),
	FOREIGN KEY (fk_id_classe) REFERENCES CLASSE(Id_classe),
	FOREIGN KEY (fk_id_eleve) REFERENCES ELEVE(Id_eleve),
	FOREIGN KEY (fk_id_anneeScolaire) REFERENCES ANNEE_SCOLAIRE(Id_anneeScolaire)
);

CREATE TABLE EVALUATION(
	Id_evaluation int AUTO_INCREMENT PRIMARY KEY,
	note float NOT NULL,
	fk_id_eleve int,
	fk_id_classe int,
	fk_id_anneeScolaire int,
	fk_id_matiere int,
	fk_id_composition int,
	FOREIGN KEY (fk_id_eleve, fk_id_classe, fk_id_anneeScolaire) REFERENCES INSCRIPTION(fk_id_eleve, fk_id_classe, fk_id_anneeScolaire),
	FOREIGN KEY (fk_id_matiere) REFERENCES MATIERE(ID_matiere),
	FOREIGN KEY (fk_id_composition) REFERENCES COMPOSITION(ID_composition)
);
