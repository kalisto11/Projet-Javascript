<?php
    $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
    $retour = $pdo->query('SELECT numero, code, solde FROM compte');
    $comptes = array();
    while ($compte = $retour->fetch()){
        $comptes[] =  $compte;
    }
    //echo $comptes[0]['numero'];
    exit(json_encode($comptes));
?>