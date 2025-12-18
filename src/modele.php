<?php
include_once "connexion.php";
class Modele extends Connexion {
    public function __construct(){
    }

    public function inscription(){
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        $this->insertDataUser($login,$mdp);

    }

    public function insertDataUser($login, $mdp){
        $requete = self::$bdd->prepare('INSERT INTO Utilisateur(nom_utilisateur, mdp) VALUES (?, ?)');
        $requete->execute([$login, $mdp]);
    }

}



?>