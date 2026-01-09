<?php

require_once ("Modules/Mod_Connexion/connexion_controleur.php");
require_once ("connexion.php");

$controleur = new Controleur();
$connexion = new Connexion();

$connexion->initConnexion();
$controleur->exec();

?>