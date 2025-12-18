<?php

require_once ("controleur.php");
require_once ("connexion.php");

$controleur = new Controleur();
$connexion = new Connexion();

$connexion->initConnexion();
$controleur->exec();

?>