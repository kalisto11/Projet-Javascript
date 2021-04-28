// fonction anonyme qui se lance au chargement de la page pour récupere la liste des numéros de compte
(function(){
    var request = null;
    if (request && request.readyState != 0){
        request.abort();
    }

    request = new XMLHttpRequest()
    var url = "senmoney.php"
    request.open("GET", url, true)
    var donnees = "operation=accueil"
    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200){
            alert("test1")
            getDonnees(JSON.parse(request.responseText))
            alert("test2")
        }
    }
    request.send(donnees)
})()

function getDonnees(reponse){
    var listeComptes = document.getElementById("listecomptes")
    for (i= 0; i < reponse.length; i++){
        var opt = document.createElement("option")
        opt.setAttribute("value", reponse[i].numero)
        var text = document.createTextNode(reponse[i].numero)
        opt.appendChild(text)
        listeComptes.appendChild(opt)
    }
} 

document.getElementById("bouton221").addEventListener("click", menu)

function menu(){
  var choix = prompt("---MENU SENMONEY---\nTapez le numero du service choisi\n1. Solde de mon compte\n2. Transfert d'argent\n3. Paiement de facture\n4. Options")
  
  if (choix == 1 ){
    demandSolde()
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

 function demandSolde(){
    var request = null
    if (request && request.readyState != 0){
        request.abort()
    }
    request = new XMLHttpRequest()
    var url = "senmoney.php"
    request.open("GET", url, true)

    request.onreadystatechange = function(){
        alert('test')
        if (request.readyState == 4 && request.status == 200){
            afficherSolde(JSON.parse(request.responseText))
        }
    }
    var numeroCompte = 0
    var listOption = document.getElementsByTagName('option')
    for (i = 0; i< listOption.length; i++){
        if ( listOption[i].selected == "selected") {
            numeroCompte = listOption[i].textContent
        }
    } 
    var data = "numeroCompte=" + numeroCompte + "&operation=1"
    request.send(data)
 }
 
 function transferer(){
     alert ('tranferer solde')
 }

 function options(){
    var op = prompt("---OPTION---\n1. Modifier son code secret\n2. Consulter les cinq dernières transactions");
 }

 function afficherSolde(solde){
    alert (solde)
 }






/*
document.getElementById("livreBtn").addEventListener("click", function(e){
    var request = null;
    if (request && request.readyState != 0){
        request.abort();
    }

    request = new XMLHttpRequest()
    var url = "livre.php"
    request.open("GET", url, true)
   
    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200){
            readData(JSON.parse(request.responseText))
        }
    }
    request.send()
})

function readData(reponse){
    var listes = ""
    for (i = 0; i < reponse.length; i++){
        listes += "<tr><td>" + reponse[i].titre + "</td><td>" + reponse[i].auteur + "</td><td>" + reponse[i].description + "</td></tr>"
    }
    alert("test3");
    document.getElementById("livres").innerHTML += listes
    alert("test2");
}
*/

/*
document.getElementById("submitButton").addEventListener("click", function(e){
    ajaxPost(readData)
})
var request = null;

function ajaxPost(callback){
    if (request && request.readyState != 0){
        request.abort();
    }

    request = new XMLHttpRequest()
    var url = "senmoney.php"
    var prenom = document.getElementById("prenom").value
    var nom = document.getElementById("nom").value
    var data = "prenom=" + prenom + "&nom=" + nom
    request.open("POST", url, true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   
    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200){
            callback(JSON.parse(request.responseText))
        }
    }
    request.send(data)
}

function readData(reponse){
    var person = reponse.person
    document.getElementById("reponse").innerHTML = person.prenom + " " + person.nom
}
*/
