<?php

include('../constants.php');
session_start();
if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImageCat']['tmp_name'])) {
        $sourcePath = $_FILES['userImageCat']['tmp_name'];
        $targetPath = "../images/" . $_FILES['userImageCat']['name'];
        $imageFileType = pathinfo($targetPath, PATHINFO_EXTENSION);
        if ($_FILES['userImageCat']['size'] < 2500000 &&
                ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg")) {
            if (move_uploaded_file($sourcePath, $targetPath)) {
                //connection to the database
                $db = mysqli_connect(HOST, USER, PASSW, DB) or die();
                $nomeFoto = basename($_FILES['userImageCat']['name']);
                $query = "UPDATE CATEGORIE SET immagine = '$nomeFoto' WHERE id = ". $_SESSION['idCat'];
                $res = mysqli_query($db, $query);
                if ($res) {
                    echo $nomeFoto; //OK
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
