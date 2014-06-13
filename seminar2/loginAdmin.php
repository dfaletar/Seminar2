<?php
  session_start();
  if (isset($_SESSION['usr'])) {
   header('Location : admin.php');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0" >
    <title>Login</title>

    <!-- Učitavanje stilskih datoteka -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/grid.css" />
    <link rel="stylesheet" href="css/stil.css" />
    <link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.js"></script>


  </head>
  <body class="login-body">
  	<header class="site">
        <div class="row color">
          <div class="column logo">
            <img src="images/logo1.png" width="400px" height="153px" alt="LOGO">
          </div>
          <div class="column column-12 login">
            <form class="prijava" action="login.php" method="post">
              Korisničko ime:
              <br>
              <input type="text" name="usr"><br><br>
              Lozinka:
              <br>
              <input type="password" name="pass"><br><br>
              <input type="submit" value="Prijava">
            </form> 
            <div id="dialogPrijava" title="Obavijest" style="display:none;">
              <p>Krivo unešena lozinka ili korisnicko ime</p>
            </div>
          </div>
      </div>
    </header>
  </body>
</html>

<?php
  if (isset($_SESSION['krivUnos'])) {
    echo "<script type='text/javascript'>
            $( '#dialogPrijava').dialog();
          </script>";
    unset($_SESSION['krivUnos']);
  }
?>
