<?php

include('../constants.php');
session_start();
$nome = $_POST['nome'];
$descr = $_POST['descr'];
$eta = $_POST['eta'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$query = "UPDATE MARCHE SET nome = '$nome', descrizione = '$descr', eta = '$eta'"
        . "WHERE id = " . $_SESSION['idProd'];
$res = mysqli_query($db, $query);
if($res) {
    echo 0; // OK
}
else {
    echo 1; // ERROR
}
mysqli_close($db);