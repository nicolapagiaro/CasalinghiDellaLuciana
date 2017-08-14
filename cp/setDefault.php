<?php

include('../constants.php');
session_start();
$id = $_POST['id'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$query = "SELECT immagine FROM FOTO WHERE id = $id";
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $image = $row['immagine'];
    $query2 = "UPDATE MARCHE SET defaultImg = '$image' WHERE id = " . $_SESSION['idProd'];
    $res2 = mysqli_query($db, $query2);
    if ($res2) {
        echo $image; //OK
    } else {
        echo 1; //ERROR
    }
}
mysqli_close($db);

