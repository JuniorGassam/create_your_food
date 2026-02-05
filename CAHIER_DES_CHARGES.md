# Cahier des Charges Fonctionnel - Create Your Food

## 1. Résumé Exécutif

**Nom du projet:** Create Your Food  
**Equipe:** Junior GASSSAM GASSAM et Judin MALIVERT  
**Type:** Application web intégrant 2 APIs externes  
**Objectif:** Fournir une plateforme permettant aux utilisateurs de rechercher des plats et consultants leurs informations nutritionnelles

---

## 2. Description du Projet

### 2.1 Vision Générale
Create Your Food est une application web innovante qui facilite la recherche de recettes et l'accès aux informations nutritionnelles détaillées. L'application s'appuie sur deux APIs externes :

- **TheMealDB** : Base de données de plats et recettes mondiaux
- **OpenFoodFacts** : Base de données sur les informations nutritionnelles des produits alimentaires

### 2.2 Objectifs Principaux
1. Permettre aux utilisateurs de rechercher des plats par ingrédient ou nom
2. Afficher les résultats de recherche avec détails des recettes
3. Fournir les informations nutritionnelles associées aux produits
4. Créer une interface utilisateur intuitive et réactive
5. Garantir une intégration seamless des deux APIs

---

## 3. Analyse SWOT

**Forces (interne)**
- APIs gratuites et riches (TheMealDB: 1000+ recettes, OpenFoodFacts: millions de produits)
- Framework Symfony mature et sécurisé
- Combinaison unique recherche plats + nutrition
- Chatbot IA pour engagement utilisateur
- Proposition IA innovante pour création de plats

**Faiblesses (interne)**
- Dépendance à APIs externes (risque indisponibilité)
- Données nutritionnelles parfois incomplètes
- Pas de vérification des données (crowdsourced)
- Chatbot/IA nécessite expertise spécialisée
- Cache limité (pas de Redis actuellement)

**Opportunités (externe)**
- Croissance du marché healthy eating
- Intégration avec apps fitness (MyFitnessPal, etc.)
- Expansion internationale (APIs multilingues)
- Monétisation via premium features
- Partenariats avec marques alimentaires

**Menaces (externe)**
- Concurrence d'apps établies (Yummly, Allrecipes)
- Changements dans les APIs externes
- Réglementation RGPD stricte
- Qualité variable des données crowdsourced
- Coûts d'IA si scaling

---

## 4. Analyse fonctionnelle

### 4.1 Diagramme Bête à Cornes

> *À qui le produit rend-il service ? Sur quoi agit-il ? Dans quel but ?*

```
    ┌──────────────────────┐                  ┌──────────────────────┐
    │   Utilisateurs       │                  │  Plats et aliments   │
    │   curieux de cuisine │                  │  avec données        │
    │   et nutrition       │                  │  nutritionnelles     │
    └──────────┬───────────┘                  └───────────┬──────────┘
               │                                          │
               │        ┌────────────────────┐            │
               └───────▸│                    │◂───────────┘
                        │   Create Your Food │
                        │       (App Web)    │
                        └────────┬───────────┘
                                 │
                                 ▼
                  ┌────────────────────────────┐
                  │  Trouver et créer des      │
                  │  plats personnalisés       │
                  │  avec infos nutritionnelles│
                  └────────────────────────────┘
```

| Question | Réponse |
|----------|---------|
| **À qui rend-il service ?** | Utilisateurs intéressés par la cuisine et la nutrition |
| **Sur quoi agit-il ?** | Plats, recettes et informations nutritionnelles |
| **Dans quel but ?** | Faciliter la découverte de recettes et l'accès aux données nutritionnelles |

### 4.2 Diagramme Pieuvre

> *Quelles sont les relations entre le produit et les éléments de son milieu extérieur ?*

```
  ┌──────────────┐          ┌──────────────┐          ┌──────────────┐
  │ Utilisateur  │          │  APIs        │          │  Appareil    │
  │ web/mobile   │          │  externes    │          │  mobile      │
  └──────┬───────┘          └──────┬───────┘          └──────┬───────┘
         │                         │                         │
         │ FP1                     │ FC1                     │ FC2
         │                         │                         │
         │    ┌────────────────────┼────────────────────┐    │
         ├───▸│                                         │◂───┤
         │    │            Create Your Food             │    │
    FP2  │    │                 (Symfony)               │    │
         │    │                                         │    │
    FP3  ├───▸│                                         │◂───┤
         │    └──┬──────────┬──────────┬────────────┬───┘    │
         │       │          │          │            │      FC5
  ┌──────┴───┐   │ FC3      │ FC4      │ FC6        │
  │  Chatbot │   │          │          │            │
  │  IA      │   │          │          │      ┌─────┴────────┐
  └──────────┘   │          │          │      │  Proposition │
          ┌──────┴───────┐  │   ┌──────┴───┐  │  IA si pas   │
          │ Réglementa-  │  │   │ Infra-   │  │  de plat     │
          │ tion (RGPD)  │  │   │ structure│  └──────────────┘
          └──────────────┘  │   └──────────┘
                     ┌──────┴────────┐
                     │  TheMealDB    │
                     │  OpenFoodFacts│
                     └───────────────┘
```

**Analyse du Diagramme Pieuvre :**
- **Utilisateur web/mobile** : Point d'entrée principal, utilise l'app via navigateur ou mobile (FP1, FP2, FP3)
- **APIs externes** : Dépendance critique pour les données (FC1), source de recettes et nutrition
- **Appareil mobile** : Contraintes techniques pour responsive design et capteurs (FC2)
- **Chatbot IA** : Fonctionnalité avancée pour engagement utilisateur (FC4)
- **Proposition IA** : Innovation clé quand les APIs ne trouvent pas de résultats (FC5)
- **Réglementation (RGPD)** : Contrainte légale obligatoire (FC3)
- **Infrastructure** : Support technique pour performance et disponibilité (FC6)
- **TheMealDB & OpenFoodFacts** : Sources de données ouvertes, gratuites mais avec risques de disponibilité

Chaque relation représente une dépendance ou contrainte qui impacte la réussite du projet.

### 4.3 Fonctions de service

#### Fonctions principales (FP)

