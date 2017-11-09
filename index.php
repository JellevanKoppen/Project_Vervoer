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
          <li class="active"><a href="index.html">Home</a></li>
          <li><a href="about.html">about me</a></li>
          <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Projecten <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="project0.html">Project 0 | De Kluis</a></li>
              <li><a href="project1.html">Project 1 | De Lift</a></li>
              <li><a href="#">Project 2 | ...</a></li>
              <li><a href="#">Project 3 | ...</a></li>
            </ul>
          </li>
          <li><a href="http://stud.hro.nl/0934984/bytegroep3/">GroepsSite</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="http://hint.hro.nl"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
          <li><a href="https://outlook.office365.com/owa/?realm=hrnl.onmicrosoft.com&exsvurl=1&ll-cc=1033&modurl=0"><span class="glyphicon glyphicon-pencil"></span> Aanmelden</a></li>
        </ul>
      </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <h3 id="demo">Column 1</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
        <div class="col-sm-4">
          <h3>Column 2</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
        <div class="col-sm-4 aanmelden-chauffeur">
          <h3>Aanmelden als passagier <span class="caret"></h3>
            <form name="frmRegistration" method="post" action="" style="display: none">
              <table border="0" width="500" align="center" class="registratie-table">
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
            <h4>of</h4>
          <h3>Aanmelden als chauffeur</h3>
          <form name="frmRegistration" method="post" action="">
          	<table border="0" width="500" align="center" class="registratie-table">
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
        </div>
      </div>
    </div>
  </body>
</html>
