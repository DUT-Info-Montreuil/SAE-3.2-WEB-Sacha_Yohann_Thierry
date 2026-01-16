<?php

class buvette_vue{

    public function __construct(){
    }

    public function choixBuvette($buvettes){
        echo '<h2>Choisissez une buvette</h2>';
        echo '<ul>';
        foreach($buvettes as $buvette){
            echo '<li><a href="index.php?module=buvette&action=carte&id=' . $buvette['id'] . '">' . $buvette['nom'] . '</a></li>';
        }
        echo '</ul>';

    }

    public function carte($produits){
        echo '<h2>Carte</h2>';

        if(empty($produits)) {
            echo "<p>Aucun produits a la carte.</p>";
            return;
        }

        foreach ($produits as $produit) {
            echo '<div style="border: 1px solid #ccc; margin: 5px; padding: 5px;">
                    <strong>' . $produit['nom'] . '</strong>
                    - Prix : ' . $produit['prix'] . ' €
                  </div>';
        }
        echo '<a href="index.php?module=connexion&action=deconnexion"> Deconnexion </a><br>';
    }

    public function boutonInventaire($idInventaire){
        echo '<a href="index.php?&module=inventaire&id=' . $idInventaire . '"> Inventaire </a>';
    }

    public function afficherEtRechargerSolde($idCompteEtSolde){
        echo'Bonjour '.$_SESSION['login'];
        echo "<p>Votre solde actuel : " . $idCompteEtSolde['solde'] . " €</p>";
        echo '<a href="index.php?module=compte&action=formRecharger&id=' . $_SESSION['id_compte'] . '">Recharger mon solde</a>';
    }
}

?>