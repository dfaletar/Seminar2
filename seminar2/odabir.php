<?php

  error_reporting(E_ERROR);
  session_start();

  $gradDec=$_SESSION['town']; 
  $izbor=$_SESSION['izbor'];
  $opisGrada=$_SESSION['opisGrada'];
  $cijena = $_SESSION['cijena'];
  $karakteristike = $_SESSION['karakteristike'];
  $brojHa=$_SESSION['brojHa'];
  $haDec = $_SESSION['ha'];
  $grad = md5($gradDec);
 
  $gradSlika= "images/{$grad}.jpg";

  $slika ="images/{$izbor}/{$grad}/";

  $href = "hotel-apartman.php?n=";

  $ext="*.{gif,jpg,JPG,jpeg,JPEG,png,PNG}"; 
  $files = array(); 
  $curimage=1;
  
	for ($i=1; $i < $brojHa+1; $i++) { 
    $ha[$i]= md5($haDec[$i]);
    $dir = $slika.$ha[$i].'/';
  	$start = strlen($dir);
  	$dir = $dir.$ext;
  	foreach (glob($dir,GLOB_BRACE) as $pathToThumb)
  	{
    	$length = strlen($pathToThumb);
      $pathToThumb = substr($pathToThumb,$start,$length);
      $files[$curimage]=$pathToThumb;
      $curimage++; 
      break;
  	}
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
    <script type="text/javascript">
      $(function(){
        $(".tekst").each(function(){
          len=$(this).text().length;
          if(len>250)
          {
            $(this).text($(this).text().substr(0,250)+'...');
          }
        });       
      });
    </script>
  </head>
  <body>
    <div class="ikone">
      <a href="">HR</a>
      <a href="odabirEng.php">ENG</a>
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
           <p>Krivo unešena lozinka ili korisnicko ime</p>
        </div>
    </div>

    <header class="site-header" id="hotel">
    <img src="images/logo1.png" style="float:left">
    </header>

    <div class="row">
    <nav class="column column-12 main-navigation">
      <ul>
        <li><a href="index.php">Početna</a></li>
        <li><a href="#karta">Karta</a></li>
        <li><a href="#opis">Opis grada</a></li>
        <li><a href="#skok1">Kontakt</a></li>
      </ul> 
    </nav>
     
    <div class = " column colum-12 ha">
      <h1><?php echo "{$gradDec} {$izbor}"?></h1>
      <?php 
    	  $izbor2 = ucfirst($izbor);
        $karakteristika= array();
        for ($i=1; $i < $brojHa+1; $i++) {
          $temp = $karakteristike[$i];
          $karakteristika = explode(";", $temp);
          echo "<div class='column column-12 clanak'> <a href='{$href}{$haDec[$i]}'><img src='{$slika}{$ha[$i]}/{$files[$i]}' style='width:250px; height:220px;  margin: 0 20px;' align='left'> <p class='tekst naslov2'>{$izbor2} {$haDec[$i]}</p>
          <p class='tekst'>Cijena: {$cijena[$i]}kn</p><p>karakteristike:";
          foreach ($karakteristika as $key) {
              echo "<br>-{$key}";
          }
              echo "</p></a></div>";
        }
      ?>
      </div>

      <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"> </script>
      <div id="karta"><div id="map" class="karta" style="width: 940px; height: 500px;"></div></div>

    <div id = "opis" class="slika-grad">
      <div class ="column column-6">
        <img src="<?php echo $gradSlika;?>" style="width:450px; height:400px;">
      </div>
      <div class ="column column-6">
        <p><?php echo $opisGrada; ?></p>
      </div>
    </div>
    </div> 
     
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


<script type="text/javascript"> 
  $( document ).ready(function() {
    var locations = <?php echo json_encode($_SESSION['karta']); ?>;
    var ko1grad = <?php echo json_encode($_SESSION['ko1grad']); ?>;
    var ko2grad = <?php echo json_encode($_SESSION['ko2grad']); ?>;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(ko1grad, ko2grad),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var infowindow = new google.maps.InfoWindow();
    var marker;
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  });
</script>
<?php
  if (isset($_SESSION['krivUnos'])) {
    echo "<script type='text/javascript'>
          $( '#dialogPrijava').dialog({ position: { my: 'right top', at: 'right top', of: '#hotel'}, resizable: false, draggable: false });
          </script>";
    unset($_SESSION['krivUnos']);
  }
?>

