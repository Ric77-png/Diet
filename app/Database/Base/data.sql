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

-- Insérer les paramètres par défaut (si la table est vide)
INSERT INTO parametres (cle, valeur, description) VALUES
('prix_gold', '49.99', 'Prix de l\'option Gold en euros'),
('reduction_gold_pourcent', '15', 'Réduction pour les membres Gold (en %)'),
('imc_normal_min', '18.5', 'IMC minimum pour la catégorie normal'),
('imc_normal_max', '24.9', 'IMC maximum pour la catégorie normal'),
('suggestion_duree_defaut', '30', 'Durée par défaut des suggestions (en jours)')
ON DUPLICATE KEY UPDATE valeur = VALUES(valeur);