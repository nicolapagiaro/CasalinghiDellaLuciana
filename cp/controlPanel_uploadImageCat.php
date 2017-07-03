<?php
	session_start();
	include('../constants.php');
	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['imageCat']['tmp_name'])) {
			$sourcePath = $_FILES['imageCat']['tmp_name'];
			$targetPath = "../images/".$_FILES['imageCat']['name'];
			$imageFileType = pathinfo($targetPath,PATHINFO_EXTENSION);
			if ($_FILES['imageCat']['size'] < 2500000 && 
				($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg")) {
				if(move_uploaded_file($sourcePath,$targetPath)) {
					//connection to the database
					$db = mysqli_connect(HOST, USER, PASSW, DB);
					$id = $_SESSION['idCat'];
					$nomeFoto = basename($_FILES['imageCat']['name']);
					$query = "UPDATE CATEGORIE
							  SET immagine = '$nomeFoto'
						      WHERE id = $id";
					$res = mysqli_query($db, $query);
					if($res) {
						echo "success";
					}
					else
						echo "query fail(".$_SESSION['idCat'].")(".$query.")";
				}
				else {
					echo "failed";
				}
			}
			else
				echo "failed if";
		}
		else
			echo "failed upload first";
	}
	else
		echo "failed porco";
?>
