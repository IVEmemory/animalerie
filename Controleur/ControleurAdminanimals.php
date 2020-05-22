<?php

require_once 'Controleur/ControleurAdmin.php';
require_once 'Modele/Animal.php';
require_once 'Modele/Health_record.php';

class ControleurAdminAnimals extends ControleurAdmin {

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
        $erreur = $this->requete->getSession()->existeAttribut("erreur") ? $this->requete->getsession()->getAttribut("erreur") : '';
        $health_records = $this->health_record->getHealth_records($idAnimal);
        $this->genererVue(['animal' => $animal, 'health_records' => $health_records, 'erreur' => $erreur]);
    }

    public function ajouter() {
        $vue = new Vue("Ajouter");
        $this->genererVue();
    }

// Enregistre le nouvel animal et retourne à la liste des animals
    public function nouveauAnimal() {
        if ($this->requete->getSession()->getAttribut("env") == 'prod') {
            $this->requete->getSession()->setAttribut("message", "Ajouter un animal n'est pas permis en démonstration");
        } else {
            $animal['utilisateur_id'] = $this->requete->getParametreId('utilisateur_id');
            $animal['nom'] = $this->requete->getParametre('nom');
            $animal['description'] = $this->requete->getParametre('description');
            $animal['sexe'] = $this->requete->getParametreId('sexe');
            $this->animal->setAnimal($animal);
            $this->executerAction('index');
        }
    }

// Modifier un animal existant    
    public function modifier() {
        $id = $this->requete->getParametreId('id');
        $animal = $this->animal->getAnimal($id);
        $this->genererVue(['animal' => $animal]);
    }

// Enregistre l'animal modifié et retourne à la liste des animals
    public function miseAJour() {
        if ($this->requete->getSession()->getAttribut("env") == 'prod') {
            $this->requete->getSession()->setAttribut("message", "Modifier un animal n'est pas permis en démonstration");
        } else {
            $animal['id'] = $this->requete->getParametreId('id');
            $animal['utilisateur_id'] = $this->requete->getParametreId('utilisateur_id');
            $animal['nom'] = $this->requete->getParametre('nom');
            $animal['description'] = $this->requete->getParametre('description');
            $animal['sexe'] = $this->requete->getParametre('sexe');
            $this->animal->updateAnimal($animal);
            $this->executerAction('index');
        }
    }

}
