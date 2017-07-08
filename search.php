<?php
include('class.php');
include('constants.php');

$parola = $_POST['key'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();

$query = "SELECT M.id, M.nome, M.defaultImg, C.id, C.nome
	  FROM MARCHE M, CATEGORIE C
          WHERE M.nome LIKE ('%$parola%') AND M.categoria = C.id";

$response = mysqli_query($db, $query);
$marche = array();
while ($row = mysqli_fetch_array($response, MYSQLI_NUM)) {
    $marche[] = Marca::conIdNomeImmagineCategoria($row[0], $row[1], $row[2], Categoria::conIdNome($row[3], $row[4]));
}
mysqli_close($db);
echo json_encode($marche);

