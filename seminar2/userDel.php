<?php
	
	session_start();

	$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

	mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");

	mysql_query("SET CHARACTER SET utf8", $link);
	
	$idRez= array();
	$countOzn=0;
	$upit = "SELECT id FROM rezervacija WHERE korisnickoIme = '{$_SESSION['user']}'";
	$result= mysql_query($upit,$link);
	$countRez=mysql_num_rows($result);
	for ($i=0; $i <$countRez ; $i++) { 
	    $id= mysql_result($result, $i);
	    $idRez[$i]= $id;
	}

	for ($i=0; $i <$countRez ; $i++) { 
		if (isset($_POST[$idRez[$i]])) {
			$oznaceno[$countOzn++]=$_POST[$idRez[$i]];
			echo $_POST[$idRez[$i]];
		}
	}

	for ($i=0; $i <$countOzn ; $i++) { 
		$upit = "DELETE FROM rezervacija WHERE id = {$oznaceno[$i]}";
		$result = mysql_query($upit,$link) or die("ERROR");
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
    
?>