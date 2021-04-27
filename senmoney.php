<?php
    $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
    getComptes();
    if ($_GET['operation']== 1) {
        getSolde($_GET['numeroCompte']);
    } 

   

    function getComptes(){
    $retour = $pdo->query('SELECT numero FROM comptes');
    $comptes = array();
    while ($compte = $retour->fetch()){
        $comptes[] =  $compte;
    }
    //echo $comptes[0]['numero'];
    exit(json_encode($comptes));
}

function getSolde($numero){
    $reponse = $pdo->prepare('SELECT solde FROM comptes WHERE numero = ?');
	$reponse->execute(array($numero));
    $solde   = $reponse->fetch();
    exit(json_encode($solde));
}

?>