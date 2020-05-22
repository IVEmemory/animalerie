<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Animal.php';
require_once 'Modele/Health_record.php';

class ControleurAnimals extends Controleur {

    private $animal;
    private $health_record;

    public function __construct() {
        $this->animal = new Animal();
        $this->health_record = new Health_record();
    }

// Affiche la liste de tous les animals du blog
    public function index() {
        $animals = $this->animal->getAnimals();
        $this->genererVue(['animals' => $animals]);
    }

// Affiche les détails sur un animal
    public function lire() {
        $idAnimal = $this->requete->getParametreId("id");
        $animal = $this->animal->getAnimal($idAnimal);
        $health_records = $this->health_record->getHealth_records($idAnimal);
        $this->genererVue(['animal' => $animal, 'health_records' => $health_records]);
    }

}