| Réf. | Fonction | Description | Critère |
|------|----------|-------------|---------|
| **FP1** | Rechercher plats | Permettre la recherche par ingrédient ou nom de plat | Résultats < 2s, APIs fiables |
| **FP2** | Afficher nutrition | Montrer les valeurs nutritionnelles des aliments | Données complètes, format clair |
| **FP3** | Créer plats personnalisés | Générer des plats à partir d'ingrédients via IA | Proposition pertinente si pas de match |

#### Fonctions contraintes (FC)

| Réf. | Fonction | Description | Critère |
|------|----------|-------------|---------|
| **FC1** | Intégrer APIs externes | Connecter TheMealDB et OpenFoodFacts | Gestion erreurs, cache |
| **FC2** | Responsive design | Adapter à mobile/tablette/desktop | Mobile-first |
| **FC3** | Authentification | Gestion comptes utilisateurs | Sécurisé, RGPD compliant |
| **FC4** | Chatbot IA | Assistant conversationnel sur page plat | Réponses pertinentes |
| **FC5** | Proposition IA | Suggestions quand pas de plat trouvé | Algorithme ML/IA |
| **FC6** | Performance | Temps réponse < 2s, disponibilité 99% | Cache, optimisation |

### 4.4 Matrice de flexibilité

| Fonction | Niveau | Justification |
|----------|--------|---------------|
| FP1 — Recherche | **F0** (impératif) | Cœur de l'application |
| FP2 — Nutrition | **F0** (impératif) | Valeur ajoutée principale |
| FP3 — Création IA | **F1** (peu flexible) | Différenciateur clé |
| FC1 — APIs | **F1** (peu flexible) | Dépendance externe |
| FC2 — Responsive | **F0** (impératif) | Usage mobile majoritaire |
| FC3 — Auth | **F2** (flexible) | Fonctionne sans compte |
| FC4 — Chatbot | **F2** (flexible) | Fonctionnalité bonus |
| FC5 — Proposition IA | **F1** (peu flexible) | Complexité technique |
| FC6 — Performance | **F1** (peu flexible) | SLOs définis |

### 4.5 Personas

#### 🍳 Marie — La cuisinière passionnée

| | |
|---|---|
| **Âge** | 35 ans |
| **Profession** | Mère de famille |
| **Lieu** | Paris |
| **Devices** | Smartphone Android, tablette |
| **Comportement** | Cuisine tous les jours, attentive à la nutrition familiale |

**Objectifs**
- Trouver des recettes équilibrées pour la famille
- Vérifier les valeurs nutritionnelles des ingrédients
- Créer des plats personnalisés avec ce qu'elle a au frigo

**Frustrations**
- Recettes trop complexes ou pas adaptées
- Difficile d'estimer les calories totales
- Perd du temps à chercher des alternatives

**Citation** : *"Je veux savoir exactement ce que je cuisine pour ma famille."*

#### 🏃‍♂️ Thomas — Le sportif healthy

| | |
|---|---|
| **Âge** | 28 ans |
| **Profession** | Coach sportif |
| **Lieu** | Lyon |
| **Devices** | iPhone, ordinateur portable |
| **Comportement** | Suit un régime strict, cuisine ses repas |

**Objectifs**
- Calculer précisément les macros de ses repas
- Découvrir de nouvelles recettes healthy
- Utiliser le chatbot pour des conseils personnalisés

**Frustrations**
- Applications trop compliquées
- Données nutritionnelles imprécises
- Manque de personnalisation

**Citation** : *"J'ai besoin d'un outil simple pour tracker ma nutrition."*

#### 👨‍💼 Sophie — La working girl pressée

| | |
|---|---|
| **Âge** | 42 ans |
| **Profession** | Cadre commerciale |
| **Lieu** | Bordeaux |
| **Devices** | Smartphone iOS |
| **Comportement** | Mange souvent dehors, veut des repas rapides healthy |

**Objectifs**
- Trouver des plats rapides à préparer
- Vérifier la nutrition avant de commander
- Utiliser l'IA pour des suggestions innovantes

**Frustrations**
- Pas le temps de cuisiner compliqué
- Applications de livraison pas transparentes sur nutrition
- Besoin de variété dans les repas

**Citation** : *"Je veux manger healthy sans y passer des heures."*

### 4.6 User Stories

#### Épopée 1 : Recherche et découverte

| ID | En tant que... | Je veux... | Afin de... | Priorité |
|----|----------------|------------|------------|----------|
| US-1.1 | Utilisateur | rechercher par ingrédient | trouver des plats avec ce que j'ai | **Must** |
| US-1.2 | Utilisateur | rechercher par nom de plat | accéder directement à une recette | **Must** |
| US-1.3 | Utilisateur | voir les valeurs nutritionnelles | faire des choix éclairés | **Must** |
| US-1.4 | Utilisateur | filtrer par régime (vegan, etc.) | adapter aux restrictions alimentaires | **Should** |
| US-1.5 | Utilisateur | trier par temps de préparation | choisir selon mon temps disponible | **Could** |

#### Épopée 2 : Création personnalisée

| ID | En tant que... | Je veux... | Afin de... | Priorité |
|----|----------------|------------|------------|----------|
| US-2.1 | Utilisateur | saisir mes ingrédients | créer un plat personnalisé | **Must** |
| US-2.2 | Utilisateur | recevoir des propositions IA | découvrir de nouvelles combinaisons | **Must** |
| US-2.3 | Utilisateur | voir la nutrition du plat créé | vérifier l'équilibre | **Should** |

#### Épopée 3 : Interaction IA

| ID | En tant que... | Je veux... | Afin de... | Priorité |
|----|----------------|------------|------------|----------|
| US-3.1 | Utilisateur | discuter avec le chatbot | obtenir des conseils culinaires | **Should** |
| US-3.2 | Utilisateur | poser des questions sur la recette | comprendre les étapes | **Should** |
| US-3.3 | Utilisateur | demander des variantes | adapter la recette | **Could** |

#### Épopée 4 : Authentification et personnalisation

| ID | En tant que... | Je veux... | Afin de... | Priorité |
|----|----------------|------------|------------|----------|
| US-4.1 | Utilisateur | créer un compte | sauvegarder mes préférences | **Should** |
| US-4.2 | Utilisateur | me connecter avec Google | m'inscrire rapidement | **Should** |
| US-4.3 | Utilisateur | changer de langue | utiliser l'app dans ma langue | **Could** |
| US-4.4 | Utilisateur | sauvegarder des recettes | les retrouver facilement | **Should** |
| US-4.5 | Utilisateur | voir mon historique | reprendre mes recherches | **Could** |

