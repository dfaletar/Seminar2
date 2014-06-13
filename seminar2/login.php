<?php 
	session_start();

	if(!(isset($_SESSION['usr']))) {
		$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

		mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");
		
		$upit = "SELECT * FROM admin WHERE korisnickoIme='".$_POST['usr']."' AND lozinka='".md5($_POST['pass'])."';";

		mysql_query("SET CHARACTER SET utf8", $link);
		
		$result = mysql_query($upit, $link);
		
		$korisnik = mysql_num_rows($result);
		
		if ($korisnik ==1) {
			$_SESSION['usr'] = $_POST['usr'];
			$_SESSION['timeout']=time();
			header('Location: admin.php');

			}else {
				$_SESSION['krivUnos']="krivo";
				header('Location: loginAdmin.php');
			}
		}else {
			header('Location: admin.php');
		}	

?>