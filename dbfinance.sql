CREATE DATABASE dbfinance;
USE dbfinance;

CREATE TABLE etablissement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    fond DECIMAL(12,2)
);

CREATE TABLE type_pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    taux FLOAT
);

CREATE TABLE client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100)
);
CREATE TABLE pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    type_pret_id INT,
    montant DECIMAL(12,2),
    duree INT, -- en mois
    date_debut DATE,
    FOREIGN KEY(client_id) REFERENCES client(id),
    FOREIGN KEY(type_pret_id) REFERENCES type_pret(id)
);
CREATE TABLE interet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    mois DATE,
    montant DECIMAL(12,2),
    FOREIGN KEY(client_id) REFERENCES client(id)
);