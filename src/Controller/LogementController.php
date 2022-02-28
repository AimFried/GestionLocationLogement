<?php

namespace App\Controller;

use App\Entity\LOGEMENT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\LogementType;
use App\Repository\RESERVATIONRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\LOGEMENTRepository;

class LogementController extends AbstractController
{
    #[Route('/logement', name: 'logement')]
    public function listeLogements(RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository, LOGEMENTRepository $logementRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        $locataires = $locataireRepository->findAll();
        $logements = $logementRepository->findAll();

        //Définit l'état de chaque logements en fonction de la date actuelle
        $dateToday = new \DateTime("now");
        foreach ($logements as $logement) 
        {
            $trouve = false;
            foreach ($reservations as $reservation) 
            {
                if($reservation->getLogements() == $logement)
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

        return $this->render('logement/listeLogements.html.twig', [
            'reservations' => $reservations,'locataires' => $locataires,'logements' =>$logements
        ]);
    }

    #[Route('/logement/profile/{id}', name: 'logement_profile')]
    public function profile(RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository, LOGEMENTRepository $logementRepository,$id): Response
    {
        $reservations = $reservationRepository->find($id);
        $locataires = $locataireRepository->find($id);
        $logements = $logementRepository->find($id);

        //Définit l'état de chaque logements en fonction de la date actuelle
        $dateToday = new \DateTime("now");
        foreach ($logements as $logement) 
        {
            $trouve = false;
            foreach ($reservations as $reservation) 
            {
                if($reservation->getLogements() == $logement)
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

        return $this->render('logement/profileLogement.html.twig', [
            'reservations' => $reservations,'locataires' => $locataires,'logements' =>$logements
        ]);
    }

    #[Route('/logement/ajouter', name: 'logement_ajouter')]
    public function ajouter(Request $request,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $logement = new LOGEMENT();

        $form = $this->createForm(LogementType::class, $logement);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($logement);
                $entityManager->flush();
               
                return $this->redirectToRoute('logement');
            }
        return $this->render('Logement/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/logement/modifier/{id}', name: 'logement_modifier')]
    public function modifier(Request $request,ManagerRegistry $doctrine, LOGEMENT $logement, RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository, LOGEMENTRepository $logementRepository,$id): Response
    {
        $reservations = $reservationRepository->find($id);
        $locataires = $locataireRepository->find($id);
        $logements = $logementRepository->find($id);
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(LogementType::class, $logement);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($logement);
                $entityManager->flush();
               
                return $this->redirectToRoute('logement');
            }
        return $this->render('Logement/modifier.html.twig', [
            'form' => $form->createView(),'reservations' => $reservations,'locataires' => $locataires,'logements' =>$logements,
        ]);
    }

    #[Route('/logement/supprimer/{id}', name: 'logement_supprimer')]
    public function supprimer(Request $request,ManagerRegistry $doctrine,LOGEMENT $logement, RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository, LOGEMENTRepository $logementRepository,$id): Response
    {
        $reservations = $reservationRepository->find($id);
        $locataires = $locataireRepository->find($id);
        $logements = $logementRepository->find($id);

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(LogementType::class, $logement);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->remove($logement);
                $entityManager->flush();
               
                return $this->redirectToRoute('logement');
            }
        return $this->render('Logement/supprimer.html.twig', [
            'form' => $form->createView(),'reservations' => $reservations,'locataires' => $locataires,'logements' =>$logements,
        ]);
    }
}
