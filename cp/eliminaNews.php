<?php

include('../constants.php');
$id = $_POST['id'];

//connection to the database
$db = mysqli_connect(HOST, USER, PASSW, DB) or die();
$query = "DELETE FROM NEWS WHERE id = $id";
$res = mysqli_query($db, $query);
if($res) {
    echo 0; //OK
}
else {
    echo 1; //ERROR
}
mysqli_close($db);

