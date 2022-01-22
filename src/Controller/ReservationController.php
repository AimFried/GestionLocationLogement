<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function reservation(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('gestion_location_logement/reservation.html.twig',
         ['reservations' => $reservations,]);
    }
}
