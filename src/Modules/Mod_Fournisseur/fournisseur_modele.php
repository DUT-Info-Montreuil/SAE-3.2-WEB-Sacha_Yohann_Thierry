<?php

include_once "connexion.php";
class fournisseur_modele extends Connexion {

    public function insertDataFournisseur($nom,$num){
        $requete = self::$bdd->prepare('INSERT INTO Fournisseurproduit(nom_fournisseur,numero ) VALUES (?,?)');
        $requete->execute([$nom, $num]);

        return self::$bdd->lastInsertId();
    }

    public function fournisseur(){
        $nomFournisseur = $_POST['nomFournisseur'];
        $numFournisseur = $_POST['numFournisseur'];
        $idInventaire = $_POST['id_inventaire'];

        $idFournisseur = $this->insertDataFournisseur($nomFournisseur, $numFournisseur);
        $this->insertFourni($idInventaire, $idFournisseur);

        header('Location: index.php?module=buvette&action=choixbuvette');
        exit;
    }
    public function getBuvettes(){
        $sql = self::$bdd->prepare("SELECT id, nom FROM Buvette");
        $sql->execute();
        return $sql->fetchAll();
    }
    public function getInventairesAvecBuvette(){
        $sql = self::$bdd->prepare("
        SELECT i.id AS id_inventaire, b.nom AS nom_buvette
        FROM Inventaire i
        JOIN Buvette b ON b.id = i.id_buvette
    ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertFourni($idInventaire, $idFournisseur){
        $sql = self::$bdd->prepare(
            'INSERT INTO Fourni(id_inventaire, id_fournisseurProduit) VALUES (?, ?)'
        );
        $sql->execute([$idInventaire, $idFournisseur]);
    }

}