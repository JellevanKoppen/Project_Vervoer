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
    <title>Contact</title>
  </head>
  <body>
    <script type="text/javascript">
      function meldingContact(){
        alert("Uw bericht is verstuurd. U krijgt zo snel mogelijk een reactie van ons terug!");
      }
    </script>
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
          <li class="active"><a href="contact.php">Contact</a></li>
          <li><a href="about.html">Wie zijn wij?</a></li>
          <li><a href="ritprijs.php">Ritprijsopgave</a></li>
          <li <?php echo $show;?>><a href="dashboard.php">Overzicht</a></li>
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
      <h3>Vragen, opmerkingen, klachten?</h3>
      <p>Stuur ons een bericht:</p>

      <form name="contactform" method="post">
<table>
<tr>
 <td valign="top" class="contact">
  <label for="first_name">Naam</label>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top" class="contact">
  <label for="email">Email Address</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td valign="top" class="contact">
  <label for="comments">Bericht</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input class="btnRegister" type="submit" onclick="meldingContact()" value="Submit">
 </td>
</tr>
</table>
</form>

    </div>
<div class="footer_page">
  <p class="footer_text">(c) 2018 CSG De Willem van Oranje</p>
</div>
  </body>
</html>
