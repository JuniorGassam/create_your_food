<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupère l'erreur de connexion si elle existe
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupère le dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * Cette route est gérée par le pare-feu Symfony (firewall).
     * Il n'y a pas besoin d'implémentation de code ici.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->render('security/login.html.twig', [
        ]);
    }

    /**
     * Route pour initier la connexion avec Google
     */
    #[Route('/connect/google', name: 'connect_google')]
    public function connectGoogle(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect(
                ['email', 'profile'], // Les scopes que vous demandez à Google
                []
            );
    }

    /**
     * Route de callback Google (gérée par GoogleAuthenticator)
     */
    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectGoogleCheck(): Response
    {
        // Si vous arrivez ici, vous êtes authentifié!
        return $this->redirectToRoute('foods_list');
    }
}
