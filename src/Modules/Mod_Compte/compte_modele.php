<?php
include_once "connexion.php";

class compte_modele extends Connexion {
    public function __construct(){
    }

    public function recharger(){
        if (!isset($_SESSION['id_compte'])) {
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

    public function getSolde(){
        $sql = self::$bdd->prepare('SELECT id_compte ,solde FROM Compte WHERE id_compte = ?');
        $sql->execute([$_SESSION['id_compte']]);
        return $sql->fetch();
    }

    public function getCommandes(){
        $sql = self::$bdd->prepare("SELECT lc.id_lignecmd, lc.date, prix_total, lc.statut
                                    FROM Lignecommande lc
                                    INNER JOIN Passercommande pc ON lc.id_lignecmd = pc.id_lignecmd
                                    WHERE id_compte = (?)  AND lc.statut like 'payee'
                                    ORDER BY lc.id_lignecmd DESC");
        $sql->execute([$_SESSION['id_compte']]);
        return $sql->fetchAll();
    }

    public function getTotalDepense(){
        $sql = self::$bdd->prepare("SELECT SUM(prix_total) AS total
                                    FROM Lignecommande lc
                                    INNER JOIN Passercommande pc ON lc.id_lignecmd = pc.id_lignecmd
                                    WHERE id_compte = ? AND lc.statut like 'payee'
                                    ");
        $sql->execute([$_SESSION['id_compte']]);
        return $sql->fetchColumn();
    }

    public function getDetailCommande($idCommande){
        $sql = self::$bdd->prepare("SELECT nom, prix, quantite
                                    FROM Lignecommande lc
                                    INNER JOIN Commander c ON lc.id_lignecmd = c.id_lignecmd
                                    INNER JOIN Produit p ON c.id_produit = p.id
                                    WHERE lc.id_lignecmd = (?)");
        $sql->execute([$idCommande]);
        return $sql->fetchAll();
    }
}