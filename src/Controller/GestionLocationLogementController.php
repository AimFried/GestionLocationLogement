<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LOGEMENT;
use App\Entity\LOCATAIRE;
use App\Entity\RESERVATION;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;


class GestionLocationLogementController extends AbstractController
{
    #[Route('/', name: 'authentification')]
    public function authentification(): Response
    {
        return $this->render('gestion_location_logement/authentification.html.twig',[
            
        ]);
    }

    #[Route('/calendrier', name: 'calendrier')]
    public function calendrier(LOGEMENTRepository $logementRepository): Response
    {
        $logements = $logementRepository->findAll();

        return $this->render('gestion_location_logement/calendrier.html.twig', 
        ['logements' => $logements,]);
    }

    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('gestion_location_logement/reservation.html.twig', [
            'controller_name' => 'GestionLocationLogementController',
        ]);
    }

    #[Route('/logement', name: 'liste_logements')]
    public function listeLogement(LOGEMENTRepository $logementRepository): Response
    {
        $logements = $logementRepository->findAll();

        return $this->render('gestion_location_logement/listeLogements.html.twig', 
        ['logements' => $logements,]);
    }
    
    #[Route('/logement/{id}', name: 'profile_logement')]
    public function profileLogement(LOGEMENTRepository $logementRepository,$id): Response
    {
        $logements = $logementRepository->find($id);
        

        return $this->render('gestion_location_logement/profileLogement.html.twig', 
        ['logements' => $logements,]);
    }

    #[Route('/locataire', name: 'liste_locataires')]
    public function listeLocataire(LOCATAIRERepository $locataireRepository,RESERVATIONRepository $reservationRepository): Response
    {
        $locataires = $locataireRepository->findAll();
        $reservations = $reservationRepository->findAll();

        return $this->render('gestion_location_logement/listeLocataires.html.twig', 
        ['locataires' => $locataires,'reservations' => $reservations,]);
    }

    #[Route('/locataire/{id}', name: 'profile_locataire')]
    public function profileLocataire(LOCATAIRERepository $locataireRepository,$id): Response
    {
        $locataires = $locataireRepository->find($id);
        

        return $this->render('gestion_location_logement/profileLocataire.html.twig', 
        ['locataires' => $locataires,]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('gestion_location_logement/historique.html.twig', 
        ['reservations' => $reservations,]);
    }
}
