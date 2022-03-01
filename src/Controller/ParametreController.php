<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class ParametreController extends AbstractController
{
    #[Route('/parametres', name: 'parametres')]
    public function parametre(UserRepository $userRepository): Response
    {
        $utilisateurs = $userRepository->findAll();

        return $this->render('Parametres/parametres.html.twig',[
           'utilisateurs' => $utilisateurs,  
        ]);
    }
}
