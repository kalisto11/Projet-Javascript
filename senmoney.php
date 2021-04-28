<?php

    if ($_GET["operation"] == "accueil"){
        getComptes();
    }
    else if ($_GET["operation"] == "getsolde"){
        getSolde($_GET["numerosolde"]);
    }
    else{
        getComptes();
    }
   
   
    // fonction pour la connexion à base de données
    function dbConnct(){
        $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
        return $pdo;
    }

    function getComptes(){
        $pdo = dbConnct();
        $retour = $pdo->query('SELECT numero FROM comptes');
        $comptes = array();
        while ($compte = $retour->fetch()){
            $comptes[] =  $compte;
        }
        exit(json_encode($comptes));
    }

    function getSolde($numero){
        $pdo = dbConnct();
        $reponse = $pdo->prepare('SELECT solde FROM comptes WHERE numero = ?');
        $reponse->execute(array($numero));
        $solde   = $reponse->fetch();
        exit(json_encode($solde));
    }

?>