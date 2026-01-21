<?php
include_once "connexion.php";

class gestion_modele extends Connexion {

    public function __construct(){}

    public function ajouterProduit($nom, $prix, $quantite, $idBuvette){
        try {
            self::$bdd->beginTransaction();

            $sqlInv = self::$bdd->prepare('SELECT id FROM Inventaire WHERE id_buvette = ?');
            $sqlInv->execute([$idBuvette]);
            $inventaire = $sqlInv->fetch(PDO::FETCH_ASSOC);

            if (!$inventaire) {
                $sqlCreation = self::$bdd->prepare('INSERT INTO Inventaire (id_buvette, date) VALUES (?, NOW())');
                $sqlCreation->execute([$idBuvette]);
                $idInventaire = self::$bdd->lastInsertId();
            } else {
                $idInventaire = $inventaire['id'];
            }

            $sqlProduit = self::$bdd->prepare('INSERT INTO Produit (nom, prix) VALUES (?, ?)');
            $sqlProduit->execute([$nom, $prix]);
            $idProduit = self::$bdd->lastInsertId();

            $sqlStock = self::$bdd->prepare('INSERT INTO Stock (id_inventaire, id_produit, quantite) VALUES (?, ?, ?)');
            $sqlStock->execute([$idInventaire, $idProduit, $quantite]);

            self::$bdd->commit();
            return true;

        }catch (Exception $e) {
             self::$bdd->rollBack();
             return false;
        }
    }

    public function recupProduit($idProduit, $idBuvette){
        $sql = self::$bdd->prepare('SELECT p.id, p.nom, p.prix, s.quantite FROM Produit p INNER JOIN Stock s ON p.id = s.id_produit INNER JOIN Inventaire i ON s.id_inventaire = i.id WHERE p.id = ? AND i.id_buvette = ? ');
        $sql->execute([$idProduit, $idBuvette]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }


    public function modifierProduit($idProduit, $nom, $prix, $quantite, $idBuvette){
        try {
            self::$bdd->beginTransaction();

            $sqlProd = self::$bdd->prepare('UPDATE Produit SET nom = ?, prix = ? WHERE id = ?');
            $sqlProd->execute([$nom, $prix, $idProduit]);

            $sqlInv = self::$bdd->prepare('SELECT id FROM Inventaire WHERE id_buvette = ?');
            $sqlInv->execute([$idBuvette]);
            $inventaire = $sqlInv->fetch(PDO::FETCH_ASSOC);

            if($inventaire){
                $sqlStock = self::$bdd->prepare('UPDATE Stock SET quantite = ? WHERE id_produit = ? AND id_inventaire = ?');
                $sqlStock->execute([$quantite, $idProduit, $inventaire['id']]);
            }

            self::$bdd->commit();
            return true;
        } catch (Exception $e) {
            self::$bdd->rollBack();
            return false;
        }
    }
}
?>