<?php

include_once "connexion.php";

class buvette_modele extends Connexion{

    public function __construct(){
    }

    public function getNomBuvettes(){
        $sql = self::$bdd->prepare('SELECT * FROM Buvette');
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNomBuvettesParId($id){
        $sql = self::$bdd->prepare('SELECT nom FROM Buvette WHERE id = ?');
        $sql->execute([$id]);
        return $sql->fetch();
    }

    public function recupProduits($idBuvette){
        $sql = self::$bdd->prepare('SELECT p.id, p.nom, p.prix FROM Stock s INNER JOIN Produit p ON s.id_produit = p.id INNER JOIN Inventaire i ON s.id_inventaire = i.id WHERE i.id_buvette = ?');
        $sql->execute([$idBuvette]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventaireBuvette($idBuvette){
        $sql = self::$bdd->prepare('SELECT Inventaire.id FROM Inventaire INNER JOIN Buvette ON id_buvette = Buvette.id WHERE Inventaire.id = ?');
        $sql->execute([$idBuvette]);
        return $sql->fetch(PDO::FETCH_COLUMN);
    }

    public function getIdCompteEtSolde() {
        $sql = self::$bdd->prepare("SELECT * FROM Compte WHERE id_compte = (?)");
        $sql->execute([$_SESSION['id_compte']]);
        return $sql->fetch();
    }

    public function getQuantiteProduitStock($idProduit, $idBuvette){
        $sql = self::$bdd->prepare("SELECT quantite FROM Stock WHERE id_produit = (?) AND id_inventaire = (?)");
        $sql->execute([$idProduit, $idBuvette]);
        return $sql->fetch(PDO::FETCH_COLUMN);
    }

    public function getQuantiteProduitCommande($idProduit, $idBuvette){
        $sql = self::$bdd->prepare("SELECT quantite
                                    FROM Commander c
                                    INNER JOIN Lignecommande lc on c.id_lignecmd = lc.id_lignecmd
                                    WHERE id_produit = (?) AND id_buvette = (?)");
        $sql->execute([$idProduit, $idBuvette]);
        return $sql->fetch(PDO::FETCH_COLUMN);
    }

    public function ajouterProduit(){
        $idProduit = $_POST['id_produit'];
        $idBuvette = $_POST['id_buvette'];

        $sql = self::$bdd->prepare("SELECT lc.id_lignecmd
                                    FROM Lignecommande lc
                                    inner join Passercommande pc
                                    on pc.id_lignecmd = lc.id_lignecmd
                                    WHERE pc.id_compte=? and id_buvette = ? and lc.statut like 'en_cours'");
        $sql ->execute([$_SESSION['id_compte'],$idBuvette]);
        $acmder = $sql->fetch();

        if($acmder){
            $idLigneCmd = $acmder['id_lignecmd'];
        }else{
            $sql = self::$bdd->prepare("INSERT INTO Lignecommande (id_buvette,prix_total, statut, date)
                                        VALUES ($idBuvette, 0, 'en_cours', NOW())");
            $sql->execute();
            $sql = self::$bdd->prepare("INSERT INTO Passercommande (id_compte, id_lignecmd, date_cmd)
                                        VALUES (?, ?, NOW())");
            $idLigneCmd = self::$bdd->lastInsertId();
            $sql->execute([$_SESSION['id_compte'], $idLigneCmd]);
        }

        $this->incrementerQuantite($idLigneCmd,$idProduit);
        $this->incrementerPrix($idLigneCmd,$idProduit);

        header('Location: index.php?module=buvette&action=carte&id=' . ($_POST['id_buvette']));
        exit;
    }

    public function incrementerQuantite($idlignecmd,$idproduit){
        $stmt = self::$bdd->prepare("SELECT quantite
                                     FROM Commander
                                     WHERE id_lignecmd = ?
                                     AND id_produit = ?");
        $stmt->execute([$idlignecmd, $idproduit]);
        $ligne = $stmt->fetch();

        if ($ligne) {
            $stmt = self::$bdd->prepare("UPDATE Commander
                                         SET quantite = quantite + 1
                                         WHERE id_lignecmd = ?
                                         AND id_produit = ?");
            $stmt->execute([$idlignecmd, $idproduit]);
        } else {
            $stmt = self::$bdd->prepare("INSERT INTO Commander (id_lignecmd, id_produit, quantite)
                                         VALUES (?, ?, 1)");
            $stmt->execute([$idlignecmd, $idproduit]);
        }
    }

    public function incrementerPrix($idlignecmd,$idproduit){

        $sql = self::$bdd->prepare("SELECT prix FROM Produit WHERE id = ? ");
        $sql->execute([$idproduit]);
        $produit = $sql->fetch();

        if ($produit) {
            $updateprix = self::$bdd->prepare("UPDATE Lignecommande
                                               SET prix_total = prix_total + ?
                                               WHERE id_lignecmd = ?");
            $updateprix->execute([$produit['prix'], $idlignecmd]);
        }
    }

    public function retirerProduit(){

        $idProduit = $_POST['id_produit'];
        $idBuvette = $_POST['id_buvette'];

        $sql = self::$bdd->prepare("SELECT lc.id_lignecmd
                                    FROM Lignecommande lc
                                    inner join Passercommande pc
                                    on pc.id_lignecmd = lc.id_lignecmd
                                    WHERE pc.id_compte=? and id_buvette = ? and lc.statut like 'en_cours'");
        $sql ->execute([$_SESSION['id_compte'],$idBuvette]);
        $acmder = $sql->fetch();

        if($acmder){
            $idLigneCmd = $acmder['id_lignecmd'];
            $this->decrementerQuantite($idLigneCmd,$idProduit);
            $this->decrementerPrix($idLigneCmd,$idProduit);
        }

        header('Location: index.php?module=buvette&action=carte&id=' . ($_POST['id_buvette']));
        exit;
    }

    public function decrementerQuantite($idlignecmd,$idproduit){

        $stmt = self::$bdd->prepare("SELECT quantite
                                     FROM Commander
                                     WHERE id_lignecmd = ?
                                     AND id_produit = ?");
        $stmt->execute([$idlignecmd, $idproduit]);
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ligne) {
            return;
        }

        if ($ligne['quantite'] > 1) {
            $stmt = self::$bdd->prepare("UPDATE Commander
                                         SET quantite = quantite - 1
                                         WHERE id_lignecmd = ?
                                         AND id_produit = ?");
            $stmt->execute([$idlignecmd, $idproduit]);
        }else{
            $stmt = self::$bdd->prepare("DELETE FROM Commander
                                         WHERE id_lignecmd = ?
                                         AND id_produit = ?");
            $stmt->execute([$idlignecmd, $idproduit]);
        }
    }

    public function decrementerPrix($idlignecmd,$idproduit){
        $sql = self::$bdd->prepare("SELECT prix FROM Produit WHERE id = ? ");
        $sql->execute([$idproduit]);
        $produit = $sql->fetch();

        if (!$produit) {
            return;
        }

        $sql = self::$bdd->prepare("SELECT prix_total 
                                    FROM Lignecommande 
                                    WHERE id_lignecmd = ?");
        $sql->execute([$idlignecmd]);
        $ligne = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$ligne) {
            return;
        }

        $nouveauPrix = max(0, $ligne['prix_total'] - $produit['prix']);

        $update = self::$bdd->prepare("UPDATE Lignecommande
                                       SET prix_total = ?
                                       WHERE id_lignecmd = ?");
        $update->execute([$nouveauPrix, $idlignecmd]);
    }

    public function ajoutBuvette($nom){
        $nomBuvettes = $this->getNomBuvettes();

        foreach ($nomBuvettes as $buvette) {
            if ($nom === $buvette['nom']) {
                return true;
            }
        }

        $sql = self::$bdd->prepare("INSERT INTO Buvette (nom) VALUES (?)");
        $sql->execute([$nom]);

        header('Location: index.php?module=buvette&action=choixbuvette');
        exit;
    }
}

?>