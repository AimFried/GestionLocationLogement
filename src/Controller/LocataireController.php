<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RESERVATIONRepository;
use App\Repository\LOCATAIRERepository;
use App\Form\LocataireType;
use App\Entity\LOCATAIRE;

class LocataireController extends AbstractController
{
    #[Route('/locataire', name: 'locataire')]
    public function listeLocataire(RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository): Response
    {
        $reservations = $reservationRepository->findAll();
        $locataires = $locataireRepository->findAll();

        $dateToday = new \DateTime("now");

        return $this->render('locataire/listeLocataires.html.twig', [
            'reservations' => $reservations,'locataires' => $locataires,'dateToday' => $dateToday
        ]);
    }

    #[Route('/locataire/profile/{id}', name: 'locataire_profile')]
    public function profile(RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository, $id): Response
    {
        $reservation = $reservationRepository->find($id);
        $locataire = $locataireRepository->find($id);

        return $this->render('locataire/profileLocataire.html.twig', [
            'reservation' => $reservation,'locataire' => $locataire,
        ]);
    }

    #[Route('/locataire/ajouter', name: 'locataire_ajouter')]
    public function ajouter(Request $request,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $locataire = new LOCATAIRE();

        $form = $this->createForm(LocataireType::class, $locataire);

        

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                
                $locataire->setNom(strtoupper($locataire->getNom()));
                $locataire->setPrenom(strtolower($locataire->getPrenom()));
                $locataire->setPrenom(ucwords($locataire->getPrenom()));

                $entityManager->persist($locataire);
                $entityManager->flush();
               
                return $this->redirectToRoute('locataire');
            }

        return $this->render('locataire/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/locataire/modifier/{id}', name: 'locataire_modifier')]
    public function modifier(Request $request,ManagerRegistry $doctrine, LOCATAIRE $locataire, LOCATAIRERepository $locataireRepository,$id): Response
    {
        $locataire = $locataireRepository->find($id);
        $locataires = $locataireRepository->findAll();

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(LocataireType::class, $locataire);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                
                $locataire->setNom(strtoupper($locataire->getNom()));
                $locataire->setPrenom(strtolower($locataire->getPrenom()));
                $locataire->setPrenom(ucwords($locataire->getPrenom()));

                $entityManager->persist($locataire);
                $entityManager->flush();
               
                return $this->redirectToRoute('locataire');
            }

        return $this->render('locataire/modifier.html.twig', [
            'form' => $form->createView(), 'locataire' => $locataire, 'locataires' => $locataires
        ]);
    }

    #[Route('/locataire/supprimer/{id}', name: 'locataire_supprimer')]
    public function supprimer(LOCATAIRERepository $locataireRepository,Request $request,ManagerRegistry $doctrine, LOCATAIRE $locataire,$id): Response
    {
        $locataire = $locataireRepository->find($id);
    
        $entityManager = $doctrine->getManager();

        if($locataire->getReservations() == false)
        {
            $entityManager->remove($locataire);
            $entityManager->flush();
            return $this->redirectToRoute('locataire');
        } 
    return $this->redirectToRoute('locataire');
    }
}
