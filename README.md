# 🎮 Cooldown Store

---

## 💡 Présentation du projet

> **Cooldown Store** est une application web e-commerce spécialisée dans la vente de **jeux vidéo** en version physique et dématérialisée.  
> Développée en **PHP** avec une architecture **MVC**, elle propose une navigation fluide, responsive et orientée expérience utilisateur.

Cette boutique en ligne permet de :

✅ Parcourir un vaste catalogue de jeux par genre, plateforme et nouveauté.  
✅ Rechercher des titres avec **autocomplétion** asynchrone.  
✅ Consulter des fiches produits complètes.  
✅ Créer un compte, gérer son panier, son profil et ses achats.  
✅ Administrer les stocks, produits et catégories via un **back-office**.  
✅ Profiter d’une interface **mobile-first** et intuitive.

---

### 🎯 Fonctionnalités principales

- 🏠 **Page d'accueil** : Nouveautés, jeux populaires, promotions.
- 🛍️ **Catalogue** : Filtres par genre, plateforme, type (édition physique / numérique).
- 🔍 **Recherche instantanée** : Autocomplétion avec JavaScript asynchrone.
- 📄 **Page jeu** : Détails complets (visuels, prix, description, stock, plateforme…).
- 🧺 **Panier & commande** : Ajout, suppression, validation (simulation de paiement).
- 👤 **Espace membre** : Création de compte, connexion, modification du profil, historique des commandes.
- 🛠️ **Espace admin** : Gestion complète des jeux, catégories, stocks et utilisateurs.

---

## 💻 Technologies utilisées

| Technologie             | Rôle                                          |
|-------------------------|-----------------------------------------------|
| PHP                     | Back-end (logique métier MVC)                 |
| MySQL                   | Stockage des données                          |
| HTML5 / CSS3            | Structure & mise en page                      |
| JavaScript (ES6+, Ajax) | Interactions dynamiques                       |
| Responsive Design       | Expérience optimisée mobile et desktop        |
| Apache + .htaccess      | URL propres et routage personnalisé           |

---

## 🚀 Fonctionnalité GitHub Actions Ajoutée

Nous avons intégré **GitHub Actions** pour l’**intégration continue (CI)** afin de garantir que chaque modification du code soit automatiquement testée et validée.

### Ce que fait GitHub Actions pour ce projet :
- **Configuration CI** : À chaque modification ou ouverture de PR vers la branche `main`, GitHub Actions vérifie la qualité du code avec des étapes de linting et exécute les tests.
- **Linting** : Nous avons configuré des outils de linting pour vérifier la qualité du code JavaScript (ESLint) et PHP (PHP_CodeSniffer).
- **Tests** : Des tests unitaires sont exécutés pour garantir la stabilité du projet.

Tu peux suivre le statut de l'intégration continue dans l'onglet **"Actions"** de GitHub pour voir si tout fonctionne correctement.

---



## ⚙️ Instructions d'installation

1. **Cloner le dépôt :**

```bash
git clone https://github.com/antonin-tacchi/Cooldown-Store.git
```

2. **Accéder au dossier du projet :**

```bash
cd Cooldown-Store
```

3. **Configurer l’environnement local :**

Assurez-vous d’avoir PHP et MySQL installés.

Créez une base de données boutique_db et exécutez le script migrations/schema.sql.

Configurez vos accès à la BDD dans config/config.php.

4. **Lancer le projet :**

Démarrez un serveur local via Apache (ex : XAMPP, MAMP, WAMP).

Accédez à http://localhost/Cooldown-Store/public/
