<?php

    session_start();

    if (!isset($_SESSION['usr'])) {
     header('Location: loginAdmin.php');
     }


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

    $_SESSION['gradovi']=$gradovi;

    $hoteli = array();
    $aparmtani = array();

    for ($i=0; $i < $count; $i++) { 
    	$upit = "SELECT hoteli.naziv FROM hoteli JOIN mjesto ON mjesto.postanskiBroj=hoteli.postanskiBroj WHERE mjesto.naziv='{$gradovi[$i]}'";
    	$result = mysql_query($upit,$link);
    	$countH = mysql_num_rows($result);

	    	for ($j=0; $j <$countH; $j++) { 
	    	$hotel=mysql_result($result,$j);
	    	$hoteli[$gradovi[$i]][$j]=$hotel;
	    	}
    	}


    	for ($i=0; $i < $count; $i++) { 
    	$upit = "SELECT apartmani.naziv FROM apartmani JOIN mjesto ON mjesto.postanskiBroj=apartmani.postanskiBroj WHERE mjesto.naziv='{$gradovi[$i]}'";
    	$result = mysql_query($upit,$link);
    	$countA = mysql_num_rows($result);

	    	for ($j=0; $j <$countA; $j++) { 
	    	$apartman=mysql_result($result,$j);
	    	$apartmani[$gradovi[$i]][$j]=$apartman;
	    	}
    	}
        
        $_SESSION['idRez'] = array();
        $upit = "SELECT id FROM rezervacija";
        $result= mysql_query($upit,$link);
        $countRez=mysql_num_rows($result);
        $_SESSION['countRez']=$countRez;
        for ($i=0; $i <$countRez ; $i++) { 
            $idRez= mysql_result($result, $i);
            $_SESSION['idRez'][$i]= $idRez;
        }


        $upitRez = "SELECT * FROM rezervacija";
        $resultRez = mysql_query($upitRez,$link);
                 
?>