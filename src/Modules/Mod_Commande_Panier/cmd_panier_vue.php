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
        <form method = "POST" action="index.php?module=commande&action=panier&id='.$idbuvette.'">
        <h2 class="border-bottom pb-2 mb-4">Mon panier</h2>';
        if($prixtotal > 0) {
            foreach ($produits as $produit) {
                echo '<div class="col-md-4 mb-3">

                  <h4 class="card-title mb-0">' . htmlspecialchars($produit['nom']) . '</h4>
                  <div class="badge bg-primary rounded-pill">' . number_format($produit['prix'], 2) . ' €</div> 
                  <div class="badge bg-primary rounded-pill">Quantité : ' . $produit['quantite'] . ' </div>
                  </div>
                  ';
            }
        }else{
            echo'rien';
        }
        echo '<h5>Total : '.number_format($prixtotal, 2).'</h5>';
    }

}