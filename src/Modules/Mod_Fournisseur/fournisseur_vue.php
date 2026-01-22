<?php

class fournisseur_vue{
    public function __construct(){

    }

    public function form_ajout_fournisseur($inventaires){
        echo '
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h3>Créer un fournisseur</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?module=fournisseur&action=ajoutFournisseur">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom du fournisseur :</label>
                                    <input type="text" name="nomFournisseur" class="form-control" placeholder="Ex: Jean" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Numéro du fournisseur :</label>
                                    <input type="tel" name="numFournisseur" class="form-control" placeholder="0X XX XX XX XX" required pattern="0[1-9](\s[0-9]{2}){4}" maxlength="14">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                            <label class="form-label">Buvette associée :</label>
                            <select name="id_inventaire" class="form-select" required>
                            <option value="">-- Choisir une buvette --</option>';

        foreach ($inventaires as $inv) {
            echo '<option value="'.$inv['id_inventaire'].'">'.$inv['nom_buvette'].'</option>';
        }
                            echo '
                            </select>
                        </div>
                            <div class="d-grid gap-2">
                                <input type="submit" class="btn btn-success btn-lg" value="Valider le fournisseur">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';

        echo '
            <script>
            document.getElementById("numFournisseur").addEventListener("input", function(e) {
                let value = e.target.value.replace(/\\D/g, "");
                value = value.substring(0, 10);
            
                let formatted = value.match(/.{1,2}/g);
                e.target.value = formatted ? formatted.join(" ") : "";
            });
            </script>';
    }
}