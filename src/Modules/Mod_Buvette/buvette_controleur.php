<?php
include_once "buvette_vue.php";
include_once "buvette_modele.php";

class buvette_controleur{

    

    public function afficherBuvettes(){
        session_start();

        if (!isset($_SESSION['login'])) {
            header('Location: index.php?action=form_connexion');
            exit;
        }

        $modele = new buvette_modele();
        $buvettes = $modele->getBuvettes();

        $vue = new buvette_vue();
        $vue->afficher($buvettes);
    }

}

?>