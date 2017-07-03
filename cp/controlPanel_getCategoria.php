<?php
	session_start();
	include('../constants.php');
	if(!isset($_POST['id']))
		die("errore id non valido");
		
	$id = $_POST['id'];
	$_SESSION['idCat'] = $id;
	//connection to the database
	$db = mysqli_connect(HOST, USER, PASSW, DB);
	
	// Check connection
	if(!$db)
		die("Errore nella connessione");
		
	$query = "SELECT descrizione, descrizione2, immagine
			  FROM CATEGORIE
			  WHERE id = $id";
	$res = mysqli_query($db, $query);
	if($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
		$nome = $row[0];
		$descr = $row[1];
		$img = $row[2];
		$info = array('nome'=>$nome, 'descrizione'=>$descr, 'immagine'=>$img);
		echo json_encode($info);
	}
?>
