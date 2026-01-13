<?php

session_start();

require_once ("Modules/Mod_Connexion/connexion_controleur.php");
require_once("Modules/Mod_Inventaire/inventaire_controleur.php");
require_once ("connexion.php");


$connexion = new Connexion();
$inventaire = new inventaire_controleur();


$connexion->initConnexion();

$inventaire->exec();

$action = isset($_GET['module']) ? $_GET['module'] : 'connexion';

switch ($action){
    case 'connexion';
        $controleur_connexion = new connexion_controleur();
        $controleur_connexion->exec();
        break;
}