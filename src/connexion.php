<?php

class Connexion {
    static protected $bdd;

    public static function initConnexion() {
        // Paramètres de connexion par défaut sur XAMPP
        $user = 'root';
        $password = ''; // Vide par défaut sur XAMPP

        try {
            self::$bdd = new PDO('mysql:host=localhost;dbname=dutinfopw201658;charset=utf8', $user, $password);

            // Il est recommandé d'ajouter ceci pour voir les erreurs SQL précises à l'avenir
            self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}


?>
