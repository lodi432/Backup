<?php

//funckija se zove provjeraOvlasti i ne prima parametra
function provjeraOvlasti(){
	if(!isset($_SESSION[$GLOBALS["appID"]."autoriziran"])){
		header("location: " . $GLOBALS["putanjaAPP"]);
	}
}



function saljiEmail($mail,$primatelji,$naslov,$poruka){
	date_default_timezone_set('Etc/UTC');
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "edunovaapp@gmail.com";
	$mail->Password = "Edunovaapp.16";
	$posiljatelj = mb_encode_mimeheader("Edunova, Škola informatike","UTF-8");
	$mail->setFrom('edunovaapp@gmail.com', $posiljatelj);
	foreach ($primatelji as $primatelj) {
		$mail->addAddress($primatelj["email"], mb_encode_mimeheader($primatelj["ime"]));
	}
	$mail->Subject = $naslov;
	$mail->msgHTML($poruka);
	$mail->AltBody = $poruka;
	if (!$mail->send()) {
	    return"Mailer Error: " . $mail->ErrorInfo;
	} else {
	   return "OK";
	}
}
