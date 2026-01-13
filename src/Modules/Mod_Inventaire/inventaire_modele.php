<?php

include_once "connexion.php";

class inventaire_modele extends \Connexion {

    public function __construct(){

    }

    public function recupProduitParId($idProduit){
        $sql = self::$bdd->prepare('SELECT * FROM Produit WHERE idProduit = ?');
        $sql->execute([$idProduit]);
        return $sql->fetch();
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