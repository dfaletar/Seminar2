<?php
  
  error_reporting(E_ERROR);
	session_start();

	if(!isset($_SESSION['usr'])){
			header("Location: loginAdmin.php");
  }

    include('baza.php');

		$inactive = 1800;


		if(isset($_SESSION['timeout'])){
			$session_life = time() - $_SESSION['timeout']; 
			
			if($session_life > $inactive) {
			   session_unset();
			   session_destroy();
			   echo ('<script type="text/javascript">alert("Isteklo je vrijeme prijave. Za nastavak prijavite se ponovo");</script>');
			  header("Location: loginAdmin.php");
			}
		}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width = device-width, initial-scale = 1.0" >
    <title>Login</title>
    <!-- Učitavanje stilskih datoteka -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/grid.css" />
    <link rel="stylesheet" href="css/stil.css" />
      <link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.js"></script>
   <!--<script src="js/jquery-1.8.3.min.js"></script>-->

  </head>
  <body>
  	<header>
  		<div class="admin-header row">
  			<img src="images/logo1.png" style="float:left">
  			<p><?php echo $_SESSION['usr']; ?><a href="logout.php"><button>Odjava</button></a></p>
  		</div>		
  	</header>
  	<section class="row margin">
  		<aside class="column column-4">
				<ul>
		      <li><a href="#" rel="forma_1">Brisanje mjesta</a></li>
					<li><a href="#" rel="forma_2">Dodavanje mjesta</a></li>
		      <li><a href="#" rel="forma_3">Brisanje apartmana/hotela</a></li>
					<li><a href="#" rel="forma_4">Dodavanje apartmana/hotela</a></li>
          <li><a href="#" rel="forma_5">Dodavanje slika</a></li>
          <li><a href="#" rel="forma_6">Brisanje rezervacija</a></li>
				<ul>
      </aside>
      <article class="column column-8 admin-article">
        <div id="dialog" title="Obavijest" style="display:none">
          <p>Sva polja moraju biti unesesna</p>
        </div>
      	<div>
      		<div id="forma_1" style="display:none;">
      			<form action="bazaAdmin.php" method="post">
              <table  class="unos2">
          			<tr>
                	<td><label for="grad">Grad:</label></td>
                  <td><select name="town">
                      <?php for ($i=0; $i <$count ; $i++)  
                        echo "<option value='{$gradovi[$i]}'>{$gradovi[$i]}</option>";?>
                      </select>
                  </td>
                  <td><input type="hidden" value="izbrisiGrad" name="radnja"></td>
                  <td><input type="submit" value="Izbriši mjesto" class="bttn"></td>
                </tr>  
              </table>
      			</form>
      		</div>
          <div id="forma_2" style="display:none;" >
      			<form action="bazaAdmin.php" method="post" enctype="multipart/form-data" id="check">
              <table class="unos2">
                <tr>
          				<td><label for="imeGrada">Ime:</label></td>
          				<td><input type="text" name="imeGrada" id="imeGrada" class ="txt inpt"></td>
                </tr>
                <tr>
                  <td><label for="postBroj" class="margin">PoštanskiBroj:</label></td>
                  <td><input type="number" name="postBroj" id="postBroj" class ="txt inpt" min="1"></td>
                </tr>
                <tr>
                  <td><label for="opisGrada">Opis:</label></td>
                  <td><textarea name="opisGrada" id="opisGrada" rows="5" cols="40" class="inpt">
                  </textarea></td>
                </tr>
                <tr>
                  <td><label for="opisGradaEng">EngleskiOpis:</label></td>
                  <td><textarea name="opisGradaEng" id="opisGradaEng" rows="5" cols="40" class="inpt">
                  </textarea></td>
                </tr>
                 <tr>
                  <td><label for="korX" class="margin">KoordinataX:</label></td>
                  <td><input type="number" name="korX" id="korX" class ="txt inpt" step="0.00000000001"></td>
                </tr>
                <tr>
                  <td><label for="korY" class="margin">KoordinataY:</label></td>
                  <td><input type="number" name="korY" id="korY" class ="txt inpt" step="0.00000000001"></td>
                </tr>
                <tr>
                  <td><label for="file">SLIKA:</label></td>
                  <td><input type="file" name="file" id="file" class="img-bttn1 inpt"></td>
          				<td><input type="hidden" value="dodajGrad" name="radnja"></td>
                </tr>
              </table>
          		<input type="submit" value="Dodaj mjesto" class="bttn">

      			</form>
      		</div>
      		
          <div id="forma_3" style="display:none;">
      			<form action="bazaAdmin.php" method="post">
              <table class="unos2">              
                <tr>
                  <td><label for="grad">Grad:</label></td>
                  <td><select name="town" id="grad">
                    <?php for ($i=0; $i <$count ; $i++)  
                      echo "<option value='{$gradovi[$i]}'>{$gradovi[$i]}</option>";?>
                    </select></td>
                </tr>
                <tr>
                  <td><label for="izbor">Izbor:</label></td>
                  <td><select name="izbor" id="ha">
                    <option value="apartmani">Apartmani</option>
                    <option value="hoteli">Hoteli</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td><label>Hotel/apratman:</label></td>
                    <td>
                    <div id="apartmani">
                    <?php 
                      for ($i=0; $i<$count;$i++){
                        if($i==0){
                          echo "<select name='izborHa-{$gradovi[$i]}-aBR' id='{$gradovi[$i]}-a' class='nes'>"; 
                         }else {
                          echo "<select name='izborHa-{$gradovi[$i]}-aBR' style='display:none' id='{$gradovi[$i]}-a' class='nes'>"; 
                         }
                              foreach ($apartmani[$gradovi[$i]] as $data) {
                            echo "<option value='{$data}'>{$data}</option>";
                              if ($data == end($apartmani[$gradovi[$i]])) break;
                          }
                      echo "</select>";
                      }
                      ?>
                      </div>
                      <div id="hoteli" style="display:none">
                        <?php 
                        for ($i=0; $i<$count;$i++){
                            if($i==0){
                            echo "<select name='izborHa-{$gradovi[$i]}-hBR' id='{$gradovi[$i]}-h' class='nes'>"; 
                           }else {
                            echo "<select name='izborHa-{$gradovi[$i]}-hBR' style='display:none' id='{$gradovi[$i]}-h' class='nes'>"; 
                           }
                                foreach ($hoteli[$gradovi[$i]] as $data) {
                            echo "<option value='{$data}'>{$data}</option>";
                              if ($data == end($hoteli[$gradovi[$i]])) break;
                          }
                        echo "</select>";
                        }
                        ?>
                      </div>
                </td></tr>
                <tr>
                  <td><input type="hidden" value="izbrisiHa" name="radnja"></td>
                </tr>
              </table>
              <input type="submit" value="Izbriši" class="bttn dodaj">
      			</form>
      		</div>

      		<div id="forma_4" style="display:none;">
            <form action="bazaAdmin.php" method="post" id="check2">
                <table  class="unos2">
                  <tr>
                    <td><label for="grad">Grad:</label></td>
                    <td><select name="town">
                      <?php for ($i=0; $i <$count ; $i++)  
                        echo "<option value='{$gradovi[$i]}'>{$gradovi[$i]}</option>";?>
                    </select></td>
                  </tr>
                  <tr>
                    <td><label for="izbor">Izbor:</label></td>
                    <td><select name="izbor" id="ha">
                      <option value="apartmani">Apartmani</option>
                      <option value="hoteli">Hoteli</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td><label for="ime">Ime:</label></td>
                    <td><input type="text" name="imeHa" id="imeHa" class="inpt2"></td>
                  </tr>
                  <tr>
                    <td><label for="brojSoba">Broj soba:</label></td>
                    <td><input type="number" name="brojSoba" id="brojSoba" class="inpt2" min="1"></td>
                  </tr>
                    <td><label for="cijena">Cijena:</label></td>
                    <td><input type="number" name="cijena" id="cijena" class="inpt2" min="1"></td>
                  <tr>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="wifi" value="wifi">Wifi</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="parking" value="parking">parking</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="klima" value="klima/air conditioner">klima</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="balkon" value="balkon/balcony">balkon</td>
                  </tr>
                  <tr>
                    <td><label for="opisHa">Opis:</label></td>
                    <td><textarea name="opisHa" id="opisHa" rows="5" cols="40" class="inpt2"></textarea></td>
                  </tr>
                  <tr>
                    <td><label for="opisHaEng">EngleskiOpis:</label></td>
                    <td><textarea name="opisHaEng" id="opisHaEng" rows="5" cols="40" class="inpt2"></textarea></td>
                  </tr>
                  <tr>
                    <td><label for="korX" class="margin">KoordinataX:</label></td>
                    <td><input type="number" name="korX" id="korX" class ="txt inpt2" step="0.00000000001"></td>
                  </tr>
                  <tr>
                    <td><label for="korY" class="margin">KoordinataY:</label></td>
                    <td><input type="number" name="korY" id="korY" class ="txt inpt2" step="0.00000000001"></td>
                  </tr>
                  <tr>
                    <input type="hidden" value="dodajHa" name="radnja">
                  </tr>
                </table>
                <input type="submit" value="Dodaj" class="bttn">

            </form>
      	 </div>

          <div id="forma_5" style="display:none;">
            <form action="bazaAdmin.php" method="post" enctype="multipart/form-data" >
              <table class="unos2">
                <tr>
                  <td><label for="town">Grad:</label></td>
                  <td><select name="town" id="grad-s">
                    <?php for ($i=0; $i <$count ; $i++)  
                      echo "<option value='{$gradovi[$i]}'>{$gradovi[$i]}</option>";?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="izbor">Izbor:</label></td>
                  <td><select name="izbor" id="ha-s">
                  <option value="apartmani">Apartmani</option>
                  <option value="hoteli">Hoteli</option>
                  </select></td>
                </tr> 
                <tr>
                  <td><label>Hotel/apartman:</label></td>
                  <td>
                  <div id="apartmani-s">
                  <?php 
                    for ($i=0; $i<$count;$i++){
                      if($i==0){
                        echo "<select name='izborHa-{$gradovi[$i]}-aSL' id='{$gradovi[$i]}-a-s' class='nes'>"; 
                       }else {
                        echo "<select name='izborHa-{$gradovi[$i]}-aSL' style='display:none' id='{$gradovi[$i]}-a-s' class='nes'>"; 
                       }
					              foreach ($apartmani[$gradovi[$i]] as $data) {
                          echo "<option value='{$data}'>{$data}</option>";
                          if ($data == end($apartmani[$gradovi[$i]])) break;
                        }
                    echo "</select>";
                    }
                    ?>
                    </div>

                    <div id="hoteli-s" style="display:none">
                      <?php 
                      for ($i=0; $i<$count;$i++){
                         if($i==0){
                          echo "<select name='izborHa-{$gradovi[$i]}-hSL' id='{$gradovi[$i]}-h-s' class='nes'>"; 
                         }else {
                          echo "<select name='izborHa-{$gradovi[$i]}-hSL' style='display:none' id='{$gradovi[$i]}-h-s' class='nes'>"; 
                         }
                          foreach ($hoteli[$gradovi[$i]] as $data) {
                          echo "<option value='{$data}'>{$data}</option>";
                            if ($data == end($hoteli[$gradovi[$i]])) break;
                          }
                          echo "</select>";
                        }
                      ?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><label for="file" class="margin">SLIKA:</label></td>
                  <td><input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" class="img-bttn2" /></td>
                  <td><input type="hidden" value="dodajSliku" name="radnja"></td>
                </tr>
              </table>
              <input type="submit" value="Dodaj" class="bttn">
            </form>
          </div>

         <div id="forma_6" style="display:none;">
            <form action="bazaAdmin.php" method="post">
                <table  class="unos2 rez" border="1" style="border-collapse:collapse">
                <tr> 
                 <th>  </th>
                 <th> id </th> 
                 <th> ime </th> 
                 <th> prezime </th> 
                 <th> brojSoba </th> 
                 <th> DatumBoravkaOd </th> 
                 <th> DatumBoravkaDo </th> 
                </tr> 

                  <?php
                    for($i=0;$i<$countRez;$i++) 
                    { 
                      $row=mysql_fetch_array($resultRez); 
                      echo "     
                         <tr> 
                          <td><input type='checkbox' name='{$row['id']}' value='{$row['id']}'></td>
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
                <input type="hidden" value="rez" name="radnja">  
                <input type="submit" value="Ukloni" class="bttn">
            </form>
         </div>
      	</div>
      </article>
  	</section>
  </body>
</html>

<script type="text/javascript">
	$('a').on('click', function(){
	   var target = $(this).attr('rel');
	   $("#"+target).show().siblings("div").hide();
	});
</script>

<!--<script type="text/javascript">
		$('input').on('input', function() {
			var searchstring = $(this);
			searchstring.focus();
			var length = searchstring.val().length;
			var slovo = searchstring.val().substring(length-1, length);
			var str =  searchstring.val().substring(0, length-1);
			var ne = /^\w+$/.test(slovo);
			if (ne == false ){ $(this).val(str);}	
		});
</script>-->

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
    $('#grad').on('change', function() {
      var ime = $(this).val();
      ime2 = ime +'-h';
      ime = ime + '-a';
     $("#"+ime).show().siblings('.nes').hide();
     $("#"+ime2).show().siblings('.nes').hide();
    });
</script>

<script type="text/javascript">
    $('#grad-s').on('change', function() {
      var ime = $(this).val();
      ime2 = ime +'-h-s';
      ime = ime + '-a-s';
     $("#"+ime).show().siblings('.nes').hide();
     $("#"+ime2).show().siblings('.nes').hide();
    });
</script>

<script type="text/javascript">
    $('#ha').on('change', function() {
      var ime = $(this).val();
      if(ime == 'hoteli'){
        $('#apartmani').hide();
        $('#hoteli').show();
      }else{
        $('#hoteli').hide();
        $('#apartmani').show();
      }
    });
</script>

<script type="text/javascript">
    $('#ha-s').on('change', function() {
      var ime = $(this).val();
        ime = ime + '-s';
      if(ime == 'hoteli-s'){
        $('#apartmani-s').hide();
        $('#hoteli-s').show();
      }else{
        $('#hoteli-s').hide();
        $('#apartmani-s').show();
      }
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

<script type="text/javascript">
  $( "#check2" ).submit(function( event ) {
    var ok = true;
     $('.inpt2').each(function() 
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












