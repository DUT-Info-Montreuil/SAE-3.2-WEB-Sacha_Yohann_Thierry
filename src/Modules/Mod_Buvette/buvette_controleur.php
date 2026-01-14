<?php
include_once "buvette_vue.php";
include_once "buvette_modele.php";

class buvette_controleur{

    private $modele;
    private $vue;
    private $action;

    public function afficherBuvettes(){
        session_start();

        if (!isset($_SESSION['login'])) {
            header('Location: index.php?action=form_connexion');
            exit;
        }

        $modele = new buvette_modele();
        $buvettes = $modele->getBuvettes();

        $vue = new buvette_vue();
        $vue->afficher($buvettes);
    }

    public function __construct(){
        $this->modele = new buvette_modele();
        $this->vue = new buvette_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        $this->vue->choixBuvette($this->modele->getNomBuvettes());
    }
}

?>