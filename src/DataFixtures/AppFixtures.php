<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\LOGEMENT;
use App\Entity\LOCATAIRE;

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
            $locataire->setTelephone($faker->serviceNumber);
            $locataire->setAdresse($faker->address);
            $locataire->setCodePostal($faker->randomNumber(5, true));            

            //Enregistrement de l'entité générée
            $manager->persist($locataire);
        }

        //Création des réservations
        for($i = 0; $i < $NbrReservations; $i ++)
        {
            
        }

        $manager->flush();
    }
}
