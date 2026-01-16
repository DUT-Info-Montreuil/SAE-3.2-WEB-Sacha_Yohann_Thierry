<?php

class compte_vue{
    public function __construct(){

    }
    public function solde(){
        echo "<p>Bonjour " . htmlspecialchars($_SESSION['login']) . " !</p>";
        echo "<p>Votre solde actuel : " . htmlspecialchars($_SESSION['solde']) . " €</p>";
    }

    public function form_recharge_compte(){
        echo '
            <h2>Rechargement</h2>

            <form method="POST" action="index.php?module=compte&action=recharger">
                <label>Montant</label><br>
                <input type="number" id="montantFinal" name="montantFinal" min="1" value="0" onclick="valeurnullpardefaut()" placeholder="0">
            
                <br><br>            
                <button type="button" onclick="ajouter(5)">+5 €</button>
                <button type="button" onclick="ajouter(10)">+10 €</button>
                <button type="button" onclick="ajouter(20)">+20 €</button>
            
                <br><br>
                <button type="button" onclick="retirer(5)">-5 €</button>
                <button type="button" onclick="retirer(10)">-10 €</button>
                <button type="button" onclick="retirer(20)">-20 €</button>
                <br><br>

            
                <input type="submit" value="Ajouter au solde">
            </form>
            
            <script>
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
            </script>

        ';
    }

}