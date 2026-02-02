<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
#[Route('/connect/google', name: 'connect_google_start')]
public function connectAction(ClientRegistry $clientRegistry): Response
{
// Redirige vers Google
return $clientRegistry
->getClient('google') // La clé définie dans knpu_oauth2_client.yaml
->redirect([
'email', 'profile' // Les scopes demandés
]);
}

#[Route('/connect/google/check', name: 'connect_google_check')]
public function connectCheckAction(): Response
{
// Laissez cette méthode vide.
// L'Authenticator (étape suivante) interceptera cette route.
return new Response();
}
}