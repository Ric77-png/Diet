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