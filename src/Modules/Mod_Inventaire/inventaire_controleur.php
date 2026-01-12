<?php
include_once "inventaire_vue.php";
include_once "inventaire_modele.php";

class inventaire_controleur{

    private $vue;
    private $modele;

    public function __construct(){
        $this->modele = new inventaire_modele();
        $this->vue = new inventaire_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        switch($this->action){
            case"afficherInventaire";
                $this->modele->afficherInventaire();
                break;
            case "default":
               $this->vue->inventaire_affichage();
               break;
        }
    }
}

