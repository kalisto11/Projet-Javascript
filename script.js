(function(){
    var xhr = null;
    if (xhr && xhr.readyState != 0){
        xhr.abort();
    }
    xhr = new XMLHttpxhr()
    var url = "senmoney.php"
    xhr.open("GET", url, true)
    xhr.onreadystatechange = function(){
        
        if (xhr.readyState == 4 && xhr.status == 200){       
            readData(JSON.parse(xhr.responseText))
        }
    }
    xhr.send()
})()

(function readData(reponse){
    var listeComptes = document.getElementById("listecomptes")
    document.getElementById("bouton221").addEventListener("click", menu)
    var donnees = "operation=accueil"
    buildxhr(donnees, getNumComptes)
})()

/**
 * Permet d'insérer la liste des numéros de compte récupéré par la fonction anonyme au chargement de la * page dans le select de la page index.html
 **/
function getNumComptes(reponse){
    var numeroComptes = document.getElementById("numerocomptes")
    for (i= 0; i < reponse.length; i++){
        var opt = document.createElement("option")
        opt.setAttribute("value", reponse[i].numero)
        var text = document.createTextNode(reponse[i].numero)
        opt.appendChild(text)
        numeroComptes.appendChild(opt)
    }
} 

document.getElementById("bouton221").addEventListener("click", menu)

function menu(){
 var choix =  prompt("---MENU SENMONEY---\nTapez le numero du service choisi\n1. Solde de mon compte\n2. Transfert d'argent\n3. Paiement de facture\n4. Options");
}  



document.getElementById("livreBtn").addEventListener("click", function(e){
    var xhr = null;
    if (xhr && xhr.readyState != 0){
        xhr.abort();
    }

    xhr = new XMLHttpxhr()
    var url = "senmoney.php"
    xhr.open("POST", url, true)
    xhr.setxhrHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4 && xhr.status == 200){
            readData(JSON.parse(xhr.responseText))
            callBack(JSON.parse(xhr.responseText))
        }
    }
    xhr.send()
})

function readData(reponse){
    var listes = ""
    for (i = 0; i < reponse.length; i++){
        listes += "<tr><td>" + reponse[i].titre + "</td><td>" + reponse[i].auteur + "</td><td>" + reponse[i].description + "</td></tr>"
    }

    document.getElementById("livres").innerHTML += listes

}


/*
document.getElementById("submitButton").addEventListener("click", function(e){
    ajaxPost(readData)
})
var xhr = null;

function ajaxPost(callback){
    if (xhr && xhr.readyState != 0){
        xhr.abort();
    }

    xhr = new XMLHttpxhr()
    var url = "senmoney.php"
    var prenom = document.getElementById("prenom").value
    var nom = document.getElementById("nom").value
    var data = "prenom=" + prenom + "&nom=" + nom
    xhr.open("POST", url, true)
    xhr.setxhrHeader("Content-type", "application/x-www-form-urlencoded")
   
    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4 && xhr.status == 200){
            callback(JSON.parse(xhr.responseText))
        }
    }
    xhr.send(data)
}

function readData(reponse){
    var person = reponse.person
    document.getElementById("reponse").innerHTML = person.prenom + " " + person.nom
}
*/

// fonction principale appelé si l'utilisateur appuie sur le bouton #221#
function menu(){
  var choix = prompt("\t---MENU SENMONEY---\nTapez le numero du service choisi\n1. Solde de mon compte\n2. Transfert d'argent\n3. Paiement de facture\n4. Options")
  
  if (choix == 1){
    afficherSolde()
  }
  else if (choix == 2) {
    transferer()
  }
  else if (choix == 4) {
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
    buildxhr(donnees, notifierSolde)
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
    buildxhr(donnees, notifierTransfert)
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
    var choix = prompt("\t---OPTIONS---\n1. Modifier mon code secret\n2. Consulter mes cinq dernières transactions\n3. Retourner au menu principal");
    if (choix == 1){
        modifierCode()
    }
    else if (choix == 2){
        afficherTransactions()
    }
    else if (choix == 3){
        menu()
    }
    else{
        alert("Veuillez choisir un chiffre correct")
        options()
    }
}

// permet de modifier le code de l'utilisateur s'il saisit le bon code
function modifierCode(){
    var numCompte = getNumCompteCourant()
    var codeActuel = prompt("Tapez votre code secret actuel")
    var nouveauCode1 = prompt("Tapez le nouveau code secret")
    var nouveauCode2 = prompt("Confirmer le nouveau code secret")
    if (nouveauCode1 == nouveauCode2){
        var donnees = "operation=modifierCode" + "&numCompte=" + numCompte + "&codeActuel=" + codeActuel + "&nouveauCode=" + nouveauCode1
        buildxhr(donnees, notifierCode)
    }
    else{
        alert("Les mots de passe ne correspondent pas.")
        options()
    }
}
  
function notifierCode(notification){
    if (notification.type == "succes"){
       var choix = confirm("Le code secret a été mis à jour avec succès.\nVoulez-vous retourner au menu ?")
       if (choix){
           menu()
       }
       else{
           alert("Au revoir !")
       }
    }
    else{
       alert("Le code secret courant saisi n'est pas correct")   
       options()      
    }
}

// Permet de faire une requte pour récupérer les 5 dernières transactions
function afficherTransactions(){
    var numCompte = getNumCompteCourant()
    var donnees = "operation=transactions" + "&numCompte=" + numCompte
    buildxhr(donnees, notifierTransactions)
}

// Permet de notifier à l'utilisateur ses 5 dernières transactions
function notifierTransactions(reponse){
    var message = "Numéro\t Type\t\t Montant\t\t Date \n" 
    for (i = 0; i < reponse.length; i++){
        message += reponse[i].numDestinataire + " \t " + reponse[i].type + " \t\t " + reponse[i].montant + " \t\t " + reponse[i].date + "\n"
    }
    choix = confirm(message)
    if (choix){
        menu()
    }
    else{
        alert("Au revoir !")
    }
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
