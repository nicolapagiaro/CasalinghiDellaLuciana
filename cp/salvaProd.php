<?php

include('../constants.php');
session_start();

if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImageProd']['tmp_name'])) {
        $sourcePath = $_FILES['userImageProd']['tmp_name'];
        $cartella = "immagini_" . $_SESSION['idCat'];
        if (!is_dir("../images/" . $cartella)) {
            mkdir("../images/" . $cartella);
        }
        $targetPath = "../images/" . $cartella . "/" . $_FILES['userImageProd']['name'];
        $imageFileType = pathinfo($targetPath, PATHINFO_EXTENSION);
        if ($_FILES['userImageProd']['size'] < 5000000 &&
                (strcasecmp($imageFileType, "jpg") == 0 || strcasecmp($imageFileType, "png") == 0 || strcasecmp($imageFileType, "jpeg") == 0 )) {
            if (move_uploaded_file($sourcePath, $targetPath)) {
                //connection to the database
                $db = mysqli_connect(HOST, USER, PASSW, DB) or die();
                $nomeFoto = $cartella . "/" . basename($_FILES['userImageProd']['name']);
                $query = "UPDATE MARCHE SET defaultImg = '$nomeFoto'"
                        . "WHERE id = " . $_SESSION['idProd'];
                $res = mysqli_query($db, $query);
                if ($res) {
                    echo 0;
                } else {
                    echo 1; //ERROR
                }
            } else {
                echo 2;
            }
        } else {
            echo 3;
        }
    } else {
        echo 4;
    }
} else {
    echo 5;
}
mysqli_close($db);