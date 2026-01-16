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

    public function monPanier(){echo'
        <form method = "POST" action="index.php?module=commande&action=panier">
        
        ';

    }

}