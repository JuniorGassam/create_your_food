<?php
/*
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FoodController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/foods', name: 'foods_list')]
    public function index(): Response
    {
        // --- THEMEALDB ---
        $mealResponse = $this->httpClient->request('GET', 'https://www.themealdb.com/api/json/v1/1/search.php?s=tomato');
        $mealData = $mealResponse->toArray()['meals'] ?? [];

        // --- OPENFOODFACTS ---
        $foodResponse = $this->httpClient->request('GET', 'https://world.openfoodfacts.org/api/v0/product/737628064502.json');
        $foodData = $foodResponse->toArray() ?? [];

        return $this->render('food/index.html.twig', [
            'meals' => $mealData,
            'food' => $foodData,
        ]);
    }
}*/


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FoodController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/foods', name: 'foods_list')]
    public function index(Request $request): Response
    {
        // Récupère la requête de recherche de l'URL (?search=...)
        // Définit 'chicken' comme recherche par défaut si rien n'est fourni.
        $searchQuery = $request->query->get('search', 'fish');

        // Nettoyage de la requête pour l'URL
        $encodedQuery = urlencode($searchQuery);

        // --- THEMEALDB : Recherche dynamique ---
        $mealApiUrl = 'https://www.themealdb.com/api/json/v1/1/search.php?s=' . $encodedQuery;

        try {
            $mealResponse = $this->httpClient->request('GET', $mealApiUrl);
            $mealData = $mealResponse->toArray()['meals'] ?? [];
        } catch (\Exception $e) {
            // En cas d'erreur de l'API ou HTTP, on retourne un tableau vide pour éviter une erreur
            $mealData = [];
            error_log('TheMealDB API Error: ' . $e->getMessage());
        }


        // --- OPENFOODFACTS : Reste statique pour l'exemple de détail ---
        $foodResponse = $this->httpClient->request('GET', 'https://world.openfoodfacts.org/api/v0/product/737628064502.json');
        $foodData = $foodResponse->toArray() ?? [];

        return $this->render('food/index.html.twig', [
            'meals' => $mealData,
            'food' => $foodData,
            'currentSearch' => $searchQuery, // On passe le terme de recherche au template
        ]);
    }
}

