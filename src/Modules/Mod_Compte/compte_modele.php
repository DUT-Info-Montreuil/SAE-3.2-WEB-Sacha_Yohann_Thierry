<?php
include_once "connexion.php";

class compte_modele extends Connexion {
    public function __construct(){
    }

    public function recharger(){
        if (!isset($_SESSION['login'])) {
            return;
        }
        $login = $_SESSION['login'];
        $montant = intval($_POST['montantFinal']);

        if ($montant > 0) {
            $this->ajouterSolde($login, $montant);
        }

        header("Location: index.php?module=buvette&action=carte&id=" . $_SESSION['idBuvette']);
        exit;
    }

    public function ajouterSolde($login, $montant){
        $sql = self::$bdd->prepare('UPDATE Compte SET solde = solde + ? WHERE login = ?');
        $sql->execute([$montant, $login]);
    }
}