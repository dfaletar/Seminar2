<?php

	session_start();


    $link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

    mysql_select_db("aplikacija") or die("Neuspjelo otvaranjebaze");

    $ime= $_POST['ime'];
    $prezime= $_POST['prezime'];
    $usr= $_POST['usr'];
    $pass= md5($_POST['pass']);
      
    $upit = "INSERT INTO korisnici(ime,prezime,korisnickoIme,lozinka) 
    		VALUES('{$ime}','{$prezime}','{$usr}','{$pass}')";

    mysql_query("SET CHARACTER SET utf8", $link);

    $result = mysql_query($upit, $link);

    header("Location: index.php");

?>