<?php


class cmd_panier_vue{

    public function __construct(){

    }

    public function menu(){
        echo '
            <form method = "POST" action="index.php?module=commande&action=panier">
            </form>
            ';
    }

    public function monPanier($produits,$prixtotal,$idbuvette){echo'
        <form method = "POST" action="index.php?module=buvette&action=carte&id='.$idbuvette.'">
             <button class="btn btn-primary btn-lg rounded-pill">
                Retour
            </button>
        </form><br>

        <h2 class="border-bottom pb-2 mb-4">Mon panier</h2>';

        if($prixtotal <= 0){
            echo'<div class="alert alert-info">Votre panier est vide</div>';
        }
        foreach ($produits as $produit) {
            echo '<div class="col-md-4 mb-3">
            <h4 class="card-title mb-0">' . htmlspecialchars($produit['nom']) . '</h4>
            <div class="badge bg-primary rounded-pill">' . number_format($produit['prix'], 2) . ' €</div>
            <div class="badge bg-primary rounded-pill">Quantité : ' . $produit['quantite'] . ' </div>
            </div>
            ';
        }

        echo '<div class="mt-4 p-3 bg-light border rounded text-end">
            <h5>Total à payer : '.number_format($prixtotal, 2).'€</h5>';

            echo '<form method="POST" action="index.php?module=panier&action=validerCommande">
                    <input type="hidden" name="id_buvette" value="'.$idbuvette.'">
                    <button type="submit" class="btn btn-success btn-lg mt-2">✅ Valider et Payer</button>
                  </form>';
        echo '</div>';

        ;
    }

}