<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="/css/master.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/script/master.js"></script>
    <title>.</title>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 51.766, lng: 4.440},
          zoom: 12
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAp41bC-pq4-49tDrcpLqAj1LTwRx3HYY4&callback=initMap"
    async defer></script>
    <div class="col-md-12" id="titlescreen">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">Vervoer_Project</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Wie zijn wij?</a></li>
          <li><a href="#">Hoe het werkt</a></li>
          <li><a href="#">Ritprijsopgave</a></li>
          <li><a href="#">Overzicht</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-pencil"></span> Aanmelden</a></li>
        </ul>
      </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <h3 id="demo">Column 1</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
        <div class="col-sm-4 aanmelden noselect">
          <h3 class="title-aanmelden" onclick="switchRegistratie()">Aanmelden als passagier  <span id="passagier-icon" class="glyphicon glyphicon-chevron-down"></h3>
            <form name="frmRegistration" method="post" action="" id="aanmelden-passagier">
              <table border="0" width="500" align="center">
                <?php if(!empty($success_message)) { ?>
                <div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
                <?php } ?>
                <?php if(!empty($error_message)) { ?>
                <div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
                <?php } ?>
                <tr>
                    <td><input type="text" placeholder="Email" class="inputBox" name="userEmail" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>"></td>
                </tr>
                <tr>
                  <td><input type="text" placeholder="Voornaam" class="inputBox" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
                </tr>
                <tr>
                  <td><input type="text" placeholder="Achternaam" class="inputBox" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
                </tr>
                <tr>
                  <td><input type="password" placeholder="Wachtwoord" class="inputBox" name="password" value=""></td>
                </tr>
                <tr>
                  <td><input type="password" placeholder="Bevestig wachtwoord" class="inputBox" name="confirm_password" value=""></td>
                </tr>
                <tr>
                  <td>
                  <input type="radio" name="gender" value="Man" <?php if(isset($_POST['gender']) && $_POST['gender']=="Man") { ?>checked<?php  } ?>> Man
                  <input type="radio" name="gender" value="Vrouw" <?php if(isset($_POST['gender']) && $_POST['gender']=="Vrouw") { ?>checked<?php  } ?>> Vrouw
                  <input type="radio" name="gender" value="Onzijdig" <?php if(isset($_POST['gender']) && $_POST['gender']=="Onzijdig") { ?>checked<?php  } ?>> Onzijdig
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
            <h3 class="title-aanmelden" onclick="switchRegistratie()">Aanmelden als chauffeur  <span id="chauffeur-icon" class="glyphicon glyphicon-chevron-up"></h3>
            <form name="frmRegistration" method="post" action="">
            	<table border="0" width="500" align="center" id="aanmelden-chauffeur">
            		<?php if(!empty($success_message)) { ?>
            		<div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
            		<?php } ?>
            		<?php if(!empty($error_message)) { ?>
            		<div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
            		<?php } ?>
            		<tr>
              			<td><input type="text" placeholder="Email" class="inputBox" name="userEmail" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>"></td>
            		</tr>
            		<tr>
            			<td><input type="text" placeholder="Voornaam" class="inputBox" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
            		</tr>
            		<tr>
            			<td><input type="text" placeholder="Achternaam" class="inputBox" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
            		</tr>
            		<tr>
            			<td><input type="password" placeholder="Wachtwoord" class="inputBox" name="password" value=""></td>
            		</tr>
            		<tr>
            			<td><input type="password" placeholder="Bevestig wachtwoord" class="inputBox" name="confirm_password" value=""></td>
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
                      <option value="1978">1988</option>
                      <option value="1977">1987</option>
                      <option value="1976">1986</option>
                      <option value="1975">1985</option>
                      <option value="1974">1984</option>
                      <option value="1973">1983</option>
                      <option value="1972">1982</option>
                      <option value="1971">1981</option>
                      <option value="1970">1980</option>
                    </select>
                  </td>
                </tr>
            		<tr>
            			<td>
                  <input type="radio" name="gender" value="Man" <?php if(isset($_POST['gender']) && $_POST['gender']=="Man") { ?>checked<?php  } ?>> Man
            			<input type="radio" name="gender" value="Vrouw" <?php if(isset($_POST['gender']) && $_POST['gender']=="Vrouw") { ?>checked<?php  } ?>> Vrouw
                  <input type="radio" name="gender" value="Onzijdig" <?php if(isset($_POST['gender']) && $_POST['gender']=="Onzijdig") { ?>checked<?php  } ?>> Onzijdig
            			</td>
            		</tr>
            		<tr>
            			<td><input type="submit" name="register-user" value="Registreer" class="btnRegister"></td>
            		</tr>
            	</table>
            </form>
        </div>
      </div>
    </div>
    </div>
  </body>
</html>
