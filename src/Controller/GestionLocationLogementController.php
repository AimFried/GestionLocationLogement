<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionLocationLogementController extends AbstractController
{
    #[Route('/', name: 'authentification')]
    public function authentification(): Response
    {
        return $this->render('gestion_location_logement/authentification.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }

    #[Route('/calendrier', name: 'calendrier')]
    public function calendrier(): Response
    {
        return $this->render('gestion_location_logement/calendrier.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }

    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('gestion_location_logement/reservation.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }

    #[Route('/logement', name: 'liste_logements')]
    public function listeLogement(): Response
    {
        return $this->render('gestion_location_logement/listeLogements.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }

    #[Route('/locataire', name: 'liste_locataires')]
    public function listeLocataire(): Response
    {
        return $this->render('gestion_location_logement/listeLocataires.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(): Response
    {
        return $this->render('gestion_location_logement/historique.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }
}
