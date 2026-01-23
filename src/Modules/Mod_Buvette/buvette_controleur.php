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
                if ($this->modele->ajoutBuvette($_POST['nomBuvette'], $_SESSION['id_utilisateur'])) {
                    header('Location: index.php?module=buvette&action=choixbuvette');
                    exit;
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

                if (!$this->modele->possedeRole($_SESSION['id_utilisateur'], $_SESSION['idBuvette'])) {
                    $this->modele->gererDemandeClient($_SESSION['id_utilisateur'], $_SESSION['idBuvette']);
                    $this->vue->messageAttenteDemande($nomBuvette);
                    break;
                }

                $estAdmin = $this->modele->estAdmin($_SESSION['id_utilisateur'], $_SESSION['idBuvette']);
                $estBarman = $this->modele->estBarman($_SESSION['id_utilisateur'], $_SESSION['idBuvette']);

                $_SESSION['est_barman'] = $estBarman;

                $this->vue->TitreBienvenue($idcompte,$nomBuvette);

                if($estBarman){
                    $clientServi = isset($_SESSION['client_servi']) ? $_SESSION['client_servi'] : null;
                    $this->vue->barre_vendeur($clientServi);
                }

                $this->vue->afficherEtRechargerSolde($idcompte);
                $this->vue->carte($this->modele->recupProduits($_SESSION['idBuvette']));
                $this->vue->afficherPanier();

                if($estAdmin){
                    $this->vue->boutonInventaire($_SESSION['idBuvette']);
                    $this->vue->form_ajout_staff($_SESSION['idBuvette']);

                    $demandes = $this->modele->getDemandesEnAttente($_SESSION['idBuvette']);
                    $this->vue->afficherDemandesAcces($demandes, $_SESSION['idBuvette']);
                }
                break;

            case "ajouterProduit":
                $idProduit = $_POST['id_produit'];
                if(isset($_SESSION['client_servi'])) {
                        $idAcheteur = $_SESSION['client_servi']['id_compte'];
                    } else {
                        $idAcheteur = $_SESSION['id_compte'];
                    }
                if(isset($_POST['id_produit']) && isset($_SESSION['idBuvette'])){
                    $quantitecmd = $this->modele->getQuantiteProduitCommande($idProduit, $_SESSION['idBuvette'])+1;
                    $quantitestock = $this->modele->getQuantiteProduitStock($idProduit, $_SESSION['idBuvette']);
                    if($quantitecmd < $quantitestock){
                        $this->modele->ajouterProduit($_POST['id_produit'], $idAcheteur, $_SESSION['idBuvette']);
                    }else{
                        $_SESSION['erreur'] = 'Pas assez de produit en stock';
                        header('Location: index.php?module=buvette&action=carte&id=' . ($_POST['id_buvette']));
                        exit;
                    }
                }
                break;

            case "retirerProduit":
                if(isset($_SESSION['client_servi'])) {
                    $idAcheteur = $_SESSION['client_servi']['id_compte'];
                } else {
                    $idAcheteur = $_SESSION['id_compte'];
                }

                if(isset($_POST['id_produit']) && isset($_SESSION['idBuvette'])){
                     $this->modele->retirerProduit($_POST['id_produit'], $idAcheteur, $_SESSION['idBuvette']);
                }

                header('Location: index.php?module=buvette&action=carte&id=' . $_SESSION['idBuvette']);
                exit;

                break;

           case "nommerStaff":
              if(isset($_POST['login_cible']) && isset($_POST['id_buvette']) && isset($_POST['role'])){
                  $message = $this->modele->nommerStaff($_POST['login_cible'], $_POST['id_buvette'], $_POST['role']);

                  if($message == "Succès"){
                      echo "<div class='alert alert-success text-center'>Le rôle <strong>".htmlspecialchars($_POST['role'])."</strong> a été attribué avec succès !</div>";
                  } else {
                      echo "<div class='alert alert-danger text-center'>Erreur : $message</div>";
                  }
                  header("Refresh: 2; url=index.php?module=buvette&action=carte&id=" . $_POST['id_buvette']);
              }
              break;

           case "selectionnerClient":
               if(isset($_POST['login_client'])){
                   $client = $this->modele->getInfoClient($_POST['login_client']);
                   if($client){
                       $_SESSION['client_servi'] = $client;
                   } else {
                       echo "<script>alert('Client introuvable');</script>";
                   }
               }

               header('Location: index.php?module=buvette&action=carte&id=' . $_SESSION['idBuvette']);
               break;

           case "annulerSelection":
               unset($_SESSION['client_servi']);
               header('Location: index.php?module=buvette&action=carte&id=' . $_SESSION['idBuvette']);
               break;

           case "validerAcces":
               if(isset($_POST['id_utilisateur_cible']) && isset($_POST['id_buvette'])){
                   if($this->modele->estAdmin($_SESSION['id_utilisateur'], $_POST['id_buvette'])){
                       $this->modele->validerDemande($_POST['id_utilisateur_cible'], $_POST['id_buvette']);
                       echo "<script>alert('Le client a été accepté avec succès !');</script>";
                   }
                   header("Location: index.php?module=buvette&action=carte&id=" . $_POST['id_buvette']);
               }
               break;

           case "refuserAcces":
               if(isset($_POST['id_utilisateur_cible']) && isset($_POST['id_buvette'])){
                   if($this->modele->estAdmin($_SESSION['id_utilisateur'], $_POST['id_buvette'])){
                       $this->modele->refuserDemande($_POST['id_utilisateur_cible'], $_POST['id_buvette']);
                       echo "<script>alert('La demande a été refusée et supprimée.');</script>";
                   }
                   header("Location: index.php?module=buvette&action=carte&id=" . $_POST['id_buvette']);
               }
               break;
        }
    }
}

?>