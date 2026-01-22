<?php
include_once "fournisseur_vue.php";
include_once "fournisseur_modele.php";

class fournisseur_controleur{

    private $fourVue;
    private $fourModele;
    private $action;

    public function __construct(){
        $this->fourVue = new fournisseur_vue();
        $this->fourModele = new fournisseur_modele();

        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){

        $inv = $this->fourModele->getInventairesAvecBuvette();
        switch($this->action){
            case "ajoutFournisseur":
                $this->fourModele->fournisseur();
                break;
            case "formFournisseur":
                $this->fourVue->form_ajout_fournisseur($inv);
                break;
        }
    }

}