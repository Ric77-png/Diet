-- ============================================
-- CRÉATION DE LA BASE
-- ============================================
DROP DATABASE IF EXISTS diet;
CREATE DATABASE diet 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE diet;

-- ============================================
-- TABLE 1 : OBJECTIFS
-- ============================================
CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL
);

-- ============================================
-- TABLE 2 : UTILISATEURS (clients + admins)
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    genre ENUM('masculin', 'feminin') NOT NULL,
    taille DECIMAL(5,2) NOT NULL,
    poids DECIMAL(5,2) NOT NULL,
    imc DECIMAL(5,2) NULL,
    objectif_id INT NULL,
    role ENUM('admin', 'client') DEFAULT 'client',
    is_gold BOOLEAN DEFAULT FALSE,
    gold_purchased_at DATETIME NULL,
    wallet_balance DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id) ON DELETE SET NULL
);

-- ============================================
-- TABLE 3 : RÉGIMES
-- ============================================
CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    pourcentage_viande INT NOT NULL,
    pourcentage_poisson INT NOT NULL,
    pourcentage_volaille INT NOT NULL,
    effet_poids_par_semaine DECIMAL(5,2) NOT NULL,
    prix_par_jour DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLE 4 : ACTIVITÉS SPORTIVES
-- ============================================
CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    duree_minutes INT NOT NULL,
    calories_par_heure INT NOT NULL,
    difficulte ENUM('facile', 'moyen', 'difficile') DEFAULT 'moyen',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLE 5 : CODES PORTER-MONNAIE
-- ============================================
CREATE TABLE wallet_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    montant DECIMAL(10,2) NOT NULL,
    utilise BOOLEAN DEFAULT FALSE,
    utilisateur_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- TABLE 6 : PARAMÈTRES
-- ============================================
CREATE TABLE parametres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(100) NOT NULL UNIQUE,
    valeur VARCHAR(255) NOT NULL,
    description TEXT NULL
);

-- ============================================
-- TABLE 7 : SUGGESTIONS (historique)
-- ============================================
CREATE TABLE suggestions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    regime_id INT NOT NULL,
    activite_id INT NOT NULL,
    duree_jours INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE,
    FOREIGN KEY (activite_id) REFERENCES activites(id) ON DELETE CASCADE
);

CREATE TABLE gold_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    duree_jours INT DEFAULT 30,
    utilise BOOLEAN DEFAULT FALSE,
    utilisateur_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE SET NULL
);