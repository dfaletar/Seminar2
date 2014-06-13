  <?php

    session_start();

    $link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

    mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");
      
    $upit = "SELECT korisnickoIme from korisnici";

    mysql_query("SET CHARACTER SET utf8", $link);

    $result = mysql_query($upit, $link);

    $count = mysql_num_rows($result);

    $user = array();

    for ($i=0; $i <$count ; $i++) { 
      $temp = mysql_result($result, $i);
      $user[$i]=$temp;
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
         <div id="dialog" title="Obavijest" style="display:none">
             <p>Sva polja moraju biti popunjena!</p>
             <p>All fields must be filled!</p>
          </div>
         <form class="prijava" action="regBaza.php" method="post" id="check">
            <table>
              <tr>
                <td><label for="ime">Ime/Name</label></td>
                <td><input type="text" name="ime" class="inpt"></td>
              </tr>
              <tr >
                <td ><label for="prezime">Prezime/Surname:</label></td>
                <td><input type="text" name="prezime" class="inpt user"></td>
              </tr>
              <tr>
                <td><label for="usr">Korisničko ime/Username:</label></td>
                <td><input type="text" name="usr" class="inpt" id="prUsr"></td>
                <td><p id="provjera" >:(</p></td>
              </tr>
              <tr>
                <td><label for="pass">Lozinka/Password:</label></td>
                <td><input type="password" name="pass" id="pr" class="inpt"></td>
                <td><p id="znak">>4</p></td>
              </tr>
            </table>
            <input type="submit" value="Registriraj/Register" id="bttn">
          </form> 
         </div>
       </div>
    </header>
  </body>
</html>


  <script type="text/javascript">
    $('#prUsr').on('input', function() {
      var searchstring = $(this);
      searchstring.focus();
      var tmp = searchstring.val();
      var user = <?php echo json_encode($user); ?>;
      if(jQuery.inArray( tmp, user)!=-1){
        $( "#provjera" ).text( ":(" );
        $('#bttn').attr("disabled", true);
      }else{
        $( "#provjera" ).text( ":)" );
        $('#bttn').attr("disabled", false);
      };
    });
</script>

<script type="text/javascript">
    $('#pr').on('input', function() {
      var string = $(this);
      string.focus();
      var count = string.val().length;
      if(count < 5){
        $( "#znak" ).text( ">4" );
        $('#bttn').attr("disabled", true);
      }else{
        $( "#znak" ).text( "ok" );
        $('#bttn').attr("disabled", false);
      };
    });
</script>

<script type="text/javascript">
  $( "#check" ).submit(function( event ) {
    var ok = true;
     $('.inpt').each(function() 
     {  
         if($(this).val() == "")  
         { 
           $( "#dialog" ).dialog({ position: { my: "center", at: "top", of: window}, resizable: false, draggable: false });
            ok = false;
            event.preventDefault();
         }
     })
          if (ok==true) {
          $(this).parents('form').submit(); 
         }
  });
</script>