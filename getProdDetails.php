<?php
include('constants.php');
include('class.php');

$id = $_POST['id'];
$marca;
$fotos = array();

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die("Errore nella connessione");

$query = "SELECT nome, descrizione, eta
          FROM MARCHE
	  WHERE id = '$id'";
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $marca = Marca::conIdNomeDescrizioneEta($id, $row['nome'], $row['descrizione'], $row['eta']);
}

$query2 = "SELECT id, immagine
           FROM FOTO
	   WHERE marca = '$id'";
$res2 = mysqli_query($db, $query2);
while ($row = mysqli_fetch_assoc($res2)) {
    $fotos[] = Foto::conIdImmagine($row['id'], $row['immagine']);
}

$marca->setFotos($fotos);

mysqli_close($db);
echo json_encode($marca);