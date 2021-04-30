<?php
    $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
    $retour = $pdo->query('SELECT numero FROM comptes');
    $comptes = array();
    while ($compte = $retour->fetch()){
        $comptes[] =  $compte;
    }
    exit(json_encode($comptes));
    
    class SenMoney{
        public function __construct(){
        
        }

            // fonction pour la connexion à base de données

    class SenMoneyRequest{
        // fonction pour la connexion à base de données
        public static function dbConnect(){
            $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
            return $pdo;
        }

        // fonction pour récupérer la liste des numéros de comptes
        public function getComptes(){
            $pdo = SELF::dbConnect();
            $reponse = $pdo->query('SELECT * FROM comptes');
            $comptes = array();
            while ($compte = $reponse->fetch()){
                $comptes[] =  $compte;
            }
            return $comptes;
        }

        // fonction pour récuperer le solde d'un compte passé en paramètre
        public function getSolde($numCompte){
            $pdo = SELF::dbConnect();
            $reponse = $pdo->prepare('SELECT solde FROM comptes WHERE numero = ?');
            $reponse->execute(array($numCompte));
            $solde   = $reponse->fetch();
            return $solde;
        }

        // fonction pour récuperer le solde d'un compte passé en paramètre
        public function modifierCode($numCompte, $codeActuel, $nouveauCode){
            $notification = array();
            $pdo = SELF::dbConnect();
            $reponse = $pdo->prepare('SELECT code FROM comptes WHERE numero = ?');
            $reponse->execute(array($numCompte));
            $compte = $reponse->fetch();
            if ($compte["code"] == $codeActuel){
                $req = "UPDATE comptes SET code = :nouveauCode WHERE numero = :numCompte";
                $reponse = $pdo->prepare($req) OR die(print_r($pdo->errorinfo()));
                $resultat = $reponse->execute(array( 
                    'nouveauCode' => $nouveauCode,
                    'numCompte' => $numCompte
                ));	
                $notification["type"] = "succes";
                $notification["message"] = "Mot de passe mis à jour avec succès";
            }
            else{
                $notification["type"] = "echec";
                $notification["message"] = "Le mot de passe courant n'est pas correct";
            }
            exit(json_encode($notification));
        }

        // fonction pour trasnfert
        public function transferer($numCompte, $numDestinataire, $montant, $code){
            $notification = array();
            $pdo = SELF::dbConnect();
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

                    $req3 = 'INSERT INTO transactions (type, compteDomicile, compteEtranger, montant, date) VALUES ("Envoi", :compteDomicile, :compteEtranger, :montant, NOW())';
                    $reponse = $pdo->prepare($req3) OR die(print_r($pdo->errorinfo()));
                    $resultat = $reponse->execute(array( 
                        'compteDomicile' => $numCompte,
                        'compteEtranger' => $numDestinataire,
                        'montant' => $montant
                    ));	

                    $req4 = 'INSERT INTO transactions (type, compteDomicile, compteEtranger, montant, date) VALUES ("Reception", :compteDomicile, :compteEtranger, :montant, NOW())';
                    $reponse = $pdo->prepare($req4) OR die(print_r($pdo->errorinfo()));
                    $resultat = $reponse->execute(array( 
                        'compteDomicile' => $numDestinataire,
                        'compteEtranger' => $numCompte,
                        'montant' => $montant
                    ));	

                    $notification["type"] = "succes";
                    $notification["message"] = "Transfert effectué avec succès";
                    exit(json_encode($notification));
                }
                else{
                    $notification["type"] = "echec";
                    $notification["message"] = "Montant insuffisant";
                    exit(json_encode($notification));
                }
            }
            else{
                $notification["type"] = "erreur";
                $notification["message"] = "Mot de passe incorrect";
                exit(json_encode($notification));
            }
        }

        // Permet de récupérer les 5 dernières transactions d'un numéro de compte donné en paramètre
        public function getTransactions($numCompte){
            $pdo = SELF::dbConnect();
            $reponse = $pdo->prepare('SELECT * FROM transactions WHERE compteDomicile = ? ORDER BY date DESC LIMIT 5');
            $reponse->execute(array($numCompte));
            $transactions = array();
            while ($transaction = $reponse->fetch()){
                $transactions[] =  $transaction;
            }
            exit(json_encode($transactions));
        }
    } // fin classe
    
    $request = new SenMoneyRequest();

    if (isset($_POST["operation"])){
        if ($_POST["operation"] == "accueil"){
            $comptes = $request->getComptes();
            exit(json_encode($comptes));
        }
        else if ($_POST["operation"] == "afficherSolde"){
            $solde = $request->getSolde($_POST["numeroCompte"]);
            exit(json_encode($solde));
        }
        else if ($_POST["operation"] == "transferer"){
            $request->transferer($_POST["numCompte"], $_POST["numDestinataire"], $_POST["montant"], $_POST["code"]);
        }
        else if ($_POST["operation"] == "modifierCode"){
            $request->modifierCode($_POST["numCompte"], $_POST["codeActuel"], $_POST["nouveauCode"]);
        }
        else if ($_POST["operation"] == "transactions"){
            $request->getTransactions($_POST["numCompte"]);
        }
    }
   
?>