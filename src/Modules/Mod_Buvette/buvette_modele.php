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
        $sql = self::$bdd->prepare('SELECT * FROM Stock INNER JOIN Produit ON id_produit = id WHERE id_inventaire = ?');
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
                                        VALUES ($idBuvette,0, 'en_cours', NOW())");
            $sql->execute();
            $sql = self::$bdd->prepare("INSERT INTO Passercommande (id_compte, id_lignecmd, date_cmd)
                                        VALUES (?, ?, NOW())");
            $idLigneCmd = self::$bdd->lastInsertId();
            $sql->execute([$_SESSION['id_compte'], $idLigneCmd]);
        }
        $this->updateQuantite($idLigneCmd,$idProduit);
        $this->updatePrix($idLigneCmd,$idProduit);

        header('Location: index.php?module=buvette&action=carte&id=' . ($_POST['id_buvette']));
        exit;
    }

    public function updateQuantite($idlignecmd,$idproduit){
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

    public function updatePrix($idlignecmd,$idproduit){

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

    public function retirerProduit($idlignecmd,$idproduit){
        $stmt = self::$bdd->prepare("SELECT quantite
                                     FROM Commander
                                     WHERE id_lignecmd = ?
                                     AND id_produit = ?");
        $stmt->execute([$idlignecmd, $idproduit]);
        $ligne = $stmt->fetch();

        if ($ligne) {
            $stmt = self::$bdd->prepare("UPDATE Commander
                                         SET quantite = quantite - 1
                                         WHERE id_lignecmd = ?
                                         AND id_produit = ?");
            $stmt->execute([$idlignecmd, $idproduit]);
        } else {

        }
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