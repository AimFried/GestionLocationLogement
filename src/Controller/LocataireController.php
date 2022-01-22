<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LOCATAIRE;
use App\Repository\CalendarRepository;
use App\Repository\LOGEMENTRepository;
use App\Repository\LOCATAIRERepository;
use App\Repository\RESERVATIONRepository;

class LocataireController extends AbstractController
{
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

    #[Route('/locataire/{id}', name: 'locataire_delete', methods: ['POST'])]
    public function delete(Request $request, LOCATAIRE $unLocataire, EntityManagerInterface $entityManager): Response
    {
            $entityManager->remove($unLocataires);
            $entityManager->flush();

        return $this->redirectToRoute('/locataire', [], Response::HTTP_SEE_OTHER);
    }
}
