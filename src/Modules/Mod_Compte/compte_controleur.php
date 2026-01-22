<?php

include_once "compte_vue.php";
include_once "compte_modele.php";

class compte_controleur{

    private $modele_compte;
    private $vue_compte;
    private $action;


    public function __construct(){
        $this->vue_compte = new compte_vue();
        $this->modele_compte = new compte_modele();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        if(isset($_SESSION['login'])) {
            switch ($this->action) {
                case "solde":
                    $this->vue_compte->solde($this->modele_compte->getSolde());
                    break;
                case "formRecharger":
                    $this->vue_compte->form_recharge_compte($_SESSION['idBuvette']);
                    break;
                case "recharger":
                    $this->modele_compte->recharger();
                    break;
                case "historique":
                    $this->vue_compte->afficherHistorique($this->modele_compte->getCommandes(), $this->modele_compte->getTotalDepense());
                    break;
                case "detailCommande":
                    $this->vue_compte->afficherDetailCommande($this->modele_compte->getDetailCommande($_GET['id']));
                    break;
            }
        }

    }
}