<?php

class connexion_vue{

    public function __construct(){
    }

    public function menu(){
        if(!isset($_SESSION['login'])){
            echo '<h1>Bienvenue sur le site</h1>';
            echo '<a href="index.php?action=formInscription"> Inscription </a> |';
            echo '<a href="index.php?action=formConnexion"> Connexion </a>';
        } else {
            echo '<a href="index.php?"> Deconnexion </a><br>';
        }
    }

    public function form_inscription(){
        echo '
            <h2>Inscription</h2>
            <form method = "POST" action = "index.php?action=inscription">
                <label>Prénom :</label> <br>
                <input type = "text" name= "prenom" placeholder="Entrez votre prénom"><br>

                <label>Nom :</label> <br>
                <input type = "text" name= "nom" placeholder="Entrez votre nom"> <br>
                
                <label>Adresse mail :</label> <br>
                <input type = "text" name= "email" placeholder="Entrez une adresse mail"> <br>
            
                <label>Login :</label> <br>
                <input type = "text" name= "login" placeholder="Entrez votre pseudonyme"><br>
    
                <label>Mot de passe :</label><br>
                <input type = "text" name= "mdp" placeholder="Entrez votre un mot de passe"> <br>
    
                <input type = "submit" value="Valider">
            </form>
        ';
    }

    public function form_connexion(){
        echo '
            <h2>Connexion</h2>
            <form method = "POST" action = "index.php?action=connexion">
                <label>Login :</label> <br>
                <input type = "text" name= "login"><br>
    
                <label>Mot de passe :</label><br>
                <input type = "text" name= "mdp"> <br>
    
                <input type = "submit" value="Connecter">
            </form>
        ';
    }
}

?>