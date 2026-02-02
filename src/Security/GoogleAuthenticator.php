<?php

namespace App\Security;

use App\Entity\User; // Votre entité User
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleAuthenticator extends OAuth2Authenticator
{
public function __construct(
private ClientRegistry $clientRegistry,
private EntityManagerInterface $entityManager,
private RouterInterface $router
) {}

public function supports(Request $request): ?bool
{
// L'authenticator se déclenche uniquement sur cette route
return $request->attributes->get('_route') === 'connect_google_check';
}

public function authenticate(Request $request): Passport
{
$client = $this->clientRegistry->getClient('google');
$accessToken = $this->fetchAccessToken($client);

return new SelfValidatingPassport(
new UserBadge($accessToken->getToken(), function() use ($accessToken, $client) {
/** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
$googleUser = $client->fetchUserFromToken($accessToken);

$email = $googleUser->getEmail();

// 1. Chercher si l'utilisateur existe déjà
$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

// 2. Si l'utilisateur existe, on le retourne
if ($user) {
return $user;
}

// 3. Sinon, on crée un nouvel utilisateur (Inscription automatique)
$user = new User();
$user->setEmail($email);
// Vous pouvez définir un mot de passe aléatoire ou vide selon votre logique
// $user->setPassword('...');
$user->setRoles(['ROLE_USER']);
// $user->setGoogleId($googleUser->getId()); // Optionnel : stocker l'ID Google

$this->entityManager->persist($user);
$this->entityManager->flush();

return $user;
})
);
}

public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
{
// Redirection après succès (ex: tableau de bord)
return new RedirectResponse($this->router->generate('foods_list'));
}

public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
{
// Gestion des erreurs
$message = strtr($exception->getMessageKey(), $exception->getMessageData());
return new Response($message, Response::HTTP_FORBIDDEN);
}
}