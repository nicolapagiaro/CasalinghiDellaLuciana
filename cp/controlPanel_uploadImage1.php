<?php
	if(isset($_FILES['filesToUpload']['name'])) {
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES['filesToUpload']['name']);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES['filesToUpload']['tmp_name']);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	}
	else
		die("Errore file vuoto");
		
	// Check if file already exists
	if (file_exists($target_file)) {
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES['filesToUpload']['size'] > 2500000) {
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo $uploadOk;
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES['filesToUpload']['tmp_name'], $target_file)) {
			echo ++$uploadOk;
		} else {
			echo $uploadOk;
		}
	}
?>
