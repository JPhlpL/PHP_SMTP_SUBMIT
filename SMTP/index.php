<?php
//index.php

//Empty input
$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

//clean text input
function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

//submit
if(isset($_POST["submit"]))
{
	//if name is empty
	if(empty($_POST["name"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
	}
	
	else
	{
		//submit name
		$name = clean_text($_POST["name"]);
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}
	
	//if email is empty
	if(empty($_POST["email"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	}

	else
	{
		//submit email
		$email = clean_text($_POST["email"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}

	//if subject is empty
	if(empty($_POST["subject"]))
	{
		$error .= '<p><label class="text-danger">Subject is required</label></p>';
	}

	else
	{
		//submit subject
		$subject = clean_text($_POST["subject"]);
	}

	//if message is empty
	if(empty($_POST["message"]))
	{
		$error .= '<p><label class="text-danger">Message is required</label></p>';
	}

	else
	{
		//submit message
		$message = clean_text($_POST["message"]);
	}

	//if no error
	if($error == '')
	{
		require 'class/class.phpmailer.php'; //must required


		$mail = new PHPMailer;

		$mail->IsSMTP();								//Sets Mailer to send message using SMTP

		$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		
		$mail->Port = '587';								//Sets the default SMTP server port

		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables

		$mail->Username = 'IT.jphlpl@gmail.com ';					//Sets SMTP username

		$mail->Password = '0mamal!n069812jp';					//Sets SMTP password

		$mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"

		$mail->From = $_POST["email"];					//Sets the From email address for the message

		$mail->FromName = $_POST["name"];				//Sets the From name of the message

		// $mail->AddCc('abc@xyz.com', 'Name');	    //Adds a "Cc" address

		$mail->AddAddress($_POST["email"], $_POST["name"]);	//Adds a "To" address
		
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters

		$mail->IsHTML(true);							//Sets message type to HTML				

		$mail->Subject = $_POST["subject"];				//Sets the Subject of the message

		$mail->Body = $_POST["message"];				//An HTML or plain text message body



		if($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$error = '<label class="text-success">Thank you for contacting us</label>';
		}

		else   //if the email is not sent
		{
			$error = '<label class="text-danger">There is an Error</label>';
		}

		$name = '';
		$email = '';
		$subject = '';
		$message = '';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Send an Email on Form Submission using PHP with PHPMailer</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h3 align="center">Send an Email on Form Submission using PHP with PHPMailer</h3>
					<br />

					<?php echo $error; ?> <!--If have any error-->

					<form method="post"> <!-----form method post --->
						
						<!-- Input Name -->
						<div class="form-group">
							<label>Enter Name</label>
							<input type="text" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $name; ?>" />
						</div>

						<!-- Input Email -->
						<div class="form-group">
							<label>Enter Email</label>
							<input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
						</div>

						<!-- Input Subject -->
						<div class="form-group">
							<label>Enter Subject</label>
							<input type="text" name="subject" class="form-control" placeholder="Enter Subject" value="<?php echo $subject; ?>" />
						</div>

						<!-- Input Message -->
						<div class="form-group">
							<label>Enter Message</label>
							<textarea name="message" class="form-control" placeholder="Enter Message"><?php echo $message; ?></textarea>
						</div>

						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Submit" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>





