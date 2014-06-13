<?php

  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }

  $link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

  mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");

  mysql_query("SET CHARACTER SET utf8", $link);

  $upitRez = "SELECT * FROM rezervacija WHERE korisnickoIme = '{$_SESSION['user']}'";
  $resultRez = mysql_query($upitRez,$link);
  $countRez=mysql_num_rows($resultRez);                 

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0" >
    <title>Seminar2</title>

    <!-- Učitavanje stilskih datoteka -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/grid.css" />
    <link rel="stylesheet" href="css/stil.css" />
    <link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.js"></script>
    
  </head>
  <body>
    <div class="ikone">
      <a href="user.php">HR</a>
      <a href="">ENG</a>
    </div>
    <div>
      <?php 
        if(isset($_SESSION['user'])){
          echo "<table class='logoutUser'>
                  <tr>
                    <td>
                      <p>{$_SESSION['user']}<a href='logoutUser.php'><button>Logout</button></a>
                      <a href='user.php'>My reservations</a></p>
                    </td>
                  </tr>
                </table>";
        }else{
          echo "<form action='loginUser.php' method='POST'>
                  <table class='loginUser'>
                    <tr>
                      <td>
                        <input type='text' name='usr' id='usr' placeholder='username'>
                        <input type ='password' name='pass' id='pass' placeholder='password'>
                        <input type='submit' value='Login'>
                        <a href='reg.php'>Registration</a>
                      </td>
                    </tr>
                  </table>
                </form> ";
        }
      ?>
    </div>
    <header class="site-header">
      <img src="images/logo1.png" style="float:left">
    </header>

    <div class="row">
      <nav class="column column-12 main-navigation">
        <ul>
          <li><a href="indexEng.php">Home</a></li>
          <li><a href="#skok1">Contact us</a></li>
          <li><a href="odabirEng.php"><?php echo "{$_SESSION['town']} {$_SESSION['izbor']}";?></a></li>
        </ul> 
      </nav>
    </div>
    <section class="intro">
     <form action="userDel.php" method="post" id="check">
       <table  class="unos2 rez" border="1" style="border-collapse:collapse">
        <tr> 
          <th>  </th>
          <th> id </th> 
          <th> name </th> 
          <th> surname </th> 
          <th> rooms</th> 
          <th> dateReserveOf </th> 
          <th> dateReserveTo </th> 
        </tr> 
          <?php
            for($i=0;$i<$countRez;$i++) 
            { 
              $row=mysql_fetch_array($resultRez); 
              echo "     
                <tr> 
                <td><input type='checkbox' name='{$row['id']}' value='{$row['id']}' class='inpt'></td>
                <td> {$row['id']} </td> 
                <td> {$row['ime']} </td> 
                <td> {$row['prezime']} </td> 
                <td> {$row['brojSoba']} </td>
                <td> {$row['datumBoravkaOd']} </td>
                <td> {$row['datumBoravkaDo']} </td>
               </tr> ";
            } 
          ?>
        </table>
      </form>

      <div id="dialog" title="Obavijest" style="display:none;">
        <p>Nothing marked</p>
      </div>

     <input type="submit" value="Delete" class="userBttn bttn" disabled>

    </section>
    <footer class="site-footer">
      <div id = "skok1" class="row">
        <h2>Contact us<h2>
        <div class="column popis">
          <table>
            <tbody>
              <tr>
                <td align="left" valign="top">
                  <ul>
                    <li><p>Adress: Ulica grada Vukovara 56, 10000 Zagreb</p></li>
                    <li><p>Email: herfal@rezervacije.hr</p></li>
                    <li><p>Telephone: +385 15463343</p></li>
                    <li><p>Mobile: +385 993764938</p></li>
                  </ul>
                </td> 
              </tr> 
            </tbody>
          </table>
        </div>
      </div>
    <!--<p>Copyright &copy; Dino Faletar i Tomislav Herout</p>-->
    </footer>
  </body>
</html>

<script type="text/javascript">
  $( "#check" ).submit(function( event ) {
    var ok = true;
    var count=0;
     $('.inpt').each(function() 
     {  
         if($(this).is(':checked'))
         { 
            count++;
         }
     })
          if (count>0) {
          $(this).parents('form').submit(); 
         }else{
          event.preventDefault();
          $( "#dialog" ).dialog({ resizable: false, draggable: false });
         }
  });
</script>


