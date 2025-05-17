<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[isGranted("ROLE_USER")]
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(RequestStack $requestStack, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
