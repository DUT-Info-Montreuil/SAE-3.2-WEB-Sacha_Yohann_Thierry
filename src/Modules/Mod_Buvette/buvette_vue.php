<?php

class buvette_vue{

    public function __construct(){
    }

   public function choixBuvette($buvettes){
       echo '<div class="text-center mb-4"><h2>Sélectionnez votre Buvette</h2></div>';

       echo '<a href="index.php?module=buvette&action=formAjoutBuvette"
                class="btn btn-custom rounded-pill" style=" background-color:#ffc0cb; color:black; border:none;
                transition: background-color 0.2s ease-in-out;
                " onmouseover="this.style.backgroundColor=\'#e6a6b2\'" onmouseout="this.style.backgroundColor=\'#ffc0cb\'">
                Créer une buvette</a>';

       echo '<a href="index.php?module=fournisseur&action=formFournisseur"
                class="btn btn-custom rounded-pill" style="margin-left: 15px; background-color:#ffc0cb; color:black; border:none;
                transition: background-color 0.2s ease-in-out;
                " onmouseover="this.style.backgroundColor=\'#e6a6b2\'" onmouseout="this.style.backgroundColor=\'#ffc0cb\'">
                Ajouter un fournisseur</a><br><br>';

       echo '<div class="list-group shadow-sm">';
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
       if (!empty($_SESSION['messageAjoutPanier'])){
           echo'
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                '.$_SESSION['messageAjoutPanier'].'
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div> ';
           unset($_SESSION['messageAjoutPanier']);
       }
       if (!empty($_SESSION['messageRetirPanier'])){
           echo'
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.$_SESSION['messageRetirPanier'].'
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div> ';
           unset($_SESSION['messageRetirPanier']);
       }
       ?>
       <script>
       setTimeout(() => {
           const alertNode = document.querySelector('.alert');
           if (alertNode) {
               const alert = new bootstrap.Alert(alertNode);
               alert.close();
           }
       }, 2000);
       </script>
<?php
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
        echo '<a href="index.php?&module=inventaire&id=' . $idInventaire . '"
                class="btn btn-custom rounded-pill" style=" background-color:#ffc0cb; color:black; border:none;
                transition: background-color 0.2s ease-in-out;
                " onmouseover="this.style.backgroundColor=\'#e6a6b2\'" onmouseout="this.style.backgroundColor=\'#ffc0cb\'">
                 Inventaire </a><br>';
    }

    public function titreBienvenue($idCompteEtSolde,$buvette){
        echo '<h2 class="border-bottom pb-2 mb-4">Bienvenue '.$idCompteEtSolde['login'].' 👋<br>
              Vous êtes sur '.$buvette['nom'].'</h2>';
    }

    public function afficherEtRechargerSolde($idCompteEtSolde){
        echo "<p>Votre solde actuel : " . $idCompteEtSolde['solde'] . " €</p>";
        echo '<a href="index.php?module=compte&action=formRecharger&id=' . $idCompteEtSolde['id_compte'] . '"
                class="btn btn-custom rounded-pill" style=" background-color:#ffc0cb; color:black; border:none;
                transition: background-color 0.2s ease-in-out;
                " onmouseover="this.style.backgroundColor=\'#e6a6b2\'" onmouseout="this.style.backgroundColor=\'#ffc0cb\'">
                Recharger mon solde</a><br><br>';
    }

    public function afficherPanier(){
        echo '<a href="index.php?module=panier&action=panier"
                class="btn btn-custom rounded-pill" style=" margin-bottom: 15px; background-color:#ffc0cb; color:black; border:none;
                transition: background-color 0.2s ease-in-out;
                " onmouseover="this.style.backgroundColor=\'#e6a6b2\'" onmouseout="this.style.backgroundColor=\'#ffc0cb\'">
                Voir mon panier</a><br>';
    }

    public function form_ajout_staff($idBuvette){
           echo '
           <div class="row justify-content-center mt-5 mb-5">
               <div class="col-md-8">
                   <div class="card border-danger shadow">
                       <div class="card-header bg-danger text-white">
                           <h5 class="mb-0"> Gestion du Staff</h5>
                       </div>
                       <div class="card-body">
                           <p>Ajouter ou modifier un membre du staff :</p>
                           <form method="POST" action="index.php?module=buvette&action=nommerStaff">
                               <div class="input-group">
                                   <input type="text" name="login_cible" class="form-control" placeholder="Login utilisateur" required>

                                   <select name="role" class="form-select" style="max-width: 150px;">
                                        <option value="barman">Barman</option>
                                        <option value="admin">Admin</option>
                                   </select>

                                   <button class="btn btn-outline-danger" type="submit">Valider</button>
                               </div>
                               <input type="hidden" name="id_buvette" value="'.$idBuvette.'">
                           </form>
                       </div>
                   </div>
               </div>
           </div>';
       }

  public function formAjoutBuvette(){
         echo '
         <div class="row justify-content-center mt-5">
             <div class="col-md-6">
                 <div class="card shadow">
                     <div class="card-header bg-primary text-white">
                         <h4 class="mb-0"> Créer une nouvelle Buvette</h4>
                     </div>
                     <div class="card-body">
                         <form method="POST" action="index.php?module=buvette&action=ajoutBuvette">
                             <div class="mb-3">
                                 <label for="nomBuvette" class="form-label">Nom de la buvette :</label>
                                 <input type="text" class="form-control" name="nomBuvette" placeholder="Ex: Buvette du BDE" required>
                             </div>
                             <div class="d-grid gap-2">
                                 <button type="submit" class="btn btn-success">Valider la création</button>
                                 <a href="index.php?module=buvette&action=choixbuvette" class="btn btn-secondary">Annuler</a>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>';
     }

    public function barre_vendeur($clientServi = null){
        echo '<div class="card bg-dark text-white mb-4 shadow">';
        echo '<div class="card-body d-flex justify-content-between align-items-center">';

        if($clientServi){
            echo '<div>
                    <h4 class="m-0"> Mode Vente</h4>
                    <span>Client actuel : <strong>' . htmlspecialchars($clientServi['login']) . '</strong> (Solde: ' . $clientServi['solde'] . '€)</span>
                  </div>';
            echo '<a href="index.php?module=buvette&action=annulerSelection" class="btn btn-outline-light btn-sm">Changer de client</a>';
        } else {
            echo '<h4 class="m-0 me-3"> Servir un client :</h4>';
            echo '<form method="POST" action="index.php?module=buvette&action=selectionnerClient" class="d-flex">
                    <input type="text" name="login_client" class="form-control me-2" placeholder="Login du client" required>
                    <button type="submit" class="btn btn-primary">Sélectionner</button>
                  </form>';
        }

        echo '</div></div>';
    }
}

?>