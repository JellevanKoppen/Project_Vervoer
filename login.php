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
    <title>Login</title>
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
          <li><a href="index.php">Home</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="about.html">Wie zijn wij?</a></li>
          <li><a href="#">Hoe het werkt</a></li>
          <li><a href="#">Ritprijsopgave</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li style="display: none;"><a href="#"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
          <li class="active"><a href="login.php"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
          <li><a href="aanmelden.php"><span class="glyphicon glyphicon-pencil"></span> Aanmelden</a></li>
        </ul>
      </div>
      </div>
    </nav>
    <?php
    include 'Dbconnect.php';
    if(isset($_SESSION['ID'])){
      header("refresh:1;url=dashboard.php");
    } else {
    $required = array("userEmail","password");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $correct = "True";
      foreach($required as $field) {
        if(empty($_POST[$field])) {
        $error_message = "Gebruikersnaam en/of Wachtwoord niet ingevuld";
        header("Refresh:3");
        $correct = "False";
        break;
      }

      }
      if($correct == "True"){
        $myusername = mysqli_real_escape_string($conn,$_POST['userEmail']);
        $mypassword = mysqli_real_escape_string($conn,md5($_POST['password']));
        $sql = "SELECT * FROM (SELECT Klantid, Naam, Email,Wachtwoord FROM vasteklanten UNION SELECT Chauffeurid, Naam, Email,Wachtwoord FROM chauffeurs ) AS DB WHERE DB.Email = '$myusername' and DB.Wachtwoord = '$mypassword'";
        $num = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($num);
        $result = mysqli_fetch_assoc($num);

        if($count == 1){
          $error_message = "";
          $gebruikerID = $result['Klantid'];
          $gebruikerEmail = $result['Email'];
          $_SESSION['Naam'] = $result['Naam'];
          $_SESSION['ID'] = $gebruikerID;
          $_SESSION['Email'] = $gebruikerEmail;
          $success_message = "U bent ingelogt!";
          header("Refresh:1;url=dashboard.php");
        } else {
          $error_message = "Geen gebruiker gevonden. Controleer je Email en/of Wachtwoord";
          $succes_message = "";
        }
      }
      }
      }

     ?>
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
        <?php if(!empty($success_message)) { ?>
        <div class="success-message col-sm-4 col-md-12"><?php if(isset($success_message)) echo $success_message; ?></div>
        <?php } ?>
        <?php if(!empty($error_message)) { ?>
        <div class="error-message col-sm-4 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div>
        <?php } ?>
      <h3>Log in</h3>
      <form name="login" method="post" action="">
        <table border="0" width="500" align="center">
          <tr>
              <td><input type="text" placeholder="Email" class="inputBox" name="userEmail" value=""></td>
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
