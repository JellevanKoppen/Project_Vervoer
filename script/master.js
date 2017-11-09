function switchRegistratie(){
  var passagier = document.getElementById("aanmelden-passagier");
  var chauffeur = document.getElementById("aanmelden-chauffeur");
  if(passagier.css('display')=='none'){
    passagier.style.display = "block";
  }
}

document.getElementById("passagier-icon").style.transform = "rotate(180deg)";
document.getElementById("aanmelden-chauffeur").style.display = "none";
