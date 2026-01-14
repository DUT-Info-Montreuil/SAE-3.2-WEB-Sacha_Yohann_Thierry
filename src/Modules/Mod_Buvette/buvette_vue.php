<?php

class buvette_vue{

    public function __construct(){
    }

    public function choixBuvette($buvettes){
        echo '<h2>Choisissez une buvette</h2>';
        echo '<ul>';
        foreach($buvettes as $buvette){
            echo '<li><a href="details_buvette.php?id=' . $buvette['id'] . '">' . $buvette['nom'] . '</a></li>';
        }
        echo '</ul>';
    }
}

?>