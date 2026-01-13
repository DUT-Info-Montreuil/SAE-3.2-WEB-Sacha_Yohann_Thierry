<?php
include_once "connexion_modele.php";
include_once "connexion_vue.php";
class connexion_controleur {

    private $modele;
    private $vue;
    private $action;

    public function __construct(){
        $this->modele = new connexion_modele();
        $this->vue = new connexion_vue();
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
                break;
            case "deconnexion":
                session_destroy();
                header('Location: index.php');
                exit;
            case "default":
                $this->vue->messageBienvenue();
                $this->vue->menu();
                break;
        }
    }
}



?>