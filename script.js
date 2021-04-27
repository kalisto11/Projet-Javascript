(function(){
    var request = null;
    if (request && request.readyState != 0){
        request.abort();
    }

    request = new XMLHttpRequest()
    var url = "senmoney.php"
    request.open("GET", url, true)
   
    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200){
            readData(JSON.parse(request.responseText))
        }
    }
    request.send()
})()

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
