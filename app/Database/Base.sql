DROP DATABASE IF EXISTS Diet;
CREATE DATABASE IF NOT EXISTS Diet 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE Diet;

-- Table des administrateurs/utilisateurs (back office)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des personnes/utilisateurs du régime
CREATE TABLE Personne (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    genre ENUM('masculin', 'feminin') NOT NULL,
    poids DECIMAL(5,2) NOT NULL,
    taille DECIMAL(5,2) NOT NULL,
    imc DECIMAL(5,2),
    objectif_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des objectifs alimentaires
CREATE TABLE Objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des régimes alimentaires
CREATE TABLE Regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    calories_min DECIMAL(6,0),
    calories_max DECIMAL(6,0),
    objectif_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (objectif_id) REFERENCES Objectifs(id) ON DELETE CASCADE
);

-- Table des aliments avec macronutriments
CREATE TABLE Aliments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    calories DECIMAL(6,2) NOT NULL,
    glucides DECIMAL(5,2),
    proteines DECIMAL(5,2),
    lipides DECIMAL(5,2),
    fibre DECIMAL(5,2),
    vitamines TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des repas
CREATE TABLE Repas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    personne_id INT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    type_repas ENUM('petit-dejeuner', 'dejeuner', 'diner', 'collation') NOT NULL,
    date_repas DATE NOT NULL,
    calories_total DECIMAL(6,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (personne_id) REFERENCES Personne(id) ON DELETE CASCADE
);

-- Table de liaison entre Repas et Aliments
CREATE TABLE Repas_Aliments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repas_id INT NOT NULL,
    aliment_id INT NOT NULL,
    quantite DECIMAL(5,2) NOT NULL,
    unite VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (repas_id) REFERENCES Repas(id) ON DELETE CASCADE,
    FOREIGN KEY (aliment_id) REFERENCES Aliments(id) ON DELETE CASCADE
);

-- ============================================
-- DONNÉES D'EXEMPLE
-- ============================================

-- Utilisateurs (administrateurs du back office)
-- Mots de passe hashés avec PASSWORD_DEFAULT (bcrypt)
-- Admin: admin@diet.com / password123
-- User: user@diet.com / password123
INSERT INTO users (nom, email, password) VALUES
('Admin Diet', 'admin@diet.com', '$2y$10$Y8TQ0n1Jy3r0u3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K'),
('Manager Diet', 'user@diet.com', '$2y$10$Y8TQ0n1Jy3r0u3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K3K');

-- Objectifs
INSERT INTO Objectifs (nom, description) VALUES
('Perte de poids', 'Réduire le poids corporel'),
('Prise de masse', 'Augmenter la masse musculaire'),
('Maintien', 'Maintenir le poids actuel'),
('Performance sportive', 'Optimiser les performances sportives'),
('Santé générale', 'Améliorer la santé globale');

-- Régimes selon les objectifs
INSERT INTO Regimes (nom, description, calories_min, calories_max, objectif_id) VALUES
('Déficit calorique modéré', 'régime pour perte de poids progressive', 1500, 1800, 1),
('Déficit calorique agressif', 'Régime pour perte de poids rapide', 1200, 1500, 1),
('Surplus calorique', 'Régime pour la prise de masse musculaire', 2500, 3000, 2),
('Équilibré', 'Régime équilibré pour le maintien du poids', 2000, 2400, 3),
('Performance', 'Régime optimisé pour la performance sportive', 2200, 2800, 4),
('Équilibré santé', 'Régime sain et équilibré pour la santé générale', 1800, 2200, 5);

-- Aliments d'exemple
INSERT INTO Aliments (nom, description, calories, glucides, proteines, lipides, fibre) VALUES
('Poulet grillé', 'Poitrine de poulet sans peau', 165, 0, 31, 3.6, 0),
('Riz blanc', 'Riz blanc cuit', 130, 28, 2.7, 0.3, 0.4),
('Brocoli', 'Brocoli cuit', 34, 7, 2.8, 0.4, 2.4),
('Oeufs', 'Oeufs entiers', 155, 1.1, 13, 11, 0),
('Pommes', 'Pomme moyenne avec peau', 95, 25, 0.5, 0.3, 4.4),
('Yaourt nature', 'Yaourt nature sans sucre', 59, 3.3, 10, 0.4, 0),
('Pain complet', 'Tranche de pain complet', 100, 18, 4, 1.5, 3.5),
('Saumon', 'Filet de saumon grillé', 280, 0, 25, 20, 0),
('Tomates', 'Tomate crue', 18, 3.9, 0.9, 0.2, 1.2),
('Banane', 'Banane moyenne', 105, 27, 1.3, 0.3, 3.1);