#### Matrice de priorisation (MoSCoW)

| Priorité | Signification | Nombre |
|----------|---------------|--------|
| **Must** | Indispensable au MVP | 6 |
| **Should** | Important pour la v1 | 6 |
| **Could** | Souhaitable si temps | 3 |
| **Won't** | Hors scope actuel | 0 |

---

## 5. KPIs (Key Performance Indicators)

### 5.1 KPIs Métier

| KPI | Définition | Cible | Fréquence |
|-----|------------|-------|-----------|
| **Taux de conversion recherche** | % recherches aboutissant à consultation recette | > 40% | Quotidien |
| **Temps moyen session** | Durée moyenne utilisateur sur l'app | > 5 min | Quotidien |
| **Taux satisfaction** | Note moyenne utilisateur (1-5) | > 4.2 | Mensuel |
| **Utilisation chatbot** | % sessions avec interaction chatbot | > 25% | Hebdomadaire |
| **Proposition IA acceptée** | % propositions IA menant à création plat | > 30% | Quotidien |

### 5.2 KPIs Technique

| KPI | Définition | Cible | Fréquence |
|-----|------------|-------|-----------|
| **Disponibilité APIs** | % temps APIs externes opérationnelles | > 99% | Quotidien |
| **Temps réponse recherche** | Latence moyenne recherche | < 1.5s | Temps réel |
| **Taux erreur API** | % appels API en erreur | < 5% | Quotidien |
| **Cache hit rate** | % requêtes servies par cache | > 60% | Quotidien |
| **Taux disponibilité app** | % uptime application | > 99.5% | Quotidien |

### 5.3 KPIs Produit

| KPI | Définition | Cible | Fréquence |
|-----|------------|-------|-----------|
| **Couverture recettes** | Nombre recettes disponibles | > 2000 | Mensuel |
| **Précision nutrition** | % données nutritionnelles complètes | > 85% | Mensuel |
| **Engagement IA** | Nombre interactions IA/session | > 2.5 | Hebdomadaire |
| **Retention utilisateurs** | % utilisateurs revenant à 7j | > 35% | Mensuel |
| **Acquisition mobile** | % trafic depuis mobile | > 70% | Quotidien |

---

## 6. Choix architecturaux

### 6.1 Monolithe vs Micro-services

| | Monolithe (choisi) | Micro-services |
|---|---|---|
| **Complexité** | Faible (Symfony standard) | Élevée (orchestration) |
| **Déploiement** | Simple (1 artefact) | Complexe (multi-conteneurs) |
| **Performance** | Bonne pour charge modérée | Optimale pour scaling |
| **Équipe** | 1-2 développeurs | Équipe plus large |

**Justification** : L'application reste modeste en taille et trafic. Symfony fournit une architecture modulaire suffisante avec contrôleurs séparés.

### 6.2 APIs externes : TheMealDB vs OpenFoodFacts

| Critère | TheMealDB | OpenFoodFacts |
|---------|-----------|---------------|
| **Usage** | Recettes et plats | Données nutritionnelles |
| **Licence** | Gratuit, commercial OK | Open Data (ODbL) |
| **Fiabilité** | Bonne (hébergé communautaire) | Excellente (fondation) |
| **Couverture** | ~300 plats | Millions de produits |
| **Format** | JSON structuré | JSON flexible |

**Justification** : Combinaison parfaite pour le besoin : recettes + nutrition.

### 6.3 IA : Proposition et Chatbot

| Option | Choix | Alternative |
|--------|-------|-------------|
| **Proposition IA** | Règles + ML simple | LLM externe (GPT) |
| **Chatbot** | Bot conversationnel spécialisé | Intégration ChatGPT |

**Justification** : Coûts maîtrisés, confidentialité des données utilisateur.

### 6.4 Cache : Doctrine vs Redis

| | Doctrine Cache (actuel) | Redis (prévu) |
|---|---|---|
| **Simplicité** | Intégré à Symfony | Configuration supplémentaire |
| **Performance** | Suffisant pour trafic actuel | Optimale pour scaling |
| **Coût** | Aucun | Infrastructure légère |
| **Fonctionnalités** | Cache simple | Structures avancées, pub/sub |

**Justification** : Doctrine pour MVP, Redis prévu pour améliorer performance et ajouter fonctionnalités avancées (sessions distribuées, cache multilingue).

### 6.5 Internationalisation : Traducteur intégré

| Option | Choix | Alternative |
|--------|-------|-------------|
| **Traducteur** | Google Translate API | Traductions manuelles |
| **Cache** | Doctrine cache 24h | Pas de cache |

**Justification** : Automatisation complète, support multilingue sans effort manuel.

### 6.6 OAuth : Google vs autres

| Option | Choix | Alternative |
|--------|-------|-------------|
| **Provider** | Google OAuth | Facebook, Apple |
| **Bundle** | KnpUOAuth2Client | Implémentation custom |

**Justification** : Popularité Google, bundle Symfony mature.

---

## 7. Architecture technique

### 6.1 Vue globale

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
   │  Doctrine Cache     │    │  Doctrine Cache    │
   │  (1h TTL)           │    │  (24h TTL)         │
   └─────────────────────┘    └────────────────────┘
              ▲                         ▲
              │                         │
   ┌──────────┴──────────┐    ┌─────────┴─────────┐
   │   Redis (prévu)     │    │   Redis (prévu)   │
   │   Cache avancé      │    │   Cache avancé    │
   └─────────────────────┘    └───────────────────┘
              ▲                         ▲
              │                         │
   ┌──────────┴─────────────────────────┴──────────┐
   │            PostgreSQL Database                │
   │   Tables: users, favorites, search_history    │
   └───────────────────────────────────────────────┘
