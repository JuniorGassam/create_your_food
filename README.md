# Create Your Food 🍽️

Une plateforme web innovante permettant de **rechercher des recettes** et **consulter leurs informations nutritionnelles** en intégrant deux APIs externes majeures.

---

## 📋 Table des Matières

- [Fonctionnalités](#-fonctionnalités)
- [Stack Technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Utilisation](#-utilisation)
- [Architecture](#-architecture)
- [Contribution](#-contribution)
- [Licence](#-licence)

---

## ✨ Fonctionnalités

- 🔍 **Recherche dynamique de plats** via TheMealDB API
- 📊 **Informations nutritionnelles détaillées** via OpenFoodFacts API
- 👤 **Système d'authentification utilisateur** (inscription/connexion)
- ⭐ **Sauvegarde des favoris** (recettes préférées)
- 📱 **Interface responsive** (mobile, tablet, desktop)
- 🎨 **Design épuré et moderne** (Twig + Bootstrap)
- 🔄 **Gestion des erreurs gracieuse** (API indisponible, pas de résultats)
- 📝 **Documentation complète** (Cahier des charges, API docs)

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
- **Nginx:** 1.23 (Alpine)
- **Database Admin:** Adminer
- **Mailer:** Mailpit (dev)

### APIs Externes
- **TheMealDB:** https://www.themealdb.com/api/json/v1/1/
- **OpenFoodFacts:** https://world.openfoodfacts.org/api/v0/

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

| Service | URL | Description |
|---------|-----|-------------|
| **Application** | http://localhost:8080 | Interface web principale |
| **Adminer** | http://localhost:8081 | Interface de gestion de la BD |
| **Mailpit** | http://localhost:8025 | Interface d'émulation email (si activé) |

#### Tester les APIs

```bash
# Recherche de plats
curl "http://localhost:8080/foods?search=chicken"

# Voir les logs
docker compose logs -f php

# Arrêter l'application
docker compose down

# Arrêter et nettoyer les volumes
docker compose down -v
```

#### Commandes utiles Docker

```bash
# Accéder au shell PHP
docker compose exec php bash

# Accéder à la base de données
docker compose exec database psql -U app -d app

# Exécuter une commande Symfony
docker compose exec php php bin/console debug:routes
```

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

## 🏗️ Architecture

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
│   └── nginx/
│       └── default.conf      # Configuration Nginx
├── compose.yaml              # Docker Compose (PostgreSQL)
├── compose.override.yaml     # Surcharge dev (Mailpit)
├── Dockerfile                # Image PHP
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

## 📄 Licence

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
