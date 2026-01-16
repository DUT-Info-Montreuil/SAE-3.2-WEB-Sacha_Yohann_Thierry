<?php
include_once "buvette_vue.php";
include_once "buvette_modele.php";

class buvette_controleur{

    private $modele;
    private $vue;
    private $action;

    public function __construct(){
        $this->modele = new buvette_modele();
        $this->vue = new buvette_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        if(!isset($_SESSION['login'])) {
            header('Location: index.php?action=formConnexion');
            exit;
        }

        switch($this->action) {
            case "choixbuvette" :
                $this->vue->choixBuvette($this->modele->getNomBuvettes());

                break;
            case "carte" :
                $login = $_SESSION['login'];
                $_SESSION['idBuvette'] = $_GET['id'];
                $this->vue->afficherEtRechargerSolde($this->modele->getIdCompteEtSolde($login));
                $this->vue->carte($this->modele->recupProduits($_SESSION['idBuvette']));
                $this->vue->boutonInventaire($this->modele->getInventaireBuvette($_SESSION['idBuvette']));
                break;
        }
    }
}

?>