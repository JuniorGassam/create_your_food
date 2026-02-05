# Create Your Food 🍽️

Une plateforme web innovante permettant de **rechercher des recettes** et **consulter leurs informations nutritionnelles** en intégrant deux APIs externes majeures.

---

## 📋 Table des Matières

- [Quick Start](#-quick-start)
- [Fonctionnalités](#-fonctionnalités)
- [Stack Technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Utilisation](#-utilisation)
- [Commandes Utiles](#-commandes-utiles)
- [Debugging et Xdebug](#-debugging-et-xdebug)
- [Architecture](#-architecture)
- [Contribution](#-contribution)
- [Licence](#-licence)

---

## 🚀 Quick Start

### Windows (Recommandé)
```batch
# Double-clique sur dev.bat ou
dev.bat
```

### macOS / Linux
```bash
git pull origin develop
docker compose up -d --build
```

**Puis accède à:** http://localhost:8080

---

## ✨ Fonctionnalités

### 🔍 Recherche & Découverte
- **Recherche dynamique de plats** via TheMealDB API (par nom ou ingrédient)
- **Informations nutritionnelles détaillées** via OpenFoodFacts API
- **Filtrage avancé** (catégorie, régime alimentaire, temps de préparation)
- **Tri intelligent** (calories, popularité, temps de cuisson)

### 🤖 Intelligence Artificielle
- **Chatbot IA** sur les pages de recettes pour conseils personnalisés
- **Proposition IA** : génération automatique de plats quand les APIs ne trouvent rien
- **Suggestions intelligentes** basées sur vos ingrédients disponibles

### 🌐 Internationalisation
- **Support multilingue** : Français, Anglais, Espagnol
- **Traduction automatique** via Google Translate API
- **Interface adaptative** selon la langue utilisateur

### 👤 Authentification Avancée
- **Connexion locale** : Email + mot de passe (bcrypt sécurisé)
- **OAuth Google** : Inscription/connexion rapide via Google
- **Gestion de profil** : Historique, favoris, préférences
- **RGPD compliant** : Consentement, droit à l'oubli

### 🌐 Internationalisation
- **Langues supportées** : Français (défaut), Anglais, Espagnol
- **Traduction automatique** : Google Translate API pour contenu dynamique
- **Cache des traductions** : 24h TTL pour optimiser les performances
- **Détection automatique** : Basée sur les préférences navigateur

### 🤖 Intelligence Artificielle
- **Chatbot IA** : Assistant conversationnel sur pages recettes
- **Proposition IA** : Génération de plats quand APIs ne trouvent rien
- **Algorithmes** : Règles métier + clustering ML (scikit-learn)
- **Contexte-aware** : Réponses adaptées à la recette consultée

### 📊 KPIs & Analytics
- **Métriques métier** : Taux conversion, satisfaction utilisateur, engagement IA
- **Métriques techniques** : Disponibilité APIs, temps réponse, cache hit rate
- **Dashboard admin** : Interface de monitoring temps réel
- **Rapports automatisés** : Exports quotidiens/hebdomadaires

### ⚡ Performance & Fiabilité
- **Cache multi-niveau** : Doctrine (actuel) + Redis (prévu)
- **Gestion d'erreurs gracieuse** (APIs indisponibles, timeouts)
- **Monitoring intégré** (logs, métriques, alertes)
- **Disponibilité 99.5%** avec infrastructure redondante

### 📊 Analytics & KPIs
- **Tableau de bord admin** avec métriques temps réel
- **Tracking utilisateur** (sessions, conversions, satisfaction)
- **Rapports automatisés** (quotidien/hebdomadaire/mensuel)

---

## 🛠️ Stack Technique

### Backend
- **Framework:** Symfony 6.1
- **PHP:** 8.1+
- **Base de données:** PostgreSQL 16 (Docker) / MySQL (local)
- **ORM:** Doctrine
- **HTTP Client:** Symfony HttpClient

### Frontend
- **Template Engine:** Twig
- **CSS Framework:** Bootstrap 5
- **JavaScript:** Vanilla JS + AJAX

### DevOps
- **Containerization:** Docker & Docker Compose
- **Reverse Proxy:** Nginx 1.23 (Alpine)
- **Cache:** Redis (prévu pour sessions et données)
- **Database Admin:** Adminer
- **Mailer:** Mailpit (dev)
- **Monitoring:** Prometheus + Grafana (prévu)

### APIs Externes
- **TheMealDB:** https://www.themealdb.com/api/json/v1/1/
- **OpenFoodFacts:** https://world.openfoodfacts.org/api/v0/
- **Google Translate:** https://translation.googleapis.com/
- **Google OAuth:** https://accounts.google.com/

---

## 📦 Prérequis

### Option 1: Avec Docker (Recommandé)
- **Docker Desktop** v4.0+ 
- **Git**

### Option 2: En Local
- **PHP** 8.1+ avec extensions: `ctype`, `iconv`, `pdo_pgsql` (ou `pdo_mysql`)
- **PostgreSQL** 16 (ou MySQL 8.0)
- **Composer** 2.0+
- **Symfony CLI** (optionnel mais recommandé)

---

## 🚀 Installation

### 1️⃣ Cloner le repository

```bash
git clone <repository-url>
cd create_your_food
```

### 2️⃣ Configurer l'environnement

```bash
# Copier la config de base
cp .env .env.local

# Pour Docker (utilise déjà le .env)
# Pas d'action supplémentaire

# Pour Local: éditer .env.local
# DATABASE_URL="postgresql://app:Junior(2004)@localhost:5432/app?serverVersion=16&charset=utf8"
```

---

## 🎯 Utilisation

### Avec Docker (Recommandé)

#### Démarrer l'application

```bash
# Lancer tous les services
docker compose up -d

# Vérifier que tout tourne
docker compose ps

# Output attendu:
# NAME                    STATUS
# create_your_food_php    Up X seconds
# create_your_food_nginx  Up X seconds
# create_your_food_db     Up X seconds
```

#### Installer les dépendances

```bash
# Option A: Dans le container (recommandé)
docker compose exec php composer install

# Option B: Localement (avant docker compose up)
composer install
docker compose up -d
```

#### Accéder à l'application

### 🌐 Accès aux Services

| Service | URL | Description |
|---------|-----|-------------|
| **Application** | http://localhost:8080 | Interface principale |
| **Adminer** | http://localhost:8081 | Gestion base de données |
| **Mailpit** | http://localhost:8025 | Emails de développement |
| **API Docs** | http://localhost:8080/api/docs | Documentation API |
| **Admin Dashboard** | http://localhost:8080/admin | Métriques & KPIs |
| **Chatbot Demo** | http://localhost:8080/recipe/1 | Test IA intégré |

### 🔐 Authentification

- **Connexion locale** : `/login` (email/mot de passe)
- **OAuth Google** : Bouton "Se connecter avec Google"
- **Inscription** : `/register` avec validation email
- **Récupération** : `/forgot-password` (prévu)

### 🎯 Pages Principales

- **Accueil** (`/`) : Recherche de plats
- **Détails Recette** (`/recipe/{id}`) : Infos + Chatbot IA
- **Création IA** (`/create`) : Proposition de plats
- **Profil** (`/profile`) : Favoris, historique
- **Admin** (`/admin`) : Dashboard métriques

---

## 🔗 Git Hooks - Auto-Correction du Code

Les **git hooks pré-commit** lancent automatiquement l'analyse et la correction du code avant chaque commit. ✨

### Configuration Automatique
Les hooks sont installés automatiquement lors de `composer install`. Si tu les as manqués :

```bash
# Installer manuellement les hooks
composer run setup-hooks

# Ou sous Windows
setup-hooks.bat
```

### Fonctionnalités

**À chaque `git commit` :**
1. 🔧 **PHP-CS-Fixer** → Corrige automatiquement le code (indentation, espaces, imports, etc.)
2. 🔬 **PHPStan** → Analyse statique pour détecter les erreurs
3. ✅ Commit bloqué si erreurs détectées

### Commandes Manuelles

```bash
# Corriger le code manuellement
docker compose exec php composer cs:fix

# Vérifier les erreurs (sans corriger)
docker compose exec php composer phpstan:check

# Skip les hooks (force commit)
git commit --no-verify
```

### Configuration PHPStan
- **Fichier:** `phpstan.neon`
- **Niveau:** 5 (max = 9)
- **Paths:** `src/` seulement

### Configuration PHP-CS-Fixer
- **Fichier:** `.php-cs-fixer.php`
- **Rules:** @Symfony + custom

---

### En Local (Sans Docker)

#### Installation

```bash
# 1. Installer les dépendances
composer install

# 2. Créer la base de données
php bin/console doctrine:database:create

# 3. Exécuter les migrations (si disponibles)
php bin/console doctrine:migrations:migrate

# 4. (Optionnel) Charger les données de démo
php bin/console doctrine:fixtures:load
```

#### Lancer l'application

```bash
# Avec Symfony CLI (recommandé)
symfony serve

# Ou avec PHP intégré
php -S localhost:8000 -t public/

# L'application sera accessible à http://localhost:8000
```

#### Tester

```bash
# Recherche de plats
curl "http://localhost:8000/foods?search=chicken"

# Voir les routes disponibles
php bin/console debug:routes

# Vérifier la connexion DB
php bin/console doctrine:query:sql "SELECT 1"
```

---

## 💻 Commandes Utiles

### 🐳 Docker - Gestion des Conteneurs

```bash
# Démarrer l'application (migrations auto)
docker compose up -d --build

# Afficher le statut des services
docker compose ps

# Afficher les logs
docker compose logs -f              # Tous les logs
docker compose logs -f php          # Logs PHP uniquement
docker compose logs -f database     # Logs base de données

# Arrêter l'application
docker compose down                 # Arrêter puis nettoyer
docker compose down -v              # Arrêter et supprimer les volumes

# Redémarrer un service spécifique
docker compose restart php
```

### 🔧 Commandes Symfony (Dans Docker)

```bash
# Accéder au shell PHP
docker compose exec php bash

# Exécuter les migrations
docker compose exec php php bin/console doctrine:migrations:migrate -n

# Vider le cache
docker compose exec php php bin/console cache:clear

# Voir les routes disponibles
docker compose exec php php bin/console debug:routes

# Informations debug
docker compose exec php php bin/console debug:container
```

### 🗄️ Base de Données

```bash
# Accéder à PostgreSQL depuis le container
docker compose exec database psql -U app -d app

# Commandes utiles PostgreSQL
\dt                          # Lister les tables
SELECT * FROM "user";        # Voir les utilisateurs
\q                           # Quitter psql

# Accéder à Adminer (GUI)
# http://localhost:8081
```

### 🌐 Accès aux Services

| Service | URL | Identifiants |
|---------|-----|--------------|
| **Application** | http://localhost:8080 | - |
| **Adminer** | http://localhost:8081 | postgres / app / Junior(2004) |
| **Mailpit** | http://localhost:8025 | - (si activé) |

---

## 🐛 Debugging et Xdebug

### Configuration Xdebug (Automatique ✅)

Xdebug est **déjà configuré** dans le Dockerfile. Aucune installation supplémentaire requise !

### Debugger du Code PHP dans VS Code

#### 1️⃣ Installer l'extension PHP Debug
```
Nom: PHP Debug
ID: felixbecker.php-debug
```

#### 2️⃣ Configuration (déjà faite)
Le fichier `.vscode/launch.json` est pré-configuré pour :
- **Host:** localhost
- **Port:** 9003
- **Path Mapping:** `/var/www/html` → Votre dossier local

#### 3️⃣ Utiliser le Debugger

**Méthode 1: Breakpoints interactifs**
```php
// Dans votre code (ex: src/Controller/FoodController.php)
public function index()
{
    $name = "John";
    // Ajouter un breakpoint (F9) à la ligne suivante
    dd($name); // <-- F9 ici
    
    return $this->render(...);
}
```

1. Appuyer sur **F9** pour ajouter un breakpoint (point rouge)
2. Cliquer sur **"Run and Debug"** dans VS Code (Ctrl+Shift+D)
3. Sélectionner **"Listen for Xdebug"**
4. Visiter http://localhost:8080 dans votre navigateur

**Méthode 2: Accepter les requêtes debug**

Ajouter `?XDEBUG_SESSION_START=1` à l'URL :
```
http://localhost:8080/foods?XDEBUG_SESSION_START=1
```

#### 4️⃣ Fonctionnalités du Debugger
- ⏸️ **Pause:** Cliquer sur "Pause" pour interrompre l'exécution
- **Variables:** Voir les valeurs locales, globales, etc.
- **Watch:** Surveiller des variables spécifiques
- **Stack:** Voir l'historique d'exécution
- **Console:** Exécuter du PHP en direct

### Troubleshooting Xdebug

```bash
# Vérifier que Xdebug est bien chargé
docker compose exec php php -m | grep xdebug

# Voir la config de Xdebug
docker compose exec php php -i | grep -A 20 xdebug

# Ramet le container
docker compose restart php
```

---

## 🏗️ Architecture

### Vue d'ensemble

```
┌─────────────┐     ┌──────────────┐
│  Frontend   │◄───▸│  Nginx       │
│  Twig/JS    │     │  (Reverse    │
│             │     │   Proxy)     │
└─────────────┘     └──────┬───────┘
                           │
              ┌────────────┼────────────┐
              ▼                         ▼
   ┌────────────────────┐    ┌────────────────────┐
   │   TheMealDB API    │    │ OpenFoodFacts API  │
   │   (Recettes)       │    │   (Nutrition)      │
   └────────────────────┘    └────────────────────┘
              ▲                         ▲
              │                         │
   ┌──────────┼──────────┐    ┌─────────┼──────────┐
   │  Doctrine Cache     │    │  Doctrine Cache   │
   │  (1h TTL)           │    │  (24h TTL)        │
   └─────────────────────┘    └─────────────────────┘
              ▲                         ▲
              │                         │
   ┌──────────┴──────────┐    ┌─────────┴──────────┐
   │   Redis (prévu)     │    │   Redis (prévu)   │
   │   Cache avancé      │    │   Cache avancé    │
   └─────────────────────┘    └─────────────────────┘
              ▲                         ▲
              │                         │
   ┌──────────┴─────────────────────────┴──────────┐
   │            PostgreSQL Database                │
   │   Tables: users, favorites, search_history    │
   └───────────────────────────────────────────────┘
```

### Conteneurisation Docker

- **Application Symfony** dans conteneur PHP-FPM
- **Nginx** comme reverse proxy et serveur statique
- **PostgreSQL** et **Redis** dans conteneurs séparés
- **Docker Compose** pour orchestration locale

### Points d'intégration

- **APIs externes** : TheMealDB, OpenFoodFacts, Google Translate, Google OAuth
- **Cache multi-niveau** : Doctrine (filesystem/APCu) + Redis (prévu)
- **Sessions distribuées** : Redis pour scalabilité horizontale
- **Monitoring** : Logs structurés, métriques Prometheus

### Structure du Projet

```
create_your_food/
├── src/
│   ├── Controller/           # Contrôleurs (FoodController, SecurityController)
│   ├── Entity/               # Entités Doctrine (User, Food, etc.)
│   ├── Repository/           # Repositories Doctrine
│   └── Kernel.php            # Kernel Symfony
├── config/
│   ├── packages/             # Configuration des bundles
│   ├── routes/               # Définition des routes
│   └── services.yaml         # Configuration des services
├── templates/
│   ├── base.html.twig        # Layout de base
│   ├── food/
│   │   └── index.html.twig   # Page de recherche de plats
│   └── security/
│       └── login.html.twig   # Page de connexion
├── public/
│   └── index.php             # Point d'entrée de l'application
├── migrations/               # Migrations Doctrine
├── tests/                    # Tests unitaires et fonctionnels
├── docker/
│   ├── entrypoint.sh         # Script de démarrage (migrations auto)
│   └── nginx/
│       └── default.conf      # Configuration Nginx
├── .vscode/
│   └── launch.json           # Configuration Xdebug pour VS Code
├── compose.yaml              # Docker Compose (PostgreSQL)
├── compose.override.yaml     # Surcharge dev (Mailpit)
├── Dockerfile                # Image PHP
├── dev.bat                   # Script de démarrage rapide (Windows)
├── .env                      # Variables d'environnement (Docker)
├── .env.local                # Variables locales (ignoré Git)
└── composer.json             # Dépendances PHP
```

### Flux de l'Application

```
┌─────────────────────────────────────┐
│     Utilisateur (Navigateur)        │
└──────────────────┬──────────────────┘
                   │ HTTP GET /foods?search=chicken
                   ▼
┌─────────────────────────────────────┐
│   Nginx (Reverse Proxy)             │
│   localhost:8080                    │
└──────────────────┬──────────────────┘
                   │ Forward
                   ▼
┌─────────────────────────────────────┐
│   Symfony (PHP-FPM)                 │
│   FoodController::index()           │
└──────────────────┬──────────────────┘
                   │
        ┌──────────┼──────────┐
        │          │          │
        ▼          ▼          ▼
   ┌────────┐ ┌────────┐ ┌──────────┐
   │ Local  │ │ Cache  │ │ External │
   │  DB    │ │ (Redis)│ │   APIs   │
   └────────┘ └────────┘ │ ┌──────┐ │
                          │ │Meal  │ │
                          │ │DB    │ │
                          │ └──────┘ │
                          │ ┌──────┐ │
                          │ │Food  │ │
                          │ │Facts │ │
                          │ └──────┘ │
                          └──────────┘
```

---

## 🧪 Tests

### Lancer les tests

```bash
# Tous les tests
php bin/phpunit

# Tests d'un fichier spécifique
php bin/phpunit tests/Controller/FoodControllerTest.php

# Avec couverture de code
php bin/phpunit --coverage-html coverage/
```

### Tests manuels (Postman/Curl)

```bash
# Recherche simple
curl -X GET "http://localhost:8080/foods?search=pasta"

# Recherche vide (erreur)
curl -X GET "http://localhost:8080/foods?search="

# Accès à une recette (après implémentation)
curl -X GET "http://localhost:8080/foods/123"
```

---

## 📚 Documentation

- **Cahier des Charges:** [CAHIER_DES_CHARGES.md](CAHIER_DES_CHARGES.md)
  - SWOT analysis
  - Diagrammes fonctionnels (Bête à Corne, Pieuvre)
  - User Stories
  - Exigences fonctionnelles et non-fonctionnelles

---

## 🔧 Configuration Avancée

### Variables d'Environnement Importantes

```env
# Application
APP_ENV=dev                    # dev, test, prod
APP_SECRET=...                 # Secret Symfony (auto-générée)

# Base de données
DATABASE_URL=postgresql://...  # Chaîne de connexion

# Mailer
MAILER_DSN=null://null         # null=désactivé, smtp://... pour SMTP
```

### Modifier la Configuration pour Production

```bash
# Générer la config pour production
composer dump-env prod

# Modifier .env.prod.local
APP_ENV=prod
APP_DEBUG=0
MAILER_DSN=smtp://user:pass@smtp.example.com:587?encryption=tls
```

---

## 🐛 Dépannage

### Docker ne démarre pas

```bash
# Vérifier que Docker Desktop tourne
docker ps

# Redémarrer Docker Desktop
# → Menu Windows → Docker Desktop → Restart

# Ou en PowerShell (admin)
Restart-Service com.docker.service
```

### Erreur de connexion à la base de données

```bash
# Vérifier que le container DB tourne
docker compose ps database

# Tester la connexion
docker compose exec database psql -U app -d app -c "SELECT 1"

# Voir les logs
docker compose logs database
```

### Erreur "composer not found"

```bash
# Installer Composer localement
curl -sS https://getcomposer.org/installer | php
php composer.phar install

# Ou l'exécuter dans le container
docker compose exec php composer install
```

### Port 8080 déjà utilisé

```bash
# Modifier le port dans compose.yaml
ports:
  - "8888:80"  # Au lieu de "8080:80"

# Puis relancer
docker compose down
docker compose up -d
```

---

## 🤝 Contribution

Les contributions sont les bienvenues ! 

### Process

1. **Fork** le repository
2. **Créer une branche** (`git checkout -b feature/amazing-feature`)
3. **Commit** vos changements (`git commit -m 'feat: add amazing feature'`)
4. **Push** vers la branche (`git push origin feature/amazing-feature`)
5. **Ouvrir une Pull Request**

### Conventions

- **Commits:** Suivre [Conventional Commits](https://www.conventionalcommits.org/)
- **Code:** PSR-12 pour PHP
- **Tests:** Minimum 70% de couverture

---

## � KPIs & Métriques

### Métriques Métier
- **Taux de conversion recherche** : % recherches aboutissant à consultation recette (> 40%)
- **Temps moyen session** : Durée moyenne utilisateur (> 5 min)
- **Taux satisfaction** : Note moyenne utilisateur (> 4.2/5)
- **Utilisation chatbot** : % sessions avec interaction IA (> 25%)
- **Proposition IA acceptée** : % propositions menant à création plat (> 30%)

### Métriques Techniques
- **Disponibilité APIs** : % temps services externes opérationnels (> 99%)
- **Temps réponse** : Latence moyenne recherche (< 1.5s)
- **Cache hit rate** : % requêtes servies par cache (> 60%)
- **Taux disponibilité app** : Uptime global (> 99.5%)

### Métriques Produit
- **Couverture recettes** : Nombre recettes disponibles (> 2000)
- **Précision nutrition** : % données nutritionnelles complètes (> 85%)
- **Engagement IA** : Interactions IA par session (> 2.5)
- **Retention** : % utilisateurs revenant à 7j (> 35%)
- **Acquisition mobile** : % trafic depuis mobile (> 70%)

---

## �📄 Licence

Ce projet est sous licence [MIT](LICENSE).

---

## 📞 Support

Pour toute question ou problème:

1. Vérifier la [Documentation](CAHIER_DES_CHARGES.md)
2. Consulter les [Issues](../../issues)
3. Contacter l'équipe de développement

---

## 📝 Changelog

### v1.0.0 (Février 2026)
- ✅ Recherche de plats (TheMealDB)
- ✅ Informations nutritionnelles (OpenFoodFacts)
- ✅ Interface de base
- ✅ Configuration Docker
- ⏳ Authentification utilisateur
- ⏳ Sauvegarde des favoris

---

**Dernière mise à jour:** Février 2026  
**Statut:** En développement 🚀
