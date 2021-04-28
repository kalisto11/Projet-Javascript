<?php
    if (isset($_POST["operation"])){
        if ($_POST["operation"] == "accueil"){
            $comptes = getComptes();
            exit(json_encode($comptes));
        }
        else if ($_POST["operation"] == "afficherSolde"){
            $solde = getSolde($_POST["numeroCompte"]);
            exit(json_encode($solde));
        }
    }
   
    // fonction pour la connexion à base de données
    function dbConnect(){
        $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
        return $pdo;
    }

    // fonction pour récupérer la liste des numéros de comptes
    function getComptes(){
        $pdo = dbConnect();
        $retour = $pdo->query('SELECT * FROM comptes');
        $comptes = array();
        while ($compte = $retour->fetch()){
            $comptes[] =  $compte;
        }
        return $comptes;
    }

    // fonction pour récuperer le solde d'un compte passé en paramètre
    function getSolde($numeroCompte){
        $pdo = dbConnect();
        $reponse = $pdo->prepare('SELECT solde FROM comptes WHERE numero = ?');
        $reponse->execute(array($numeroCompte));
        $solde   = $reponse->fetch();
        return $solde;
    }
?>