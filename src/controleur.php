<?php
include_once "modele.php";
include_once "vue.php";
class Controleur {

    private $modele;
    private $vue;
    private $action;

    public function __construct(){
        $this->modele = new Modele();
        $this->vue = new Vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        switch($this -> action){
            case "formConnexion":
                $this->vue->form_connexion();
                break;
            case "formInscription":
                $this->vue->form_inscription();
                break;
            case "inscription":
                $this->modele->inscription();
                break;
            case "connexion":
                $this->modele->connexion();
            case "default":
                $this->vue->messageBienvenue();
                $this->vue->menu();
                break;
        }
    }
}



?>