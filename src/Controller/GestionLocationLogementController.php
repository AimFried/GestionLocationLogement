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
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class GestionLocationLogementController extends AbstractController
{
    #[Route('/', name: 'authentification')]
    public function authentification(): Response
    {
        return $this->render('gestion_location_logement/authentification.html.twig',[
            
        ]);
    }

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
            ];
            }
        }
        //Encodage du tableau pour FullCalendar
        $data = json_encode($rdvs);


        return $this->render('gestion_location_logement/calendrierLogement.html.twig', compact('data','logements','logement'));
    }
}
