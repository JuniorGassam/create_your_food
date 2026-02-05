<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FridgeController extends AbstractController
{
    #[Route('/mon-frigo', name: 'app_fridge')]
    public function index(): Response
    {
        return $this->render('fridge/index.html.twig');
    }

    #[Route('/fridge/search', name: 'app_fridge_search', methods: ['POST'])]
    public function search(Request $request, HttpClientInterface $httpClient): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $ingredients = $data['ingredients'] ?? [];

        if (count($ingredients) === 0) {
            return new JsonResponse(['meals' => []]);
        }

        $allResults = [];

        // 1. Récupérer les listes de recettes pour chaque ingrédient
        foreach ($ingredients as $ingredient) {
            $response = $httpClient->request('GET', "https://www.themealdb.com/api/json/v1/1/filter.php?i=" . urlencode($ingredient));
            $meals = $response->toArray()['meals'] ?? [];

            // On stocke les IDs des recettes trouvées pour cet ingrédient
            $allResults[] = array_column($meals, 'idMeal');
        }

        // 2. Trouver l'intersection (les IDs présents dans TOUTES les listes)
        $commonIds = count($allResults) > 1
            ? array_intersect(...$allResults)
            : ($allResults[0] ?? []);

        if (empty($commonIds)) {
            return new JsonResponse(['meals' => [], 'message' => 'Aucun plat ne contient tous ces ingrédients ensemble.']);
        }

        // 3. Récupérer les détails des plats communs (nom et image)
        // Note: L'API de filtrage précédente nous donne déjà les noms et images
        // On va donc faire une dernière requête pour récupérer les infos complètes des 6 premiers
        $finalMeals = [];
        $count = 0;
        foreach ($commonIds as $id) {
            if ($count >= 6) break;
            $res = $httpClient->request('GET', "https://www.themealdb.com/api/json/v1/1/lookup.php?i=$id");
            $mealDetails = $res->toArray()['meals'][0] ?? null;
            if ($mealDetails) {
                $finalMeals[] = [
                    'idMeal' => $mealDetails['idMeal'],
                    'strMeal' => $mealDetails['strMeal'],
                    'strMealThumb' => $mealDetails['strMealThumb']
                ];
            }
            $count++;
        }

        return new JsonResponse(['meals' => $finalMeals]);
    }
}