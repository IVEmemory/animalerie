<?php

require_once 'Controleur/ControleurAdmin.php';
require_once 'Modele/Health_record.php';

class ControleurAdminHealth_records extends ControleurAdmin {

    private $health_record;

    public function __construct() {
        $this->health_record = new Health_record();
    }

// L'action index n'est pas utilisée mais pourrait ressembler à ceci 
// en ajoutant la fonctionnalité de faire afficher tous les health_records
    public function index() {
        $health_records = $this->health_record->getHealth_records();
        $this->genererVue(['health_records' => $health_records]);
    }
  
// Confirmer la suppression d'un health_record
    public function confirmer() {
        $id = $this->requete->getParametreId("id");
        // Lire le health_record à l'aide du modèle
        $health_record = $this->health_record->getHealth_record($id);
        $this->genererVue(['health_record' => $health_record]);
    }

// Supprimer un health_record
    public function supprimer() {
        $id = $this->requete->getParametreId("id");
        // Lire le health_record afin d'obtenir le id de l'animal associé
        $health_record = $this->health_record->getHealth_record($id);
        // Supprimer le health_record à l'aide du modèle
        $this->health_record->deleteHealth_record($id);
        //Recharger la page pour mettre à jour la liste des health_records associés
        $this->rediriger('Adminanimals', 'lire/' . $health_record['animal_id']);
    }

    // Rétablir un health_record
    public function retablir() {
        $id = $this->requete->getParametreId("id");
        // Lire le health_record afin d'obtenir le id de l'animal associé
        $health_record = $this->health_record->getHealth_record($id);
        // Supprimer le health_record à l'aide du modèle
        $this->health_record->restoreHealth_record($id);
        //Recharger la page pour mettre à jour la liste des health_records associés
        $this->rediriger('Adminanimals', 'lire/' . $health_record['animal_id']);
    }

}
