<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LOCATAIRE;
use App\Entity\RESERVATION;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;

class LocataireController extends AbstractController
{
    #[Route('/locataire', name: 'liste_locataires', methods: ['GET'])]
    public function listeLocataire(LOCATAIRERepository $locataireRepository,RESERVATIONRepository $reservationRepository): Response
    {
        $locataires = $locataireRepository->findAll();
        $reservations = $reservationRepository->findAll();

        return $this->render('Locataire/listeLocataires.html.twig', 
        ['locataires' => $locataires,'reservations' => $reservations,]);
    }

    #[Route('/locataire/profile/{id}', name: 'profile_locataire')]
    public function profileLocataire(LOCATAIRERepository $locataireRepository,$id): Response
    {
        $locataires = $locataireRepository->find($id);
    
        return $this->render('Locataire/profileLocataire.html.twig', 
        ['locataires' => $locataires,]);
    }

    #[Route('/locataire/{id}', name: 'locataire_delete', methods: ['GET', 'POST'])]
    public function delete(LOCATAIRERepository $locataireRepository,RESERVATION $reservation, EntityManagerInterface $entityManager, $id): Response
    {
            $locataires = $locataireRepository->find($id);
            $locataires->removeReservation($reservation);
            $entityManager->remove($locataires);

            $entityManager->flush();

            $locataires = $locataireRepository->findAll();

        return $this->redirectToRoute('liste_locataires', ['locataires' => $locataires,], Response::HTTP_SEE_OTHER);
    }
}
