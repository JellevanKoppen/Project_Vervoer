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
    <title>Aanmelden</title>
  </head>
  <body>
    <?php
    if(isset($_GET['logout'])){
      $_SESSION = array();
      if($_COOKIE[session_name()]){
        setcookie(session_name(), '', time()-42000, '/');
      }
      session_destroy();
      header("Location: index.php");
    }

    if(isset($_SESSION['ID'])){
      if(!isset($_SESSION['Visited'])){
        echo '<body onLoad="referDashboard()">';
      }
      $_SESSION['Visited'] = "true";
      $show = "";
      $dontshow = "style='display: none'";
      $gebruiker = $_SESSION['Naam'];
    } else {
    $show = "style='display: none'";
    $dontshow = "";
    }?>
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
          <li><a href="#">Wie zijn wij?</a></li>
          <li><a href="ritprijs.php">Ritprijsopgave</a></li>
          <li <?php echo $show;?>><a href="#">Overzicht</a></li>
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
        <div class="container">
          <div class="row">
            <div class="col-sm-8">
              <h3>Meld je aan!</h3>
              <p>Vul je gegevens hiernaast in om je aan te melden</p>
            </div>
            <!-- DIT IS HET PHP GEDEELTE  -->
            <?php
            include 'Dbconnect.php';
            $correct = "True";
            $required = array("firstName","lastName","password","userEmail","gender","confirm_password");
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              foreach($required as $field) {
                if(empty($_POST[$field])) {
                $error_message = "Niet alle velden zijn ingevuld";
                header("Refresh:3");
                $correct = "False";
                break;
                }
              }
              if($_POST['password'] != $_POST['confirm_password']){
                $error_message = 'Wachtwoorden zijn niet hetzelfde';
                header("Refresh:3");
                $correct = "False";
              } elseif(!isset($error_message)) {
                if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
                  $error_message = "Geen geldig email addres";
                  header("Refresh:3");
                  $correct = "False";
                }
              } elseif(!isset($error_message)) {
                if(empty($_POST["gender"])) {
                  $error_message = " Kies een geslacht";
                  header("Refresh:3");
                  $correct = "False";
                }
              }
              if(isset($_POST["register-user"])){
                if($correct == "True") {
                $voornaam=$_POST["firstName"];
                $achternaam=$_POST['lastName'];
                $wachtwoord=$_POST['password'];
                $email=$_POST['userEmail'];
                @$geslacht=$_POST['gender'];
                $sql="INSERT INTO vasteklanten (Naam, Achternaam, Wachtwoord, Email, Geslacht) VALUES('".$voornaam."','".$achternaam."','".md5($wachtwoord)."','".$email."','".$geslacht."')";
                $result = mysqli_query($conn, $sql);
                if($result){
                  $error_message = "";
                  $success_message = "U bent succesvol geregistreerd";
                } else {
                    $error_message = "Er is een fout opgetreden: " . mysqli_error($conn);
                  }
                }
              } elseif(isset($_POST["register-chauffeur"])){
                if($correct == "True") {
                $voornaam=$_POST["firstName"];
                $achternaam=$_POST['lastName'];
                $wachtwoord=$_POST['password'];
                $email=$_POST['userEmail'];
                @$geslacht=$_POST['gender'];
                $geboortedatum = $_POST['jaar']."-". $_POST['maand']."-".$_POST['dag'];
                $sql="INSERT INTO chauffeurs (Naam, Achternaam, Geboortedatum, Email, Wachtwoord, Geslacht) VALUES('".$voornaam."','".$achternaam."','".$geboortedatum."','".$email."','".md5($wachtwoord)."','".$geslacht."')";
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

            }
             ?>

            <div class="col-sm-4 aanmelden noselect">
              <?php if(!empty($success_message)) { ?>
              <div class="success-message col-sm-4 col-md-12"><?php if(isset($success_message)) echo $success_message; ?></div>
              <?php } ?>
              <?php if(!empty($error_message)) { ?>
              <div class="error-message col-sm-4 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div>
              <?php } ?>
              <h3 class="title-aanmelden" onclick="switchRegistratie()">Aanmelden als passagier  <span id="passagier-icon" class="glyphicon glyphicon-chevron-down"></h3>
                <form name="frmRegistration" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" id="aanmelden-passagier">
                  <table border="0" width="500" align="center">
                    <tr>
                        <td><input type="text" placeholder="Email" class="inputBox" name="userEmail" value=""></td>
                    </tr>
                    <tr>
                      <td><input type="text" placeholder="Voornaam" class="inputBox" name="firstName"></td>
                    </tr>
                    <tr>
                      <td><input type="text" placeholder="Achternaam" class="inputBox" name="lastName"></td>
                    </tr>
                    <tr>
                      <td><input type="password" placeholder="Wachtwoord" class="inputBox" name="password"></td>
                    </tr>
                    <tr>
                      <td><input type="password" placeholder="Bevestig wachtwoord" class="inputBox" name="confirm_password"></td>
                    </tr>
                    <tr>
                      <td>
                      <input type="radio" name="gender" value="Man"> Man
                      <input type="radio" name="gender" value="Vrouw"> Vrouw
                      <input type="radio" name="gender" value="Onzijdig"> Onzijdig
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <input type="submit" name="register-user" value="Registreer" class="btnRegister"></td>
                    </tr>
                  </table>
                </form>
                <div class="midden">
                <div class="onderbreking"></div><p class="onderbreking-text">of <br /></p><div class="onderbreking"></div>
              </div>
                <h3 class="title-aanmelden" onclick="switchRegistratie()">Aanmelden als chauffeur <span id="chauffeur-icon" class="glyphicon glyphicon-chevron-up"></h3>

                <form name="frmRegistration" method="post" id="aanmelden-chauffeur" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>">
                  <table border="0" width="500" align="center">
                    <tr>
                        <td><input type="text" placeholder="Email" class="inputBox" name="userEmail"></td>
                    </tr>
                    <tr>
                      <td><input type="text" placeholder="Voornaam" class="inputBox" name="firstName"></td>
                    </tr>
                    <tr>
                      <td><input type="text" placeholder="Achternaam" class="inputBox" name="lastName"></td>
                    </tr>
                    <tr>
                      <td><input type="password" placeholder="Wachtwoord" class="inputBox" name="password"></td>
                    </tr>
                    <tr>
                      <td><input type="password" placeholder="Bevestig wachtwoord" class="inputBox" name="confirm_password"></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                      <p>Geboortedatum: </p>
                    </td>
                    </tr>
                    <tr>
                      <td>
                        <select name="dag" id="Birthday_day">
                          <option value="-1">Dag:</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>

                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>

                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>

                          <option value="22">22</option>
                          <option value="23">23</option>
                          <option value="24">24</option>
                          <option value="25">25</option>
                          <option value="26">26</option>
                          <option value="27">27</option>
                          <option value="28">28</option>
                          <option value="29">29</option>
                          <option value="30">30</option>

                          <option value="31">31</option>
                        </select>

                        <select id="Birthday_Month" name="maand">
                          <option value="-1">Maand:</option>
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">Mei</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Okt</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                        </select>

                        <select name="jaar" id="Birthday_Year">

                          <option value="-1">Jaar:</option>
                          <option value="2010">2010</option>
                          <option value="2009">2009</option>
                          <option value="2008">2008</option>
                          <option value="2007">2007</option>
                          <option value="2006">2006</option>
                          <option value="2005">2005</option>
                          <option value="2004">2004</option>
                          <option value="2003">2003</option>
                          <option value="2002">2002</option>
                          <option value="2001">2001</option>
                          <option value="2000">2000</option>

                          <option value="1999">1999</option>
                          <option value="1998">1998</option>
                          <option value="1997">1997</option>
                          <option value="1996">1996</option>
                          <option value="1995">1995</option>
                          <option value="1994">1994</option>
                          <option value="1993">1993</option>
                          <option value="1992">1992</option>
                          <option value="1991">1991</option>
                          <option value="1990">1990</option>

                          <option value="1989">1989</option>
                          <option value="1988">1988</option>
                          <option value="1987">1987</option>
                          <option value="1986">1986</option>
                          <option value="1985">1985</option>
                          <option value="1984">1984</option>
                          <option value="1983">1983</option>
                          <option value="1982">1982</option>
                          <option value="1981">1981</option>
                          <option value="1980">1980</option>

                          <option value="1979">1979</option>
                          <option value="1978">1978</option>
                          <option value="1977">1977</option>
                          <option value="1976">1976</option>
                          <option value="1975">1975</option>
                          <option value="1974">1974</option>
                          <option value="1973">1973</option>
                          <option value="1972">1972</option>
                          <option value="1971">1971</option>
                          <option value="1970">1970</option>

                          <option value="1969">1969</option>
                          <option value="1968">1968</option>
                          <option value="1967">1967</option>
                          <option value="1966">1966</option>
                          <option value="1965">1965</option>
                          <option value="1964">1964</option>
                          <option value="1963">1963</option>
                          <option value="1962">1962</option>
                          <option value="1961">1961</option>
                          <option value="1960">1960</option>

                          <option value="1959">1959</option>
                          <option value="1958">1958</option>
                          <option value="1957">1957</option>
                          <option value="1956">1956</option>
                          <option value="1955">1955</option>
                          <option value="1954">1954</option>
                          <option value="1953">1953</option>
                          <option value="1952">1952</option>
                          <option value="1951">1951</option>
                          <option value="1950">1950</option>

                          <option value="1949">1949</option>
                          <option value="1948">1948</option>
                          <option value="1947">1947</option>
                          <option value="1946">1946</option>
                          <option value="1945">1945</option>
                          <option value="1944">1944</option>
                          <option value="1943">1943</option>
                          <option value="1942">1942</option>
                          <option value="1941">1941</option>
                          <option value="1940">1940</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <input type="radio" name="gender" value="Man"> Man
                      <input type="radio" name="gender" value="Vrouw"> Vrouw
                      <input type="radio" name="gender" value="Onzijdig"> Onzijdig
                      </td>
                    </tr>
                    <tr>
                      <td><input type="submit" name="register-chauffeur" value="Registreer" class="btnRegister"></td>
                    </tr>
                  </table>
                </form>
            </div>
          </div>
        </div>
<div class="footer_page">
  <p class="footer_text">(c) 2018 CSG De Willem van Oranje</p>
</div>
  </body>
</html>
