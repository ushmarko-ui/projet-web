CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pilote', 'etudiant') NOT NULL
);

--Création compte Pilote
INSERT INTO utilisateurs (username, password, role) 
VALUES ('pilote_user', 'pilote123', 'pilote');


-- Création entreprises 

CREATE TABLE IF NOT EXISTS entreprises (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255),
  description TEXT,
  mots_cles TEXT
);

INSERT INTO entreprises (nom, description, mots_cles)
VALUES ("TechCorp", "Entreprise informatique", "informatique, tech, logiciel");