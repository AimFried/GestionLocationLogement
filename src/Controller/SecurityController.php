<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="connexion")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository, ManagerRegistry $doctrine): Response
    {
        if ($this->getUser()) 
        {
            return $this->redirectToRoute('calendrier');
        }

        $users = $userRepository->findAll();
        $entityManager = $doctrine->getManager();

        $existe = false;
        foreach ($users as $utilisateur) 
        {
            if ($utilisateur->getEmail() == "admin@gmail.com") 
            {
               $existe = true;
            }
        }

        if ($existe == false) 
        {
            //Utilisateur par default
            $user = new User();

            $user->setEmail("admin@gmail.com");//Mail : admin@gmail.com
            $user->setPassword("$2y$13$0rdZ4JD/BBs4x0un.kHQ3OEPf0lSnRQAPYFJcbT5IjrbeQKe6ktRO");//Mots de passe : adminadmin


            $entityManager->persist($user);
            $entityManager->flush();
        }
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logout(): void
    {
        
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        
    }
}
