<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Health_record.php';

class ControleurHealth_records extends Controleur {

    private $health_record;

    public function __construct() {
        $this->health_record = new Health_record();
    }

// L'action index n'est pas utilisée mais pourrait ressembler à ceci 
// en ajoutant la fonctionnalité de faire afficher tous les health_records
    public function index() {
        $health_records = $this->health_record->getHealth_recordsPublics();
        $this->genererVue(['health_records' => $health_records]);
    }

// Ajoute un health_record à un animal
    public function ajouter() {
        $health_record['animal_id'] = $this->requete->getParametreId("animal_id");
        $health_record['nom'] = $this->requete->getParametre('nom');
        $validation_courriel = filter_var($health_record['nom'], FILTER_VALIDATE_EMAIL);
        if ($validation_courriel) {
            if ($this->requete->getSession()->getAttribut("env") == 'prod') {
                $this->requete->getSession()->setAttribut("message", "Ajouter un health_record n'est pas permis en démonstration");
            } else {
                $health_record['nom'] = $this->requete->getParametre('nom');
                $health_record['description'] = $this->requete->getParametre('description');
                // Ajuster la valeur de la case à cocher
                $health_record['prive'] = $this->requete->existeParametre('prive') ? 1 : 0;
                // Ajouter le health_record à l'aide du modèle
                $this->health_record->setHealth_record($health_record);
            }
            // Éliminer un code d'erreur éventuel
            if ($this->requete->getSession()->existeAttribut('erreur')) {
                $this->requete->getsession()->setAttribut('erreur', '');
            }
            //Recharger la page pour mettre à jour la liste des health_records associés
            $this->rediriger('Animals', 'lire/' . $health_record['animal_id']);
        } else {
            //Recharger la page avec une erreur près du courriel
            $this->requete->getSession()->setAttribut('erreur', 'courriel');
            $this->rediriger('Animals', 'lire/' . $health_record['animal_id']);
        }
    }

}
