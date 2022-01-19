<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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

        }

        //Création des locataires
        for($i = 0; $i < $NbrLocataires; $i ++)
        {
            
        }

        //Création des réservations
        for($i = 0; $i < $NbrReservations; $i ++)
        {
            
        }

        $manager->flush();
    }
}
