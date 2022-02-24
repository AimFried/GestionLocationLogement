<?php

namespace App\Controller;

use App\Entity\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RESERVATIONRepository;
use App\Form\ReservationType;
use App\Entity\RESERVATION;


class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function reservation(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        
        return $this->render('reservation/reservation.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        
        return $this->render('reservation/historique.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reservation/ajouter', name: 'reservation_ajouter')]
    public function ajouter(Request $request,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $reservation = new RESERVATION();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($reservation);
                $entityManager->flush();

                $event = new Calendar();

                $event->setTitle($reservation->getLocataires()->getNom());
                $event->setStart(new \DateTime($reservation->getDateDebut()));
                $event->setEnd(new \DateTime($reservation->getDateFin()));
                $event->setDescription("Location");
                $event->setBackgroundColor("blue");
                $event->setBorderColor("blue");
                $event->setTextColor("white");
                $event->setAllday("false");

                $entityManager->persist($event);
                $entityManager->flush();

               
                return $this->redirectToRoute('reservation');
            }
   
            return $this->render('Reservation/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/modifier/{id}', name: 'reservation_modifier')]
    public function modifier(Request $request,ManagerRegistry $doctrine, RESERVATION $reservation): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($reservation);
                $entityManager->flush();
               
                return $this->redirectToRoute('reservation');
            }
        return $this->render('Reservation/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/supprimer/{id}', name: 'reservation_supprimer')]
    public function supprimer(Request $request,ManagerRegistry $doctrine, RESERVATION $reservation): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->remove($reservation);
                $entityManager->flush();
               
                return $this->redirectToRoute('reservation');
            }
        return $this->render('Reservation/supprimer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
