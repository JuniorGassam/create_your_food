<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatController extends AbstractController
{
    #[Route('/nutrition/{id}', name: 'recipe_nutrition', methods: ['POST', 'GET'])]
    public function index(string $id, HttpClientInterface $httpClient): Response
    {
        $mealResponse = $httpClient->request('GET', "https://www.themealdb.com/api/json/v1/1/lookup.php?i=$id");
        $mealData = $mealResponse->toArray()['meals'][0];

        // Données par défaut pour éviter les erreurs Twig si l'analyse échoue
        $nutritionData = ['calories' => 'Analyse IA', 'totalNutrients' => []];

        return $this->render('nutrition/show.html.twig', [
            'meal' => $mealData,
            'nutrition' => $nutritionData
        ]);
    }

    #[Route('/chat/ask', name: 'chat_ask', methods: ['POST'])]
    public function ask(Request $request, HttpClientInterface $httpClient): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userMessage = $data['message'] ?? '';
        $mealName = $data['mealName'] ?? 'ce plat';

        try {
            $response = $httpClient->request('POST', 'https://api.mistral.ai/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['MISTRAL_KEY'],
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'mistral-tiny', // Modèle rapide et économique
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "Tu es un nutritionniste expert. Tu aides l'utilisateur à comprendre les bienfaits et calories du plat : $mealName. Réponds de manière amicale, précise et en français."
                        ],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                ],
            ]);

            $result = $response->toArray();
            $reply = $result['choices'][0]['message']['content'];

            return new JsonResponse(['response' => $reply]);

        } catch (\Exception $e) {
            return new JsonResponse(['response' => "Désolé, je n'arrive pas à me connecter à Mistral AI. Vérifiez votre clé API."], 500);
        }
    }
}