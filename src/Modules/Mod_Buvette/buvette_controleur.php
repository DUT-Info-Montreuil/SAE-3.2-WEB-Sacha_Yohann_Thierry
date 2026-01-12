<?php

include_once "buvette_vue.php";
include_once "buvette_modele.php";

class buvette_controleur
{
    private $modele;
    private $vue;
    private $action;

    public function __construct(){
        $this->modele = new buvette_modele();
        $this->vue = new buvette_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){

    }
}

?>