<?php

include_once "connexion.php";

class inventaire_modele extends \Connexion {

    public function __construct(){

    }

    public function recupProduitParBuvette($idBuvette){
        $sql = self::$bdd->prepare('SELECT p.id, p.nom, p.prix, s.quantite FROM Stock s INNER JOIN Produit p ON s.id_produit = p.id INNER JOIN Inventaire i ON s.id_inventaire = i.id WHERE i.id_buvette = ? ');
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