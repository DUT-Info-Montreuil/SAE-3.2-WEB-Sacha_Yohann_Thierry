<?php
include_once "inventaire_vue.php";
include_once "inventaire_modele.php";

class inventaire_controleur{

    private $vue;
    private $modele;
    private $action;

    public function __construct(){
        $this->modele = new inventaire_modele();
        $this->vue = new inventaire_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "afficherInventaire";
    }

    public function exec(){
        //if (isset($_SESSION['login'])) {
            switch($this->action){
                case"afficherInventaire";
                    //$produits = $this->modele->recupProduitsParBuvette($idBuvette);
                    $this->vue->form_inventaire($this->modele->recupProduitParBuvette($_GET['id']));
                    break;
            }
        //}
    }
}

