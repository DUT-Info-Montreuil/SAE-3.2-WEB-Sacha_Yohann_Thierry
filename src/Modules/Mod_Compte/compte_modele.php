<?php
include_once "connexion.php";

class compte_modele extends Connexion {
    public function __construct(){
    }

    public function recharger(){
        if (!isset($_SESSION['id_utilisateur'])) {
            return;
        }
        $idUtilisateur = $_SESSION['id_utilisateur'];
        $montant = intval($_POST['montantFinal']);

        if ($montant > 0) {
            $this->ajouterSolde($idUtilisateur, $montant);
            $_SESSION['solde'] += $montant;
        }

        header("Location: index.php");
        exit;
    }

    public function ajouterSolde($idUtilisateur, $montant){
        $sql = self::$bdd->prepare('UPDATE Compte SET solde = solde + ? WHERE id_utilisateur = ?');
        $sql->execute([$montant, $idUtilisateur]);
    }
}