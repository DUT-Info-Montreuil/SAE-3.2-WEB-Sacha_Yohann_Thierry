<?php

class compte_vue{
    public function __construct(){

    }
    public function solde(){
        echo '
        <div class="alert alert-primary shadow-sm d-flex justify-content-between align-items-center">
            <span><strong>Utilisateur :</strong> ' . htmlspecialchars($_SESSION['login']) . '</span>
            <h4 class="mb-0 text-dark">Solde : ' . htmlspecialchars($_SESSION['solde']) . ' €</h4>
        </div>';
    }

    public function form_recharge_compte(){
        echo '
        <div class="card shadow mt-4">
            <div class="card-header bg-info text-white"><h3>Recharger mon compte</h3></div>
            <div class="card-body">
                <form method="POST" action="index.php?module=compte&action=recharger">
                    <div class="mb-4">
                        <label class="form-label h5">Montant à ajouter :</label>
                        <div class="input-group input-group-lg">
                            <input type="number" id="montantFinal" name="montantFinal" class="form-control text-center" value="0" readonly>
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

}