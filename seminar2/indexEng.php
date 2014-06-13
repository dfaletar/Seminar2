<?php

  error_reporting(E_ERROR);
  session_start();

  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

   if ($actual_link=='http://localhost/seminar2/indexEng.php') {
      $_SESSION['lang']='eng';
  }else{
      $_SESSION['lang']='hr';
  }

  $link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

  mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");

  mysql_query("SET CHARACTER SET utf8", $link);

  $upit = "SELECT naziv FROM  mjesto";
  $result = mysql_query($upit,$link);
  $count = mysql_num_rows($result);
  $gradovi = array();

  for ($i=0; $i <$count ; $i++) { 
    $grad=mysql_result($result,$i);
    $gradovi[$i]=$grad;
  }
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
      <a href="index.php">HR</a>
      <a href="">ENG</a>
    </div>
    <div>
      <?php 
        if(isset($_SESSION['user'])){
          echo "<table class='logoutUser'>
                  <tr>
                    <td>
                     <p>{$_SESSION['user']}<a href='logoutUser.php'><button>Logout</button></a>
                      <a href='userEng.php'>My reservations</a></p>
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
      <div id="dialogPrijava" title="Obavijest" style="display:none;">
        <p>Incorrect password or username</p>
      </div>
    </div>
  <header class="site-header" id="hotel">
    <img src="images/logo1.png" style="float:left">
  </header>
  <div class="row">
    <nav class="column column-12 main-navigation">
      <ul>
        <li><a href="#skok">Populate beaches</a></li>
        <li><a href="#skok">Culture momoments</a></li>
        <li><a href="#skok">Nightlife</a></li>
        <li><a href="#skok1">Contact us</a></li>
      </ul> 
    </nav>
  </div>
  <section class="intro">
    <div class="row">
      <div class="column column-6 opis"> 
        <p>Every year the Mediterranean Croatia attracts millions of tourists with its beauty, cultural diversity and entertainment activities. It is a land of welcome for all people and cultures. Discover the Mediterranean as it once was, and visit the ancient cities of Split, Dubrovnik, Rovinj, Pula ... Length Adriatic coast without islands is 1,777 kilometers and uljučucjući islands is over 6,000 kilometara.Neka your vacation filled story of ribarma, wine and richness of olive oil . Bring the whole family or friends and explore all the charms Croatian.</p> 
      </div>
      <div class="column column-6 opis">
        <p><img src="images/jadranskoMore.jpg" style="width:450px; height=250px; "></p>  
      </div>
      <div class="column column-12 odabir">
        <form class="odaberi" action="sesija.php" method="post">
          <label for="grad">Town:</label>
          <select name="town">
            <?php for ($i=0; $i <$count ; $i++)  
            echo "<option value='{$gradovi[$i]}'>{$gradovi[$i]}</option>";?>
          </select>
          <label for="izbor">Hotels/apartmans:</label>
          <select name="izbor">
            <option value="apartmani">Apartmans</option>
            <option value="hoteli">Hotels</option>
          </select>
          <input type="submit" value="Choose">
        </form>
      </div>
  	  <div id = "skok"class="row">
        <div class="column column-4 naslov">
      		<h3>Populate beaches<h3>
        </div>
        <div class="column column-4 naslov">
  		    <h3>Culture momoments<h3>
  	    </div>
        <div class="column column-4 naslov">
    		  <h3>Nightlife<h3>
        </div>
      </div>
      <div class="row prijedlog">
        <div class="column column-4 crta">
          <p><img src="images/bacvice.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Bacvice Beach is a cult picigin playing field on which is held every year in water volleyball championship.</p>
          <p><img src="images/banje.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Pebble Beach Banja located near Old Town offers a breathtaking view of the city walls and Lokrum Island.</p>
          <p><img src="images/ambrela.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Ambrela beach is popular pjlažau Pula has a blue flag, with pebbles, with a nice entrance to the sea.</p>
        </div>
        <div class="column column-4 crta">
          <p><img src="images/dioklecian.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Diocletian's Palace is an ancient palace of Emperor Diocletian in Split, under UNESCO protection.</p>
          <p><img src="images/zidine.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Dubrovnik city walls are complex fortifications that surround the old city. Tower Fortress is a fortress in the north wall.</p>
          <p><img src="images/pula_arena.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Pula Arena is the most important monument of cultural and historical heritage of the Roman Empire.</p>
        </div>
        <div class="column column-4 crta">
          <p><img src="images/vanilla.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Vanilla is one of the most popular places to go in Split and often is packed during the summer months, has a large terrace.</p>
          <p><img src="images/fuego.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Latino Club Fuego is a popular nightclub in Dubrovnik. Modern music, affordable prices.</p>
          <p><img src="images/aruba.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Aruba Club in Pula is a favorite place for fun and enjoyment of cultural and entertainment programs.</p>
        </div>
      </div>
    </div>
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

<?php
  if (isset($_SESSION['krivUnos'])) {
    echo "<script type='text/javascript'>
          $( '#dialogPrijava').dialog({ position: { my: 'right top', at: 'right top', of: '#hotel'}, resizable: false, draggable: false });
          </script>";
    unset($_SESSION['krivUnos']);
  }
?>
