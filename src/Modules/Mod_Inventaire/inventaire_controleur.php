<?php


include_once "inventaire_vue.php";
include_once "inventaire_modele.php";

class inventaire_controleur{

    private $vue;
    private $modele;

    public function __construct(){

        $this->vue = new inventaire_vue();
        $this->modele = new inventaire_modele();
    }

    public function afficherInventaire(){
        $produits = $this->modele->recupTousProduits();

        $this->vue->form_inventaire($produits);
    }
}

?>