```

**Conteneurisation Docker :**
- Application Symfony dans conteneur PHP-FPM
- Nginx comme reverse proxy et serveur statique
- PostgreSQL et Redis dans conteneurs séparés
- Docker Compose pour orchestration locale

### 6.2 Stack technique

| Couche | Technologies |
|--------|-------------|
| **Frontend** | Twig, CSS3, JavaScript (ES6+), Bootstrap |
| **Backend** | Symfony 6.1, PHP 8.1, Nginx |
| **Base de données** | PostgreSQL 15 |
| **Cache** | Doctrine Cache (actuel), Redis (prévu) |
| **Conteneurisation** | Docker, Docker Compose |
| **APIs externes** | TheMealDB, OpenFoodFacts |

---

## 7. Pipeline de données

### 7.1 Flux recherche

```
Requête utilisateur ──▸ Controller ──▸ Service ──▸ API externe ──▸ Cache ──▸ Base ──▸ Vue
```

### 7.2 Intégration APIs

- **TheMealDB** : Recherche par nom/ingrédient, détails recette
- **OpenFoodFacts** : Recherche par code-barres ou nom produit
- **Matching** : Algorithme simple pour lier ingrédients recette ↔ produits nutrition

### 7.3 Proposition IA

- **Entrée** : Liste ingrédients utilisateur
- **Traitement** : Règles métier + clustering ML
- **Sortie** : Plat suggéré avec recette générée

### 7.4 Chatbot

- **Technologie** : Bot basé règles + NLP simple
- **Contexte** : Recette actuelle
- **Réponses** : Conseils cuisine, variantes, FAQ

### 8. Authentification & sécurité

#### 8.1 Authentification

- **Méthodes disponibles** : 
  - Locale : Email + mot de passe (bcrypt)
  - OAuth : Google pour inscription/connexion rapide
- **Symfony Security** : Sessions PHP sécurisées
- **Connexion** : Standard avec remember me
- **Liaison comptes** : Possibilité de lier compte Google à compte local existant

#### 8.2 Google OAuth 2.0

- **Flux** : Authorization Code avec PKCE
- **Scénarios** :
  1. Nouvel utilisateur Google → création automatique du compte
  2. Email Google existant → liaison automatique
- **Sécurité** : State parameter, PKCE pour protection
- **Intégration** : Via KnpUOAuth2ClientBundle (Symfony)

#### 8.3 Sécurité

- **RGPD** : Consentement, droit oubli, minimisation données
- **HTTPS** : Obligatoire en production
- **Rate limiting** : Via firewall Symfony
- **Validation** : Toutes entrées utilisateur validées

---

## 9. Internationalisation (i18n)

### 9.1 Support multilingue

- **Langues supportées** : Français (par défaut), Anglais, Espagnol
- **Framework** : Symfony Translator
- **Traducteur intégré** : Utilisation de Google Translate API pour traductions dynamiques
- **Fichiers de traduction** : YAML/JSON pour textes statiques
- **Contenu dynamique** : Traduction automatique des recettes et ingrédients via API

### 9.2 Implémentation

- **Détection langue** : Browser locale, paramètre URL, choix utilisateur
- **Cache traductions** : Doctrine cache pour éviter appels répétés à Google Translate
- **Fallback** : Affichage en anglais si traduction échoue
- **Performance** : Traductions mises en cache 24h

### 9.3 APIs et données

- **TheMealDB** : Recettes en anglais, traduction vers langues cibles
- **OpenFoodFacts** : Données multilingues natives, utilisation directe
- **Chatbot IA** : Réponses traduites selon langue utilisateur

---

## 10. Application frontend

### 9.1 Pages principales

| Route | Page | Description |
|-------|------|-------------|
| `/` | HomePage | Recherche principale |
| `/recipe/{id}` | RecipePage | Détails + chatbot |
| `/create` | CreatePage | Saisie ingrédients + IA |
| `/nutrition/{query}` | NutritionPage | Valeurs nutritionnelles |

### 9.2 Responsive design

- Mobile-first avec Bootstrap
- Optimisé pour smartphones (320px+)
- Progressive enhancement

---

## 10. Infrastructure & déploiement

### 10.1 Conteneurisation

- **Docker** : Image PHP + Nginx
- **Docker Compose** : Dev environment
- **Production** : Hébergement traditionnel (pas cloud requis)

### 10.2 Monitoring

- **Logs** : Monolog (Symfony)
- **Métriques** : Manuel pour l'instant
- **Alertes** : Email sur erreurs critiques

---

## 11. Observabilité

### 11.1 Logs

- Niveaux : DEBUG, INFO, WARNING, ERROR
- Format : JSON structuré
- Rotation : Quotidienne

### 11.2 Métriques

- Temps réponse APIs
- Taux succès requêtes
- Utilisation cache

---

## 12. Sécurité

- **OWASP Top 10** : Protection XSS, CSRF, injection
- **Mots de passe** : bcrypt cost 12
- **Sessions** : Sécurisées, expiration
- **APIs** : Rate limiting, validation

---

## 13. Performance

### 13.1 Objectifs

| Métrique | Cible |
|----------|-------|
| Temps réponse recherche | < 2s |
| Disponibilité app | > 99% |
| Cache hit rate | > 50% |

### 13.2 Optimisations

- Cache APIs externes
- Requêtes parallèles quand possible
- Lazy loading images

---

## 14. Conformité légale

- **RGPD** : Respecté (voir section sécurité)
- **Licences APIs** : Gratuites et compatibles
- **Droits d'auteur** : Crédits aux APIs

---

## 15. Roadmap (mise à jour)

### Implémenté

- [x] Recherche basique plats
- [x] Intégration TheMealDB
- [x] Affichage recettes
- [x] Intégration OpenFoodFacts basique
- [x] Connexion Google OAuth
- [x] Internationalisation avec traducteur Google

### À venir

- [ ] Authentification complète (locale)
- [ ] Chatbot IA sur page recette
- [ ] Proposition IA pour création plats
- [ ] Implémentation Redis pour cache avancé
- [ ] Tests automatisés
- [ ] PWA (Progressive Web App)
- [ ] API REST pour mobile
- [ ] Dashboard admin
- [ ] Analytics utilisateur

### Strengths (Forces)
- ✅ **APIs gratuites et fiables** : TheMealDB et OpenFoodFacts offrent des données à jour
- ✅ **Base de données riche** : Accès à des milliers de plats et produits
- ✅ **Technologie moderne** : Framework Symfony 6.1 performant
- ✅ **Architecture modulaire** : Séparation claire entre les contrôleurs et les vues
- ✅ **Cas d'usage pertinent** : Adresse un besoin réel (recherche nutritionnelle + recettes)

### Weaknesses (Faiblesses)
- ❌ **Dépendance à des services tiers** : Indisponibilité des APIs = dysfonctionnement de l'app
- ❌ **Données fragmentées** : Les deux APIs ne sont pas liées, matching manuel requis
- ❌ **Performance potentielle** : Appels API multiples par requête utilisateur
- ❌ **Couverture géographique** : Les résultats peuvent varierselon la région
- ❌ **Pas de système de cache** : Requêtes répétées sans optimisation

### Opportunities (Opportunités)
- 🎯 **Expansion mobile** : Développer une application mobile (iOS/Android)
- 🎯 **Recommandations personnalisées** : Système de recommandations basé sur l'historique
- 🎯 **Intégration santé** : Lier à des applications de suivi de santé/fitness
- 🎯 **Fonctionnalités sociales** : Partage de recettes, évaluations communautaires
- 🎯 **Mode hors ligne** : Cache local des recherches fréquentes
- 🎯 **Internationalisation** : Support multilingue et adaptations régionales

### Threats (Menaces)
- ⚠️ **Concurrence** : MyFitnessPal, Yazio, Cronometer existants
- ⚠️ **Changements d'APIs** : Modifications ou suppression des endpoints
- ⚠️ **Conformité légale** : RGPD, licences de données
- ⚠️ **Erreurs de données** : Informations nutritionnelles inexactes
- ⚠️ **Ralentissements** : Congestion de la bande passante entre les APIs

---

## 4. Diagramme Bête à Corne

```
                    ┌─────────────────────┐
                    │   UTILISATEUR       │
                    │   (Personne)        │
                    └──────────┬──────────┘
                               │
                      Cherche des recettes
                      et leurs données
                         nutritionnelles
                               │
          ┌────────────────────┼────────────────────┐
          │                    │                    │
    ┌─────▼─────┐        ┌─────▼─────┐      ┌──────▼────────┐
    │  Create   │        │   API     │      │  OpenFood     │
    │ Your Food │◄───────┤ TheMealDB │◄─────┤   Facts API   │
    │ Platform  │        │  (Plats)  │      │  (Nutrition)  │
    └───────────┘        └───────────┘      └───────────────┘
          │
    Affiche les résultats
    et informations nutritionnelles
          │
    ┌─────▼─────────────────────────────┐
    │    NAVIGATEUR WEB / INTERFACE     │
    │   (Écran ordinateur/tablette)     │
    └───────────────────────────────────┘
