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
    alert("test3")
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
    request.open("GET", url, true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.onreadystatechange = function(){
        
        if (request.readyState == 4 && request.status == 200){
            alert("test1")
            callBack(JSON.parse(request.responseText))
            alert("test2")
        }
    }
    request.send(donnees)
}

// fonction principale appelé si l'utilisateur appuie sur le bouton #221#
function menu(){
  var choix = prompt("\t---MENU SENMONEY---\nTapez le numero du service choisi\n1. Solde de mon compte\n2. Transfert d'argent\n3. Paiement de facture\n4. Options")
  
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
      alert ('Au revoir !')
  }
}  

/**
 * Permet de faire une requete au fichier php pour récupérer le solde du compte de l'utilisateur
 * la fonction est appelée par la fonction menu si l'utilisateur choisit 1.
**/
function afficherSolde(){
   var numCompte = getNumCompteCourant()
    var donnees = "operation=afficherSolde" + "&numeroCompte=" + numCompte
    buildRequest(donnees, notifierSolde)
}

/** Permet d'afficher le solde récupéré par la fonction afficherSolde
* Elle est appelée par la fonction afficherSolde
**/
function notifierSolde(compte){
    choix = confirm("Le solde de votre compte est: " + compte.solde + "\nVoulez-vous retourner au menu ?")
    if (choix){
        menu()
    }
}

// pas encore implémentée
 function transferer(){
    var numCompte = getNumCompteCourant()
    var NumDestinataire = prompt("Tapez le numéro du destinataire")
    var montant = prompt("Tapez le montant à envoyer")
    var code = prompt("Tapez votre code secret")
    var donnees = "operation=transferer" + "&numCompte=" + numCompte + "&numDestinataire=" + NumDestinataire + "&montant=" + montant + "&code=" + code
    buildRequest(donnees, notifierTransfert)
 }

function notifierTransfert(notification){
  var choix = confirm(notification.message)
  if (choix){
      menu()
  }
  else{
      alert("Au revoir !")
  }
}

// pas encore implémentée
 function options(){
    var op = prompt("---OPTION---\n1. Modifier son code secret\n2. Consulter les cinq dernières transactions");
 }

 // Permet de récupérer le numéro du compte sélectionné dans le champ select
 function getNumCompteCourant(){
    var listeOptions =  document.getElementsByTagName("option")
    for (i = 0; i < listeOptions.length; i++){
        if (listeOptions[i].selected == true){
            var numeroCompte = listeOptions[i].textContent
        }
    }
    return numeroCompte
 }

