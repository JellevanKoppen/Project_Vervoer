<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/master.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="script/master.js"></script>
    <title>Ritprijsopgave</title>
    </head>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map3 {
        height: 85%;
        min-height: 85%;
        width:100%;
        z-index: 0;
        position: absolute;
        top:50px;
      }
    </style>
  </head>
<?php
  include 'Dbconnect.php';

  if(isset($_GET['logout'])){
    $_SESSION = array();
    if($_COOKIE[session_name()]){
      setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    header("Location: index.php");
  }
  if(isset($_SESSION['ID'])){
    $show = "";
    $dontshow = "style='display: none'";
   $gebruiker = $_SESSION['Naam'];
  } else {
    $show = "style='display: none'";
    $dontshow = "";
  }
?>
  <body>
    <div class="col-md-12" id="titlescreen">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">De Willem Transport</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="about.html">Wie zijn wij?</a></li>
          <li class="active"><a href="ritprijs.php">Ritprijsopgave</a></li>
          <li <?php echo $show?>><a href="dashboard.php">Overzicht</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li style="display: none;"><a href="#"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
          <li <?php echo $dontshow?>><a href="login.php"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
          <li <?php echo $dontshow?>><a href="aanmelden.php"><span class="glyphicon glyphicon-pencil"></span> Aanmelden</a></li>
          <li <?php echo $show?>><a><span class="glyphicon glyphicon-user"></span> Welkom <?php echo $gebruiker;?></a></li>
          <li <?php echo $show?>><a href="dashboard.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> Log uit</a></li>
        </ul>
      </div>
      </div>
    </nav>
  </div>
  <div class=" container row">
  <div class="col-sm-3 col-6 aanmelden noselect">
    <?php if(!empty($success_message)) { ?>
    <div class="success-message col-sm-3 col-md-12"><?php if(isset($success_message)) echo $success_message; ?></div>
    <?php } ?>
    <?php if(!empty($error_message)) { ?>
    <div class="error-message col-sm-3 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div>
    <?php } ?>
    <h3>Ritprijzen</h3>
    <div id="prijzen-panel"></div>
    <p>Vervoersmiddel:</p>
      <select id="vervoersmiddel" onchange="calcRoute()">
        <option value="auto">Auto | 2 tot 5 Pers</option>
        <option value="busje">Busje | 5 tot 8 Pers</option>
      </select>
    <p>Opstap: </p>
      <select id="start" name="opstap" onchange="calcRoute()">
        <option value="51.824454,4.420387">Oud-Beijerland Poortwijk</option>
        <option value="51.818241,4.394979">CSG Dewillem van Oranje</option>
        <option value="-1">----------</option>
        <option value="51.809077,4.345452">Nieuw-Beijerland</option>
        <option value="51.794048,4.316347">Piershil</option>
        <option value="51.793556,4.280886">Goudswaard</option>
        <option value="51.754420,4.316819">Nieuwendijk</option>
        <option value="51.750960,4.366937">Zuid-Beijerland</option>
        <option value="51.738056,4.437549">Numansdorp</option>
        <option value="51.744604,4.553764">Strijen</option>
        <option value="51.714451,4.587206">Strijensas</option>
        <option value="51.823767,4.477460">Heinenoord</option>
        <option value="51.777841,4.616266">'s-Gravendeel</option>
        <option value="51.803431,4.554325">Puttershoek</option>
        <option value="51.792360,4.557118">Maasdam</option>
        <option value="51.789210,4.474168">Westmaas</option>
        <option value="51.800932,4.479705">Mijnsheerenland</option>
        <option value="51.772094,4.449812">Klaaswaal</option>
      </select>
      <p>Bestemming: </p>
      <select id="end" name="uitstap" onchange="calcRoute()">
        <option value="51.818241,4.394979">CSG Dewillem van Oranje</option>
        <option value="-1">----------</option>
        <option value="51.824454,4.420387">Oud-Beijerland Poortwijk</option>
        <option value="51.809077,4.345452">Nieuw-Beijerland</option>
        <option value="51.794048,4.316347">Piershil</option>
        <option value="51.793556,4.280886">Goudswaard</option>
        <option value="51.754420,4.316819">Nieuwendijk</option>
        <option value="51.750960,4.366937">Zuid-Beijerland</option>
        <option value="51.738056,4.437549">Numansdorp</option>
        <option value="51.744604,4.553764">Strijen</option>
        <option value="51.714451,4.587206">Strijensas</option>
        <option value="51.823767,4.477460">Heinenoord</option>
        <option value="51.777841,4.616266">'s-Gravendeel</option>
        <option value="51.803431,4.554325">Puttershoek</option>
        <option value="51.792360,4.557118">Maasdam</option>
        <option value="51.789210,4.474168">Westmaas</option>
        <option value="51.800932,4.479705">Mijnsheerenland</option>
        <option value="51.772094,4.449812">Klaaswaal</option>
      </select>
      <div id="directions-panel"></div>
    </div>
  </div>
    <div id="map3"></div>
    <script>
      var map;
      function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        map = new google.maps.Map(document.getElementById('map3'), {
          center: {lat: 51.766, lng: 4.440},
          zoom: 12,
          styles: [
              {
                  "featureType": "administrative",
                  "elementType": "all",
                  "stylers": [
                      {
                          "saturation": "-100"
                      }]},
              {
                  "featureType": "administrative.province",
                  "elementType": "all",
                  "stylers": [
                      {
                          "visibility": "off"
                      }]},
              {
                  "featureType": "landscape",
                  "elementType": "all",
                  "stylers": [
                      {
                          "saturation": -100
                      },
                      {
                          "lightness": 65
                      },
                      {
                          "visibility": "on"
                      }]},
              {
                  "featureType": "poi",
                  "elementType": "all",
                  "stylers": [
                      {
                          "saturation": -100
                      },
                      {
                          "lightness": "50"
                      },
                      {
                          "visibility": "simplified"
                      }]},
              {
                  "featureType": "road",
                  "elementType": "all",
                  "stylers": [
                      {
                          "saturation": "-100"
                      }]},
              {
                  "featureType": "road.highway",
                  "elementType": "all",
                  "stylers": [
                      {
                          "visibility": "simplified"
                      }]},
              {
                  "featureType": "road.arterial",
                  "elementType": "all",
                  "stylers": [
                      {
                          "lightness": "30"
                      }]},
              {
                  "featureType": "road.local",
                  "elementType": "all",
                  "stylers": [
                      {
                          "lightness": "40"
                      }]},
              {
                  "featureType": "transit",
                  "elementType": "all",
                  "stylers": [
                      {
                          "saturation": -100
                      },
                      {
                          "visibility": "simplified"
                      }]},
              {
                  "featureType": "water",
                  "elementType": "geometry",
                  "stylers": [{
                          "hue": "#ffff00"
                      },
                      {
                          "lightness": -25
                      },
                      {
                          "saturation": -97
                      }]},
              {
                  "featureType": "water",
                  "elementType": "labels",
                  "stylers": [
                      {
                          "lightness": -25
                      },
                      {
                          "saturation": -100
        }]}]});
        directionsDisplay.setMap(map);
      }
      function calcRoute(){
        console.log("Berekenen route...");
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;
        var vervoersmiddel = document.getElementById('vervoersmiddel').value;
        var request = {
          origin:start,
          destination:end,
          travelMode: 'DRIVING'
        };
        directionsService.route(request, function(result, status){
          if(status == "OK") {
            directionsDisplay.setDirections(result);
            var route = result.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            var prijzenPanel = document.getElementById('prijzen-panel');
            if(vervoersmiddel == 'busje'){
              var startprijs = 1.84;
              var minuutprijs = 0.84;
              var kilometerprijs = 0.13;
            } else if (vervoersmiddel == 'auto'){
              var startprijs = 0.91;
              var minuutprijs = 0.67;
              var kilometerprijs = 0.11;
            }
            prijzenPanel.innerHTML = '';
            summaryPanel.innerHTML = '';
            for(var i = 0; i < route.legs.length;i++){
              summaryPanel.innerHTML += '<br>Afstand: ' + route.legs[i].distance.text +  '<br>';
              var afstand = route.legs[i].distance.value; //Afstand in m
              summaryPanel.innerHTML += 'Tijdsduur: ' + route.legs[i].duration.text + '<br>';
              var tijdsduur = route.legs[i].duration.value; //Tijdsduur in seconden
              prijzenPanel.innerHTML += 'Startprijs: €' + startprijs + ',-<br>';
              prijzenPanel.innerHTML += 'Minuutprijs: €' + minuutprijs + ',-<br>';
              prijzenPanel.innerHTML += 'Kilometerprijs: €' + kilometerprijs + ',-<br><br>';
              var prijs = startprijs + (minuutprijs * (tijdsduur/60)) + (kilometerprijs * (afstand/1000));
              prijs = (Math.round(prijs * 100) / 100);
              summaryPanel.innerHTML += 'Prijs: €' + prijs + ',-<br><br>';
            }
          }
          else {
            window.alert("ERROR: "+status);
          }
        })
      }
      </script>
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp41bC-pq4-49tDrcpLqAj1LTwRx3HYY4&callback=initMap"
    async defer></script>
    <!-- API KEY: AIzaSyAp41bC-pq4-49tDrcpLqAj1LTwRx3HYY4 -->
  </body>
</html>
