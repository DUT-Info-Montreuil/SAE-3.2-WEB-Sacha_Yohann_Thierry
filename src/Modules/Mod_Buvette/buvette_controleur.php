<?php
include_once "buvette_vue.php";
include_once "buvette_modele.php";

class buvette_controleur{

    private $modele;
    private $vue;
    private $action;
    private $existe;

    public function __construct(){
        $this->modele = new buvette_modele();
        $this->vue = new buvette_vue();
        $this->action = isset($_GET["action"]) ? $_GET["action"]: "default";
    }

    public function exec(){
        if(!isset($_SESSION['login'])) {
            header('Location: index.php?action=formConnexion');
            exit;
        }
        $idcompte = $this->modele->getIdCompteEtSolde();

        switch($this->action) {
            case "choixbuvette" :
                $this->vue->choixBuvette($this->modele->getNomBuvettes());
                break;
            case "formAjoutBuvette" :
                $this->vue->formAjoutBuvette();
                break;
            case "ajoutBuvette":
                if (!$this->modele->ajoutBuvette($_POST['nomBuvette'])) {
                    $this->modele->ajoutBuvette($_POST['nomBuvette']);
                } else {
                    echo "<div class='alert alert-danger text-center'>
                            Une buvette avec ce nom existe déjà.
                          </div>";
                    $this->vue->formAjoutBuvette();
                }
                break;
            case "carte" :
                $_SESSION['idBuvette'] = $_GET['id'];
                $nomBuvette = $this->modele->getNomBuvettesParId($_SESSION['idBuvette']);
                $this->vue->TitreBienvenue($idcompte,$nomBuvette);
                $this->vue->afficherEtRechargerSolde($idcompte);
                $this->vue->carte($this->modele->recupProduits($_SESSION['idBuvette']));
                $this->vue->boutonInventaire($_SESSION['idBuvette']);
                $this->vue->afficherPanier();
                break;
            case "ajouterProduit":
                $this->modele->ajouterProduit();
                break;

            case "retirerProduit";
                $this->modele->retirerProduit();
                break;
        }
    }

}

?>