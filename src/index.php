<?php
session_start();
require_once ("Modules/Mod_Connexion/connexion_controleur.php");
require_once("Modules/Mod_Inventaire/inventaire_controleur.php");
require_once ("connexion.php");

$connexion = new Connexion();

$controleur = new connexion_controleur();
$inventaire = new inventaire_controleur();


$connexion->initConnexion();
$controleur->exec();
$inventaire->exec();


