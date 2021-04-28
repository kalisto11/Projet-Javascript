<?php
    $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
    $retour = $pdo->query('SELECT numero FROM comptes');
    $comptes = array();
    while ($compte = $retour->fetch()){
        $comptes[] = $compte;
    }
    exit(json_encode($comptes));
?>