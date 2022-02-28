<?php

namespace App\Controller;

use App\Entity\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LOGEMENT;
use App\Entity\LOCATAIRE;
use App\Entity\RESERVATION;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

class GestionLocationLogementController extends AbstractController
{
    #[Route('/calendrier/tous', name: 'calendrier')]
    public function calendrier(RESERVATIONRepository $reservationRepository,LOGEMENTRepository $logementRepository ,calendarRepository $calendar): Response
    {
        $logements = $logementRepository->findAll();
        $reservations = $reservationRepository->findAll();
        $events = $calendar->findAll();

        //Création d'un tableau pour rendre compatible les valeurs des dates
        $rdvs = [];
        foreach($events as $event)
        {  
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllday(),
                'description' => $event->getDescription()
            ];
        }
        //Encodage du tableau pour FullCalendar
        $data = json_encode($rdvs);


        return $this->render('gestion_location_logement/calendrier.html.twig', compact('data','logements'));
    }

    #[Route('/calendrier/logement/{id}', name: 'calendrier_logement')]
    public function calendrierLogement(LOGEMENTRepository $logementRepository,RESERVATIONRepository $reservationRepository, calendarRepository $calendar, $id): Response
    {
        $logements = $logementRepository->findAll();
        $logement = $logementRepository->find($id);
        $reservations = $reservationRepository->findAll();

        //Définit l'état de chaque logements en fonction de la date actuelle
        $dateToday = new \DateTime("now");
        foreach ($logements as $loge) 
        {
            $trouve = false;
            foreach ($reservations as $reservation) 
            {
                if($reservation->getLogements() == $loge)
                {
                    if (($dateToday > $reservation->getDateDebut())&($dateToday < $reservation->getDateFin())) 
                    {
                        $logement->setEtat("0");
                        $trouve = true;
                    }    
                }
            } 
            if($trouve == false)
            {
                $logement->setEtat("1");
            }   
        }

        $rdvs = [];

        foreach ($reservations as $reservation) 
        {
            if($reservation->Logements->getId() == $id)
            {
                $idEvent = $reservation->Calendrier->getId();
                $event = $calendar->find($idEvent);
                
                $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllday(),
                'description' => $event->getDescription()
            ];
            }
        }
        //Encodage du tableau pour FullCalendar
        $data = json_encode($rdvs);


        return $this->render('gestion_location_logement/calendrierLogement.html.twig', compact('data','logements','logement'));
    }

    /**
     * @Route("/calendrier/modifier/{id}", name="calendrier_modifier", methods={"PUT"})
     */
    #[Route('/calendrier/modifier/{id}', name: 'calendrier_modifier')]
    public function majEvent(?Calendar $calendar, Request $request, ManagerRegistry $doctrine, RESERVATIONRepository $reservationRepository,$id)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());
        $reservations = $reservationRepository->findAll();

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Calendar;

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            $calendar->setEnd(new DateTime($donnees->end));
            $calendar->setAllDay($donnees->allDay);
            $calendar->setBackgroundColor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextColor($donnees->textColor);

            //Mise à jour des dates dans la table de réservation
            foreach ($reservations as $reservation)
            {
                if($reservation->Calendrier->getId() == $id)
                {
                    $reservation->setDateDebut(new DateTime($donnees->start));
                    $reservation->setDateFin(new DateTime($donnees->end));
                }
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->persist($calendar);
            $entityManager->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }


        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
