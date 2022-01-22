<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;

class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'historique')]
    public function historique(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('gestion_location_logement/historique.html.twig', 
        ['reservations' => $reservations,]);
    }
}
