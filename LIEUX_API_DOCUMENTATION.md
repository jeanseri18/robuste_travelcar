# Documentation des API Lieux - TravelCar225

## Nouvelles méthodes ajoutées au LieuController

Cette documentation décrit les nouvelles méthodes ajoutées au `LieuController` pour gérer les lieux de départ et d'arrivée selon le type de destination (national ou sous-régional).

## Méthodes disponibles

### 1. getLieuxDepartNational()
**Route:** `GET /api/lieux-depart-national`  
**Description:** Récupère tous les lieux de départ pour les destinations nationales  
**Filtres appliqués:**
- `typedestination = 'national'`
- `type IN ('depart', 'les_deux')`
- `est_actif = true`
- Triés par `ville`

**Réponse JSON:**
```json
[
  {
    "id": 1,
    "pays": "Côte d'Ivoire",
    "ville": "Abidjan",
    "commune": "Adjamé",
    "region": "Lagunes",
    "type": "depart",
    "typedestination": "national",
    "est_actif": true
  }
]
```

### 2. getLieuxArriveNational()
**Route:** `GET /api/lieux-arrive-national`  
**Description:** Récupère tous les lieux d'arrivée pour les destinations nationales  
**Filtres appliqués:**
- `typedestination = 'national'`
- `type IN ('arrive', 'les_deux')`
- `est_actif = true`
- Triés par `ville`

### 3. getLieuxDepartSousRegion()
**Route:** `GET /api/lieux-depart-sousregion`  
**Description:** Récupère tous les lieux de départ pour les destinations sous-régionales  
**Filtres appliqués:**
- `typedestination = 'sousregion'`
- `type IN ('depart', 'les_deux')`
- `est_actif = true`
- Triés par `ville`

### 4. getLieuxArriveSousRegion()
**Route:** `GET /api/lieux-arrive-sousregion`  
**Description:** Récupère tous les lieux d'arrivée pour les destinations sous-régionales  
**Filtres appliqués:**
- `typedestination = 'sousregion'`
- `type IN ('arrive', 'les_deux')`
- `est_actif = true`
- Triés par `ville`

### 5. getLieuxByTypeDestination($typeDestination)
**Route:** `GET /api/lieux-by-type/{typeDestination}`  
**Paramètres:** 
- `typeDestination`: 'national' ou 'sousregion'

**Description:** Récupère les lieux de départ ET d'arrivée pour un type de destination donné  

**Réponse JSON:**
```json
{
  "depart": [
    {
      "id": 1,
      "ville": "Abidjan",
      "commune": "Adjamé",
      "region": "Lagunes",
      "type": "depart",
      "typedestination": "national"
    }
  ],
  "arrive": [
    {
      "id": 2,
      "ville": "Bouaké",
      "commune": "Centre",
      "region": "Vallée du Bandama",
      "type": "arrive",
      "typedestination": "national"
    }
  ]
}
```

## Améliorations apportées

### 1. Migration mise à jour
- Ajout d'index composites pour optimiser les performances
- Index sur `typedestination`, `type`, et `est_actif`
- Index sur `ville` pour le tri

### 2. Vues mises à jour

#### Destinations Nationales
- `create.blade.php`: Utilise maintenant les API spécifiques aux destinations nationales
- `edit.blade.php`: Mise à jour pour utiliser les nouvelles API
- Affichage amélioré avec région dans les options

#### JavaScript mis à jour
```javascript
// Ancien code
fetch('/api/gares-lieux')

// Nouveau code pour destinations nationales
Promise.all([
    fetch('/api/lieux-depart-national'),
    fetch('/api/lieux-arrive-national')
])
```

### 3. Routes ajoutées
```php
// Dans routes/web.php - Groupe API
Route::get('lieux-depart-national', [LieuController::class, 'getLieuxDepartNational']);
Route::get('lieux-arrive-national', [LieuController::class, 'getLieuxArriveNational']);
Route::get('lieux-depart-sousregion', [LieuController::class, 'getLieuxDepartSousRegion']);
Route::get('lieux-arrive-sousregion', [LieuController::class, 'getLieuxArriveSousRegion']);
Route::get('lieux-by-type/{typeDestination}', [LieuController::class, 'getLieuxByTypeDestination']);
```

## Avantages des nouvelles méthodes

1. **Performance améliorée**: Filtrage direct en base de données
2. **Séparation claire**: Distinction entre destinations nationales et sous-régionales
3. **Flexibilité**: API combinée disponible pour les cas d'usage complexes
4. **Maintenance**: Code plus lisible et maintenable
5. **Évolutivité**: Facilite l'ajout de nouveaux types de destinations

## Test des API

Un fichier de test HTML (`test_lieux_api.html`) a été créé pour tester toutes les nouvelles API. Ouvrez ce fichier dans un navigateur après avoir démarré le serveur Laravel pour tester les endpoints.

## Migration

Pour appliquer les améliorations de la base de données :

```bash
php artisan migrate:refresh
# ou si la table existe déjà
php artisan migrate:rollback --step=1
php artisan migrate
```

## Compatibilité

Les anciennes API restent fonctionnelles :
- `GET /api/gares-lieux` continue de fonctionner
- Aucune rupture de compatibilité avec l'existant