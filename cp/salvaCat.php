<?php

include('../constants.php');
session_start();
$nome = $_POST['nome'];
$descr = $_POST['descr'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$query = "UPDATE CATEGORIE SET nome = '$nome', descrizione = '$descr'"
        . "WHERE id = " . $_SESSION['idCat'];
$res = mysqli_query($db, $query);
if($res) {
    echo 0; // OK
}
else {
    echo 1; // ERROR
}
mysqli_close($db);

