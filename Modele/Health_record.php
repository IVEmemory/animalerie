<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 * 
 * @author Baptiste Pesquet
 */
class Health_record extends Modele {

    // Renvoie la liste des health_records associés à un animal
    public function getHealth_records($idAnimal = NULL) {
        if ($idAnimal == NULL) {
            $sql = 'SELECT c.id,'
                    . ' c.animal_id,'
                    . ' c.nom,'
                    . ' c.summary,'
                    . ' c.details,'
                    . ' c.prive,'
                    . ' c.efface,'
                    . ' a.sexe'
                    . ' FROM health_records c'
                    . ' INNER JOIN animals a'
                    . ' ON c.animal_id = a.id'
                    . ' ORDER BY id desc';;
        } else {
            $sql = 'SELECT * from health_records'
                    . ' WHERE animal_id = ?'
                    . ' ORDER BY id desc';;
        }
        $health_records = $this->executerRequete($sql, [$idAnimal]);
        return $health_records;
    }

    // Renvoie la liste des health_records publics associés à un animal
    public function getHealth_recordsPublics($idAnimal = NULL) {
        if ($idAnimal == NULL) {
            $sql = 'SELECT c.id,'
                    . ' c.animal_id,'
                    . ' c.nom,'
                    . ' c.summary,'
                    . ' c.details,'
                    . ' c.prive,'
                    . ' c.efface,'
                    . ' a.sexe'
                    . ' FROM health_records c'
                    . ' INNER JOIN animals a'
                    . ' ON c.animal_id = a.id'
                    . ' WHERE c.efface = 0 AND c.prive = 0'
                    . ' ORDER BY id desc';
        } else {
            $sql = 'SELECT * FROM health_records'
                    . ' WHERE animal_id = ? AND efface = 0 AND prive = 0'
                    . ' ORDER BY id desc';;
        }
        $health_records = $this->executerRequete($sql, [$idAnimal]);
        return $health_records;
    }

// Renvoie un health_record spécifique
    public function getHealth_record($id) {
        $sql = 'SELECT * FROM health_records'
                . ' WHERE id = ?';
        $health_record = $this->executerRequete($sql, [$id]);
        if ($health_record->rowCount() == 1) {
            return $health_record->fetch();  // Accès à la première ligne de résultat
        } else {
            throw new Exception("Aucun health_record ne correspond à l'identifiant '$id'");
        }
    }

// Supprime un health_record
    public function deleteHealth_record($id) {
        $sql = 'UPDATE health_records'
                . ' SET efface = 1'
                . ' WHERE id = ?';
        $result = $this->executerRequete($sql, [$id]);
        return $result;
    }

    // Réactive un health_record
    public function restoreHealth_record($id) {
        $sql = 'UPDATE health_records'
                . ' SET efface = 0'
                . ' WHERE id = ?';
        $result = $this->executerRequete($sql, [$id]);
        return $result;
    }

// Ajoute un health_record associés à un animal
    public function setHealth_record($health_record) {
        $sql = 'INSERT INTO health_records ('
                . 'animal_id,'
                . ' nom,'
                . ' summary,'
                . ' details,'
                . ' efface,'
                . ' prive)'
                . ' VALUES(?, ?, ?, ?, ?, ?)';
        $result = $this->executerRequete($sql, [
            $health_record['animal_id'],
            $health_record['nom'],
            $health_record['description'],
            $health_record['sexe'],
            $health_record['efface'],
            $health_record['prive']
                ]
        );
        return $result;
    }

}
