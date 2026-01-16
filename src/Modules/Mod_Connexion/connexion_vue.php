<?php

class connexion_vue{

    public function __construct(){
    }

    public function messageBienvenue(){
        echo '<h1>Bienvenue sur le site</h1>';
    }

    public function menu(){
        if(!isset($_SESSION['login'])){
            echo '<a href="index.php?module=connexion&action=formInscription"> Inscription </a> |';
            echo '<a href="index.php?module=connexion&action=formConnexion"> Connexion </a>';
        } else {
            echo '<a href="index.php?module=connexion&action=deconnexion"> Deconnexion </a><br>';
            echo '<strong>Bienvenue, ' . htmlspecialchars($_SESSION['login']) . '</strong>';
        }
    }

    public function form_inscription(){
        echo '
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h3>Créer un compte</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?action=inscription">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prénom :</label>
                                    <input type="text" name="prenom" class="form-control" placeholder="Ex: Jean" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom :</label>
                                    <input type="text" name="nom" class="form-control" placeholder="Ex: Dupont" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adresse mail :</label>
                                <input type="email" name="email" class="form-control" placeholder="nom@exemple.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Login (pseudonyme) :</label>
                                <input type="text" name="login" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe :</label>
                                <input type="password" name="mdp" class="form-control" required>
                            </div>
                            <div class="d-grid gap-2">
                                <input type="submit" class="btn btn-success btn-lg" value="Valider l\'inscription">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }

    public function form_connexion(){
        echo '
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="mb-0">Connexion</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?action=connexion">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Login :</label>
                                <input type="text" name="login" required class="form-control form-control-lg" placeholder="Votre pseudonyme">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Mot de passe :</label>
                                <input type="password" name="mdp" required class="form-control form-control-lg" placeholder="••••••••">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">Se connecter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }
}

?>