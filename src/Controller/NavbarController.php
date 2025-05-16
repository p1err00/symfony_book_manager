<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    /**
     * @Route("/navbar", name="app_navbar")
     */
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();

        return $this->render('navbar/index.html.twig', [
            'user' => $user,
        ]);
    }
}
