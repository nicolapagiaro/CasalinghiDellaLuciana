<?php

session_start();

include('constants.php');
include('class.php');

$result = array();
$nomeCat = "";
$descrCat = "";
$id = $_POST['id'];
$ordine = $_POST['ordine'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$marche = array();
// switch per ordinare le marche visualizzate
if ($ordine == 1) {
    $query = "SELECT id, nome, defaultImg
          FROM MARCHE
	  WHERE categoria = '$id'
          ORDER BY (nome) ASC";
} else if ($ordine == 2) {
    $query = "SELECT id, nome, defaultImg
          FROM MARCHE
	  WHERE categoria = '$id'
          ORDER BY (nome) DESC";
} else {
    $query = "SELECT id, nome, defaultImg
          FROM MARCHE
	  WHERE categoria = '$id'";
}
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $marche[] = Marca::conIdNomeImmagine($row['id'], $row['nome'], $row['defaultImg']);
}

$query2 = "SELECT nome, descrizione, eta
           FROM CATEGORIE
	   WHERE id = '$id'";
$res2 = mysqli_query($db, $query2);
while ($row = mysqli_fetch_assoc($res2)) {
    $categoria = new Categoria();
    $categoria->setNome($row['nome']);
    $categoria->setDescrizione($row['descrizione']);
    $categoria->setEta($row['eta']);
}

$fotos = array();
$query3 = "SELECT id, immagine
           FROM FOTO
	   WHERE categoria = '$id'";
$res3 = mysqli_query($db, $query3);
while ($row = mysqli_fetch_assoc($res3)) {
    $fotos[] = Foto::conIdImmagine($row['id'], $row['immagine']);
}
$categoria->setFotos($fotos);

mysqli_close($db);
$result['lista'] = $marche;
$result['categoria'] = $categoria;
echo json_encode($result);
