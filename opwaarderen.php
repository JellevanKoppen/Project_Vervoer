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
    <title>Tegoed opwaarderen</title>
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
      } else {
        $gebruiker = "- niet ingelogt";
        header("Location: login.php");
      }

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $bedrag = $_POST['bedrag'];
        if(empty($_POST['bedrag'])){
          $error_message = "Vul het bedrag in wat je wilt opwaarderen";
          header("Refresh:2");
        } else if($bedrag < 0 OR $bedrag > 10000){
          $error_message = "Bedrag is of te groot of te klein... Probeer opnieuw";
          header("Refresh:2");
        } else {
          $_SESSION['Tegoed'] += $bedrag;
          if($_SESSION['Type'] == "Klant"){
            $sql="UPDATE vasteklanten SET Tegoed='".$_SESSION['Tegoed']."' WHERE vasteklanten.Email = '$savedEmail' AND vasteklanten.Klantid = '$savedID';";
          } else if($_SESSION['Type'] == "Chauffeur"){
            $sql="UPDATE chauffeurs   SET Tegoed='".$_SESSION['Tegoed']."' WHERE chauffeurs.Email = '$savedEmail' AND chauffeurs.Chauffeurid = '$savedID';";
          }
          $result = mysqli_query($conn, $sql);
          if($result){
            $error_message = "";
            $success_message = "Uw tegoed is opgewaardeerd";
            header("Refresh:1;url='dashboard.php'");
          } else {
            $error_message = "Er is een fout opgetreden " . mysqli_error($conn);
            header("Refresh:5");
          }
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
          <a class="navbar-brand" href="index.php">De Willem Transport</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="about.html">Wie zijn wij?</a></li>
          <li><a href="ritprijs.php">Ritprijsopgave</a></li>
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
        <h3>Opwaarderen</h3>
        <?php if(!empty($success_message)) { ?>
        <div class="success-message col-sm-4 col-md-12"><?php if(isset($success_message)) echo $success_message; ?></div>
        <?php } ?>
        <?php if(!empty($error_message)) { ?>
        <div class="error-message col-sm-4 col-md-12"><?php if(isset($error_message)) echo $error_message; ?></div>
        <?php } ?>
        <div class="indent">
          </div>
          <form name="frmRegistration" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <table border="0" width="500" align="center">
              <tr>
                <td>Tegoed:</td>
                <td><input type="number" placeholder="<?php echo $_SESSION['Tegoed'] ?>" class="inputBox noselect" name="bedrag" value=""></td>
              </tr>
              <tr>
                <td>
                  <input type="submit" name="" value="Opwaarderen" class="btnRegister">
                </td>
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
