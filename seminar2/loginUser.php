<?php 
	session_start();

		if(!(isset($_SESSION['user']))) {
			$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

			mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");
			
			$upit = "SELECT * FROM korisnici WHERE korisnickoIme='".$_POST['usr']."' AND lozinka='".md5($_POST['pass'])."';";

			mysql_query("SET CHARACTER SET utf8", $link);
			
			$result = mysql_query($upit, $link);
			
			$korisnik = mysql_num_rows($result);
		
		if ($korisnik ==1) {
		$_SESSION['user'] = $_POST['usr'];
		}else{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			$_SESSION['krivUnos']="Krivo";
			}
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
?>