<?php

class connexion_vue{

    public function __construct(){
    }

    public function messageBienvenue(){
        echo '<h1>Bienvenue sur le site</h1>';
    }

    public function menu(){
        if(!empty($_SESSION['login'])){
            echo '<a href="index.php?module=connexion&action=formInscription"> Inscription </a> |';
            echo '<a href="index.php?module=connexion&action=formConnexion"> Connexion </a>';
        } else {
            echo '<a href="index.php?module=connexion&action=deconnexion"> Deconnexion </a><br>';
            echo '<strong>Bienvenue, ' . htmlspecialchars($_SESSION['login']) . '</strong><br>';

            if(isset($_SESSION['id_compte'])) {
                echo '<br>ID Compte : ' . $_SESSION['id_compte'];
            }

        }
    }

    public function form_inscription(){
        echo '
            <h2>Inscription</h2>
            <form method = "POST" action = "index.php?action=inscription">
                <label>Prénom :</label> <br>
                <input type = "text" name= "prenom" placeholder="Enter votre prénom"><br>

                <label>Nom :</label> <br>
                <input type = "text" name= "nom" placeholder="Enter votre nom"> <br>
                
                <label>Adresse mail :</label> <br>
                <input type = "text" name= "email" placeholder="Enter une adresse mail"> <br>
            
                <label>Login :</label> <br>
                <input type = "text" name= "login" placeholder="Enter votre pseudonyme"><br>
    
                <label>Mot de passe :</label><br>
                <input type = "password" name= "mdp" placeholder="Enter votre un mot de passe"> <br>
    
                <input type = "submit" value="Valider">
            </form>
        ';
    }

    public function form_connexion(){
        echo '
            <h2>Connexion</h2>
            <form method = "POST" action = "index.php?action=connexion">
                <label>Login :</label> <br>
                <input type = "text" name= "login" required><br>
    
                <label>Mot de passe :</label><br>
                <input type = "password" name= "mdp" required> <br>
    
                <input type = "submit" value="Connecter">
            </form>
        ';
    }
}

?>