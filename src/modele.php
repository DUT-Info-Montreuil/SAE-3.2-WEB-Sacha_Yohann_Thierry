<?php
include_once "connexion.php";
class Modele extends Connexion {
    public function __construct(){
    }

    public function inscription(){
        $login = $_POST['nom_utilisateur'];
        $mdp = $_POST['mdp'];
        $this->insertDataUser($login,$mdp);

    }

    public function connexion(){
        $login = $_POST['nom_utilisateur'];
        $mdp = $_POST['mdp'];

        $veriflogin = $this->recupLogin($login);
        $verifmdp = $this->recupMdp($mdp);

        if ($veriflogin && $verifmdp){
            $_SESSION['nom_utilisateur'] = $login;
            echo 'Vous êtes connecté';
        }else {
            echo "Le login ou le mot de passe n'est pas correct !";
        }

    }

    public function insertDataUser($login, $mdp){
        $requete = self::$bdd->prepare('INSERT INTO Utilisateur(nom_utilisateur, mdp) VALUES (?, ?)');
        $requete->execute([$login, $mdp]);
    }

    public function recupLogin($login){
        $sql = self::$bdd->prepare('SELECT * from Utilisateur where nom_utilisateur = ?');
        $sql->execute([$login]);
        return $sql->fetch();
    }

    //le mdp je le hash pas mais vous pouvez le changer
    public function recupMdp($mdp){
        $sql = self::$bdd->prepare('SELECT * from Utilisateur where mdp = ?');
        $sql->execute([$mdp]);
        return $sql->fetch();
    }

}



?>