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
        $sql = self::$bdd->prepare('SELECT p.id, p.nom, p.prix FROM Stock s INNER JOIN Produit p ON s.id_produit = p.id INNER JOIN Inventaire i ON s.id_inventaire = i.id WHERE i.id_buvette = ? ');
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


    public function ajouterProduit($idProduit, $idAcheteur, $idBuvette){
            $sql = self::$bdd->prepare("SELECT lc.id_lignecmd
                                        FROM Lignecommande lc
                                        inner join Passercommande pc
                                        on pc.id_lignecmd = lc.id_lignecmd
                                        WHERE pc.id_compte=? and id_buvette = ? and lc.statut like 'en_cours'");
            $sql ->execute([$idAcheteur, $idBuvette]);
            $acmder = $sql->fetch();

            if($acmder){
                $idLigneCmd = $acmder['id_lignecmd'];

            }else{
                $sql = self::$bdd->prepare("INSERT INTO Lignecommande (id_buvette, prix_total, statut, date)
                                            VALUES (?, 0, 'en_cours', NOW())");
                $sql->execute([$idBuvette]);

                $idLigneCmd = self::$bdd->lastInsertId();

                $sql = self::$bdd->prepare("INSERT INTO Passercommande (id_compte, id_lignecmd, date_cmd)
                                            VALUES (?, ?, NOW())");

                $sql->execute([$idAcheteur, $idLigneCmd]);
            }

            $this->incrementerQuantite($idLigneCmd,$idProduit);
            $this->incrementerPrix($idLigneCmd,$idProduit);

            return true;
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

    public function retirerProduit($idProduit, $idAcheteur, $idBuvette){

            $sql = self::$bdd->prepare("SELECT lc.id_lignecmd FROM Lignecommande lc INNER JOIN Passercommande pc ON pc.id_lignecmd = lc.id_lignecmd WHERE pc.id_compte = ? AND lc.id_buvette = ? AND lc.statut = 'en_cours'");
            $sql->execute([$idAcheteur, $idBuvette]);
            $commande = $sql->fetch();

            if($commande){
                $idLigneCmd = $commande['id_lignecmd'];

                $this->decrementerQuantite($idLigneCmd, $idProduit);
                $this->decrementerPrix($idLigneCmd, $idProduit);
            }

            return true;
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

    public function ajoutBuvette($nom, $idUtilisateur){
        try {
           self::$bdd->beginTransaction();

           $verif = self::$bdd->prepare('SELECT id FROM Buvette WHERE nom = ?');
           $verif->execute([$nom]);
           if ($verif->fetch()) {
               self::$bdd->rollBack();
               return false;
           }

            $reqBuvette = self::$bdd->prepare("INSERT INTO Buvette (nom) VALUES (?)");
            $reqBuvette->execute([$nom]);

            $idBuvette = self::$bdd->lastInsertId();

            $reqRole = self::$bdd->prepare('INSERT INTO A_role (id_buvette, id_utilisateur, role) VALUES (?, ?, ?)');
            $reqRole->execute([$idBuvette, $idUtilisateur, 'admin']);

            $reqInventaire = self::$bdd->prepare('INSERT INTO Inventaire (categorie, date, id_buvette) VALUES (NULL, NOW(), ?)');
            $reqInventaire->execute([$idBuvette]);

            self::$bdd->commit();
            return true;
        } catch (Exeption $e){
            self::$bdd->rollBack();
            return false;
        }
    }

    public function nommerAdmin($loginCible, $idBuvette){

        $sqlUser = self::$bdd->prepare('SELECT id_utilisateur FROM Compte WHERE login = ?');
        $sqlUser->execute([$loginCible]);
        $user = $sqlUser->fetch(PDO::FETCH_ASSOC);

        if(!$user){
            return "Utilisateur introuvable.";
        }

        $idNouveauAdmin = $user['id_utilisateur'];


        $verif = self::$bdd->prepare('SELECT * FROM A_role WHERE id_buvette = ? AND id_utilisateur = ?');
        $verif->execute([$idBuvette, $idNouveauAdmin]);

        if($verif->fetch()){

            $update = self::$bdd->prepare('UPDATE A_role SET role = "admin" WHERE id_buvette = ? AND id_utilisateur = ?');
            $update->execute([$idBuvette, $idNouveauAdmin]);
        } else {

            $insert = self::$bdd->prepare('INSERT INTO A_role (id_buvette, id_utilisateur, role) VALUES (?, ?, "admin")');
            $insert->execute([$idBuvette, $idNouveauAdmin]);
        }

        return "Succès";
    }

    public function estAdmin($idUtilisateur, $idBuvette){
        $sql = self::$bdd->prepare('SELECT role FROM A_role WHERE id_utilisateur = ? AND id_buvette = ?');
        $sql->execute([$idUtilisateur, $idBuvette]);
        $resultat = $sql->fetch(PDO::FETCH_ASSOC);

        if($resultat && $resultat['role'] == 'admin'){
            return true;
        }
        return false;
    }

    public function getInfoClient($login){
        $sql = self::$bdd->prepare('SELECT id_utilisateur, id_compte, login, solde FROM Compte WHERE login = ?');
        $sql->execute([$login]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}

?>