<?php
/*
$_POST["operation"] = "transferer";
$_POST["numCompte"] = "773452398";
$_POST["numDestinataire"] = "774569043";
$_POST["montant"] = "150";
$_POST["code"] = "0000";
*/
    if (isset($_POST["operation"])){
        if ($_POST["operation"] == "accueil"){
            $comptes = getComptes();
            exit(json_encode($comptes));
        }
        else if ($_GET["operation"] == "afficherSolde"){
            $solde = $senMoney->getSolde($_GET["numeroCompte"]);
            exit(json_encode($solde));
        }
        else if ($_POST["operation"] == "transferer"){
            transferer($_POST["numCompte"], $_POST["numDestinataire"], $_POST["montant"], $_POST["code"]);
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
    function getSolde($numCompte){
        $pdo = dbConnect();
        $reponse = $pdo->prepare('SELECT solde FROM comptes WHERE numero = ?');
        $reponse->execute(array($numCompte));
        $solde   = $reponse->fetch();
        return $solde;
    }

    // fonction pour trasnfert
    function transferer ($numCompte, $numDestinataire, $montant, $code){
        
        $pdo = dbConnect();
        $reponse = $pdo->prepare('SELECT code, solde FROM comptes WHERE numero = ?');
        $reponse->execute(array($numCompte));
        $compte = $reponse->fetch();
       
        if ($compte["code"] == $code){
            if ($compte["solde"] >= $montant){
                // traitement tansfert ici
                $req1 = "UPDATE comptes SET solde = solde - :montant WHERE numero = :numCompte";
                $reponse = $pdo->prepare($req1) OR die(print_r($pdo->errorinfo()));
			    $resultat = $reponse->execute(array( 
			        'montant' => $montant,
			        'numCompte' => $numCompte
                ));	

                $req2 = "UPDATE comptes SET solde = solde + :montant WHERE numero = :numDestinataire";
                $reponse = $pdo->prepare($req2) OR die(print_r($pdo->errorinfo()));
			    $resultat = $reponse->execute(array( 
			        'montant' => $montant,
			        'numDestinataire' => $numDestinataire
                ));	

                $req3 = 'INSERT INTO transactions (type, compteDomicile, compteEtranger, montant, date) VALUES ("debit", :compteDomicile, :compteEtranger, :montant, NOW())';
                $reponse = $pdo->prepare($req3) OR die(print_r($pdo->errorinfo()));
			    $resultat = $reponse->execute(array( 
                    'compteDomicile' => $numCompte,
                    'compteEtranger' => $numDestinataire,
			        'montant' => $montant
                ));	

                $req4 = 'INSERT INTO transactions (type, compteDomicile, compteEtranger, montant, date) VALUES ("credit", :compteDomicile, :compteEtranger, :montant, NOW())';
                $reponse = $pdo->prepare($req4) OR die(print_r($pdo->errorinfo()));
			    $resultat = $reponse->execute(array( 
                    'compteDomicile' => $numDestinataire,
                    'compteEtranger' => $numCompte,
			        'montant' => $montant
                ));	

                $notification = array();
                $notification["type"] = "succes";
                $notification["message"] = "Transfert effectué avec succès";
                exit(json_encode($notification));
            }
            else{
                $notification = array();
                $notification["type"] = "echec";
                $notification["message"] = "Montant insuffisant";
                exit(json_encode($notification));
            }
        }
        else{
            $erreur = array();
            $erreur["type"] = "erreur";
            $erreur["message"] = "Mot de passe incorrect";
            exit(json_encode($erreur));
        }
    }
?>