```

### Analyse de la Bête à Corne
- **Qui ?** Utilisateur recherchant des recettes et informations nutritionnelles
- **Quoi ?** Plateforme d'intégration de données culinaires et nutritionnelles
- **Où ?** Interface web accessible via navigateur
- **Quand ?** En temps réel lors de la recherche
- **Pourquoi ?** Faciliter l'accès aux données combinées de deux sources différentes
- **Comment ?** Via intégration API et interface web Symfony

---

## 5. Diagramme de la Pieuvre (Analyse Fonctionnelle)

```
                            UTILISATEUR
                                 │
                        ┌────────┼────────┐
                        │        │        │
                   ┌────▼───┐┌──▼─────┐┌─▼─────┐
                   │  FP1   ││  FP2   ││ FP3   │
                   │Chercher││Afficher││Gérer  │
                   │ Plats  ││Données ││Compte │
                   └────────┘└────────┘└───────┘
          │                                       │
     ┌────▼─────────────────────────────────────┬─▼────┐
     │            SYSTEM CORE                   │ INIT │
     │   (Create Your Food Platform)            │      │
     └──────────────────────────────────────────┘──────┘
     │
     ├──▼── FP4 : Récupérer données TheMealDB
     │
     ├──▼── FP5 : Récupérer données OpenFoodFacts
     │
     ├──▼── FP6 : Transformer et mapper les données
     │
     ├──▼── FP7 : Gérer les erreurs de connexion
     │
     ├──▼── FP8 : Cacher les résultats de recherche
     │
     └──▼── FP9 : Authentifier l'utilisateur
```

### Fonctionnalités Principales (FP) :

| Code | Fonction | Description |
|------|----------|-------------|
| **FP1** | Chercher des plats | L'utilisateur recherche un plat par nom ou ingrédient |
| **FP2** | Afficher les données | Affichage des recettes et informations nutritionnelles |
| **FP3** | Gérer les comptes | Inscription, connexion, profil utilisateur |
| **FP4** | Intégration TheMealDB | Requête API vers TheMealDB pour récupérer les plats |
| **FP5** | Intégration OpenFoodFacts | Requête API vers OpenFoodFacts pour la nutrition |
| **FP6** | Traitement des données | Nettoyage et formatage des données reçues |
| **FP7** | Gestion d'erreurs | Gestion des timeouts, erreurs API, données manquantes |
| **FP8** | Cache et optimisation | Stockage temporaire des requêtes fréquentes |
| **FP9** | Authentification | Gestion des utilisateurs et sessions |

---

## 6. User Stories et Cas d'Utilisation

### 6.1 Acteurs Principaux
- 👤 **Utilisateur Non Authentifié** : Peut consulter
- 👤 **Utilisateur Authentifié** : Accès complet + sauvegarde
- 🔧 **Administrateur** : Gestion du système
- 🌐 **Systèmes Externes** : TheMealDB, OpenFoodFacts

---

### 6.2 User Stories

#### US1 : Recherche Simple de Plats
```
EN TANT QUE utilisateur
JE VEUX rechercher des plats par nom ou ingrédient
AFIN DE trouver rapidement les recettes qui m'intéressent

Critères d'Acceptation:
✓ L'utilisateur peut entrer un terme de recherche
✓ Les résultats s'affichent sous 3 secondes
✓ Au minimum 5 résultats sont affichés
✓ Un message d'erreur s'affiche si aucun résultat
✓ La recherche n'est pas sensible à la casse

Exemple:
GIVEN l'utilisateur est sur la page de recherche
WHEN il tape "chicken"
THEN il voit les plats contenant "chicken"
```

#### US2 : Consulter les Informations Nutritionnelles
```
EN TANT QUE utilisateur
JE VEUX voir les informations nutritionnelles des produits
AFIN DE faire des choix alimentaires éclairés

Critères d'Acceptation:
✓ Les calories sont affichées
✓ Les macronutriments (protéines, glucides, lipides) sont visibles
✓ Les micronutriments sont détaillés (vitamines, minéraux)
✓ Un indicateur "Sain/Équilibré" est affiché si disponible
✓ Les données manquantes sont clairement indiquées

Exemple:
GIVEN un plat est sélectionné
WHEN j'accède aux informations nutritionnelles
THEN je vois au minimum les calories et macronutriments
```

#### US3 : Voir les Détails d'une Recette
```
EN TANT QUE utilisateur
JE VEUX consulter les détails complets d'une recette
AFIN DE l'apprendre et la reproduire

