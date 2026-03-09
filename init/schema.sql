-- 1. Création de la table utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pilote', 'etudiant') NOT NULL
);

-- Insertion du compte Pilote
INSERT INTO utilisateurs (username, password, role) 
VALUES ('pilote_user', 'pilote123', 'pilote');


-- 2. Création de la table entreprises (CORRIGÉE)
CREATE TABLE IF NOT EXISTS entreprises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    secteur VARCHAR(255),
    localite VARCHAR(255)
);

-- Insertion des entreprises de test
INSERT INTO entreprises (nom, description, secteur, localite) VALUES 
('TechNova', 'Solutions cloud innovantes', 'Informatique', 'Paris'),
('EcoBuild', 'Construction durable et écologique', 'Bâtiment', 'Lyon'),
('SantePlus', 'Services de santé connectés', 'Médical', 'Bordeaux'),
('CyberGuard', 'Sécurité informatique avancée', 'Cybersécurité', 'Lille');