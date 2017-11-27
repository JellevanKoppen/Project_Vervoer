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
          <a class="navbar-brand" href="index.php">Vervoer_Project</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Wie zijn wij?</a></li>
          <li><a href="#">Hoe het werkt</a></li>
          <li><a href="#">Ritprijsopgave</a></li>
          <li style="display: none;"><a href="#">Overzicht</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li style="display: none;"><a href="#"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
          <li><a href="login.php"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
          <li><a href="aanmelden.php"><span class="glyphicon glyphicon-pencil"></span> Aanmelden</a></li>
        </ul>
      </div>
      </div>
    </nav>
    <div class="container">
      <div class="col-sm-8">
        <h3>Bereid je voor!</h3>
        <p>Bereid je voor om een nieuwe manier van transport te ontdekken...</p>
        <p>Nadat je hebt ingelogt zal er een nieuwe wereld van transport voor je open gaan. <br />
        Goedkoop, gemakkelijk, snel en veilig! </p>
        <p>Waar wacht je nog op?</p>
        <p>Nieuw hier?</p>
        <a href="aanmelden.php"><button class="btnRegister">Registreren</button></a>
      </div>
      <div class="col-sm-4">
      <h3>Log in</h3>
      <form name="login" method="post" action="">
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
            <td><input type="password" placeholder="Wachtwoord" class="inputBox" name="password" value=""></td>
          </tr>
          <tr>
            <td>
            <input type="submit" name="login_gebruiker" value="Login" class="btnRegister"></td>
          </tr>
        </table>
      </form>
    </div>
    </div>
  </body>
</html>
