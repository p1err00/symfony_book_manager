<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\RegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

abstract class AbstractOAuthAuthenticator extends OAuth2Authenticator
{

    use TargetPathTrait;
    protected $serviceName = '';
    public function __construct(
        ClientRegistry $clientRegistry,
        UserRepository $repository,
        EntityManagerInterface $em,
        RegistrationService $registrationService,
        RouterInterface $router,
        RequestStack $requestStack
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->repository = $repository;
        $this->registrationService = $registrationService;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {

        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);

        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse('/home');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse($this->router->generate('auth_oauth_login'));
    }


    public function authenticate(Request $request): SelfValidatingPassport
    {
        // 1. Récupérer le token d'accès Google via ta méthode (ex: fetchAccessToken)
        $credentials = $this->fetchAccessToken($this->getClients());
        $accessToken = $credentials->getToken();

        // 2. Récupérer les infos utilisateur Google
        $resourceOwner = $this->getRessourceOwnerFromCredentials($credentials);
        // 3. Chercher l'utilisateur en base via google_id ou email
        $user = $this->getUserFromResourceOwner($resourceOwner, $this->repository);

        // 4. Si l'utilisateur n'existe pas, le créer et persister (registrationService à créer)
        if (null === $user) {
            $user = $this->registrationService->persist($resourceOwner);
        }

        // 5. Mettre à jour le token et sa date d'expiration dans l'entité User
        $user->setGoogleAccessToken($accessToken);
        $expiresInSeconds = $credentials->getExpires() ?: 3600; // fallback 1h
        $user->setGoogleTokenExpiresAt((new \DateTime())->add(new \DateInterval('PT' . $expiresInSeconds . 'S')));

        // 6. Sauvegarder les modifications en base
        $this->em->persist($user);
        $this->em->flush();

        // 7. Stocker token dans la session (optionnel)
        $session = $this->requestStack->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }
        $session->set('google_access_token', $accessToken);
        $session->save();

        // 8. Retourner le Passport avec UserBadge
        return new SelfValidatingPassport(
            new UserBadge($user->getUserIdentifier()),
            [new RememberMeBadge()]
        );
    }

    private function getClients(): OAuth2Client
    {

        return $this->clientRegistry->getClient($this->serviceName);
    }

    protected function getRessourceOwnerFromCredentials(AccessToken $credentials): GoogleUser
    {
        return $this->getClients()->fetchUserFromToken($credentials);
    }

    abstract protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User;

}
