<?php

include('../constants.php');
session_start();
if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        $sourcePath = $_FILES['userImage']['tmp_name'];
        $cartella = "immagini_" . $_SESSION['idCat'];
        if (!is_dir("../images/" . $cartella)) {
            mkdir("../images/" . $cartella);
        }
        $targetPath = "../images/" . $cartella . "/" . $_FILES['userImage']['name'];
        $imageFileType = pathinfo($targetPath, PATHINFO_EXTENSION);
        if ($_FILES['userImage']['size'] < 5000000 &&
                (strcasecmp($imageFileType, "jpg") == 0 || strcasecmp($imageFileType, "png") == 0  || strcasecmp($imageFileType, "jpeg") == 0 )) {
            if (move_uploaded_file($sourcePath, $targetPath)) {
                //connection to the database
                $db = mysqli_connect(HOST, USER, PASSW, DB) or die();
                $nomeFoto = $cartella . "/" . basename($_FILES['userImage']['name']);
                $query = "INSERT INTO FOTO(categoria, immagine) VALUES(" . $_SESSION['idCat'] . ", '$nomeFoto')";
                $res = mysqli_query($db, $query);
                if ($res) {
                    echo mysqli_insert_id($db) . "|" . $nomeFoto; //OK
                } else {
                    echo 1; //ERROR
                }
            } else {
                echo 1;
            }
        } else {
            echo 1;
        }
    } else {
        echo 1;
    }
} else {
    echo 1;
}
