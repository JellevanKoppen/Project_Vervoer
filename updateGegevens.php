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
    <title>Gegevens updaten</title>
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

        if($_SESSION['Geslacht'] == "Man"){
          $Man = "checked='checked'";
          $Vrouw='';
          $Onzijdig='';
        } else if ($_SESSION['Geslacht'] == "Vrouw"){
          $Vrouw = "checked='checked'";
          $Man='';
          $Onzijdig='';
        } else if ($_SESSION['Geslacht'] == "Onzijdig"){
          $Onzijdig = "checked='checked'";
          $Man='';
          $Vrouw='';
        } else {
          $Man = '';
          $Vrouw = '';
          $Onzijdig = '';
        }
      } else {
        $gebruiker = "- niet ingelogt";
        header("Location: login.php");
      }

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!empty($_POST['firstName'])){
          $_SESSION['Naam'] = $_POST['firstName'];
        }
        if(!empty($_POST['lastName'])){
          $_SESSION['Achternaam'] = $_POST['lastName'];
        }
        if(!empty($_POST['Geslacht'])){
          $_SESSION['Geslacht'] = $_POST['gender'];
        }
        if(!empty($_POST['userEmail'])){
          $_SESSION['Email'] = $_POST['userEmail'];
        }
        if($_SESSION['Type'] == "Klant"){
          $sql="UPDATE vasteklanten SET Naam='".$_SESSION['Naam']."', Achternaam='".$_SESSION['Achternaam']."', Email='".$_SESSION['Email']."', Geslacht='".$_SESSION['Geslacht']."' WHERE vasteklanten.Email = '$savedEmail' AND vasteklanten.Klantid = '$savedID';";
        } else if($_SESSION['Type'] == "Chauffeur"){
          $sql="UPDATE chauffeurs   SET Naam='".$_SESSION['Naam']."', Achternaam='".$_SESSION['Achternaam']."', Email='".$_SESSION['Email']."', Geslacht='".$_SESSION['Geslacht']."' WHERE chauffeurs.Email = '$savedEmail' AND chauffeurs.Chauffeurid = '$savedID';";
      }
      $result = mysqli_query($conn, $sql);
      if($result){
        $error_message = "";
        $succes_message = "Gegevens succesvol bijgewerkt";
        header("Refresh:1;url='dashboard.php'");
      } else {
        $error_message = "Er is een fout opgetreden " . mysqli_error($conn);
        header("Refresh:5");
      }
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
          <li><a href="dashboard.php">Overzicht</a></li>
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
      <div class="col-sm-6 blok aanmelden noselect">
        <h3>Gegevens wijzigen</h3>
        <?php if(!empty($succes_message)){?>
          <div class="succes-message col-sm-6 col-md-12"><?php if(isset($succes_message)) echo $succes_message; ?></div><?php } ?>
        <?php if(!empty($error_message)){?>
          <div class="succes-message col-sm-6 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div> <?php } ?>
        <div class="indent">
          </div>
          <form name="frmRegistration" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <table border="0" align="center">
              <tr>
                <td>Naam:</td>
                <td><input type="text" placeholder="<?php echo $_SESSION['Naam'] ?>" class="inputBox" name="firstName" value=""></td>
              </tr>
              <tr>
                <td>Achternaam:</td>
                <td> <input type="text" placeholder="<?php echo $_SESSION['Achternaam']?>" class="inputBox" name="lastName" value=""> </td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><input type="text" placeholder="<?php echo $_SESSION['Email'] ?>" class="inputBox" name="userEmail" value=""></td>
              </tr>
              <tr>
                <td>Geslacht: </td>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                    <input type="radio" name="gender" value="Man" <?php echo $Man?>> Man
                    <input type="radio" name="gender" value="Vrouw" <?php echo $Vrouw?>> Vrouw
                    <input type="radio" name="gender" value="Onzijdig"<?php echo $Onzijdig?>> Onzijdig
                  </td>
                </tr>
              </tr>
              <tr>
                <td>
                  <input type="submit" name="" value="Wijzig gegevens" class="btnRegister">
                </td>
              </tr>
            </table>
          </form>

          <a href="updatePassword.php">Ik wil mijn wachtwoord wijzigen</a>
        </div>
      </div>
    </div>
    <div class="footer_page">
      <p class="footer_text">(c) 2018 CSG De Willem van Oranje</p>
    </div>
  </body>
</html>
