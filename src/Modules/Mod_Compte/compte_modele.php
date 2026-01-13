<?php
include_once "connexion.php";

class compte_modele extends Connexion {
    public static $bdd;

    public function __construct(){
    }

    public function connexionCompte($login, $mdp){
        $sql = self::$bdd->prepare('SELECT * FROM Compte WHERE login = ?');
        $sql->execute([$login]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            return $user;
        }

        return false;
    }

    public function ajouterSolde($idUtilisateur, $montant){
        $sql = self::$bdd->prepare('UPDATE Compte SET solde = solde + ? WHERE id_utilisateur = ?');
        $sql->execute([$montant, $idUtilisateur]);
    }
}