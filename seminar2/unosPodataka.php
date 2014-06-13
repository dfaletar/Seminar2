<?php
	
	session_start();

	if(isset($_SESSION['user'])){

		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$osobna = $_POST['osobna'];
		$brojSoba = $_POST['soba'];
		$datumOd = $_POST['datumOD'];
		$datumDo = $_POST['datumDO'];
		$izbor = $_POST['izbor'];
		$ha = $_POST['ha'];

		$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

		mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");

		mysql_query("SET CHARACTER SET utf8", $link);
		  
		$upit = "DELETE FROM rezervacija WHERE id IN 
				(SELECT id FROM {$izbor} WHERE {$izbor}.naziv='{$ha}'
				 AND rezervacija.datumBoravkaDo <= CURDATE());";

		$result = mysql_query($upit, $link);	

		$count = mysql_affected_rows();

		$upit = "UPDATE {$izbor} SET brojSoba = brojSoba + {$count} WHERE naziv='{$ha}'";

		$result = mysql_query($upit, $link);

		$upit ="SELECT id FROM {$izbor} WHERE naziv = '{$ha}'";

		$result = mysql_query($upit, $link);

		$id = mysql_result($result, 0);

		$upit = "INSERT INTO rezervacija(id,ime,prezime,korisnickoIme,brojOsobne,brojSoba,datumBoravkaOd,datumBoravkaDo) 
			VALUES ({$id},'{$ime}','{$prezime}','{$_SESSION['user']}',{$osobna},{$brojSoba},'{$datumOd}','{$datumDo}')";

		$result = mysql_query($upit, $link);

		$upit = "UPDATE {$izbor} SET brojSoba = brojSoba - {$brojSoba} WHERE naziv ='{$ha}';";

		$result = mysql_query($upit, $link); 

		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}else {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

?>