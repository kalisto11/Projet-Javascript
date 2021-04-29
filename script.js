// fonction anonyme qui se lance au chargement de la page pour récupere la liste des numéros de compte
(function(){
    document.getElementById("bouton221").addEventListener("click", menu)
    var donnees = "operation=accueil"
    buildRequest(donnees, readData)
})()

/**
 * Permet d'insérer la liste des numéros de compte récupéré par la fonction anonyme au chargement de la * page dans le select de la page index.html
 **/
function readData(reponse){
    var listeComptes = document.getElementById("listecomptes")
    for (i= 0; i < reponse.length; i++){
        var opt = document.createElement("option")
        opt.setAttribute("value", reponse[i].numero)
        var text = document.createTextNode(reponse[i].numero)
        opt.appendChild(text)
        listeComptes.appendChild(opt)
    }
} 

/**
 * fonction pour préparer une requete avec l'objet XMLHttpRequest avec des paramètres
 * tels que la fonction de callback et les donnes à envoyer au fichie php en POST
 **/
function buildRequest(donnees, callBack){
    var request = null
    if (request && request.readyState != 0){
        request.abort()
    }
    request = new XMLHttpRequest()
    var url = "senmoney.php"
    request.open("POST", url, true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200){
            callBack(JSON.parse(request.responseText))
        }
    }
    request.send(donnees)
}

// fonction principale appelé si l'utilisateur appuie sur le bouton #221#
function menu(){
  var choix = prompt("---MENU SENMONEY---\nTapez le numero du service choisi\n1. Solde de mon compte\n2. Transfert d'argent\n3. Paiement de facture\n4. Options")
  
  if (choix == 1 ){
    afficherSolde()
  }
  else if (choix == 2 ) {
    transferer()
  }
  else if (choix == 4 ) {
    options()
  }
  else {
      alert ('Choix inconnu')
  }
}  

/**
 * Permet de faire une requete au fichier php pour récupérer le solde du compte de l'utilisateur
 * la fonction esr appelé par la fonction menu si l'utilisateur choisit 1.
**/
function afficherSolde(){
    var listeOptions =  document.getElementsByTagName("option")
    for (i = 0; i < listeOptions.length; i++){
        if (listeOptions[i].selected == true){
            var numeroCompte = listeOptions[i].textContent
        }
    }
    var donnees = "operation=afficherSolde" + "&numeroCompte=" + numeroCompte
    buildRequest(donnees, notifierSolde)
}

// pas encore implémentée
 function transferer(){
     alert ('tranferer solde')
 }

// pas encore implémentée
 function options(){
    var op = prompt("---OPTION---\n1. Modifier son code secret\n2. Consulter les cinq dernières transactions");
 }

 /** Permet d'afficher le solde récupéré par la fonction afficherSolde
 * Elle est appelée par la fonction afficherSolde
 **/
 function notifierSolde(compte){
    alert(compte.solde)
 }