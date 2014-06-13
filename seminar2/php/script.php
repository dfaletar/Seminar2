<?php

	$dbc = mysqli_connect("localhost","root","root","vodic") or die('Error connecting to database');

	$query = "SELECT naziv,opis,urlSlike FROM tocke WHERE id=".$_GET['point'];

	$result = mysqli_query($dbc,$query) or die('Error querying database');

	while ($row=mysqli_fetch_array($result)) {
		echo ('<div class="column column-6">
					<div class="box">');
		echo "<h3>".$row['naziv']."</h3><p>";
		echo $row['opis'];			
		echo ('</p></div></div>
				<div class="column column-6">
					<div class="box">
						<img src="');
		echo $row['urlSlike'];
		echo ('" alt="slika1">
					</div>
				</div>');
	}

	mysqli_close($dbc);

?>