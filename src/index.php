<?php

session_start();

require_once ("connexion.php");



$connexion = new Connexion();
$connexion->initConnexion();

$module = isset($_GET["module"]) ? $_GET["module"]: "default";

switch($module){
    case 'buvette' :
        include_once ("Modules/Mod_Buvette/buvette_controleur.php");
        $controleur = new buvette_controleur();
        $controleur->exec();
        break;
    case 'inventaire' :
        include_once ("Modules/Mod_Inventaire/inventaire_controleur.php");
        $controleur = new inventaire_controleur();
        $controleur->exec();
        break;
    case 'compte' :
        include_once ("Modules/Mod_Compte/compte_controleur.php");
        $controleur = new compte_controleur();
        $controleur->exec();
        break;
    default :
        include_once ("Modules/Mod_Connexion/connexion_controleur.php");
        $controleur = new connexion_controleur();
        $controleur->exec();
        break;
}