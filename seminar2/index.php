<?php
  
  error_reporting(E_ERROR);
  session_start();

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
      <a href="#">HR</a>
      <a href="indexEng.php">ENG</a>
    </div>
    <div>
      <?php 
        if(isset($_SESSION['user'])){
          echo "<table class='logoutUser'>
                  <tr>
                    <td>
                     <p>{$_SESSION['user']}<a href='logoutUser.php'><button>Odjava</button></a>
                      <a href='user.php'>Moje rezervacije</a></p>
                    </td>
                  </tr>
                </table>";
        }else{
          echo "<form action='loginUser.php' method='POST'>
                  <table class='loginUser'>
                    <tr>
                      <td>
                        <input type='text' name='usr' id='usr' placeholder='korisničko ime'>
                        <input type ='password' name='pass' id='pass' placeholder='lozinka'>
                        <input type='submit' value='Prijava'>
                        <a href='reg.php'>Registracija</a>
                      </td>
                    </tr>
                  </table>
                 </form> ";
        }
      ?>
        <div id="dialogPrijava" title="Obavijest" style="display:none;">
           <p>Krivo unešena lozinka ili korisničko ime</p>
        </div>
    </div>
    <header class="site-header" id="hotel">
      <img src="images/logo1.png" style="float:left">
    </header>
    <div class="row">
      <nav class="column column-12 main-navigation">
        <ul>
          <li><a href="#skok">Najljepše plaže</a></li>
          <li><a href="#skok">Spomenici kulture</a></li>
          <li><a href="#skok">Noćni život</a></li>
          <li><a href="#skok1">Kontakt</a></li>
        </ul> 
      </nav>
    </div>
    <section class="intro">
      <div class="row">
        <div class="column column-6 opis"> 
          <p>Svake godine mediteranska Hrvatska privuče milijune turista svojom ljepotom, kulturnom raznolikošću i zabavnim aktivnostima. To je zemlja dobrodošlice za sve ljude i kulture. Otkrijte Mediteran kakav je nekada bio i posjetite drevne gradove: Split, Dubrovnik, Rovinj, Pula... Dužina jadranske obale bez otoka iznosi 1.777 kilometara a uljučucjući otoke iznosi preko 6.000 kilometara.Neka Vaš odmor ispuni priča o ribarma, vinu i bogastvu maslinova ulja. Povedite cijelu obitelj ili prijatelje i istražite sve čari Hrvatske.</p> 
        </div>
        <div class="column column-6 opis">
          <p><img src="images/jadranskoMore.jpg" style="width:450px; height=250px; "></p>  
        </div>
        <div class="column column-12 odabir">
          <form class="odaberi" action="sesija.php" method="post">
            <label for="grad">Grad:</label>
            <select name="town">
              <?php for ($i=0; $i <$count ; $i++)  
                      echo "<option value='{$gradovi[$i]}'>{$gradovi[$i]}</option>";?>
            </select>
            <label for="izbor">Hotel/apartman:</label>
            <select name="izbor">
              <option value="apartmani">Apartman</option>
              <option value="hoteli">Hotel</option>
            </select>
            <input type="submit" value="Odaberi">
          </form>
        </div>
        <div id = "skok"class="row">
          <div class="column column-4 naslov">
    		    <h3>Najljepše plaže<h3>
    	    </div>
          <div class="column column-4 naslov">
      		  <h3>Spomenici kulture<h3>
      	  </div>
          <div class="column column-4 naslov">
    		    <h3>Noćni život<h3>
          </div>
        </div>
        <div class="row prijedlog">
          <div class="column column-4 crta">
            <p><img src="images/bacvice.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Plaža Bačvice je kultno piciginsko igralište na kojemu se svake godine održava prvenstvo u piciginu.</p>
            <p><img src="images/banje.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Šljunčana plaža Banje smještena nedaleko Starog grada nudi prekrasan pogled na zidine i otok Lokrum.</p>
            <p><img src="images/ambrela.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Plaža Ambrela je popularna pjlažau Puli, ima plavu zastavu, šljunčana je, s blagim ulazom u more.</p>
          </div>
          <div class="column column-4 crta">
            <p><img src="images/dioklecian.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Dioklecijanova palača je antička palača cara Dioklecijana u Splitu, pod UNESCO-vom zaštitom.</p>
            <p><img src="images/zidine.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Dubrovačke zidine su sklop utvrda koje okružuju stari dio grada. Kula Minčeta je utvrda na sjeveru zidina.</p>
            <p><img src="images/pula_arena.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Pulska Arena je najznačajniji spomenik kulturno-povijesnog naslijeđa iz doba Rimskog carstva.</p>
          </div>
          <div class="column column-4 crta">
            <p><img src="images/vanilla.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Vanilla je jedno od najpopularnijih mjesta za izlazak u Splitu i često je puno tijekom ljetnih mjeseci, ima veliku terasu.</p>
            <p><img src="images/fuego.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Latino club Fuego je popularan noćni klub u Dubrovniku. Moderna glazba, pristupačne cijene.</p>
            <p><img src="images/aruba.jpg" style="width:130px; height:130px; margin-right:20px;" align="left" >Aruba Club u Puli je omiljeno mjesto za zabavu i uživanje u kulturnim i zabavnim programima.</p>
          </div>
        </div>
      </div>
    </section>
    <footer class="site-footer">
      <div id = "skok1" class="row">
      <h2>Kontakt<h2>
        <div class="column popis">
          <table>
            <tbody>
              <tr>
                <td align="left" valign="top">
                  <ul>
                    <li><p>Adresa: Ulica grada Vukovara 56, 10000 Zagreb</p></li>
                    <li><p>Email: herfal@rezervacije.hr</p></li>
                    <li><p>Telefon: +385 15463343</p></li>
                    <li><p>Mobitel: +385 993764938</p></li>
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
