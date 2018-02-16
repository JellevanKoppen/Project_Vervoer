var casus = 1;

function switchRegistratie(){
  var passagier = document.getElementById("aanmelden-passagier");
  var chauffeur = document.getElementById("aanmelden-chauffeur");
  var chauffeuricon = document.getElementById("chauffeur-icon");
  var passagiericon = document.getElementById("passagier-icon");
  if (casus == 0){
    chauffeuricon.style.transform = "rotate(0deg)";
    passagiericon.style.transform = "rotate(0deg)";
    passagier.style.display = "none";
    chauffeur.style.display = "block";
    casus = 1;
  } else if (casus == 1){
    chauffeuricon.style.transform = "rotate(180deg)";
    passagiericon.style.transform = "rotate(180deg)";
    chauffeur.style.display = "none";
    passagier.style.display = "block";
    casus = 0;
  }
}

function popUp(){
  window.alert("Ik ben een melding!");
}

function showKlant(){
  var hide = document.getElementById("hiderG");
  hide.style.display = "block";
}

function showChauffeur(){
  var hide = document.getElementById("hiderG");
  hide.style.display = "block";
}

function referDashboard(){
  if(confirm("Je bent al ingelogt, wil je je overzicht bekijken?")){
    window.location.href = "http://www.dewillem.nu/v6/v6vervoer04/dashboard.php";
  }
  else {
    //Niks
  }
}
