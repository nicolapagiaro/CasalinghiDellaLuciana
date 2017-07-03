<?php
	include('constants.php');
	
	$parola = $_POST['key'];
	
	//connection to the database
	$db = mysqli_connect(HOST, USER, PASSW, DB);
	
	// Check connection
	if(!$db)
		die("Errore nella connessione");
		
	$query = "SELECT M.id, M.nome, M.defaultImg, C.descrizione
			  FROM MARCHE M, CATEGORIE C
              WHERE M.nome LIKE ('%$parola%') AND M.categoria = C.id";
			  
	$response = mysqli_query($db, $query);
	
	$s = "";
	$i = 0;
	while($row = mysqli_fetch_array($response, MYSQLI_NUM)) {
		$i++;
		$s .= "<div class=\"col l4 s12 m6\">
				<a href=\"viewItem.php?prod=$row[0]\">
					<div class=\"card hoverable\">
						<div class=\"card-image\">
							<img src=\"images/$row[2]\">
						</div>
						<div class=\"card-content\">
						   <b><p class=\"grey-text-1 center-align\">$row[1]</p></b>
						   <p class=\"grey-text-2 center-align\">$row[3]</p>
						</div>
					</div>
				</a>
				</div>";
	}
	
	if($i == 0)	
		$s = "<div class=\"col s12\">
				<p>Nessun risultato</p>
			  </div>";
	echo $s;
	
	// Close the connection
	mysqli_close($db);
?>
