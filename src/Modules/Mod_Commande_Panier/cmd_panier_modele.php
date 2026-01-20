<?php
include_once "connexion.php";
class cmd_panier_modele extends Connexion {

    public function getLigneCommandeEnCours($idCompte,$idBuvette)
    {
        $sql = self::$bdd->prepare("
        SELECT lc.id_lignecmd 
        FROM Lignecommande lc
        JOIN Passercommande pc ON lc.id_lignecmd = pc.id_lignecmd
        WHERE pc.id_compte = ? AND lc.id_buvette = ? AND lc.statut = 'en_cours'
    ");
        $sql->execute([$idCompte,$idBuvette]);
        $ligne = $sql->fetch();

        return $ligne ? $ligne['id_lignecmd'] : null;
    }

    public function getProduit($id_compte,$id_buvette){
        $sql = self::$bdd->prepare("
        SELECT lc.id_lignecmd 
        FROM Lignecommande lc
        INNER JOIN Passercommande pc
        ON pc.id_lignecmd = lc.id_lignecmd
        WHERE pc.id_compte = ? AND lc.id_buvette = ? 
        AND lc.statut = 'en_cours'
    ");
        $sql->execute([$id_compte,$id_buvette]);
        $ligneCmd = $sql->fetch();

        if (!$ligneCmd) {
            return [];
        }

        $sql = self::$bdd->prepare("
        SELECT c.*, p.nom, p.prix
        FROM Commander c
        INNER JOIN Produit p ON c.id_produit = p.id
        WHERE c.id_lignecmd = ?
    ");
        $sql->execute([$ligneCmd['id_lignecmd']]);
        return $sql->fetchAll();
    }

    public function getTotalPrix($idLigneCmd,$idBuvette){

        $sql = self::$bdd->prepare("
        SELECT SUM(p.prix * c.quantite) AS total
        FROM Commander c 
        INNER JOIN Produit p ON c.id_produit = p.id
        INNER JOIN Lignecommande lc on c.id_lignecmd = lc.id_lignecmd
        WHERE c.id_lignecmd = ? AND lc.id_buvette = ?
    ");
        $sql->execute([$idLigneCmd,$idBuvette]);
        return (float)$sql->fetchColumn();
    }

}