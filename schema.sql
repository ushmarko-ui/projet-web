CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pilote', 'etudiant') NOT NULL
);

-- Création de ton compte Pilote
INSERT INTO utilisateurs (username, password, role) 
VALUES ('pilote_user', 'pilote123', 'pilote');