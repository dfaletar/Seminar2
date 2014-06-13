<?php
	
	error_reporting(E_ERROR);
	$grad = $_POST['town'];
	$izbor = $_POST['izbor'];
	session_start();
	$_SESSION['town'] = $grad;
	$_SESSION['izbor'] = $izbor;

	$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

	mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");
	  
	$upit = "SELECT ".$izbor.".naziv FROM ".$izbor." JOIN mjesto ON ".$izbor.".postanskiBroj=mjesto.postanskiBroj WHERE mjesto.naziv='".$grad."';";

	mysql_query("SET CHARACTER SET utf8", $link);

	$result = mysql_query($upit, $link);

	$_SESSION['brojHa']=mysql_num_rows($result);

		$_SESSION['ha']=array();

		for ($i=1; $i < mysql_num_rows($result)+1; $i++) { 
		$b=mysql_result($result,$i-1);
	$_SESSION['ha'][$i]=$b;
		}

		$upit = "SELECT opis FROM mjesto WHERE naziv = '{$grad}'";

		$result = mysql_query($upit, $link);

		$_SESSION['opisGrada']=mysql_result($result,0);

		$_SESSION['opisHa']=array();

		for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		$upit = "SELECT {$izbor}.opis FROM {$izbor} JOIN mjesto ON mjesto.postanskiBroj={$izbor}.postanskiBroj WHERE mjesto.naziv='{$grad}' AND {$izbor}.naziv='{$_SESSION['ha'][$i]}'";	
	$result = mysql_query($upit, $link);
	$_SESSION['opisHa'][$i]=mysql_result($result,0);
	}

	$upit = "SELECT opisEng FROM mjesto WHERE naziv = '{$grad}'";

		$result = mysql_query($upit, $link);

		$_SESSION['opisGradaEng']=mysql_result($result,0);

		$_SESSION['opisHaEng']=array();

		for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		$upit = "SELECT {$izbor}.opisEng FROM {$izbor} JOIN mjesto ON mjesto.postanskiBroj={$izbor}.postanskiBroj WHERE mjesto.naziv='{$grad}' AND {$izbor}.naziv='{$_SESSION['ha'][$i]}'";	
	$result = mysql_query($upit, $link);
	$_SESSION['opisHaEng'][$i]=mysql_result($result,0);
	}


	$_SESSION['cijena']=array();

		for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		$upit = "SELECT {$izbor}.cijena FROM {$izbor} JOIN mjesto ON mjesto.postanskiBroj={$izbor}.postanskiBroj WHERE mjesto.naziv='{$grad}' AND {$izbor}.naziv='{$_SESSION['ha'][$i]}'";	
	$result = mysql_query($upit, $link);
	$_SESSION['cijena'][$i]=mysql_result($result,0);
	}

	for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		echo$_SESSION['cijena'][$i];
	}


	$_SESSION['karakteristike']=array();

		for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		$upit = "SELECT {$izbor}.karakteristike FROM {$izbor} JOIN mjesto ON mjesto.postanskiBroj={$izbor}.postanskiBroj WHERE mjesto.naziv='{$grad}' AND {$izbor}.naziv='{$_SESSION['ha'][$i]}'";	
	$result = mysql_query($upit, $link);
	$_SESSION['karakteristike'][$i]=mysql_result($result,0);
	}


	$_SESSION['ko1grad'] = array();
	$_SESSION['ko2grad'] = array();

	$upit = "SELECT korX FROM mjesto WHERE naziv='{$grad}'";
	$result = mysql_query($upit, $link);
	$_SESSION['ko1grad'] =mysql_result($result,0);

	$upit = "SELECT korY FROM mjesto WHERE naziv='{$grad}'";
	$result = mysql_query($upit, $link);
	$_SESSION['ko2grad'] =mysql_result($result,0);


	$_SESSION['ko1'] = array();
	$_SESSION['ko2'] = array();


		for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		$upit = "SELECT korX FROM {$izbor} WHERE naziv='{$_SESSION['ha'][$i]}'";
	$result = mysql_query($upit, $link);
	$_SESSION['ko1'][$i]=mysql_result($result,0);
	}

	for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
		$upit = "SELECT korY FROM {$izbor} WHERE naziv='{$_SESSION['ha'][$i]}'";
	$result = mysql_query($upit, $link);
	$_SESSION['ko2'][$i]=mysql_result($result,0);
	echo $_SESSION['ko2'][$i];
	}

	$_SESSION['karta'] = array();


	for ($i=1; $i <$_SESSION['brojHa']+1 ; $i++) { 
			$_SESSION['karta'][$i-1][0] = "{$_SESSION['ha'][$i]}";
			$_SESSION['karta'][$i-1][1] = $_SESSION['ko1'][$i];
			$_SESSION['karta'][$i-1][2] =  $_SESSION['ko2'][$i];
	}


	if ($_SESSION['lang']=='eng') {
		header('Location: odabirEng.php');
	}else{
		header('Location: odabir.php');
	}
		
?>