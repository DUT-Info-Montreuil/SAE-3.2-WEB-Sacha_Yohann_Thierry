<?php

class compte_vue{
    public function __construct(){

    }
    public function solde($compte){
        $solde = $compte['solde'];
        echo '
        <div class="alert alert-primary shadow-sm d-flex justify-content-between align-items-center">
            <span><strong>Utilisateur :</strong> ' . ($_SESSION['login']) . '</span>
            <h4 class="mb-0 text-dark">Solde : ' . $solde . ' €</h4>
        </div>';
    }

    public function form_recharge_compte($idbuvette){
        echo'
        <form method = "POST" action="index.php?module=buvette&action=carte&id='.$idbuvette.'">
         <button class="btn btn-primary btn-lg rounded-pill">
            Retour
        </button>
        </form><br>';

        echo '
        <div class="card shadow mt-4">
            <div class="card-header bg-info text-white"><h3>Recharger mon compte</h3></div>
            <div class="card-body">
                <form method="POST" action="index.php?module=compte&action=recharger">
                    <div class="mb-4">
                        <label class="form-label h5">Montant à ajouter :</label>
                        <div class="input-group input-group-lg">
                            <input type="number" id="montantFinal" name="montantFinal" class="form-control text-center" value="0" oninput="this.value=this.value.replace(/[^0-9]/g,)">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-4"><button type="button" class="btn btn-outline-success w-100" onclick="ajouter(5)">+5 €</button></div>
                        <div class="col-4"><button type="button" class="btn btn-outline-success w-100" onclick="ajouter(10)">+10 €</button></div>
                        <div class="col-4"><button type="button" class="btn btn-outline-success w-100" onclick="ajouter(20)">+20 €</button></div>
                    </div>

                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary btn-lg" value="Confirmer le rechargement">
                    </div>
                </form>
            </div>
        </div>';

        echo '<script>
              function ajouter(valeur) {
                  let champ = document.getElementById("montantFinal");
                  if (champ.value === "") {
                      champ.value = valeur;
                  } else {
                      champ.value = parseInt(champ.value) + valeur;
                  }
              }
              </script>

              <script>
              function retirer(valeur) {
                  let champ = document.getElementById("montantFinal");
                  if (champ.value  <= 0 || parseInt(champ.value) - valeur <= 0) {
                      champ.value = 0;
                  } else {
                      champ.value = parseInt(champ.value) - valeur;
                  }
              }
              </script>

              <script>
                  function valeurnullpardefaut(){
                      let champ = document.getElementById("montantFinal");
                      champ.value = "";
                  }
              </script>';
    }

    public function afficherHistorique($commandes, $total){
        echo '<div class="text-center mb-4"><h2>Votre historique de commandes</h2></div>';
        echo '<div class="list-group shadow-sm">';

        //$total = 0;

        foreach($commandes as $commande){
            echo '<a href="index.php?module=compte&action=detailCommande&id=' . $commande['id_lignecmd'] . '"
                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                ' . $commande['date'] . ' : ' . $commande['prix_total'] . '€, statut : ' . $commande['statut'] . '</br>' . '
                <span class="btn btn-sm btn-outline-primary">Voir le detail de la commande</span>
                </a>';
            //$total += $commande['prix_total'];
        }

        echo '</div>';
        echo '<h4>Total dépensé : ' . $total . '€</h4>';
    }

    public function afficherDetailCommande($details){
        echo '<div class="text-center mb-4"><h2>Detail de la commande</h2></div>';

        foreach($details as $detail){
            $total = $detail['prix']*$detail['quantite'];
            echo '<li>Produit : ' . $detail['nom'] . ' ' .  $detail['prix'] . '€, quantité : ' . $detail['quantite'] . '. Total : ' . $total . '€</li>';
        }

        echo '</div>';
    }
}