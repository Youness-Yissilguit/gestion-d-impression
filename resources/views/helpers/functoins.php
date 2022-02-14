<?php
    function selectedInput($val1, $val2){
        if ($val1 == $val2){
            echo 'selected';
        }
    };

    function echoLink($source, $id){
        if ($source == 'Tickets'){
            echo 'ticket_'.$id;
        }
        else if ($source == 'imprimante'){
            echo 'imprimante_'.$id;
        }
        else if ($source == 'Contrat'){
            echo 'contrat_'.$id;
        }
        if ($source == 'Fournisseur'){
            echo 'fournisseur_'.$id;
        }
        if ($source == 'Utilisateur'){
            echo 'user_'.$id;
        }
    }
