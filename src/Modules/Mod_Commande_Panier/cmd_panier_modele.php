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

   public function payerCommande($idCompte, $idBuvette){
           try {
               self::$bdd->beginTransaction();

               $sqlCmd = self::$bdd->prepare("SELECT lc.id_lignecmd, lc.prix_total FROM Lignecommande lc INNER JOIN Passercommande pc ON pc.id_lignecmd = lc.id_lignecmd WHERE pc.id_compte = ? AND lc.id_buvette = ? AND lc.statut = 'en_cours' ");
               $sqlCmd->execute([$idCompte, $idBuvette]);
               $commande = $sqlCmd->fetch(PDO::FETCH_ASSOC);

               if(!$commande){
                   self::$bdd->rollBack();
                   return "Aucune commande trouvée.";
               }

               $montant = $commande['prix_total'];
               $idLigneCmd = $commande['id_lignecmd'];

               $sqlSolde = self::$bdd->prepare("SELECT solde FROM Compte WHERE id_compte = ?");
               $sqlSolde->execute([$idCompte]);
               $soldeActuel = $sqlSolde->fetchColumn();

               if($soldeActuel < $montant){
                   self::$bdd->rollBack();
                   return "Solde insuffisant (Manque " . ($montant - $soldeActuel) . " €).";
               }

               $sqlDebit = self::$bdd->prepare("UPDATE Compte SET solde = solde - ? WHERE id_compte = ?");
               $sqlDebit->execute([$montant, $idCompte]);

               $sqlUpdateCmd = self::$bdd->prepare("UPDATE Lignecommande SET statut = 'payee' WHERE id_lignecmd = ?");
               $sqlUpdateCmd->execute([$idLigneCmd]);

               $sqlProduits = self::$bdd->prepare("SELECT id_produit, quantite FROM Commander WHERE id_lignecmd = ?");
               $sqlProduits->execute([$idLigneCmd]);
               $articles = $sqlProduits->fetchAll(PDO::FETCH_ASSOC);

               $sqlInv = self::$bdd->prepare("SELECT id FROM Inventaire WHERE id_buvette = ?");
               $sqlInv->execute([$idBuvette]);
               $idInventaire = $sqlInv->fetchColumn();

               if (!$idInventaire) {
                   self::$bdd->rollBack();
                   return "Erreur : Aucun inventaire trouvé pour la buvette n°" . $idBuvette;
               }

               $sqlStock = self::$bdd->prepare("UPDATE Stock SET quantite = quantite - ? WHERE id_inventaire = ? AND id_produit = ?");

               foreach($articles as $article){
                   $sqlStock->execute([$article['quantite'], $idInventaire, $article['id_produit']]);

                   if ($sqlStock->rowCount() == 0) {
                        self::$bdd->rollBack();
                        return "Erreur Stock : Le produit ID " . $article['id_produit'] . " n'existe pas dans l'inventaire n°" . $idInventaire;
                   }
               }

               self::$bdd->commit();
               return "Succès";

           } catch (Exception $e) {
               self::$bdd->rollBack();
               return "Erreur technique : " . $e->getMessage();
           }
       }

}