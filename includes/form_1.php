<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/Exception.php';
	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/SMTP.php';

	if (empty($_POST['name']) && strlen($_POST['name']) == 0 || empty($_POST['email']) && strlen($_POST['email']) == 0 || empty($_POST['message']) && strlen($_POST['message']) == 0)
	{
		return false;
	}
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	/** SMTP Server Credentials **/
	$smtp_host = 'smtp.gmail.com';
	$smtp_username = 'Guytalleyportfolio@gmail.com';
	$smtp_password = 'Talley68!';
	$smtp_port = '587';

	// Create Message	
	$to = 'Guytalleyportfolio@gmail.com';
	$replyTo = $email;
	$email_subject = "Message from your portfolio website.";
	$email_body = "You have received a new message. <br><br>Name: $name <br>Email: $email <br>Message: $message <br>";

	$mail = new PHPMailer(true);

	try {
		$mail->isSMTP();
		$mail->CharSet = 'utf-8';
		$mail->Host = $smtp_host;
		$mail->SMTPAuth = true;
		$mail->Username = $smtp_username;
		$mail->Password = $smtp_password;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; /** or PHPMailer::ENCRYPTION_SMTPS for SSL **/
		$mail->Port = $smtp_port;

		$mail->setFrom($smtp_username, 'Guy Talley');
		$mail->addAddress($to);
    	$mail->addReplyTo($replyTo, 'Reply To');

		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body = $email_body;

		$mail->send();
		exit;
	}
	catch (Exception $e)
	{
		$error = array("message" => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
		header('Content-Type: application/json');
		http_response_code(500);
		echo json_encode($error);
	}
?>
