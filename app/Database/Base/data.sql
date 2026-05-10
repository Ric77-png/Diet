-- ============================================
-- INSÉRER LES 3 OBJECTIFS (obligatoire pour clé étrangère)
-- ============================================
INSERT INTO objectifs (id, nom, description) VALUES
(1, 'reduire', 'Réduire son poids'),
(2, 'augmenter', 'Augmenter son poids'),
(3, 'imc_ideal', 'Atteindre son IMC idéal');

-- ============================================
-- INSÉRER 1 ADMIN (pour tester le back office)
-- ============================================
-- email: admin@diet.com
-- password: admin123
INSERT INTO users (nom, email, password, genre, taille, poids, role) VALUES
('Administrateur', 'admin@diet.com', 'admin123', 'masculin', 1.75, 70, 'admin');

-- ============================================
-- INSÉRER 1 CLIENT (pour tester le front office)
-- ============================================
-- email: client@diet.com
-- password: client123
INSERT INTO users (nom, email, password, genre, taille, poids, objectif_id, role) VALUES
('Client Test', 'client@diet.com', 'client123', 'masculin', 1.80, 85, 1, 'client');

INSERT INTO regimes (nom, description, pourcentage_viande, pourcentage_poisson, pourcentage_volaille, effet_poids_par_semaine, prix_par_jour) VALUES
('Equilibre', 'Regime polyvalent pour stabiliser le poids.', 40, 30, 30, 0.00, 12.00),
('Leger', 'Regime hypocalorique pour reduire le poids.', 20, 40, 40, -0.60, 9.50),
('Proteine', 'Regime riche en proteines pour augmenter le poids.', 50, 20, 30, 0.45, 14.00),
('Ocean', 'Regime base sur le poisson pour une silhouette plus fine.', 10, 70, 20, -0.35, 13.00),
('Volaille', 'Regime riche en volaille et en fibres.', 20, 10, 70, 0.10, 11.00);

-- ============================================
-- INSERER 5 ACTIVITES SPORTIVES
-- ============================================
INSERT INTO activites (nom, duree_minutes, calories_par_heure, difficulte) VALUES
('Marche rapide', 45, 280, 'facile'),
('Course legere', 30, 520, 'moyen'),
('Cyclisme', 40, 450, 'moyen'),
('Natation', 35, 600, 'difficile'),
('Yoga dynamique', 50, 220, 'facile');

-- Insérer les paramètres par défaut (si la table est vide)
INSERT INTO parametres (cle, valeur, description) VALUES
('prix_gold', '49.99', 'Prix de l\'option Gold en euros'),
('reduction_gold_pourcent', '15', 'Réduction pour les membres Gold (en %)'),
('imc_normal_min', '18.5', 'IMC minimum pour la catégorie normal'),
('imc_normal_max', '24.9', 'IMC maximum pour la catégorie normal'),
('suggestion_duree_defaut', '30', 'Durée par défaut des suggestions (en jours)')
ON DUPLICATE KEY UPDATE valeur = VALUES(valeur);

INSERT INTO gold_codes (code, duree_jours, utilise) VALUES
('GOLD2026MAY001', 30, FALSE),
('GOLD2026MAY002', 30, FALSE),
('GOLD2026MAY003', 30, FALSE),
('PROMO30DAYS', 30, FALSE),
('FREEGOLD', 30, FALSE);