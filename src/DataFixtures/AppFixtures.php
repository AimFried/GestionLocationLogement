<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\LOGEMENT;
use App\Entity\LOCATAIRE;
use App\Entity\RESERVATION;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ///GENERATEUR DE DONNEES
        //Region des données
        $faker = \Faker\Factory::create('fr_FR');

        //Nombre(s) de logements
        $NbrLogements = 5;
        //Nombre(s) de locataires
        $NbrLocataires = 10;
        //Nombre(s) de réservations
        $NbrReservations = 10;

        //Création des logements
        for($i = 0; $i < $NbrLogements; $i ++)
        {
            $logement = new Logement();
            $logement->setNom("Appartement n°",$i);
            $logement->setAdresse($faker->address);
            $logement->setVille($faker->region);
            $logement->setCodePostal($faker->randomNumber(5, true));
            $logement->setPersMax($faker->numberBetween($min=4, $max=8));
            $logement->setDescription($faker->realText(200,2));
            $logement->setEtat($faker->boolean);
            $logements[] = $logement;

            //Enregistrement de l'entité générée
            $manager->persist($logement);
        }

        //Création des locataires
        for($i = 0; $i < $NbrLocataires; $i ++)
        {
            $locataire = new Locataire();
            $locataire->setNom($faker->lastName);
            $locataire->setPrenom($faker->firstName);
            $locataire->setEmail($faker->freeEmail);
            $locataire->setTelephone($faker->e164PhoneNumber);
            $locataire->setAdresse($faker->address);
            $locataire->setCodePostal($faker->randomNumber(5, true)); 
            $locataires[] = $locataire;           

            //Enregistrement de l'entité générée
            $manager->persist($locataire);
        }

        //Création des réservations
        for($i = 0; $i < $NbrReservations; $i ++)
        {
            //Donne une valeur aléatoire
            $logementAssocieALaReservation = $faker->numberBetween($min=0, $max=$NbrLogements);
            $locataireAssocieALaReservation = $faker->numberBetween($min=0, $max=$NbrLocataires);

            $reservation = new Reservation();
            $reservation->setDateDebut($faker->date);
            $reservation->setDateFin($faker->date);
            $reservation->setPrixNuit($faker->numberBetween($min=40, $max=80));
            $reservation->setPrixTotal($faker->numberBetween($min=40, $max=250));
            $reservation->setNbrAdulte($faker->numberBetween($min=1, $max=4));
            $reservation->setNbrEnfant($faker->numberBetween($min=1, $max=4));
            $reservation->setEtatContrat($faker->boolean);
            $reservation->setLogements($logements[$logementAssocieALaReservation]);
            $reservation->setLocataires($locataires[$locataireAssocieALaReservation]);
            
            //Enregistrement de l'entité générée
            $manager->persist($reservation);
        }

        $manager->flush();
    }
}
