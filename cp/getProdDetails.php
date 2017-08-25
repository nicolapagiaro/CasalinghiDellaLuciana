<?php

include('../constants.php');
include('../class.php');
session_start();

$marca;
$id = $_POST['id'];
$_SESSION['idProd'] = $id;

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$query = "SELECT defaultImg, categoria
          FROM MARCHE
	  WHERE id = '$id'";
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $marca = Marca::conIdNomeImmagine($row['id'], null, $row['defaultImg']);
    $_SESSION['idCat'] = $row['categoria'];
}
mysqli_close($db);
echo json_encode($marca);