Critères d'Acceptation:
✓ Les ingrédients sont listés avec quantités
✓ Les étapes de préparation sont claires
✓ Le temps de préparation est indiqué
✓ Les portions recommandées sont visibles
✓ Une image du plat est affichée

Exemple:
GIVEN je suis sur la liste des résultats
WHEN je clique sur une recette
THEN je vois tous les détails (ingrédients, étapes, temps)
```

#### US4 : Authentification Utilisateur
```
EN TANT QUE utilisateur
JE VEUX créer un compte et me connecter
AFIN DE sauvegarder mes recettes favoris et mon historique

Critères d'Acceptation:
✓ L'inscription nécessite email et mot de passe
✓ Un email de confirmation est envoyé
✓ La connexion stocke une session sécurisée
✓ Le mot de passe est hashé en base de données
✓ Un utilisateur ne peut voir que ses propres données

Exemple:
GIVEN je suis sur la page de connexion
WHEN j'entre mes identifiants
THEN je suis connecté et accède à mes favoris
```

#### US5 : Sauvegarder les Favoris
```
EN TANT QUE utilisateur authentifié
JE VEUX sauvegarder mes recettes préférées
AFIN DE les retrouver rapidement plus tard

Critères d'Acceptation:
✓ Un bouton "Ajouter aux favoris" est disponible
✓ Les favoris sont sauvegardés en base de données
✓ Je peux consulter la liste de mes favoris
✓ Je peux supprimer un favori
✓ Un message de confirmation s'affiche

Exemple:
GIVEN je consulte une recette
WHEN je clique sur "Ajouter aux favoris"
THEN la recette est sauvegardée et confirmée
```

#### US6 : Gestion des Erreurs API
```
EN TANT QUE utilisateur
JE VEUX voir des messages d'erreur clairs
AFIN DE comprendre pourquoi ma recherche a échoué

Critères d'Acceptation:
✓ Si TheMealDB est indisponible → message spécifique
✓ Si OpenFoodFacts est indisponible → message adapté
✓ Si aucun résultat → suggestion de recherche alternative
✓ Les erreurs sont logguées côté serveur
✓ L'utilisateur peut réessayer en 1 clic

Exemple:
GIVEN j'effectue une recherche
WHEN l'API TheMealDB ne répond pas
THEN je vois "Service indisponible, réessayez plus tard"
```

#### US7 : Filtrage et Tri des Résultats
```
EN TANT QUE utilisateur
JE VEUX filtrer et trier les résultats de recherche
AFIN DE trouver rapidement les recettes les plus pertinentes

Critères d'Acceptation:
✓ Tri par calories (ascendant/descendant)
✓ Filtrer par catégorie (vegan, sans gluten, etc.)
✓ Filtrer par temps de préparation
✓ Les filtres se combinent
✓ Le nombre de résultats filtrés s'affiche

Exemple:
GIVEN j'ai des résultats de recherche
WHEN je sélectionne "Vegan" et trie par calories
THEN seules les recettes vegan s'affichent, triées par calories
```

#### US8 : Performance et Cache
```
EN TANT QUE développeur
JE VEUX que les requêtes soient optimisées
AFIN DE réduire les appels API et améliorer la performance

Critères d'Acceptation:
✓ Les résultats identiques sont cachés pendant 1 heure
✓ Les données sont compressées avant transmission
✓ Le temps de réponse est inférieur à 2 secondes
✓ Les appels API en doublons sont évités
✓ Un système de logging suit les performances

Exemple:
GIVEN un utilisateur cherche "pasta"
WHEN un autre utilisateur fait la même recherche 5 min après
THEN les résultats viennent du cache
```

---

### 6.3 Diagramme de Cas d'Utilisation

```
                                    ┌─────────────────────┐
                                    │   UTILISATEUR       │
                                    │  Non Authentifié    │
                                    └──────────┬──────────┘
                                               │
                ┌──────────────────────────────┼──────────────────────────────┐
                │                              │                              │
          ┌─────▼──────┐              ┌───────▼────────┐          ┌──────────▼──────┐
          │  Rechercher│              │  Voir Détails  │          │  Voir Nutrition │
          │   Plats    │              │  de Recette    │          │   Informations  │
          └────────────┘              └────────────────┘          └─────────────────┘
                                               │
                                    ┌──────────▼──────────┐
                                    │  UTILISATEUR        │
                                    │  Authentifié        │
                                    └──────────┬──────────┘
                                               │
                ┌──────────────────────────────┼──────────────────────────────┐
                │                              │                              │
          ┌─────▼──────────┐         ┌────────▼─────────┐     ┌──────────────▼───┐
          │ Sauvegarder    │         │  Consulter       │     │  Gérer Profil    │
          │    Favoris     │         │  Historique      │     │  Utilisateur     │
          └────────────────┘         └──────────────────┘     └──────────────────┘
                                               │
                                    ┌──────────▼──────────┐
                                    │  ADMINISTRATEUR     │
                                    └──────────┬──────────┘
                                               │
                ┌──────────────────────────────┼──────────────────────────────┐
                │                              │                              │
          ┌─────▼──────────┐         ┌────────▼─────────┐     ┌──────────────▼───┐
          │ Gérer les      │         │  Consulter       │     │ Gérer la Base    │
          │ Utilisateurs   │         │  Logs et Stats   │     │  de Données      │
          └────────────────┘         └──────────────────┘     └──────────────────┘
