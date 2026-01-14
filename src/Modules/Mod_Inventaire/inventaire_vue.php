<?php


class inventaire_vue{
    public function inventaire_affichage(){
        echo '<a href="index.php?action=afficherInventaire"> Inventaire </a>';
    }

    public function form_inventaire($produits){
        echo '<h2>Liste Inventaire</h2>';

        if(empty($produits)) {
            echo "<p>Aucun produits dans l'inventaire.</p>";
            return;
        }

        foreach ($produits as $produit) {
            echo '<div style="border: 1px solid #ccc; margin: 5px; padding: 5px;">
                    <strong>' . $produit['nom'] . '</strong>
                    - Prix : ' . $produit['prix'] . ' €
                    - Quantite : ' . $produit['quantite'] . '
                  </div>';
        }
    }
}

/*

*/