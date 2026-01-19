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
        $idbuvette = $_SESSION['id'];
        $ligncmd =$this->modeleCmd->getLigneCommandeEnCours($_SESSION['id_compte']);

        switch($this->action){
            case "panier";
                $this->vueCmd->monPanier($this->modeleCmd->getProduit($_SESSION['id_compte'],$idbuvette),$this->modeleCmd->getTotalPrix($ligncmd));
                break;
        }
    }
}