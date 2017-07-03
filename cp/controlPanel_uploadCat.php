<?php
	include('../constants.php');
	session_start();
	
	//connection to the database
	$db = mysqli_connect(HOST, USER, PASSW, DB);
	
	// Check connection
	if(!$db)
		die("Errore nella connessione");
	
	$id = $_SESSION['idCat'];
	$nome = mysqli_real_escape_string($db, $_POST['nome']);
	$descr = mysqli_real_escape_string($db, $_POST['descr']);
	
	$query = "UPDATE CATEGORIE
			  SET descrizione = '$nome', descrizione2 = '$descr'
			  WHERE id = $id";
	$res = mysqli_query($db, $query);
	if($res)
		$info = array('result'=>true);

	else
		$info = array('result'=>false);
		
	echo json_encode($info);
?>
