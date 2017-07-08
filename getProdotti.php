<?php
include('constants.php');
include('class.php');

$result = array();
$nomeCat = "";
$descrCat = "";
$id = $_POST['id'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$marche = array();
$query = "SELECT id, nome, defaultImg
                FROM MARCHE
		WHERE categoria = '$id'";
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $marche[] = Marca::conIdNomeImmagine($row['id'], $row['nome'], $row['defaultImg']);
}

$query2 = "SELECT nome, descrizione
           FROM CATEGORIE
	   WHERE id = '$id'";
$res2 = mysqli_query($db, $query2);
while ($row = mysqli_fetch_assoc($res2)) {
    $nomeCat = $row['nome'];
    $descrCat = $row['descrizione'];
}

mysqli_close($db);
$result['lista'] = $marche;
$result['nomeCat'] = $nomeCat;
$result['descrCat'] = $descrCat;
echo json_encode($result);