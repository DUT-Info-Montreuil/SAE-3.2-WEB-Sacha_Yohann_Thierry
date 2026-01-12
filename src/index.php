<?php

require_once ("Modules/Mod_Connexion/connexion_controleur.php");
require_once("Modules/Mod_Inventaire/inventaire_controleur.php");

require_once ("connexion.php");

$controleur = new connexion_controleur();
$connexion = new Connexion();
$inventaire = new inventaire_controleur();


$connexion->initConnexion();
$controleur->exec();
$inventaire->exec();


