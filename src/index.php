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
        $inventaire = new inventaire_controleur();
        $inventaire->exec();
        break;
    default :
        include_once ("Modules/Mod_Connexion/connexion_controleur.php");
        $controleur = new connexion_controleur();
        $controleur->exec();
        break;
}



