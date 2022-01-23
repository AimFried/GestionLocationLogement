<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;

class LogementController extends AbstractController
{
    #[Route('/logement', name: 'liste_logements')]
    public function listeLogement(LOGEMENTRepository $logementRepository): Response
    {
        $logements = $logementRepository->findAll();

        return $this->render('Logement/listeLogements.html.twig', 
        ['logements' => $logements,]);
    }
    
    #[Route('/logement/{id}', name: 'profile_logement')]
    public function profileLogement(LOGEMENTRepository $logementRepository,$id): Response
    {
        $logements = $logementRepository->find($id);
        

        return $this->render('Logement/profileLogement.html.twig', 
        ['logements' => $logements,]);
    }
}
