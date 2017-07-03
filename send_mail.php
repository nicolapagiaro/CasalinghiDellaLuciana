<?php
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$msg = $_POST['mailText'];
	if ($email === "" || $msg === "" || $nome === "") {
		echo 0;
	}
	else {
		$msg = $nome."\n\n".$msg;
		$msg = str_replace("\n.", "\n..", $msg);
		$headers = 'From: '.$email;
		
		if(mail("pagiaro@gmail.com","E-mail dal sito",$msg,$headers)) 
			echo 1;
		else
			echo 0;
    }
?>
