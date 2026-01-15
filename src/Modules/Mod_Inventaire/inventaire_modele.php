<?php

include_once "connexion.php";

class inventaire_modele extends \Connexion {

    public function __construct(){

    }

    public function recupProduitParBuvette($idBuvette){
        $sql = self::$bdd->prepare('SELECT nom, prix, quantite FROM Stock INNER JOIN Produit ON id_produit = id WHERE id_inventaire = ?');
        $sql->execute([$idBuvette]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recupTousProduits(){
        $sql = self::$bdd->query('SELECT * FROM Produit');
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
/*
     public function afficherInventaire(){
        $produits = $this->modele->recupTousProduits();
        $this->vue->form_inventaire($produits);
     }
 */
}

?>