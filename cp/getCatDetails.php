<?php

include('../constants.php');
include('../class.php');
session_start();

$id = $_POST['id'];
$_SESSION['idCat'] = $id;
$cat;

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die("Errore nella connessione");

$query = "SELECT nome, eta, immagine, descrizione
          FROM CATEGORIE
	  WHERE id = $id";
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $cat = Categoria::conIdNomeImmagine($id, $row['nome'], $row['immagine']);
    $cat->setDescrizione($row['descrizione']);
    $cat->setEta($row['eta']);
}

$fotos = array();
$query1 = "SELECT id, immagine
          FROM FOTO
	  WHERE categoria = $id";
$res1 = mysqli_query($db, $query1);
while ($row = mysqli_fetch_assoc($res1)) {
    $fotos[] = Foto::conIdImmagine($row['id'], $row['immagine']);
}
$cat->setFotos($fotos);

mysqli_close($db);
echo json_encode($cat);
