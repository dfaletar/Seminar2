<?php

  error_reporting(E_ERROR);
  session_start();

  $opisHa = $_SESSION['opisHa'];
  $gradDec=$_SESSION['town'];
  $izbor=$_SESSION['izbor'];
  $haA=$_SESSION['ha'];
  $brojHa =$_SESSION['brojHa'];
  $karakteristike = $_SESSION['karakteristike'];
  $haDec = $_GET['n'];
  $ha = md5($haDec);
  $grad = md5($gradDec);

  $karakteristika= array();
  for ($i=1; $i < $brojHa+1; $i++) {
    if ($haA[$i]==$haDec){
      $temp = $karakteristike[$i];
      $karakteristika = explode(";", $temp);
      break;
    }
  }

  for ($i=1; $i < $brojHa+1; $i++) {
    if(md5($haA[$i])==$ha){
      $pos = $i-1;
      $opis=$opisHa[$i];
      break;
    }
  }
  
  $ext="*.{gif,jpg,JPG,jpeg,JPEG,png,PNG}"; 
	$files = array(); 
	$curimage=0;
	$slika="images/{$izbor}/{$grad}/{$ha}/";
	$start=strlen($slika);
	$dir=$slika.$ext;
	foreach (glob($dir,GLOB_BRACE) as $pathToThumb){
  	$length = strlen($pathToThumb);
  	$pathToThumb = substr($pathToThumb,$start,$length);
  	$files[$curimage]=$pathToThumb;
    $curimage++; 
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
    <link rel="stylesheet" href="js/slider/jquery.bxslider.css" type="text/css">
    <link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.js"></script>
    <script src="js/slider/jquery.bxslider.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.slike').bxSlider({
          slideWidth: 300,
          minSlides: 3,
          maxSlides: 3,
          moveSlides: 2,
          slideMargin: 10
        });
      });
    </script>
    <script type="text/javascript">
      $(function() {
        var today = new Date();
        $( "#datepicker" ).datepicker({ minDate: 0,dateFormat: 'yy-mm-dd'});
        $( "#datepicker2" ).datepicker({ minDate: 1,dateFormat: 'yy-mm-dd'});
      });
    </script>
    <script type="text/javascript"> 
      function change(url) {
        document.getElementById("img").src=url;
      }
    </script>
  </head>
  <body>
    <div class="ikone">
      <a href="">HR</a>
      <a href="hotel-apartmanEng.php?n=<?php echo $haDec; ?>">ENG</a>
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
          <li><a href="index.php">Početna</a></li>
          <li><a href="odabir.php">Nazad na <?php echo "{$gradDec} {$izbor}"; ?></a></li>
          <li><a href="#skok2">Rezervacija</a></li>
    	    <li><a href="#skok3">Kontakt</a></li>
        </ul> 
      </nav>
      <section class="imageSlide">
        <div class="hoteli">
          <div class="column column-7">
           <img src="<?php echo "{$slika}{$files[0]}"; ?>" style="width:540px; height:300px;" id="img">
          </div>
          <div class="column column-5">
            <p><?php echo $opis; ?></p>
          </div>
        </div>
        <div class="slike"> 
          <?php
            for ($i=0; $i <$curimage ; $i++) { 
              echo "<div class='slide'>
                    <img src='{$slika}{$files[$i]}' onclick='change(\"{$slika}{$files[$i]}\")' style='width:300px; height:200px;' >
                    </div>";
            }
          ?>
        </div> 
      </section>

      <div class="column column-5 karakteristike" id ="skok1">
        <h1>Karakteristike</h1>
         <?php
          foreach ($karakteristika as $key) {
            echo "<p><br>-{$key}</p>";
          }
        ?>
      </div>

      <div>
        <div class="column column-7 rezervacija" id ="skok2">
          <h1>Rezervacija</h1>
            <form action="unosPodataka.php" id="bttn" method="POST">
              <table class="unos">
                <tr>
                  <td><label for="name">Ime:</label></td>
                  <td><input type="text" name="ime" id="name" class="inpt"></td>
                </tr>
                <tr>
                  <td><label for="surname">Prezime:</label></td>
                  <td><input type="text" name="prezime" id="surname" class="inpt"></td>
                </tr>
                <tr>
                  <td><label for="id">Broj osobne</label></td>
                  <td><input type="number" name="osobna" id="id" class="inpt"></td>
                </tr>
                <tr>
                  <td><label for="numb">Broj soba</label></td>
                  <td><input type="number" name="soba" id="numb" class="inpt" min="1"></td>
                </tr>
                <tr>
                  <td><label for="date">Datum boravka od</label></td>
                  <td><input type="text" name="datumOD" id="datepicker" class="inpt"></td>
                </tr>
                <tr>
                  <td><label for="date">Datum boravka do</label></td>
                  <td><input type="text" name="datumDO" id="datepicker2" class="inpt"></td>
                  <td><input type="hidden" name="izbor" value="<?php echo $izbor;?>"></td>
                  <td><input type="hidden" name="ha" value="<?php echo $haDec;?>"></td>
                </tr>
              </table>
              <?php 
                if (isset($_SESSION['user'])) {
                 echo "<input class='button-rez' type='submit' value='Rezerviraj'>";
                }
              ?>    
            </form>
            <div id="dialog" title="Obavijest" style="display:none">
             <p>Sva polja moraju biti popunjena</p>
            </div>
            <?php 
              if (!isset($_SESSION['user'])) {
               echo "<a id='bttn3'><button class='button-rez'>Prijava</button></a>";
              }
            ?>    
            <div id="dialog3" title="Obavijest" style="display:none;">
             <p>Prvo se prijavite</p>
             <p><a href=""><button>Prijava</button></a></p>
            </div>
        </div>
        <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"> </script>
        <div id="map" class="karta-hotel" style="width: 380px; height: 380px;"></div>
      </div>
    </div>
    <footer class="site-footer">
      <div class="row">
        <h2>Kontakt<h2>
        <div class="column popis" id = "skok3">
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
    var ha = <?php echo json_encode($pos); ?>;
    var locations = <?php echo json_encode($_SESSION['karta']); ?>;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
        center: new google.maps.LatLng(locations[ha][1], locations[ha][2]),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
    var infowindow = new google.maps.InfoWindow();
    var marker;
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[ha][1], locations[ha][2]),
      map: map
    });

     google.maps.event.addListener(marker,'click',function() {
     infowindow.setContent(locations[ha][0]);
     infowindow.open(map, marker);
    });
  });
</script>

<script type="text/javascript">
  $('input').on('input', function() {
    var searchstring = $(this);
    searchstring.focus();
    var length = searchstring.val().length;
    var slovo = searchstring.val();
    var ne = /^\w+$/.test(slovo);
    if (ne == false ){ $(this).val(slovo);} 
  });
</script>

<script type="text/javascript">
  $( "#bttn" ).submit(function( event ) {
    var ok = true;
      $('.inpt').each(function() {  
        if($(this).val() == ""){ 
          $( "#dialog" ).dialog({ position: { my: 'center top', at: 'center top', of: window}, resizable: false, draggable: false });
          ok = false;
          event.preventDefault();
        }
      })
      if (ok==true) {
      $(this).parents('form').submit(); 
      }
  });
</script>


<script type="text/javascript">
  $( "#bttn3" ).click(function( event ) {
    $( "#dialog3" ).dialog({ position: { my: 'top', at: 'top', of: '#hotel'}, resizable: false, draggable: false });
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
