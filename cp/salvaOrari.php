<?php

$orariStringa = $_POST['orari'];
$file = fopen("../orari.txt", "w") or die("Unable to open file!");
$res = fwrite($file, $orariStringa);
fclose($file);
if($res != false) {
    echo '0';
}
else {
    echo '1';
}
