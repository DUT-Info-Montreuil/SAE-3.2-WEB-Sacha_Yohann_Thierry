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

    public function getIdCompteEtSolde() {
        $sql = self::$bdd->prepare("SELECT id_compte, solde FROM Compte WHERE id_compte = (?)");
        $sql->execute([$_SESSION['id_compte']]);
        return $sql->fetch();
    }

    public function ajoutBuvette($nom){
        $nomBuvettes = $this->getNomBuvettes();

        foreach ($nomBuvettes as $buvette) {
            if ($nom === $buvette['nom']) {
                return true;
            }
        }

        $sql = self::$bdd->prepare("INSERT INTO Buvette (nom) VALUES (?)");
        $sql->execute([$nom]);

        header('Location: index.php?module=buvette&action=choixbuvette');
        exit;
    }
}

?>