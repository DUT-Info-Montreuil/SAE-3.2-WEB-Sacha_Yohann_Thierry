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
                if (isset($_SESSION['erreur'])){
                    echo "<div class='alert alert-danger text-center'>"
                            . $_SESSION['erreur'] .
                          "</div>";
                    unset($_SESSION['erreur']);
                }

                $_SESSION['idBuvette'] = $_GET['id'];
                $nomBuvette = $this->modele->getNomBuvettesParId($_SESSION['idBuvette']);
                $this->vue->TitreBienvenue($idcompte,$nomBuvette);
                $this->vue->afficherEtRechargerSolde($idcompte);
                $this->vue->carte($this->modele->recupProduits($_SESSION['idBuvette']));
                $this->vue->boutonInventaire($_SESSION['idBuvette']);
                $this->vue->afficherPanier();
                break;
            case "ajouterProduit":
                $idProduit = $_POST['id_produit'];
                if($this->modele->getQuantiteProduitCommande($idProduit, $_SESSION['idBuvette'])+1 < $this->modele->getQuantiteProduitStock($idProduit, $_SESSION['idBuvette'])){
                    $this->modele->ajouterProduit();
                }else{
                    $_SESSION['erreur'] = 'Pas assez de produit en stock';
                    header('Location: index.php?module=buvette&action=carte&id=' . ($_POST['id_buvette']));
                    exit;
                }
                break;
            case "retirerProduit";
                $this->modele->retirerProduit();
                break;
        }
    }

}

?>