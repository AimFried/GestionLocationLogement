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

        return $this->render('locataire/listeLocataires.html.twig', [
            'reservations' => $reservations,'locataires' => $locataires,
        ]);
    }

    #[Route('/locataire/{id}', name: 'locataire_profile')]
    public function profile(RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository, $id): Response
    {
        $reservations = $reservationRepository->find($id);
        $locataires = $locataireRepository->find($id);

        return $this->render('locataire/profileLocataire.html.twig', [
            'reservations' => $reservations,'locataires' => $locataires,
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
                $entityManager->persist($locataire);
                $entityManager->flush();
               
                return $this->redirectToRoute('locataire');
            }

        return $this->render('locataire/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/locataire/{id}/modifier', name: 'locataire_modifier')]
    public function modifier(Request $request,ManagerRegistry $doctrine, LOCATAIRE $locataire): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(LocataireType::class, $locataire);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($locataire);
                $entityManager->flush();
               
                return $this->redirectToRoute('locataire');
            }

        return $this->render('locataire/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/locataire/{id}/supprimer', name: 'locataire_supprimer')]
    public function supprimer(RESERVATIONRepository $reservationRepository, LOCATAIRERepository $locataireRepository,Request $request,ManagerRegistry $doctrine, LOCATAIRE $locataire): Response
    {
        $reservations = $reservationRepository->findAll();
        $locataires = $locataireRepository->findAll();

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(LocataireType::class, $locataire);

        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->remove($locataire);
                $entityManager->flush();
               
                return $this->redirectToRoute('locataire');
            }

        return $this->render('locataire/listeLocataires.html.twig', [
            'reservations' => $reservations,'locataires' => $locataires,
        ]);
    }
}
