# Diet Manager - Guide de Configuration

## Modifications Apportées

### 1. Validations Strictes
- **Mot de passe**: Minimum 2 caractères, maximum 50
- **Nom**: Minimum 3 caractères, maximum 100
- **Email**: Format valid email requis
- **Champ "Confirmation de mot de passe"**: SUPPRIMÉ
- Validation en client ET serveur


### 3. AJAX et JavaScript Intégrés

#### Page de Connexion (`auth/login.php`)
- Validation AJAX du formulaire
- Message d'erreur en temps réel
- Spinner de chargement lors de l'envoi
- Récupération automatique du token CSRF

#### Page d'Inscription (`auth/register.php`)
- Validation AJAX complète
- Vérification client avant envoi
- Animations et feedback utilisateur
- Suggestions de validations visibles

#### Tableau de Bord (`dashboard/index.php`)
- Rafraîchissement automatique des statistiques toutes les 30 secondes
- Bouton "Rafraîchir les données" manuel
- Appel AJAX à `/dashboard/stats`
- Graphes Chart.js dynamiques

#### Pages des Utilisateurs, Régimes, Aliments
- Bouton "Actualiser" pour charger les données via AJAX
- Spinner de chargement lors du refresh
- Rafraîchissement automatique toutes les 60 secondes
- Tableau dynamique sans rechargement de page

## Installation et Démarrage

### 1. Configuration de la Base de Données
```sql
-- Importer le fichier app/Database/Base.sql dans votre MySQL
mysql -u root -p < app/Database/Base.sql
```

### 2. Configuration du fichier `.env`
```
app.baseURL = 'http://localhost:8080/'
database.default.hostname = 'localhost'
database.default.database = 'Diet'
database.default.username = 'root'
database.default.password = ''
database.default.DBDriver = 'MySQLi'
```

### 3. Lancer le serveur de développement
```bash
cd C:\Users\Oracle\Documents\S4\m.Rojo\11_mai\Diet
php spark serve
```

### 4. Accéder à l'application
- URL: `http://localhost:8080`
- Page de connexion s'affiche automatiquement

## Identifiants de Test

### Administrateur
- Email: `admin@diet.com`
- Mot de passe: `password123`

### Utilisateur Standard
- Email: `user@diet.com`
- Mot de passe: `password123`

## Nouveautés JavaScript/AJAX

### 1. Formulaire de Connexion
```javascript
- POST AJAX vers /auth/login
- Validation client avant envoi
- Gestion des erreurs de réponse
- Redirection automatique
```

### 2. Formulaire d'Inscription
```javascript
- POST AJAX vers /auth/signup
- Validation de tous les champs
- Détection email déjà utilisé
- Feedback utilisateur immédiat
```

### 3. Dashboard Dynamique
```javascript
- GET AJAX vers /dashboard/stats
- Mise à jour des cartes statistiques
- Rafraîchissement automatique
- Charger/afficher les données sans rechargement
```

### 4. Tables avec AJAX
```javascript
- Chargement dynamique des données
- Spinner de chargement visible
- Actualisation manuelle possible
- Mise à jour automatique
```

## Structure des Routes

```
GET  /                      -> Page de connexion
POST /auth/login           -> Traiter la connexion (AJAX)
GET  /auth/register        -> Page d'enregistrement
POST /auth/signup          -> Traiter l'inscription (AJAX)
GET  /auth/logout          -> Déconnexion

GET  /dashboard            -> Tableau de bord (protégé)
GET  /dashboard/stats      -> API stats JSON (AJAX)
GET  /dashboard/utilisateurs -> Liste des utilisateurs
GET  /dashboard/regimes    -> Liste des régimes
GET  /dashboard/aliments   -> Liste des aliments
```

## Technos Utilisées

- **Backend**: CodeIgniter 4
- **Frontend**: Bootstrap 5, Chart.js
- **AJAX**: Fetch API native (pas jQuery)
- **Validation**: Client-side + Server-side
- **Sécurité**: Token CSRF, Sessions, Password hashing

## Notes Importantes

1. Les validations minimales sont très strictes (2 caractères pour le mot de passe)
2. Il n'y a plus de confirmation de mot de passe
3. Tous les emojis ont été supprimés
4. AJAX utilisé pour améliorer UX
5. Les filtres d'authentification protègent toutes les routes du dashboard

## Fichiers Modifiés/Créés

```
Controllers:
- AuthController.php (validations strictes)
- DashboardController.php (avec stats JSON)

Views:
- auth/login.php (avec AJAX)
- auth/register.php (avec AJAX, sans password_confirm)
- dashboard/index.php (avec AJAX + Chart.js)
- dashboard/utilisateurs.php (avec AJAX)
- dashboard/regimes.php (avec AJAX)
- dashboard/aliments.php (avec AJAX)

Filters:
- AuthFilter.php (protection des routes)

Config:
- Filters.php (enregistrement du filtre auth)
- Routes.php (routes avec filtre)

Database:
- Base.sql (avec table users)
```