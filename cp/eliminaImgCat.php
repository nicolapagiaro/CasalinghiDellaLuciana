<?php

include('../constants.php');
$id = $_POST['id'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$query = "SELECT immagine FROM FOTO WHERE id = $id";
$res = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $image = $row['immagine'];
    $path = "../images/" . explode("/", $image)[0];
    $img = explode("/", $image)[1];
    chdir($path);
    unlink($img);
}
$query2 = "DELETE FROM FOTO WHERE id = $id";
$res2 = mysqli_query($db, $query2);
if($res2) {
    echo 0; //OK
}
else {
    echo 1; //ERROR
}
mysqli_close($db);
