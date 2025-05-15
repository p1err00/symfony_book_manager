<?php

declare(strict_types=1);

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController extends AbstractController
{   

    public const SCOPS = [
        'google' => ['https://www.googleapis.com/auth/books']
    ];

    /**
     * @Route("/login", name="auth_oauth_login", methods={"GET"})
     */
    public function login () : Response {
        
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('home');
        // }

        return $this->render("security/index.html.twig");

    }
/**
     * @Route("/login", name="auth_oauth_logout", methods={"GET"})
     */
    public function logout () : Response {
        throw new \Exception("Dont forget to activate logout in security.yaml");
    }

    /**
     * @Route("/connect/{service}/connect", name="auth_oauth_connect", methods={"GET"})
     */
    public function connect(string $service, ClientRegistry $registry): RedirectResponse {
        if (! in_array($service, array_keys(self::SCOPS), true)) {
            throw $this->createNotFoundException();
        }
        return $registry->getClient($service)->redirect(self::SCOPS[$service]);
    }
    
    /**
     * @Route("/connect/{service}/check", name="connect_google_check", methods={"GET", "POST"})
     */
    public function check (Request $request): RedirectResponse {
        $registry->getClient('google')->redirect('/home');

        return new RedirectResponse('/home');
    }
}
