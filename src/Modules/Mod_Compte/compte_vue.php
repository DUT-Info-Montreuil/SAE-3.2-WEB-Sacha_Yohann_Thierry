<?php

class compte_vue{
    public function __construct(){

    }
    public function solde(){
        echo "<p>Bonjour " . htmlspecialchars($_SESSION['login']) . " !</p>";
        echo "<p>Votre solde actuel : " . htmlspecialchars($_SESSION['solde']) . " €</p>";
    }
}