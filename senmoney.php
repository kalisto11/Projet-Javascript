<?php
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

            // récupération du code et du solde du compte courant
            $reponse = $pdo->prepare('SELECT code, solde FROM comptes WHERE numero = ?');
            $reponse->execute(array($numCompte));
            $compte = $reponse->fetch();
            
            // Vérification si le code saisi est correct et de la solde du compte
            if ($compte["code"] == $code){
                if ($compte["solde"] >= $montant){

                    // Mis à jour de la solde du compte de l'expediteur
                    $req1 = "UPDATE comptes SET solde = solde - :montant WHERE numero = :numCompte";
                    $reponse = $pdo->prepare($req1) OR die(print_r($pdo->errorinfo()));
                    $resultat = $reponse->execute(array( 
                        'montant' => $montant,
                        'numCompte' => $numCompte
                    ));	

                    // Mis à jour de la solde du compte du destinataire
                    $req2 = "UPDATE comptes SET solde = solde + :montant WHERE numero = :numDestinataire";
                    $reponse = $pdo->prepare($req2) OR die(print_r($pdo->errorinfo()));
                    $resultat = $reponse->execute(array( 
                        'montant' => $montant,
                        'numDestinataire' => $numDestinataire
                    ));	

                    // Enregistrement de la transaction
                    $req3 = 'INSERT INTO transactions (type, compteExpediteur, compteDestinataire, montant, date) VALUES ("Envoi", :compteExpediteur, :compteDestinataire, :montant, NOW())';
                    $reponse = $pdo->prepare($req3) OR die(print_r($pdo->errorinfo()));
                    $resultat = $reponse->execute(array( 
                        'compteExpediteur' => $numCompte,
                        'compteDestinataire' => $numDestinataire,
                        'montant' => $montant
                    ));	

                    $req4 = 'INSERT INTO transactions (type, compteExpediteur, compteDestinataire, montant, date) VALUES ("Reception", :compteExpediteur, :compteDestinataire, :montant, NOW())';
                    $reponse = $pdo->prepare($req4) OR die(print_r($pdo->errorinfo()));
                    $resultat = $reponse->execute(array( 
                        'compteExpediteur' => $numDestinataire,
                        'compteDestinataire' => $numCompte,
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
            $reponse = $pdo->prepare('SELECT * FROM transactions WHERE compteExpediteur = ? ORDER BY date DESC LIMIT 5');
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
        switch ($_POST["operation"]){
            case "accueil":
                $comptes = $request->getComptes();
                exit(json_encode($comptes));
            break;
            
            case "afficherSolde":
                $solde = $request->getSolde($_POST["numeroCompte"]);
                exit(json_encode($solde));
            break;

            case "transferer":
                $request->transferer($_POST["numCompte"], $_POST["numDestinataire"], $_POST["montant"], $_POST["code"]);
            break;

            case "modifierCode":
                $request->modifierCode($_POST["numCompte"], $_POST["codeActuel"], $_POST["nouveauCode"]);
            break;

            case "transactions":
                $request->getTransactions($_POST["numCompte"]);
            break;
            
            default:
            $comptes = $request->getComptes();
        }
    }
   
?>