# Cahier des Charges Fonctionnel - Create Your Food

## 1. Résumé Exécutif

**Nom du projet:** Create Your Food  
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
    └──────────────────────────────────┘
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
                   ┌────▼───┐┌──▼────┐┌─▼─────┐
                   │  FP1   ││  FP2  ││ FP3   │
                   │Chercher││Afficher││Gérer  │
                   │ Plats  ││Données ││Compte │
                   └────────┘└────────┘└───────┘
          │                                        │
     ┌────▼─────────────────────────────────────┬─▼────┐
     │            SYSTEM CORE                    │ INIT │
     │   (Create Your Food Platform)             │      │
     └────────────────────────────────────────────┘──────┘
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
          ┌─────▼──────┐              ┌───────▼────────┐          ┌──────────▼─────┐
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
   └────┬──────┘  └────────┬──────┘  └──────┬────────┘
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
│  │ [Tapez un ingrédient...]        [🔍] │ │
│  └─────────────────────────────────────┘ │
│                                          │
│  Catégories: Viande | Végétal | Etc.   │
│                                          │
│  Résultats:                              │
│  ┌──────────┬──────────┬──────────┐     │
│  │ Chicken  │ Fish     │ Pasta    │     │
│  │ Curry    │ Tacos    │ Risotto  │     │
│  └──────────┴──────────┴──────────┘     │
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
**Auteur:** Équipe Développement  
**Dernière mise à jour:** 02/02/2026  
**Statut:** ✅ Approuvé
