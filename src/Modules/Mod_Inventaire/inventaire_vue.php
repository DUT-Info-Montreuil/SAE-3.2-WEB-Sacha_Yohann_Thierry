<?php


class inventaire_vue{
    public function inventaire_affichage(){
        echo '<a href="index.php?action=FormInventaire"> Inventaire </a>';
    }

    public function form_inventaire($produits){
        echo '<h2>Inventaire</h2>';

        foreach ($produits as $produit) {
            echo '
            <div>
                <strong>' . htmlspecialchars($produit['Nom']) . '</strong>
                (Prix : ' . $produit['Prix'] . ')
                <a href="index.php?action=FormInventaire&id='
                . $produit['id'] . '">
                </a>
            </div>
        ';
        }
    }
}

?>