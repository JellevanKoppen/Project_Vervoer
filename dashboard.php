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
    <title>Welkom</title>
  </head>
  <body  class="grey_theme">
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
          $sql = "SELECT Chauffeurid, Email FROM chauffeurs AS DB2 WHERE DB2.Email = '$savedEmail' AND DB2.Chauffeurid = '$savedID'";
          $num = mysqli_query($conn, $sql);
          $count = mysqli_num_rows($num);
          $result = mysqli_fetch_assoc($num);

          if($count == 1){
            $_SESSION['Type'] = "Chauffeur";
            $_SESSION['Geslacht'] = $result['Geslacht'];
            $_SESSION['Tegoed'] = $result['Tegoed'];
            if($_SESSION['Tegoed'] == 0){
              $subfix = ",-";
            } else {
              $subfix = "";
            }
            echo '<body onLoad="showChauffeur()">';
          } else {
            echo "Er is een onbekende fout opgetreden";
          }
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
          if($_POST['opstap'] != "-1" OR $_POST['uitstap'] != "-1")){
            $_SESSION['opstap'] = $_POST['opstap']
            $_SESSION['uitstap'] = $_POST['uitstap']
            header("Location: ritprijs.php")
          } else {
            header("Refresh:1");
          }
        }

      } else {
        $gebruiker = "- niet ingelogt";
        header("Refresh:2;url=login.php");
      }

     ?>
    <div class="col-md-12" id="titlescreen">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Vervoer_Project</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="about.html">Wie zijn wij?</a></li>
          <li><a href="#">Hoe het werkt</a></li>
          <li><a href="#">Ritprijsopgave</a></li>
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
      <div id="hiderG" style="display: none;">
        <div class="col-sm-5 blok" style="margin-bottom: 10%;">
          <h3>Gegevens</h3>
          <div class="indent">
            <table>
              <tr>
                <td>Naam:</td>
                <td><?php echo $_SESSION['Naam'] . " " .$_SESSION['Achternaam']?></td>
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
          <h2>Saldo: €<?php echo $_SESSION['Tegoed'] . $subfix?></h2>
          <a href="opwaarderen.php">Opwaarderen?</a>
        </div>
        </div>

        <div class="col-sm-12 row" style="margin-bottom: 10 px;"></div>

        <div class="col-sm-5 blok" style="margin-bottom: 10%;">
          <h3>Boek een rit</h3>
          <div class="indent">
            <form name="boek_rit" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <p>Opstap: </p>
            <select name="opstap">
              <option value="home">CSG Dewillem van Oranje:</option>
              <option value="-1">----------</option>
              <option value="obl">Oud-Beijerland Poortwijk</option>
              <option value="nbl">Nieuw-Beijerland</option>
              <option value="pih">Piershil</option>
              <option value="gwd">Goudswaard</option>
              <option value="nwd">Nieuwendijk</option>
              <option value="zbl">Zuid-Beijerland</option>
              <option value="ndp">Numansdorp</option>
              <option value="str">Strijen</option>
              <option value="sts">Strijensas</option>
              <option value="hno">Heinenoord</option>
              <option value="sgd">'s-Gravendeel</option>
              <option value="pho">Puttershoek</option>
              <option value="msd">Maasdam</option>
              <option value="wms">Westmaas</option>
              <option value="mhl">Mijnsheerenland</option>
              <option value="klw">Klaaswaal</option>
            </select>
            <p>Bestemming: </p>
            <select name="uitstap">
              <option value="home">CSG Dewillem van Oranje:</option>
              <option value="-1">----------</option>
              <option value="obl">Oud-Beijerland Poortwijk</option>
              <option value="nbl">Nieuw-Beijerland</option>
              <option value="pih">Piershil</option>
              <option value="gwd">Goudswaard</option>
              <option value="nwd">Nieuwendijk</option>
              <option value="zbl">Zuid-Beijerland</option>
              <option value="ndp">Numansdorp</option>
              <option value="str">Strijen</option>
              <option value="sts">Strijensas</option>
              <option value="hno">Heinenoord</option>
              <option value="sgd">'s-Gravendeel</option>
              <option value="pho">Puttershoek</option>
              <option value="msd">Maasdam</option>
              <option value="wms">Westmaas</option>
              <option value="mhl">Mijnsheerenland</option>
              <option value="klw">Klaaswaal</option>
            </select>
            <p><br /></p>
            <input type="submit" name="check-prijs" value="Check prijs" class="btnRegister">
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
