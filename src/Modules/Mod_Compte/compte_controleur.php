<?php

include_once "compte_vue.php";
include_once "compte_modele.php";

class compte_controleur{

    private $modele_compte;
    private $vue_compte;
    private $action;


    public function __construct(){
        $this -> vue_compte = new compte_vue();
        $this ->modele_compte = new compte_modele();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        if(isset($_SESSION['login'])) {
            switch ($this->action) {
                case "solde";
                    $this->vue_compte->solde();
                    break;
                case "recharger";
                    $this -> vue_compte->form_recharge_compte();
                    break;
                case "formRecharger";
                    $this->modele_compte->recharger();
                    break;
                case "default":
                    break;
            }
        }

    }



}