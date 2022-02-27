<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RESERVATIONRepository;
use App\Form\ReservationType;
use App\Entity\RESERVATION;
use App\Entity\Calendar;


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
               
                $event = new Calendar();
                
                $event->setTitle($reservation->getLocataires()->getNom());
                $event->setStart($reservation->getDateDebut());
                $event->setEnd($reservation->getDateFin());
                $event->setDescription($form['Description']->getData());
                $event->setBackgroundColor($form['CouleurFond']->getData());
                $event->setBorderColor($form['CouleurBordure']->getData());
                $event->setTextColor($form['CouleurTexte']->getData());
                $event->setAllday("0");
                
                $reservation->setCalendrier($event);

                $entityManager->persist($event);
                $entityManager->persist($reservation);
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
        
        //Initialisation des champs non mappé
        $event_temp = $reservation->getCalendrier();
        $form['Description']->setData($event_temp->getDescription());
        $form['CouleurFond']->setData($event_temp->getBackgroundColor());
        $form['CouleurBordure']->setData($event_temp->getBorderColor());
        $form['CouleurTexte']->setData($event_temp->getTextColor());

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                
                $event = $reservation->getCalendrier();

                $event->setTitle($reservation->getLocataires()->getNom());
                $event->setStart($reservation->getDateDebut());
                $event->setEnd($reservation->getDateFin());
                $event->setDescription($form['Description']->getData());
                $event->setBackgroundColor($form['CouleurFond']->getData());
                $event->setBorderColor($form['CouleurBordure']->getData());
                $event->setTextColor($form['CouleurTexte']->getData());
                $event->setAllday("0");
                
                $reservation->setCalendrier($event);

                $entityManager->persist($event);
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

        //Initialisation des champs non mappé
        $event_temp = $reservation->getCalendrier();
        $form['Description']->setData($event_temp->getDescription());
        $form['CouleurFond']->setData($event_temp->getBackgroundColor());
        $form['CouleurBordure']->setData($event_temp->getBorderColor());
        $form['CouleurTexte']->setData($event_temp->getTextColor());

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                              
                $entityManager->remove($reservation->getCalendrier());
                $entityManager->remove($reservation);
                $entityManager->flush();
               
                return $this->redirectToRoute('reservation');
            }
        return $this->render('Reservation/supprimer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
