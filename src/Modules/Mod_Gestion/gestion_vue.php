<?php
class gestion_vue {

    public function form_ajout_produit(){
        var_dump($_SESSION['idBuvette']);
        echo '
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"> Gestion : Ajouter un produit</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php?module=gestion&action=validerAjout">
                            <div class="mb-3">
                                <label class="form-label">Nom du produit :</label>
                                <input type="text" name="nom" class="form-control" placeholder="Ex: Orangina" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prix (€) :</label>
                                    <input type="number" step="0.01" name="prix" class="form-control" placeholder="0.00" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Quantité initiale :</label>
                                    <input type="number" name="quantite" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?module=inventaire&id=' . (isset($_SESSION['idBuvette']) ? $_SESSION['idBuvette'] : 1) . '" class="btn btn-secondary me-md-2">Annuler</a>
                                <button type="submit" class="btn btn-warning">Ajouter au stock</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }
}
?>