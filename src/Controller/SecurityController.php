<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordHasherAdapter;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class SecurityController extends AbstractController
{   

    public const SCOPS = [
        'google' => []
    ];

    /**
     * @Route("/login", name="auth_oauth_login", methods={"GET", "POST"})
     */
    public function login (Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator) : Response {

        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $plainPassword = $form->get('password')->getData();
        
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            
            if (!$user) {
                return new RedirectResponse('/register');
            }

            if (!$userPasswordHasher->isPasswordValid($user, $plainPassword)) {
                return new RedirectResponse('/login?error=invalid_credentials');
            }
            $userAuthenticator->authenticateUser(
                $user,
                null,
                $request
            );
            return new RedirectResponse('/home');
        }
        
        return $this->render("security/index.html.twig", [
            'form' => $form->createView(),
        ]);
    }
/**
     * @Route("/logout", name="auth_oauth_logout", methods={"GET"})
     */
    public function logout () : Response {
        throw new \Exception("Dont forget to activate logout in security.yaml");
    }

    /**
     * @Route("/connect/{service}/connect", name="auth_oauth_connect", methods={"GET", "POST"})
     */
    public function connect(string $service, ClientRegistry $registry, EntityManagerInterface $em): RedirectResponse {
        if (! in_array($service, array_keys(self::SCOPS), true)) {
            throw $this->createNotFoundException();
        }
        return $registry->getClient($service)->redirect(self::SCOPS[$service]);
    }
}
