<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RecipeController extends AbstractController
{
#[Route('/recipe/{id}', name: 'recipe_show')]
public function show(string $id, HttpClientInterface $httpClient): Response
{
$response = $httpClient->request('GET', "https://www.themealdb.com/api/json/v1/1/lookup.php?i=$id");
$data = $response->toArray();

if (!$data['meals']) {
throw $this->createNotFoundException('La recette n\'existe pas.');
}

$meal = $data['meals'][0];

// On nettoie les ingrédients pour les mettre dans un tableau propre
$ingredients = [];
for ($i = 1; $i <= 20; $i++) {
if (!empty($meal["strIngredient$i"])) {
$ingredients[] = [
'name' => $meal["strIngredient$i"],
'measure' => $meal["strMeasure$i"]
];
}
}

return $this->render('recipe/show.html.twig', [
'meal' => $meal,
'ingredients' => $ingredients
]);
}
}