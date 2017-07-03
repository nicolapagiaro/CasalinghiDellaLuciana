<?php
	include('../constants.php');
	if(!isset($_POST['id']))
		die("errore id non valido");
		
	$id = $_POST['id'];
	//connection to the database
	$db = mysqli_connect(HOST, USER, PASSW, DB);
	
	// Check connection
	if(!$db)
		die("Errore nella connessione");
		
	$foto = array();
	$i = false;
	$query = "SELECT id, immagine
			  FROM FOTO
			  WHERE $id = marca";
	$res = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
		$foto[] = $row[0]."|".$row[1];
		$i = true;
	}
	$count = 1;
	if($i) {
		foreach($foto as $f) {
			$c = explode("|", $f);
			echo "<div class=\"col s12 valign-wrapper\">
					<div class=\"col l4\">
						<img src=\"images/$c[1]\" class=\"responsive-img materialboxed\" width=\"96\">
					</div>
					<div class=\"col l4\">
						<p class=\"valign\">$c[1]</p>
					</div>
					<div class=\"col l4 left-align\">
						<a class=\"btn-flat\"><i class=\"material-icons right\">cancel</i>elimina</a>
					</div>
				</div>";
			$count++;
		}
	}
	else {
		echo "<div class=\"col s12 valign-wrapper\">
				<p>Nessuna foto caricata</p>
			</div>";
	}
?>
