@echo off
REM Script de démarrage automatisé pour le projet

echo.
echo ╔════════════════════════════════════════╗
echo ║  Create Your Food - Démarrage Rapide   ║
echo ╚════════════════════════════════════════╝
echo.

REM Vérifier que Docker est installé
docker --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker n'est pas installé ou pas accessible
    exit /b 1
)

echo 📥 Synchronisation du code...
git pull

if errorlevel 1 (
    echo ❌ Erreur lors du git pull
    exit /b 1
)

echo.
echo 🐳 Démarrage des containers Docker...
docker compose up -d --build

if errorlevel 1 (
    echo ❌ Erreur lors du démarrage de Docker
    exit /b 1
)

REM Attendre que les services soient prêts
echo.
echo ⏳ Attente du démarrage des services...
timeout /t 5 /nobreak

echo.
echo ✅ Démarrage terminé !
echo.
echo 🌐 Accédez à : http://localhost:8080
echo 📊 Admin BD : http://localhost:8081
echo.
echo 💡 Pour afficher les logs :
echo    docker compose logs -f
echo.
