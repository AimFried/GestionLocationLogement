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

    #[Route('/calendrier', name: 'calendrier')]
    public function calendrier(LOGEMENTRepository $logementRepository, calendarRepository $calendar): Response
    {
        $logements = $logementRepository->findAll();
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

    #[Route('/calendrier/event/{id}', name: 'event_update', methods:"PUT")]
    public function majEvent(?calendarRepository $calendar, Request $request): Response
    {
       
        // On récupére les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)

        ){
            //Les données sont complètes
            //On initialise un code
            $code = 200;
            
            //On vérifie si l'id existe
            if(!$calendar){
                //On instancie un rendez-vous
                $calendar = new Calendar;
                //On change le code
                $code = 201;
            }
                //On hydrate l'objet avec les données
                $calendar->setTitle($donnees->title);
                $calendar->setDescription($donnees->description);
                $calendar->setStart(new DateTime($donnees->start));
                if($donnees->allDay)
                {
                    $calendar->setEnd(new DateTimeType($donnees->end));
                }
                $calendar->setAllDay($donnees->allDay);
                $calendar->setBackgroundColor($donnees->backgroundColor);
                $calendar->setBorderColor($donnees->borderColor);
                $calendar->setTextColor($donnees->textColor);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($calendar);
                $em->flush();
                
                //On retourne le code
                return new Response('OK',$code);
          

        }
        else{
            //Les données sont imcomplètes
            return new Response('Données imcomplètes', 404);
        }
    }
}
