<?php
	include('../constants.php');
	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
			$sourcePath = $_FILES['userImage']['tmp_name'];
			$targetPath = "../images/".$_FILES['userImage']['name'];
			$imageFileType = pathinfo($targetPath,PATHINFO_EXTENSION);
			if ($_FILES['userImage']['size'] < 2500000 && 
				($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg")) {
				if(move_uploaded_file($sourcePath,$targetPath)) {
					//connection to the database
					$db = mysqli_connect(HOST, USER, PASSW, DB);
					$queryId = "SELECT MAX(id)
								FROM FOTO";
					$resId = mysqli_query($db, $queryId);
					if($row = mysqli_fetch_array($resId, MYSQLI_NUM)) {
						$nomeFoto = basename($_FILES['userImage']['name']);
						$query = "INSERT INTO FOTO 
								  VALUES($row[0],".$_SESSION['idProd'].", $nomeFoto)";
						$res = mysqli_query($db, $query);
						if($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
							echo "success";
						}
					}
					
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