```

---

## 7. Flux des Cas d'Utilisation Détaillés

### CU1 : Rechercher un Plat

**Acteur Principal:** Utilisateur  
**Acteurs Secondaires:** TheMealDB API  
**Préconditions:** L'utilisateur est sur la page d'accueil

**Scénario Nominal:**
1. L'utilisateur entre un terme de recherche (ex: "chicken")
2. Il clique sur "Rechercher" ou appuie sur Entrée
3. L'application valide le terme
4. Une requête est envoyée à TheMealDB
5. L'API retourne les résultats
6. Les résultats sont affichés avec image, nom et courte description
7. L'utilisateur peut cliquer sur un résultat pour plus de détails

**Scénarios Alternatifs:**
- **A1** : Si le terme contient des caractères invalides → message d'erreur
- **A2** : Si TheMealDB ne répond pas → afficher "Service indisponible"
- **A3** : Si aucun résultat n'existe → "Aucun plat trouvé"
- **A4** : Si la recherche est vide → afficher des suggestions populaires

---

### CU2 : Consulter Détails et Nutrition

**Acteur Principal:** Utilisateur  
**Acteurs Secondaires:** TheMealDB API, OpenFoodFacts API  
**Préconditions:** L'utilisateur a effectué une recherche et vu les résultats

**Scénario Nominal:**
1. L'utilisateur clique sur une recette dans les résultats
2. L'application récupère les détails complets de TheMealDB
3. L'application récupère les informations nutritionnelles (si applicable)
4. La page affiche:
   - Image en haute résolution
   - Ingrédients avec quantités
   - Étapes de préparation
   - Temps de cuisson
   - Informations nutritionnelles (calories, macro/micronutriments)
5. L'utilisateur peut retourner à la recherche

**Scénarios Alternatifs:**
- **A1** : Si les données nutritionnelles ne sont pas disponibles → afficher "Non disponible"
- **A2** : Si l'une des API échoue → afficher les données disponibles

---

## 8. Exigences Fonctionnelles

### 8.1 Recherche et Affichage

| ID | Exigence | Priorité | Statut |
|----|----------|----------|--------|
| RF01 | Recherche par terme libre | **HAUTE** | ✅ |
| RF02 | Affichage des résultats en liste paginée | **MOYENNE** | ⏳ |
| RF03 | Filtre par catégorie (viande, végétal, etc.) | **MOYENNE** | ⏳ |
| RF04 | Tri par calories, temps de cuisson | **MOYENNE** | ⏳ |
| RF05 | Barre de recherche sur toutes les pages | **HAUTE** | ✅ |
| RF06 | Suggestions de recherche (autocomplétion) | **BASSE** | ⏳ |

### 8.2 Affichage des Détails

| ID | Exigence | Priorité | Statut |
|----|----------|----------|--------|
| RF07 | Page détail recette avec image, ingrédients, étapes | **HAUTE** | ✅ |
| RF08 | Affichage des informations nutritionnelles | **HAUTE** | ⏳ |
| RF09 | Portion recommandée et calories totales | **MOYENNE** | ⏳ |
| RF10 | Temps de préparation et portion | **MOYENNE** | ✅ |

### 8.3 Authentification

| ID | Exigence | Priorité | Statut |
|----|----------|----------|--------|
| RF11 | Système d'inscription avec email | **HAUTE** | ⏳ |
| RF12 | Connexion/Déconnexion sécurisée | **HAUTE** | ⏳ |
| RF13 | Récupération de mot de passe oublié | **MOYENNE** | ⏳ |
| RF14 | Profil utilisateur éditable | **MOYENNE** | ⏳ |

### 8.4 Favoris

| ID | Exigence | Priorité | Statut |
|----|----------|----------|--------|
| RF15 | Ajouter une recette aux favoris | **MOYENNE** | ⏳ |
| RF16 | Consulter la liste des favoris | **MOYENNE** | ⏳ |
| RF17 | Supprimer d'un favori | **MOYENNE** | ⏳ |
| RF18 | Partager un favori (lien/email) | **BASSE** | ⏳ |

### 8.5 Performance et Sécurité

| ID | Exigence | Priorité | Statut |
|----|----------|----------|--------|
| RF19 | Temps de réponse < 2 secondes | **HAUTE** | ⏳ |
| RF20 | Cache des résultats pour 1 heure | **MOYENNE** | ⏳ |
| RF21 | Gestion des erreurs API gracieuse | **HAUTE** | ✅ |
| RF22 | Logging des erreurs et actions | **MOYENNE** | ✅ |
| RF23 | HTTPS obligatoire | **HAUTE** | ⏳ |
| RF24 | RGPD compliant (consentement, suppression) | **HAUTE** | ⏳ |

---

## 9. Exigences Non-Fonctionnelles

### 9.1 Performance
- Temps de réponse initial : < 1 seconde
- Recherche complète : < 2 secondes
- Affichage des détails : < 1.5 secondes

### 9.2 Disponibilité
- Disponibilité minimale : 99% (sauf maintenance)
- Temps de maintenance : maintenu en heures creuses
- Basculement automatique si une API externe échoue

### 9.3 Sécurité
- Authentification par JWT ou session sécurisée
- Chiffrement des mots de passe (bcrypt)
- Protection CSRF
- Validation des entrées utilisateur
- Rate limiting sur les recherches (10 req/minute)

### 9.4 Scalabilité
- Architecture microservices possible
- Base de données relational (Doctrine)
- Cache Redis envisagé
- Support de 1000 utilisateurs simultanés

### 9.5 Compatibilité
- Navigateurs : Chrome, Firefox, Safari, Edge (versions récentes)
- Résolutions : Desktop (1024px+), Tablet (768px+), Mobile (320px+)
- Accessibilité : WCAG 2.1 AA

---

## 10. Architecture Technique

### 10.1 Stack Technologique

```
┌─────────────────────────────────────────────────────┐
│            Frontend (Twig + CSS/JS)                 │
│              Interface Utilisateur                  │
└──────────────────────────┬──────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────┐
│         Symfony 6.1 Framework                       │
│  ┌──────────────────────────────────────────────┐   │
│  │ Controllers: FoodController, SecurityCtrl    │   │
│  │ Services: HTTP Client, Validators            │   │
│  │ Routes: /foods, /security/login              │   │
│  └──────────────────────────────────────────────┘   │
└──────────────────────────┬──────────────────────────┘
                           │
        ┌──────────────────┼──────────────────┐
        │                  │                  │
   ┌────▼──────┐  ┌────────▼──────┐  ┌──────▼────────┐
   │ Doctrine  │  │  Symfony      │  │ HTTP Client   │
   │   ORM     │  │  Security     │  │               │
   │           │  │               │  │               │
   └────┬──────┘  └────────┬──────┘  └────────┬──────┘
        │                  │                  │
   ┌────▼──────────────────▼──────────────────▼─────┐
   │   Base de Données PostgreSQL                   │
   │   Tables: users, favorites, search_cache       │
   └────────────────────────────────────────────────┘
        │
        └──────────────────────────────────┐
                                           │
          ┌────────────────────────────────▼─────────┐
          │  Intégrations Externes                   │
          │  ┌──────────────┐  ┌──────────────────┐  │
          │  │  TheMealDB   │  │ OpenFoodFacts    │  │
          │  │  API v1.1    │  │ API v0           │  │
          │  └──────────────┘  └──────────────────┘  │
          └──────────────────────────────────────────┘
