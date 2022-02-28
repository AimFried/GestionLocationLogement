<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RESERVATIONRepository;
use App\Form\ReservationType;
use App\Entity\RESERVATION;
use App\Entity\Calendar;
use DateTime;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function reservation(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        $dateToday = new \DateTime("now");
        
        return $this->render('reservation/reservation.html.twig', [
            'reservations' => $reservations, 'dateToday' => $dateToday
        ]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(RESERVATIONRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        $dateToday = new \DateTime("now");
        
        return $this->render('reservation/historique.html.twig', [
            'reservations' => $reservations, 'dateToday' => $dateToday
        ]);
    }

    #[Route('/historique/profile/{id}', name: 'historique_profile')]
    public function profileHistorique(RESERVATIONRepository $reservationRepository, $id): Response
    {
        $reservations = $reservationRepository->find($id);
        
        return $this->render('reservation/profileHistorique.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/reservation/profile/{id}', name: 'reservation_profile')]
    public function profileReservation(RESERVATIONRepository $reservationRepository, $id): Response
    {
        $reservations = $reservationRepository->find($id);
        
        return $this->render('reservation/profileReservation.html.twig', [
            'reservations' => $reservations
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
                
                //Données calendrier
                $event->setTitle($reservation->getLocataires()->getNom());
                $event->setStart($reservation->getDateDebut());
                $event->setEnd($reservation->getDateFin());
                $event->setDescription($form['Description']->getData());
                $event->setBackgroundColor($form['CouleurFond']->getData());
                $event->setBorderColor($form['CouleurBordure']->getData());
                $event->setTextColor($form['CouleurTexte']->getData());
                $event->setAllday("0");

                //Données reservation
                $reservation->setCalendrier($event);
                $reservation->setTaxeVariable($form['TaxeVariable']->getData());
                $reservation->setDescription($form['Description']->getData());
                
                //Calcule le nombres de jours en fonction de deux dates
                $firstDate  = $reservation->getDateDebut();
                $secondDate = $reservation->getDateFin();
                $intvl = $firstDate->diff($secondDate);
                $reservation->setNbrJours($intvl->days);
                
                //Calcule Prix taxe
                $nbrAdulte = $reservation->getNbrAdulte();
                $nbrNuit = $reservation->getNbrJours();
                $taxeVariable = $reservation->getTaxeVariable(); //2 étoiles classement

                $ValeurTaxe = $nbrAdulte * $nbrNuit * $taxeVariable;
                $reservation->setValeurTaxe($ValeurTaxe);
                $prixTotal = $ValeurTaxe + $reservation->getNbrJours() * $reservation->getPrixNuit();


                $reservation->setPrixTotal($prixTotal);

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
                
                //Données calendrier
                $event = $reservation->getCalendrier();
                $event->setTitle($reservation->getLocataires()->getNom());
                $event->setStart($reservation->getDateDebut());
                $event->setEnd($reservation->getDateFin());
                $event->setDescription($form['Description']->getData());
                $event->setBackgroundColor($form['CouleurFond']->getData());
                $event->setBorderColor($form['CouleurBordure']->getData());
                $event->setTextColor($form['CouleurTexte']->getData());
                $event->setAllday("0");
                
                //Données reservation
                $reservation->setCalendrier($event);
                $reservation->setTaxeVariable($form['TaxeVariable']->getData());

                //Calcule le nombres de jours en fonction de deux dates
                $firstDate  = $reservation->getDateDebut();
                $secondDate = $reservation->getDateFin();
                $intvl = $firstDate->diff($secondDate);

                $reservation->setNbrJours($intvl->days);

                
                //Calcule le nombres de jours en fonction de deux dates
                $firstDate  = $reservation->getDateDebut();
                $secondDate = $reservation->getDateFin();
                $intvl = $firstDate->diff($secondDate);
                $reservation->setNbrJours($intvl->days);
                
                //Calcule Prix taxe
                $nbrAdulte = $reservation->getNbrAdulte();
                $nbrNuit = $reservation->getNbrJours();
                $taxeVariable = $reservation->getTaxeVariable(); //2 étoiles classement

                $ValeurTaxe = $nbrAdulte * $nbrNuit * $taxeVariable;
                $reservation->setValeurTaxe($ValeurTaxe);
                $prixTotal = $ValeurTaxe + $reservation->getNbrJours() * $reservation->getPrixNuit();

                $reservation->setPrixTotal($prixTotal);

                $reservation->setDescription($form['Description']->getData());
                

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
