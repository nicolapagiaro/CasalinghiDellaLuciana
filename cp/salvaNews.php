<?php

include('../constants.php');
$titolo = $_POST['titolo'];
$descr = $_POST['descr'];
$color = $_POST['color'];
$dataI = $_POST['dataI'];
$dataF = $_POST['dataF'];

if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImageN']['tmp_name'])) {
        $sourcePath = $_FILES['userImageN']['tmp_name'];
        $cartella = "immagini_news";
        if (!is_dir("../images/" . $cartella)) {
            mkdir("../images/" . $cartella);
        }
        $targetPath = "../images/" . $cartella . "/" . $_FILES['userImageN']['name'];
        $imageFileType = pathinfo($targetPath, PATHINFO_EXTENSION);
        if ($_FILES['userImageN']['size'] < 5000000 &&
                (strcasecmp($imageFileType, "jpg") == 0 || strcasecmp($imageFileType, "png") == 0  || strcasecmp($imageFileType, "jpeg") == 0 )) {
            if (move_uploaded_file($sourcePath, $targetPath)) {
                //connection to the database
                $db = mysqli_connect(HOST, USER, PASSW, DB) or die();
                $nomeFoto = $cartella . "/" . basename($_FILES['userImageN']['name']);
                $query = "INSERT INTO NEWS(titolo, descrizione, coloreTesto, immagine, dataI, dataF)"
                       . "VALUES('$titolo', '$descr', '$color','$nomeFoto',  '$dataI', '$dataF')";
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
mysqli_close($db);