```

### 10.2 Points d'Intégration API

#### API TheMealDB
```
GET https://www.themealdb.com/api/json/v1/1/search.php?s={query}

Réponse:
{
  "meals": [
    {
      "idMeal": "52772",
      "strMeal": "Chicken Fettuccine",
      "strMealThumb": "...",
      "strIngredient1": "Chicken",
      "strMeasure1": "500g",
      "strInstructions": "Cook chicken...",
      ...
    }
  ]
}
```

#### API OpenFoodFacts
```
GET https://world.openfoodfacts.org/api/v0/product/{barcode}.json

Réponse:
{
  "product": {
    "name": "Product Name",
    "nutriments": {
      "energy_kcal": "100",
      "fat": "5",
      "protein": "10",
      "carbohydrates": "15"
    },
    "ingredients": [...],
    "image_url": "..."
  }
}
```

---

## 11. Contexte Réglementaire et Légal

### 11.1 RGPD (Règlement Général sur la Protection des Données)
- ✓ Politique de confidentialité claire
- ✓ Consentement explicite pour collecte de données
- ✓ Droit d'accès, rectification, suppression
- ✓ Droit à la portabilité
- ✓ Durée de rétention définie (12 mois max)

### 11.2 Licences des APIs
- **TheMealDB** : Gratuit, usage commercial autorisé
- **OpenFoodFacts** : Open Data (ODbL), crédits requis

### 11.3 Accessibilité
- Conformité WCAG 2.1 AA
- Textes alt pour images
- Navigation au clavier
- Contraste suffisant

---

## 12. Planification et Chronologie

### Phase 1 : MVP (2 semaines)
- [x] Setup Symfony + APIs
- [x] Recherche basique
- [x] Affichage des résultats
- [ ] Détails recette complets
- [ ] Informations nutritionnelles basiques

### Phase 2 : Authentification (1 semaine)
- [ ] Inscription/Connexion
- [ ] Gestion de sessions
- [ ] Profil utilisateur

### Phase 3 : Favoris et Historique (1 semaine)
- [ ] Système de favoris
- [ ] Historique de recherche
- [ ] Partage de recettes

### Phase 4 : Optimisation (1 semaine)
- [ ] Cache et performance
- [ ] Tests unitaires
- [ ] Documentation API

### Phase 5 : Déploiement (1 semaine)
- [ ] Configuration Docker
- [ ] Tests d'intégration
- [ ] Déploiement production

---

## 13. Critères de Succès

✅ **Fonctionnels**
- 95% des recherches retournent des résultats valides
- 99% des appels API réussissent ou sont gérés gracieusement
- Toutes les user stories du MVP sont implémentées

✅ **Performance**
- 90% des requêtes < 1.5 secondes
- Temps de chargement initial < 3 secondes
- Cache réduit les requêtes dupliquées de 80%

✅ **Utilisateur**
- Score de satisfaction > 4/5
- Taux de rebond < 20%
- Session moyenne > 5 minutes

✅ **Technique**
- Couverture de tests > 70%
- Aucune erreur critique en production
- Disponibilité > 99%

---

## 14. Risques et Mitigation

| Risque | Probabilité | Impact | Mitigation |
|--------|-------------|--------|-----------|
| API TheMealDB indisponible | Moyenne | Haute | Cache local, message utilisateur clair |
| Données nutritionnelles incomplètes | Haute | Moyenne | Affichage "N/A", recherche produit alternative |
| Performance lente avec beaucoup d'utilisateurs | Moyenne | Haute | Implémentation cache Redis, load balancing |
| Conformité RGPD insuffisante | Basse | Très Haute | Audit légal, consent management |
| Données inexactes des APIs externes | Moyenne | Moyenne | Validation des données, système de signalement |

---

## 15. Glossaire

| Terme | Définition |
|-------|-----------|
| **API** | Interface de Programmation Applicative - moyen de communication entre applications |
| **Cache** | Stockage temporaire de données pour accélérer l'accès ultérieur |
| **JWT** | JSON Web Token - format de sécurité pour authentifier les requêtes |
| **TheMealDB** | API gratuite contenant 1000+ recettes mondiales |
| **OpenFoodFacts** | Base de données open-source sur les informations nutritionnelles |
| **RGPD** | Règlement général sur la protection des données (UE) |
| **MVP** | Produit Minimum Viable - version fonctionnelle minimale |
| **WCAG** | Web Content Accessibility Guidelines - normes d'accessibilité |
| **Macronutriments** | Protéines, glucides, lipides |
| **Micronutriments** | Vitamines, minéraux, oligo-éléments |

---

## Annexes

### Annexe A : Mockups Interface

**Page de Recherche:**
```
┌──────────────────────────────────────────┐
│  Create Your Food          [Login]       │
├──────────────────────────────────────────┤
│                                          │
│  Rechercher des plats                    │
│  ┌─────────────────────────────────────┐ │
│  │ [Tapez un ingrédient...]       [🔍]   │ 
│  └─────────────────────────────────────┘ │
│                                          │
│  Catégories: Viande | Végétal | Etc.     │
│                                          │
│  Résultats:                              │
│  ┌──────────┬──────────┬──────────┐      │
│  │ Chicken  │ Fish     │ Pasta    │      │
│  │ Curry    │ Tacos    │ Risotto  │      │
│  └──────────┴──────────┴──────────┘      │
│                                          │
└──────────────────────────────────────────┘
```

### Annexe B : Endpoints API Backend

```
GET    /                           → Page d'accueil
GET    /foods                      → Recherche plats
GET    /foods/{id}                 → Détails plat
GET    /api/nutrition/{query}      → Données nutrition
POST   /auth/register              → Inscription
POST   /auth/login                 → Connexion
GET    /favorites                  → Mes favoris
POST   /favorites/{id}             → Ajouter favori
DELETE /favorites/{id}             → Supprimer favori
GET    /admin/dashboard            → Dashboard admin
```

---

**Document Version:** 1.0  
**Date de création:** Février 2026  
**Auteur:** Junior GASSAM GASSAM et Judin MALIVERT  
**Dernière mise à jour:** 02/02/2026  
**Statut:** ✅ Approuvé
