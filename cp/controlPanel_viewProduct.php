<?php
	include('../constants.php');
	if(!isset($_POST['id']))
		die("errore id non valido");
		
	$id = $_POST['id'];
	$_SESSION['idProd'] = $id;
	//connection to the database
	$db = mysqli_connect(HOST, USER, PASSW, DB);
	
	// Check connection
	if(!$db)
		die("Errore nella connessione");
		
	$query = "SELECT nome, descrizione, categoria
			  FROM MARCHE
			  WHERE id = $id";
	$res = mysqli_query($db, $query);
	if($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
		$nomeM = $row[0];
		$descrM = $row[1];
		$categoriaM = $row[2];
		$info = array('nome'=>$nomeM, 'descr'=>$descrM,
					'cat'=>$categoriaM);
		echo json_encode($info);
	}
?>
