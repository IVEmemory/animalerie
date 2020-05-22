<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux animals 
 * 
 * @author André Pilon
 */
class Animal extends Modele {

// Renvoie la liste de tous les animals, triés par identifiant décroissant avec le nom de l'utilisateus lié
    public function getAnimals() {
        $sql = 'SELECT a.id,'
                . ' a.nom,'
                . ' a.utilisateur_id,'
                . ' a.description,'
                . ' a.sexe,'
                . ' u.nom as nomUtile,'
                . ' u.identifiant'
                . ' FROM animals a'
                . ' INNER JOIN utilisateurs u'
                . ' ON a.utilisateur_id = u.id'
                . ' ORDER BY id desc';
        $animals = $this->executerRequete($sql);
        return $animals;
    }

// Renvoie la liste de tous les animals, triés par identifiant décroissant
    public function setAnimal($animal) {
        $sql = 'INSERT INTO animals ('
                . ' nom,'
                . ' description,'
                . ' utilisateur_id,'
                . ' sexe)'
                . ' VALUES(?, ?, ?, ?)';
        $result = $this->executerRequete($sql, [
            $animal['nom'],
            $animal['description'],
            $animal['utilisateur_id'],
            $animal['sexe']
                ]
        );
        return $result;
    }

// Renvoie les informations sur un animal avec le nom de l'utilisateur lié
    function getAnimal($idAnimal) {
        $sql = 'SELECT a.id,'
                . ' a.nom,'
                . ' a.utilisateur_id,'
                . ' a.description,'
                . ' a.sexe,'
                . ' u.nom as nomUtile'
                . ' FROM animals a'
                . ' INNER JOIN utilisateurs u'
                . ' ON a.utilisateur_id = u.id'
                . ' WHERE a.id=?';
        $animal = $this->executerRequete($sql, [$idAnimal]);
        if ($animal->rowCount() == 1) {
            return $animal->fetch();  // Accès à la première ligne de résultat
        } else {
            throw new Exception("Aucune animalerie ne correspond à l'identifiant '$idAnimal'");
        }
    }

// Met à jour un animal
    public function updateAnimal($animal) {
        $sql = 'UPDATE animals'
                . ' SET nom = ?,'
                . ' description = ?,'
                . ' utilisateur_id = ?,'
                . ' sexe = ?'
                . ' WHERE id = ?';
        $result = $this->executerRequete($sql, [
            $animal['nom'],
            $animal['description'],
            $animal['utilisateur_id'],
            $animal['sexe'],
            $animal['id']
                ]
        );
        return $result;
    }

}
