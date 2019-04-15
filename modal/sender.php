<?php

function sendEmail($from_name,$reply,$address,$subject,$body,$is_html=false,$charset='utf-8')
{
	include_once('phpmailer/class.phpmailer.php');
	include_once('options.php');

	$mail = new PHPMailer(true);
	$mail->CharSet = $charset;
	$mail->IsSMTP();
	$mail->IsHTML($is_html);
	$mail->SMTPDebug = false;

	$mail->FromName = $from_name;
	$mail->From = $reply;
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddReplyTo($reply);
	$mail->AddAddress($address);

	$mail->SMTPAuth = true;
	$mail->Host = $options['host'];
	$mail->Port = $options['port'];
	$mail->Username = $options['username'];
	$mail->Password = $options['password'];
	$mail->Send();
}