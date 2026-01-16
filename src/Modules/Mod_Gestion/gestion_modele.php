<?php
include_once "connexion.php";

class gestion_modele extends Connexion {

    public function __construct(){}

    public function ajouterProduit($nom, $prix, $quantite, $idInventaire){
            self::$bdd->beginTransaction();

            $sqlProduit = self::$bdd->prepare('INSERT INTO Produit (nom, prix) VALUES (?, ?)');
            $sqlProduit->execute([$nom, $prix]);

            $idProduit = self::$bdd->lastInsertId();

            $sqlStock = self::$bdd->prepare('INSERT INTO Stock (id_inventaire, id_produit, quantite) VALUES (?, ?, ?)');
            $sqlStock->execute([$_SESSION['idBuvette'], $idProduit, $quantite]);

            self::$bdd->commit();
            return true;
    }
}
?>