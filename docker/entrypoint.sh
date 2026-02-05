#!/bin/bash

# Arrêter si une erreur se produit
set -e

echo "🚀 Démarrage de l'application..."

# 1. Installer les dépendances Composer si nécessaire
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installation des dépendances Composer..."
    composer install --no-interaction --optimize-autoloader
fi

# 2. Exécuter les migrations Doctrine
echo "🗄️ Exécution des migrations Doctrine..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "✅ Démarrage du serveur PHP-FPM..."
# Lancer PHP-FPM en tant que processus principal
php-fpm
