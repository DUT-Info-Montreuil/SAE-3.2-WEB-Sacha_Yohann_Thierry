<?php

include_once "connexion.php";

class buvette_modele extends Connexion{

    public function __construct(){
    }

    public function getNomBuvettes(){
        $sql = self::$bdd->prepare('SELECT * FROM buvette');
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>