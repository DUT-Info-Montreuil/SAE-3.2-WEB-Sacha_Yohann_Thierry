<?php
include_once "connexion.php";

class connexion_modele extends Connexion {
    public function __construct(){
    }

    public function inscription(){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        $hashMdp = password_hash($mdp, PASSWORD_DEFAULT);

        $idUtilisateur = $this->insertDataUtilisateur($nom,$prenom,$email);
        $this -> insertDataCompte($login,$hashMdp,$idUtilisateur);

    }

    public function connexion(){
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];

        $sql = self::$bdd->prepare('SELECT * FROM Compte WHERE login = ?');
        $sql->execute([$login]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            $_SESSION['login'] = $login;
            echo 'Vous êtes connecté';
        } else {
            echo "Problème lors de la connexion: Le login ou le mot de passe n'est pas correct !";
        }

    }

    public function insertDataCompte($login, $mdp, $idUtilisateur){
        $sql = self::$bdd->query('SELECT COUNT(*) as nbDeCompte FROM Compte');
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if ($result['nbDeCompte'] == 0) {
            // Réinitialiser AUTO_INCREMENT à 1
            self::$bdd->exec('ALTER TABLE Compte AUTO_INCREMENT = 1');
        }
        $solde = 0;
        $requete = self::$bdd->prepare('INSERT INTO Compte(login, mot_de_passe,solde, id_utilisateur) VALUES (?, ?, ?,?)');
        $requete->execute([$login, $mdp, $solde, $idUtilisateur]);
    }

    public function recupLogin($login){
        $sql = self::$bdd->prepare('SELECT * from Compte where login = ?');
        $sql->execute([$login]);
        return $sql->fetch();
    }

    //le mdp je le hash pas mais vous pouvez le changer
    public function recupMdp($mdp){
        $sql = self::$bdd->prepare('SELECT * from Compte where mdp = ?');
        $sql->execute([$mdp]);
        return $sql->fetch();
    }

    public function insertDataUtilisateur($nom,$prenom,$email){
        // Vérifier si la table est vide
        $sql = self::$bdd->query('SELECT COUNT(*) as nbUtilisateur FROM Utilisateur');
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if ($result['nbUtilisateur'] == 0) {
            // Réinitialiser AUTO_INCREMENT à 1
            self::$bdd->exec('ALTER TABLE Utilisateur AUTO_INCREMENT = 1');
        }

        $requete = self::$bdd->prepare('INSERT INTO Utilisateur(nom,prenom,adresse_mail) VALUES (?,?,?)');
        $requete -> execute([$nom,$prenom,$email]);
        return self::$bdd->lastInsertId();
    }

    public function recupPrenom($prenom){
        $sql = self::$bdd->prepare('SELECT * from Utilisateur where prenom = ?');
        $sql->execute([$prenom]);
        return $sql->fetch();
    }

    public function recupNom($nom){
        $sql = self::$bdd->prepare('SELECT * from Utilisateur where nom = ?');
        $sql->execute([$nom]);
        return $sql->fetch();
    }

    public function recupEmail($email){
        $sql = self::$bdd->prepare('SELECT * from Utilisateur where email = ?');
        $sql->execute([$email]);
        return $sql->fetch();
    }

}



?>