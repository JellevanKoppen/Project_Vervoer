<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/master.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp41bC-pq4-49tDrcpLqAj1LTwRx3HYY4"></script>
    <script src="script/master.js"></script>
    <title>Welkom</title>
  </head>
  <script type="text/javascript">
  function init(start, start2, end, end2) {
    var service = new google.maps.DistanceMatrixService;
    origin = new google.maps.LatLng(start, start2);
    destination = new google.maps.LatLng(end, end2);
    console.log("Start: " + origin + " End: " + destination);
    service.getDistanceMatrix({
      origins: [origin],
      destinations: [destination],
      travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
      if (status !== google.maps.DistanceMatrixStatus.OK){
        alert("Error: " + status);
      } else {
        console.log(response);
        var startprijs = 0.91;
        var minuutprijs = 0.67;
        var kilometerprijs = 0.11;
        var afstand = response.rows[0].elements[0].distance.value; //Afstand in m
        var tijdsduur = response.rows[0].elements[0].duration.value; //Tijdsduur in seconden
        var date = new Date();
        date.setTime(date.getTime()+(30*1000));
        var expires = "; expires="+date.toGMTString();
        document.cookie = "tijdsduur=" + tijdsduur + expires +"; path=/";
        var prijs = startprijs + (minuutprijs * (tijdsduur/60)) + (kilometerprijs * (afstand/1000));
        prijs = (Math.round(prijs * 100) / 100);
        document.cookie = "prijs=" + prijs + expires +"; path=/";
      }
    })
  }
  function deleteCookie(){
    document.cookie = "prijs=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "tijdsduur=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }
  </script>
    <?php
      include 'Dbconnect.php';

      if(isset($_GET['logout'])){
        $_SESSION = array();
        if($_COOKIE[session_name()]){
          setcookie(session_name(), '', time()-42000, '/');
        }
        if(isset($_COOKIE['prijs'])){
          setcookie("prijs","",time()-3600);
          unset($_COOKIE['prijs']);
          echo "<script>";
          echo 'deleteCookie();';
          echo "</script>";
        }
        session_destroy();
        header("Location: index.php");
      }

      if(isset($_SESSION['ID'])){
        $gebruiker = $_SESSION['Naam'];
        $savedEmail = $_SESSION['Email'];
        $savedID = $_SESSION['ID'];

        $sql = "SELECT Klantid, Naam, Achternaam, Email, Geslacht, Tegoed FROM vasteklanten AS DB WHERE DB.Email = '$savedEmail' AND DB.Klantid = '$savedID'";
        $num = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($num);
        $result = mysqli_fetch_assoc($num);

        if($count == 1){
          $_SESSION['Type'] = "Klant";
          $_SESSION['Achternaam'] = $result['Achternaam'];
          $_SESSION['Geslacht'] = $result['Geslacht'];
          $_SESSION['Tegoed'] = $result['Tegoed'];
          if(!is_float($_SESSION['Tegoed'])){
            $subfix = ",-";
          } else {
            $subfix = "";
          }
          echo '<body onLoad="showKlant()">';
        } else {
          $sql = "SELECT Chauffeurid, Naam, Email, Geslacht, Tegoed FROM chauffeurs AS DB2 WHERE DB2.Email = '$savedEmail' AND DB2.Chauffeurid = '$savedID'";
          $num = mysqli_query($conn, $sql);
          $count = mysqli_num_rows($num);
          $result = mysqli_fetch_assoc($num);

          if($count == 1){
            $_SESSION['Type'] = "Chauffeur";
            $_SESSION['Geslacht'] = $result['Geslacht'];
            $_SESSION['Tegoed'] = $result['Tegoed'];
            if(!is_float($_SESSION['Tegoed'])){
              $subfix = ",-";
            } else {
              $subfix = "";
            }
            echo '<body onLoad="showChauffeur()">';
          } else {
            echo "Er is een onbekende fout opgetreden";
          }
        }

        if($_SESSION['Type'] == "Klant"){
          $sql = "SELECT logboek.Ritnr, ritten.Ritnr, Status, Kosten, AantalPassagiers, Datum, Vertrektijd, Aankomsttijd, Opstaplocatie, Uitstaplocatie FROM logboek JOIN ritten ON logboek.Ritnr = ritten.Ritnr WHERE ritten.Klantnr = '$savedID' ";
          $rittenKlant = mysqli_query($conn, $sql);
          $aantalritten = mysqli_num_rows($rittenKlant);
          if($aantalritten > 0){
            $_SESSION['heeft_ritten'] = "ja";
          } else {
            $_SESSION['heeft_ritten'] = "nee";
          }
        }

        if(isset($_COOKIE['prijs'])){
          date_default_timezone_set("Europe/Amsterdam");
          $prijs = $_COOKIE['prijs'];
          $reistijd = $_COOKIE['tijdsduur'];
          $tijd = $_SESSION['tijd'];
          $datetime = new DateTime($tijd);
          $datetime->modify('+'.$reistijd.' seconds');
          $datetime = $datetime->format("H:i");
          $vertrektijd = $_SESSION['datum'] . " " . $datetime;
          $prijs = mysqli_real_escape_string($conn, $prijs);
          $datum = mysqli_real_escape_string($conn,$_SESSION['datum']);
          $tijdstip =  mysqli_real_escape_string($conn,$_SESSION['tijdstip']);
          $opstap =  mysqli_real_escape_string($conn,$_SESSION['opstap']);
          $uitstap = mysqli_real_escape_string($conn,$_SESSION['uitstap']);
          $sql = "INSERT INTO logboek (VerwachteReistijd, Status, Kosten, AantalPassagiers, Datum, Vertrektijd, Aankomsttijd, Opstaplocatie, Uitstaplocatie) VALUES ('$reistijd', 'Wachten op chauffeur', '$prijs', '1', '$datum', '$tijdstip', '$vertrektijd', '$opstap', '$uitstap');";
          $resultaat = mysqli_query($conn, $sql);
          if ($resultaat){
            $error_message = "";
            $success_message = "Rit succesvol aangemaakt!";
            $ritnr = $conn->insert_id;
            $sql = "INSERT INTO ritten (Ritnr, Klantnr) VALUES ('".$ritnr."','".$savedID."')";
              $succes = mysqli_query($conn, $sql);
              if(!$succes){
                $error_message = "Er is een fout opgetreden: " . mysqli_error($conn);
              }
            setcookie("prijs","",time()-3600);
            unset($_COOKIE['prijs']);
            echo "<script>";
            echo 'deleteCookie();';
            echo "</script>";
            header("Refresh:3");
          } else {
              $error_message = "Er is een fout opgetreden: " . mysqli_error($conn);
              setcookie("prijs","",time()-3600);
              unset($_COOKIE['prijs']);
              echo "<script>";
              echo 'deleteCookie();';
              echo "</script>";
              header("Refresh:5");
          }
        }
        if ($_SESSION['Type'] == "Chauffeur"){
          $sql = "SELECT voertuigid, Zitplaatsen, Kenteken, Merk, Kleur FROM voertuigen AS DB WHERE DB.Chauffeurid = '$savedID'";
          $num = mysqli_query($conn, $sql);
          $count = mysqli_num_rows($num);
          if($count >= 1){
            $autolijst = "";
            $autoregistreer = "display: none";
          } else {
            $autolijst = "display: none";
            $autoregistreer = "";
          }
          $sql2 = "SELECT Ritnr, VerwachteReistijd, Status, Kosten, AantalPassagiers, Datum, Vertrektijd, Aankomsttijd, Opstaplocatie, Uitstaplocatie FROM logboek WHERE status = 'Wachten op chauffeur'";
          $num2 = mysqli_query($conn, $sql2);
          if(!$num2){
            echo "Er is een fout opgetreden " . mysqli_error($conn);
          }
        }
        if($_SERVER["REQUEST_METHOD"] == "POST" AND $_SESSION['Type'] == "Klant"){
          //CHECK IF RIT BESTAAT (ZO JA ADD PASSAGIER (ALS MOGELIJK)) ELSE MAAK NIEUWE RIT
          if($_POST['opstap'] != "-1" OR $_POST['uitstap'] != "-1"){
            $datum = $_POST['datum'];
            $tijdstip = $datum . " " . $_POST['tijdstip'];
            $opstap = $_POST['opstap'];
            $uitstap = $_POST['uitstap'];
            $sql = "SELECT Ritnr, AantalPassagiers FROM logboek AS DB WHERE DB.Datum = '$datum' AND DB.Vertrektijd = '$tijdstip' AND DB.Opstaplocatie = '$opstap' AND DB.Uitstaplocatie = '$uitstap'";
            $num = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($num);
            if($count){
              $row = mysqli_fetch_assoc($num);
              $ritnr = $row['Ritnr'];
              $aantpas = intval($row['AantalPassagiers']);
              $aantpas += 1;
              $aantalpassagiers = strval($aantpas);
              $sql = "UPDATE logboek SET AantalPassagiers = '".$aantalpassagiers."' WHERE Ritnr='".$ritnr."'";
              $num = mysqli_query($conn, $sql);
              if($num){
                $error_message = "";
                $success_message = "Je bent toegevoegd aan een bestaande rit";
                $sql = "INSERT INTO ritten (Ritnr, Klantnr) VALUES ('".$ritnr."','".$savedID."')";
              } else {
                $error_message = "Er is een fout opgetreden: " . mysqli_error($conn);
              }
            } else {
              switch ($opstap) {
                case "Poortwijk":
                  $GLOBALS['start'] = "51.824454";
                  $GLOBALS['start2'] = "4.420387";
                  break;
                case "Dewillem":
                  $GLOBALS['start'] = "51.818241";
                  $GLOBALS['start2'] = "4.394979";
                  break;
                case "Nieuw-Beijerland":
                  $GLOBALS['start'] = "51.809077";
                  $GLOBALS['start2'] = "4.345452";
                  break;
                case "Piershil":
                  $GLOBALS['start'] = "51.794048";
                  $GLOBALS['start2'] = "4.316347";
                  break;
                case "Goudswaard":
                  $GLOBALS['start'] = "51.793556";
                  $GLOBALS['start2'] = "4.280886";
                  break;
                case "Nieuwendijk":
                  $GLOBALS['start'] = "51.754420";
                  $GLOBALS['start2'] = "4.316819";
                  break;
                case "Zuid-Beijerland":
                  $GLOBALS['start'] = "51.750960";
                  $GLOBALS['start2'] = "4.366937";
                  break;
                case "Numansdorp":
                  $GLOBALS['start'] = "51.738056";
                  $GLOBALS['start2'] = "4.437549";
                  break;
                case "Strijen":
                  $GLOBALS['start'] = "51.744604";
                  $GLOBALS['start2'] = "4.553764";
                  break;
                case "Strijensas":
                  $GLOBALS['start'] = "51.714451";
                  $GLOBALS['start2'] = "4.587206";
                  break;
                case "Heinenoord":
                  $GLOBALS['start'] = "51.823767";
                  $GLOBALS['start2'] = "4.477460";
                  break;
                case "s-Gravendeel":
                  $GLOBALS['start'] = "51.777841";
                  $GLOBALS['start2'] = "4.616266";
                  break;
                case "Puttershoek":
                  $GLOBALS['start'] = "51.803431";
                  $GLOBALS['start2'] = "4.554325";
                  break;
                case "Maasdam":
                  $GLOBALS['start'] = "51.792360";
                  $GLOBALS['start2'] = "4.557118";
                  break;
                case "Westmaas":
                  $GLOBALS['start'] = "51.789210";
                  $GLOBALS['start2'] = "4.474168";
                  break;
                case "Mijnsheerenland":
                  $GLOBALS['start'] = "51.800932";
                  $GLOBALS['start2'] = "4.479705";
                  break;
                case "Klaaswaal":
                  $GLOBALS['start'] = "51.772094";
                  $GLOBALS['start2'] = "4.449812";
                  break;
                default:
                  break;
              }
              switch ($uitstap) {
                case "Poortwijk":
                  $GLOBALS['end'] = "51.824454";
                  $GLOBALS['end2'] = "4.420387";
                  break;
                case "Dewillem":
                  $GLOBALS['end'] = "51.818241";
                  $GLOBALS['end2'] = "4.394979";
                  break;
                case "Nieuw-Beijerland":
                  $GLOBALS['end'] = "51.809077";
                  $GLOBALS['end2'] = "4.345452";
                  break;
                case "Piershil":
                  $GLOBALS['end'] = "51.794048";
                  $GLOBALS['end2'] = "4.316347";
                  break;
                case "Goudswaard":
                  $GLOBALS['end'] = "51.793556";
                  $GLOBALS['end2'] = "4.280886";
                  break;
                case "Nieuwendijk":
                  $GLOBALS['end'] = "51.754420";
                  $GLOBALS['end2'] = "4.316819";
                  break;
                case "Zuid-Beijerland":
                  $GLOBALS['end'] = "51.750960";
                  $GLOBALS['end2'] = "4.366937";
                  break;
                case "Numansdorp":
                  $GLOBALS['end'] = "51.738056";
                  $GLOBALS['end2'] = "4.437549";
                  break;
                case "Strijen":
                  $GLOBALS['end'] = "51.744604";
                  $GLOBALS['end2'] = "4.553764";
                  break;
                case "Strijensas":
                  $GLOBALS['end'] = "51.714451";
                  $GLOBALS['end2'] = "4.587206";
                  break;
                case "Heinenoord":
                  $GLOBALS['end'] = "51.823767";
                  $GLOBALS['end2'] = "4.477460";
                  break;
                case "s-Gravendeel":
                  $GLOBALS['end'] = "51.777841";
                  $GLOBALS['end2'] = "4.616266";
                  break;
                case "Puttershoek":
                  $GLOBALS['end'] = "51.803431";
                  $GLOBALS['end2'] = "4.554325";
                  break;
                case "Maasdam":
                  $GLOBALS['end'] = "51.792360";
                  $GLOBALS['end2'] = "4.557118";
                  break;
                case "Westmaas":
                  $GLOBALS['end'] = "51.789210";
                  $GLOBALS['end2'] = "4.474168";
                  break;
                case "Mijnsheerenland":
                  $GLOBALS['end'] = "51.800932";
                  $GLOBALS['end2'] = "4.479705";
                  break;
                case "Klaaswaal":
                  $GLOBALS['end'] = "51.772094";
                  $GLOBALS['end2'] = "4.449812";
                  break;
                default:
                  break;
              }
              $_SESSION['start'] = $start;
              $_SESSION['end'] = $end;
              $_SESSION['opstap'] = $opstap;
              $_SESSION['uitstap'] = $uitstap;
              $_SESSION['tijdstip'] = $tijdstip;
              $_SESSION['tijd'] = $_POST['tijdstip'];
              $_SESSION['datum'] = $datum;
              echo "<script>";
              echo 'init('.$start.','. $start2 .','.$end.','. $end2 .');';
              echo "</script>";
              header("Refresh:1");
            }
          } else {
            header("Refresh:1");
          }
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" AND !empty($_POST['boekrit']) AND $_SESSION['Type'] == "Chauffeur"){
          $ritten = $_POST['Ritten'];
          $sql = "UPDATE logboek SET Status='Rit Geaccepteerd', Chauffeurid='$savedID' WHERE Ritnr='$ritten'";
          $result = mysqli_query($conn, $sql);
          if($result){
            $error_message2 = "";
            $success_message2 = "U bent nu chauffeur van deze rit";
            header("Refresh:2");
          } else {
            $error_message2 = "Er is een fout opgetreden: " . mysqli_error($conn);
          }
        } else if($_SERVER["REQUEST_METHOD"] == "POST" AND $_SESSION['Type'] == "Chauffeur"){
          $zitplaatsen = $_POST['Zitplaatsen'];
          $merk = $_POST['Merk'];
          $kleur = $_POST['Kleur'];
          $kenteken = $_POST['Kenteken'];
          if(empty($zitplaatsen) or empty($merk) or empty($kleur) or empty($kenteken)){
            $error_message = "Niet alle velden ingevuld.";
            header("Refresh:3");
          } else if($zitplaatsen < 0 OR $zitplaatsen > 17){
            $error_message = "Aantal zitplaatsen is of te groot of te klein... Probeer opnieuw";
            header("Refresh:3");
          } else {
          $sql = "INSERT INTO voertuigen (Chauffeurid, Zitplaatsen, Kenteken, Kleur, Merk) VALUES('".$savedID."','".$zitplaatsen."','".$kenteken."','".$kleur."','".$merk."')";
          $result = mysqli_query($conn, $sql);
          if($result){
            $error_message = "";
            $success_message = "U bent succesvol geregistreerd";
            header("Refresh:5");
          } else {
              $error_message = "Er is een fout opgetreden: " . mysqli_error($conn);
              header("Refresh:3");
            }
          }
        }
      } else {
        $gebruiker = "- niet ingelogt";
        header("Refresh:2;url=login.php");
      }
  ?>
  <body  class="grey_theme">
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
          <li><a href="ritprijs.php">Ritprijsopgave</a></li>
          <li class="active"><a href="dashboard.php">Overzicht</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li style="display: none;"><a href="#"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
          <li class="active"><a><span class="glyphicon glyphicon-user"></span> Welkom <?php echo $gebruiker;?></a></li>
          <li><a href="dashboard.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> Log uit</a></li>
        </ul>
      </div>
      </div>
    </nav>
    </div>
    <div class="container">
      <div id="GegevensTegoed" style="display: none;">
        <div class="col-sm-5 blok" style="margin-bottom: 10%;">
          <h3>Gegevens <span class="glyphicon glyphicon-book"></span></h3>
          <div class="indent">
            <table>
              <tr>
                <td>Naam:</td>
                <td><?php echo $_SESSION['Naam'] . " " . ((isset($_SESSION['Achternaam']))?$_SESSION['Achternaam']:"")?></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><?php echo $_SESSION['Email'] ?></td>
              </tr>
              <tr>
                <td>Geslacht:</td>
                <td><?php echo $_SESSION['Geslacht'] ?></td>
              </tr>
              <tr>
                <td>Klantnummer:</td>
                <td><?php echo $_SESSION['ID'] ?></td>
              </tr>
              <tr>
                <td> <a href="updateGegevens.php">Gegevens wijzigen?</a></td>
              </tr>
            </table>
          </div>
          </div>
          <div class="col-sm-1"></div>

        <div class="col-sm-5 blok" style="margin-bottom: 10%;">
            <h3>Tegoed <span class="glyphicon glyphicon-piggy-bank"></span></h3>
          <div class="indent">
          <h2>Saldo: €<?php echo $_SESSION['Tegoed'] . $subfix ?></h2>
          <a href="opwaarderen.php">Opwaarderen?</a>
        </div>
        </div>
      </div>
        <div class="col-sm-12 row" style="margin-bottom: 10px;"></div>
      <div id="hiderG" style="display: none; margin-bottom: 10%;">
        <div class="col-sm-5 blok">
          <h3>Boek een rit <span class="glyphicon glyphicon-road"></span></h3>
          <?php if(!empty($success_message)) { ?>
          <div class="success-message col-sm-4 col-md-12"><?php if(isset($success_message)) echo $success_message; ?></div>
          <?php } ?>
          <?php if(!empty($error_message)) { ?>
          <div class="error-message col-sm-4 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div>
          <?php } ?>
          <div class="indent">
            <form name="boek_rit" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <p>Opstap: </p>
            <select name="opstap">
              <option value="Poortwijk">Oud-Beijerland Poortwijk</option>
              <option value="Dewillem">CSG Dewillem van Oranje</option>
              <option value="Nieuw-Beijerland">Nieuw-Beijerland</option>
              <option value="Piershil">Piershil</option>
              <option value="Goudswaard">Goudswaard</option>
              <option value="Nieuwendijk">Nieuwendijk</option>
              <option value="Zuid-Beijerland">Zuid-Beijerland</option>
              <option value="Numansdorp">Numansdorp</option>
              <option value="Strijen">Strijen</option>
              <option value="Strijensas">Strijensas</option>
              <option value="Heinenoord">Heinenoord</option>
              <option value="s-Gravendeel">'s-Gravendeel</option>
              <option value="Puttershoek">Puttershoek</option>
              <option value="Maasdam">Maasdam</option>
              <option value="Westmaas">Westmaas</option>
              <option value="Mijnsheerenland">Mijnsheerenland</option>
              <option value="Klaaswaal">Klaaswaal</option>
            </select>
            <p>Bestemming: </p>
            <select name="uitstap">
              <option value="Dewillem">CSG Dewillem van Oranje</option>
              <option value="-1">----------</option>
              <option value="Poortwijk">Oud-Beijerland Poortwijk</option>
              <option value="Nieuw-Beijerland">Nieuw-Beijerland</option>
              <option value="Piershil">Piershil</option>
              <option value="Goudswaard">Goudswaard</option>
              <option value="Nieuwendijk">Nieuwendijk</option>
              <option value="Zuid-Beijerland">Zuid-Beijerland</option>
              <option value="Numansdorp">Numansdorp</option>
              <option value="Strijen">Strijen</option>
              <option value="Strijensas">Strijensas</option>
              <option value="Heinenoord">Heinenoord</option>
              <option value="s-Gravendeel">'s-Gravendeel</option>
              <option value="Puttershoek">Puttershoek</option>
              <option value="Maasdam">Maasdam</option>
              <option value="Westmaas">Westmaas</option>
              <option value="Mijnsheerenland">Mijnsheerenland</option>
              <option value="Klaaswaal">Klaaswaal</option>
            </select>
            <p>Datum: </p>
            <select name="datum">
              <?php
              date_default_timezone_set("Europe/Amsterdam");
              $datetime = new DateTime('now');
              for ($x = 0; $x < 10; $x++){
                $datetime->modify('+1 day');
                echo "<option value='" . $datetime->format("Y-m-d") . "' >" . $datetime->format("d-m-Y") . "</option>";
              }?>
            </select>
            <p>Vertrektijd: </p>
            <select name="tijdstip">
              <?php
              $datetime = new DateTime('5:00');
              for ($x = 0; $x < 6; $x++){
                $datetime->modify('+2 hours');
                $uur = $datetime->format("H:i");
                echo "<option value='" . $uur . "'>" . $uur . "</option>";
              }?>
            </select>
            <p><br /></p>
            <input type="submit" name="submitRit" value="Boek rit" class="btnRegister">
            </form>
          </div>
        </div>
      <div class="col-sm-1"> </div>
        <div class="col-sm-5 blok">
          <h3>Mijn ritten <span class="glyphicon glyphicon-map-marker"></span></h3>
          <div class="indent">
            <p>Dit is een overzicht van al je geboekte ritten.</p>
            <select id="autoOverzicht" width="50%" name="Voertuigen" onchange="checkValue()">
              <option value="-1">Mijn ritten:</option>
              <?php
              if($_SESSION['heeft_ritten'] == "ja"){
                $x = 0;
                while($klantRitten = mysqli_fetch_assoc($rittenKlant)){
                  $x += 1;
                  $vertrek = substr($klantRitten['Vertrektijd'],0,16);
                  $aankomst = substr($klantRitten['Aankomsttijd'],0,16);
                  $ritnr = $klantRitten['Ritnr'];
                  echo "<option value='" . $ritnr . "' >" . "Kosten: €" . $klantRitten['Kosten'] . " - Status: " . $klantRitten['Status'] . " - Vertrek: " . $vertrek . " - Aankomst: " . $aankomst . " - Opstap: " . $klantRitten['Opstaplocatie'] . " - Uitstap: " . $klantRitten['Uitstaplocatie'] . "</option>";
                }
              } else {
                echo "<option value='-1'>Er zijn geen ritten gevonden</option>";
              }?>
            </select>
          </div>
        </div>
      </div>
      <div id="hiderC" style="display: none;">
        <div class="col-sm-5 blok chauffeur" style="margin-bottom: 10%;"> <!-- Chauffeurid Zitplaatsen Kenteken Kleur Merk -->
          <div id="registreerAuto" style="<?php echo $autoregistreer?>">
          <h3>Registreer een auto <span class="glyphicon glyphicon-list-alt"></span></h3>
          <?php if(!empty($success_message)) { ?>
          <div class="success-message col-sm-4 col-md-12"><?php if(isset($success_message)) echo $success_message; ?></div>
          <?php } ?>
          <?php if(!empty($error_message)) { ?>
          <div class="error-message col-sm-4 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div>
          <?php } ?>
            <div class="indent">
              <form name="registreer-auto" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <table border="0" width="500" align="center">
                  <tr>
                    <td><input type="text" placeholder="Kenteken" class="inputBox" name="Kenteken"></td>
                  </tr>
                  <tr>
                    <td><input type="number" placeholder="Zitplaatsen + chauffeur" class="inputBox noselect" name="Zitplaatsen" value=""></td>
                  </tr>
                  <tr>
                    <td><input type="text" placeholder="Merk" class="inputBox" name="Merk"></td>
                  </tr>
                  <tr>
                    <td><input type="text" placeholder="Kleur" class="inputBox" name="Kleur"></td>
                  </tr>
                </table>
              <p><br /></p>
              <input type="submit" name="registreer-auto" value="Registreer auto" class="btnRegister">
            </form>
          </div>
        </div>
      <div id="autoLijst" style="<?php echo $autolijst?>">
        <h3>Mijn voertuigen <span class="glyphicon glyphicon-list-alt"></span></h3>
        <select id="autoOverzicht" width="50%" name="Voertuigen" onchange="checkValue()">
          <option value="-1">Voertuigen:</option>
          <option value="new">Voeg een nieuwe auto toe</option>
          <?php
          $x = 0;
          while($row = mysqli_fetch_assoc($num)){
            $x += 1;
            echo "<option value='" . $x . "' >" . $row['Merk'] . " - Kenteken: " . $row['Kenteken'] . " - Zitplaatsen: " . $row['Zitplaatsen'] . " - Kleur: " . $row['Kleur'] . "</option>";
          }?>
        </select>
      </div>
      </div>
      <div class="col-sm-1"></div>
      <div style="margin-bottom: 10%;">
        <div class="col-sm-5 blok chauffeur">
          <h3>Beschikbare ritten <span class="glyphicon glyphicon-road"></span></h3>
          <?php if(!empty($success_message2)) { ?>
          <div class="success-message col-sm-4 col-md-12"><?php if(isset($success_message2)) echo $success_message2; ?></div>
          <?php } ?>
          <?php if(!empty($error_message2)) { ?>
          <div class="error-message col-sm-4 col-md-12"><?php if(isset($error_message2)) echo $error_message2; ?></div>
          <?php } ?>
          <form name="boek_rit" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
          <select width="50%" name="Ritten">
            <option value="-1">Beschikbare Ritten:</option>
            <?php
            while($row2 = mysqli_fetch_assoc($num2)){
              $vertrek = substr($row2['Vertrektijd'],0,16);
              $aankomst = substr($row2['Aankomsttijd'],0,16);
              $ritnr = $row2['Ritnr'];
              echo "<option value='" . $ritnr . "' >" . "Vergoeding: €" . $row2['Kosten'] . " - Passagiers: " . $row2['AantalPassagiers'] . " - Vertrek: " . $vertrek . " - Aankomst: " . $aankomst . " - Opstap: " . $row2['Opstaplocatie'] . " - Uitstap: " . $row2['Uitstaplocatie'] . "</option>";
            }?>
          </select>
          <input type="submit" name="boekrit" value="Neem rit aan" class="btnRegister">
        </form>
        </div>
      </div>
    </div>
    </div>
    <div class="footer_page">
      <p class="footer_text">(c) 2018 CSG De Willem van Oranje</p>
    </div>
  </body>
</html>
