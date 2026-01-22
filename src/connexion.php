<?php

class Connexion{
    static protected $bdd;

    public static function initConnexion(){

        /*$dsn = "mysql:host=database-etudiants.iut.univ-paris8.fr;dbname=dutinfopw201658;charset=utf8";
        $user = "dutinfopw201658";
        $password = "ravuveny";*/

        $dsn = "mysql:host=localhost;dbname=sae2;charset=utf8";
        $user = "root";
        $password = "";

        self::$bdd = new PDO($dsn, $user, $password);
    }

}


?>
