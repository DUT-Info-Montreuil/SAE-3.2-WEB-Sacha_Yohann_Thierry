<?php

class buvette_vue{

    public function __construct(){
    }

   public function choixBuvette($buvettes){
       echo '<div class="text-center mb-4"><h2>Sélectionnez votre Buvette</h2></div>';
       echo '<div class="list-group shadow-sm">';
       echo '<a href="index.php?module=buvette&action=formAjoutBuvette">Créer une buvette</a>';
       foreach($buvettes as $buvette){
           echo '<a href="index.php?module=buvette&action=carte&id=' . $buvette['id'] . '"
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                   ' . htmlspecialchars($buvette['nom']) . '
                   <span class="btn btn-sm btn-outline-primary">Voir la carte</span>
                 </a>';
       }
       echo '</div>';
   }

   public function carte($produits){
       echo '<h2 class="border-bottom pb-2 mb-4">Notre Carte</h2>';
       if(empty($produits)) {
           echo '<div class="alert alert-info">Aucun produit disponible pour le moment.</div>';
           return;
       }
       echo '<div class="row">';

       foreach ($produits as $produit) {
           echo '
           <div class="col-md-4 mb-3">
               <div class="card h-100 border-0 shadow-sm">
                   <div class="card-body d-flex align-items-center gap-3">
                       <h5 class="card-title mb-0">' . htmlspecialchars($produit['nom']) .'</h5>
                       <span class="badge bg-primary rounded-pill">' . number_format($produit['prix'], 2) . ' €</span>

                       <form method="POST" action="index.php?module=buvette&action=ajouterProduit" style="display:inline">
                            <input type="hidden" name="id_produit" value="'. $produit['id'] .'">
                            <input type="hidden" name="id_buvette" value="'. $_GET['id'] .'">
                            <button type="submit" class="btn btn-primary rounded-circle border-0 btn-sm"
                                    style="width:32px; height:32px; font-weight:bold;">+</button>
                       </form>   
                        
                       <form method="POST" action="index.php?module=buvette&action=retirerProduit" style="display:inline">
                            <input type="hidden" name="id_produit" value="'. $produit['id'] .'">
                            <input type="hidden" name="id_buvette" value="'. $_GET['id'] .'">
                            <button type="submit" class="btn btn-primary rounded-circle border-0 btn-sm"
                                    style="width:32px; height:32px; font-weight:bold;">-</button>
                       </form>                    
                   </div>
               </div>
           </div>';
       }
       echo '</div>';
   }

    public function boutonInventaire($idInventaire){
        echo '<a href="index.php?&module=inventaire&id=' . $idInventaire . '"> Inventaire </a><br>';
    }

    public function afficherEtRechargerSolde($idCompteEtSolde){
        echo "<p>Votre solde actuel : " . $idCompteEtSolde['solde'] . " €</p>";
        echo '<a href="index.php?module=compte&action=formRecharger&id=' . $idCompteEtSolde['id_compte'] . '">Recharger mon solde</a><br><br>';
    }

    public function afficherPanier(){
        echo '<a href="index.php?module=panier&action=panier">Voir mon panier</a>';
    }

    public function formAjoutBuvette(){
        echo '
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white text-center">
                            <h3>Créer une buvette </h3>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="index.php?module=buvette&action=ajoutBuvette">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nom buvette :</label>
                                        <input type="text" name="nomBuvette" class="form-control" placeholder="Ex: buvette" required>
                                    </div>
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
}

?>