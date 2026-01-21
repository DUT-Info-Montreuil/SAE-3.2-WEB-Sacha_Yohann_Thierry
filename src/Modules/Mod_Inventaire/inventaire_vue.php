<?php


class inventaire_vue{
    public function inventaire_affichage(){
        echo '<a href="index.php?action=afficherInventaire"> Inventaire </a>';
    }

   public function form_inventaire($produits,$idbuvette){
        echo'
       <form method = "POST" action="index.php?module=buvette&action=carte&id='.$idbuvette.'">
           <button class="btn btn-primary btn-lg rounded-pill">
           Retour
           </button>
       </form><br>';

       echo '<h2 class="mb-4">Gestion de l\'Inventaire</h2>';
       echo '<div class="d-flex justify-content-between align-items-center mb-4">
               <h2> Liste Inventaire</h2>
               <a href="index.php?module=gestion&action=formAjout" class="btn btn-warning">Ajouter un produit</a>
             </div>';
       if(empty($produits)) {
           echo '<div class="alert alert-warning">L\'inventaire est vide.</div>';
           return;
       }
       echo '
       <div class="table-responsive shadow-sm border rounded">
           <table class="table table-striped table-hover mb-0">
               <thead class="table-dark">
                   <tr>
                       <th>Produit</th>
                       <th class="text-center">Prix Unitaire</th>
                       <th class="text-center">Quantité en Stock</th>
                       <th class="text-center">Actions</th>
                   </tr>
               </thead>
               <tbody>';
       foreach ($produits as $produit) {
           $stockClass = ($produit['quantite'] < 5) ? 'table-danger' : '';
           echo '
                   <tr class="'.$stockClass.'">
                       <td class="fw-bold">' . htmlspecialchars($produit['nom']) . '</td>
                       <td class="text-center">' . number_format($produit['prix'], 2) . ' €</td>
                       <td class="text-center">
                           <span class="badge '.($produit['quantite'] > 0 ? 'bg-success' : 'bg-danger').'">
                               ' . $produit['quantite'] . '
                           </span>
                       </td>
                       <td class="text-center">
                           <a href="index.php?module=gestion&action=formModif&id_produit=' . $produit['id'] . '" class="btn btn-sm btn-outline-primary">
                               Modifier
                           </a>
                       </td>
                   </tr>';
       }
       echo '</tbody></table></div>';
   }
}

/*

*/