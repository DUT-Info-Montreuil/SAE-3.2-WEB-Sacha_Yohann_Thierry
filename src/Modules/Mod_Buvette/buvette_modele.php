<?php

include_once "connexion.php";

class buvette_modele extends Connexion{

    public function __construct(){
    }

    public function getNomBuvettes(){
        $sql = self::$bdd->prepare('SELECT * FROM Buvette');
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recupProduits($idBuvette){
        $sql = self::$bdd->prepare('SELECT nom, prix FROM Stock INNER JOIN Produit ON id_produit = id WHERE id_inventaire = ?');
        $sql->execute([$idBuvette]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventaireBuvette($idBuvette){
        $sql = self::$bdd->prepare('SELECT Inventaire.id FROM Inventaire INNER JOIN Buvette ON id_buvette = Buvette.id WHERE Inventaire.id = ?');
        $sql->execute([$idBuvette]);
        return $sql->fetch(PDO::FETCH_COLUMN);
    }

    public function getIdCompteEtSolde($login) {
        $sql = self::$bdd->prepare("SELECT id_utilisateur, solde FROM Compte WHERE login = (?)");
        $sql->execute([$login]);
        return $sql->fetch();
    }
}

?>