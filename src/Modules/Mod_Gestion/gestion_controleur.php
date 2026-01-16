<?php
include_once "gestion_vue.php";
include_once "gestion_modele.php";

class gestion_controleur {

    private $vue;
    private $modele;
    private $action;

    public function __construct(){
        $this->modele = new gestion_modele();
        $this->vue = new gestion_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"] : "formAjout";
    }

    public function exec(){

        if(!isset($_SESSION['login'])) {
            header('Location: index.php?module=connexion&action=formConnexion');
            exit;
        }

        switch($this->action){
            case "formAjout":
                $this->vue->form_ajout_produit();
                break;

            case "validerAjout":
                if(isset($_POST['nom']) && isset($_SESSION['idBuvette'])){
                    $nom = $_POST['nom'];
                    $prix = $_POST['prix'];
                    $quantite = $_POST['quantite'];

                    $succes = $this->modele->ajouterProduit($nom, $prix, $quantite, $_SESSION['idBuvette']);

                    if($succes){

                        header('Location: index.php?module=inventaire&id=' . $_SESSION['idBuvette']);
                    } else {
                        echo "Erreur lors de l'ajout.";
                    }
                } else {
                    echo "Erreur : Session expirée ou buvette non sélectionnée.";
                }
                break;
        }
    }
}
?>