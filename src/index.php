<?php

require_once("Modules/Mod_Inventaire/inventaire_controleur.php");

require_once ("connexion.php");

$connexion = new Connexion();
$connexion->initConnexion();

switch(isset($_GET["action"]) ? $_GET["action"]: "default"){
    case 'connexion' :
        include_once ("Modules/Mod_Buvette/buvette_controleur.php");
        $controleur = new buvette_controleur();
        $controleur->exec();
        break;
    default :
        include_once ("Modules/Mod_Connexion/connexion_controleur.php");
        $controleur = new connexion_controleur();
        $controleur->exec();
        break;
}



/*$controleur = new connexion_controleur();

$inventaire = new inventaire_controleur();



$controleur->exec();
$inventaire->afficherInventaire();*/


