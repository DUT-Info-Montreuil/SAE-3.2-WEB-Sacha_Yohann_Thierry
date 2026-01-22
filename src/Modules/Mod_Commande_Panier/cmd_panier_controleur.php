<?php

include_once "cmd_panier_vue.php";
include_once "cmd_panier_modele.php";
class cmd_panier_controleur{

    private $vueCmd;
    private $modeleCmd;
    private $action;

    public function __construct(){

        $this->vueCmd = new cmd_panier_vue();
        $this->modeleCmd = new cmd_panier_modele();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";

    }

    public function exec(){

        if(isset($_SESSION['client_servi'])) {
            $idClientActuel = $_SESSION['client_servi']['id_compte'];

            echo '<div class="alert alert-info text-center">🛒 Panier de : <strong>'. $_SESSION['client_servi']['login'] .'</strong></div>';
        } else {
            $idClientActuel = $_SESSION['id_compte'];
        }
        $ligncmd =$this->modeleCmd->getLigneCommandeEnCours($idClientActuel,$_SESSION['idBuvette']);

        switch($this->action){
            case "panier":
                $this->vueCmd->monPanier(
                    $this->modeleCmd->getProduit($idClientActuel,$_SESSION['idBuvette']),
                    $this->modeleCmd->getTotalPrix($ligncmd,$_SESSION['idBuvette']),
                    $_SESSION['idBuvette']
                );
                break;
        }
    }
}