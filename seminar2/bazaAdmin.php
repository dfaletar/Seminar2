<?php 
	session_start();

    if (!isset($_SESSION['usr'])) {
     header('Location: loginAdmin.php');
     }


	$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

	mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");

	mysql_query("SET CHARACTER SET utf8", $link);

	$radnja = $_POST['radnja'];
	

	switch ($radnja) {
		case 'izbrisiGrad':
			$grad = $_POST['town'];
			$upit = "DELETE FROM rezervacija WHERE id IN ( SELECT id FROM hoteli JOIN mjesto ON mjesto.postanskiBroj  = hoteli.postanskiBroj WHERE mjesto.naziv='{$grad}');";
			mysql_query($upit,$link) or die ("ERROR");
			$upit = "DELETE FROM rezervacija WHERE id IN ( SELECT id FROM apartmani JOIN mjesto ON mjesto.postanskiBroj  = apartmani.postanskiBroj WHERE mjesto.naziv='{$grad}')";
			mysql_query($upit,$link) or die ("ERROR");
			$upit = "DELETE FROM hoteli WHERE postanskiBroj IN (SELECT postanskiBroj FROM mjesto WHERE mjesto.naziv='{$grad}')";
			mysql_query($upit,$link) or die ("ERROR");
			$upit = "DELETE FROM apartmani WHERE postanskiBroj IN (SELECT postanskiBroj FROM mjesto WHERE mjesto.naziv='{$grad}')";
			mysql_query($upit,$link) or die ("ERROR");
			$upit = "DELETE FROM mjesto WHERE naziv = '{$grad}'";
			mysql_query($upit,$link) or die ("ERROR");

			$grad = md5($grad);
			if(is_dir("images/hoteli/{$grad}")) {
			$dir = __DIR__ . "/images/hoteli/{$grad}";
			echo $dir;
			$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
			$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ( $ri as $file ) {
			    $file->isDir() ?  rmdir($file) : unlink($file);
			}
			rmdir("images/hoteli/{$grad}");
			}
			if(is_dir("images/apartmani/{$grad}")) {
			$dir = __DIR__ . "/images/apartmani/{$grad}";
			echo $dir;
			$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
			$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ( $ri as $file ) {
			    $file->isDir() ?  rmdir($file) : unlink($file);
			}
			rmdir("images/apartmani/{$grad}");
			}

			break;
	
		case 'dodajGrad':
			$korX = $_POST['korX'];
			$korY = $_POST['korY'];
			$postBroj = $_POST['postBroj'];
			$imeGrada = $_POST['imeGrada'];
			$opisGrada = $_POST['opisGrada'];
			$opisGradaEng = $_POST['opisGradaEng'];
			$upit = "INSERT INTO mjesto (postanskiBroj, naziv,opis,opisEng,korX,korY) VALUES ({$postBroj},'{$imeGrada}','{$opisGrada}','$opisGradaEng',{$korX},{$korY})";
			mysql_query($upit,$link) or die ("<br>ERROR<br>");

			$imeGrada = md5($imeGrada);

			$dirPath="images/hoteli/{$imeGrada}";

			echo $dirPath;

			if(is_dir($dirPath)) {
			    echo "The Directory {$dirPath} exists";
			 }else{
				$result = mkdir($dirPath, 0755);
				if ($result == 1) {
			    echo $dirPath . " has been created";
				} else {
			    echo $dirPath . " has NOT been created";
				}
			}

			$dirPath="images/apartmani/{$imeGrada}";

			if(is_dir($dirPath)) {
			    echo "The Directory {$dirPath} exists";
			 }else{
				$result = mkdir($dirPath, 0755);
				if ($result == 1) {
			    echo $dirPath . " has been created";
				} else {
			    echo $dirPath . " has NOT been created";
				}
			}

			$allowedExts = array("jpeg", "jpg");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);

			if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 9999999999999)
			&& in_array($extension, $allowedExts)) {
			  if ($_FILES["file"]["error"] > 0) {
			    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			  } else {
			    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			    echo "Type: " . $_FILES["file"]["type"] . "<br>";
			    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			    if (file_exists("images/" . $imeGrada)) {
			      echo $imeGrada . " already exists. ";
			    } else {

			    $temp = explode(".",$_FILES["file"]["name"]);
				$newfilename = $imeGrada.".".end($temp);
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"images/" . $newfilename);		
			     echo "Stored in: " . "images/" . $imeGrada;
			    }
			  }
			} else {
			  echo "Invalid file";
			}

			break;

		case 'izbrisiHa':
			$izbor = $_POST['izbor'];
			$grad = $_POST['town'];

			if ($izbor=='apartmani') {
				$temp="izborHa-{$grad}-aBR";
			}else {
				$temp="izborHa-{$grad}-hBR";
			}
			$ha = $_POST[$temp];

			$upit = "DELETE FROM rezervacija WHERE id IN ( SELECT id FROM {$izbor} JOIN mjesto ON mjesto.postanskiBroj  = {$izbor}.postanskiBroj WHERE mjesto.naziv='{$grad}' AND {$izbor}.naziv='{$ha}');";
			mysql_query($upit,$link) or die ("ERROR 1");
			$upit = "DELETE FROM {$izbor} WHERE postanskiBroj IN (SELECT postanskiBroj FROM mjesto WHERE mjesto.naziv='{$grad}' AND {$izbor}.naziv='{$ha}');";
			mysql_query($upit,$link) or die ("ERROR 3");

			$grad = md5($grad);
			$ha = md5($ha);

			if(is_dir("images/{$izbor}/{$grad}/{$ha}")) {
			$dir = __DIR__ . "/images/{$izbor}/{$grad}/{$ha}";
			$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
			$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ( $ri as $file ) {
			    $file->isDir() ?  rmdir($file) : unlink($file);
			}
			$path="images/{$izbor}/{$grad}/{$ha}";
			if (is_dir($path)){
				echo $path;
				rmdir($path);
			}
			}
		break;

		case 'dodajHa':
			$korX = $_POST['korX'];
			$korY = $_POST['korY'];
			$izbor = $_POST['izbor'];
			$grad = $_POST['town'];
			$imeHa = $_POST['imeHa'];
			$opisHa = $_POST['opisHa'];
			$cijena = $_POST['cijena'];
			$brojSoba = $_POST['brojSoba'];
			$opisHaEng = $_POST['opisHaEng'];

			$karakteristika=array();

			$karakteristike = "";

			$count = 0;

			if (isset($_POST['wifi']))
				$karakteristika[$count++] = $_POST['wifi'];

			if (isset($_POST['parking']))
				$karakteristika[$count++] = $_POST['parking'];

			if (isset($_POST['klima']))
				$karakteristika[$count++] = $_POST['klima'];

			if (isset($_POST['balkon']))
				$karakteristika[$count++] = $_POST['balkon'];

			echo "<br>{$count} <br>";

			for ($i=0; $i <=$count-1 ; $i++) { 
				if($i == $count-1){
				$karakteristike=$karakteristike.$karakteristika[$i];
				}else {
				$karakteristike=$karakteristike.$karakteristika[$i].";";
				}
			}

			echo $karakteristike;


			echo $imeHa;

			$upit = "SELECT postanskiBroj FROM mjesto WHERE mjesto.naziv = '$grad'";
			$result = mysql_query($upit,$link) or die ("<br>ERROR 1 <br>");
			$postBroj= mysql_result($result, 0);

			$upit = "SELECT id FROM {$izbor} ORDER BY id DESC";
			echo $upit;
			$result = mysql_query($upit,$link) or die ("<br>ERROR 2<br>");
			$id = mysql_result($result, 0);
			$id = $id +1;

			$upit = "INSERT INTO {$izbor} (id, naziv, postanskiBroj,karakteristike,opis,brojSoba,cijena,opisEng,korX,korY) VALUES ({$id},'{$imeHa}',{$postBroj},'{$karakteristike}','{$opisHa}',{$brojSoba},{$cijena},'{$opisHaEng}',{$korX},{$korY})";
			mysql_query($upit,$link) or die ("<br>ERROR 3<br>");

			$grad = md5($grad);
			$imeHa = md5($imeHa);
			$dirPath="images/{$izbor}/{$grad}/".$imeHa;

			echo "<br>{$dirPath}<br>";

			if(is_dir($dirPath)) {
			    echo "The Directory {$dirPath} exists";
			 }else{
				$result = mkdir($dirPath, 0755);
				if ($result == 1) {
			    echo $dirPath . " has been created";
				} else {
			    echo $dirPath . " has NOT been created";
				}
			}

		break;	
		case 'dodajSliku':
			$izbor = $_POST['izbor'];
			$grad = $_POST['town'];

			if ($izbor=='apartmani') {
				$temp="izborHa-{$grad}-aSL";
			}else {
				$temp="izborHa-{$grad}-hSL";
			}

			$ha = $_POST[$temp];

			$grad = md5($grad);
			$ha = md5($ha);



			$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
			$max_file_size = 100000000*1000000000; //100 kb
			$path = "images/{$izbor}/{$grad}/{$ha}/";
			echo $path;
			$count = 0;

			if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			  // Loop $_FILES to exeicute all files
			  foreach ($_FILES['files']['name'] as $f => $name) {  
			    echo "<br>{$name}";   
			      if ($_FILES['files']['error'][$f] == 4) {
			        echo "<br>ERROR";
			        continue; // Skip file if any error found
			      }        
			      if ($_FILES['files']['error'][$f] == 0) {            
			          if ($_FILES['files']['size'][$f] > $max_file_size) {
			              $message[] = "$name is too large!.";
			              echo("<br> too large");
			              continue; // Skip large files
			          }
			      elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
			        $message[] = "$name is not a valid format";
			        continue; // Skip invalid file formats
			        echo("<br>not valid");
			      }
			          else{ // No error found! Move uploaded files
			          	 $ext = pathinfo($_FILES['files']['name'][$f], PATHINFO_EXTENSION);
						 $uniq_name = uniqid();
						 $uniq_name = md5($uniq_name); 
						 $uniq_name = $uniq_name.".".$ext;
			              if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . $uniq_name))
			                echo $path . $uniq_name;
			              $count++; // Number of successfully uploaded file
			            echo("<br> uspijelo");
			          }
			      }
			  }
			}
		break;
		case 'rez':
			$countRez=$_SESSION['countRez'];
			$idRez= $_SESSION['idRez'];
			$countOzn=0;
			$oznaceno = array();

			for ($i=0; $i <$countRez ; $i++) { 
				if (isset($_POST[$idRez[$i]])) {
					$oznaceno[$countOzn++]=$_POST[$idRez[$i]];
					echo $_POST[$idRez[$i]];
				}else echo "nema";
			}

			for ($i=0; $i <$countOzn ; $i++) { 
				$upit = "DELETE FROM rezervacija WHERE id = {$oznaceno[$i]}";
				$result = mysql_query($upit,$link) or die("ERROR");
			}
		break;
		default:
			break;
	}
	header('Location: admin.php')
?>