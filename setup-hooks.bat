@echo off
REM Setup des git hooks

echo Setting up pre-commit hooks...

REM Créer le répertoire hooks s'il n'existe pas
if not exist ".git\hooks" mkdir ".git\hooks"

REM Copier les hooks (le hook bash pour Git Bash, batch pour CMD)
echo Installing pre-commit hook...

REM Pour Git Bash (Unix style)
copy "hooks\pre-commit" ".git\hooks\pre-commit" >nul 2>&1

echo.
echo ✅ Git hooks configured!
echo.
echo 📝 Now when you commit:
echo    1. Code will be auto-fixed with php-cs-fixer
echo    2. Code will be analyzed with phpstan
echo    3. Commit will be blocked if errors found
echo.
echo 💡 To skip checks: git commit --no-verify
