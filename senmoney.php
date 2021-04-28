<?php
    class SenMoney{
        public function __construct(){
        
        }

            // fonction pour la connexion à base de données
        public static function dbConnect(){
            $pdo = new PDO('mysql:host=localhost; dbname=senmoneydb', 'root', '');
            return $pdo;
        }

        // fonction pour récupérer la liste des numéros de comptes
        public function getComptes(){
            $pdo = SenMoney::dbConnect();
            $retour = $pdo->query('SELECT * FROM comptes');
            $comptes = array();
            while ($compte = $retour->fetch()){
                $comptes[] =  $compte;
            }
            return $comptes;
        }

        // fonction pour récuperer le solde d'un compte passé en paramètre
        public function getSolde($numeroCompte){
            $pdo = SenMoney::dbConnect();
            $reponse = $pdo->prepare('SELECT solde FROM comptes WHERE numero = ?');
            $reponse->execute(array($numeroCompte));
            $solde   = $reponse->fetch();
            return $solde;
        }

    } // fin classe

    $senMoney = new SenMoney();
    if (isset($_GET["operation"])){
        if ($_GET["operation"] == "accueil"){
            $comptes = $senMoney->getComptes();
            echo(json_encode($comptes));
            die();
        }
        else if ($_GET["operation"] == "afficherSolde"){
            $solde = $senMoney->getSolde($_GET["numeroCompte"]);
            exit(json_encode($solde));
        }
        else{
            $comptes = $senMoney->getComptes();
            echo(json_encode($comptes));
            die();
        }
    }
?>
