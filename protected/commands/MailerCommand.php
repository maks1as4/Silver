<?php

class MailerCommand extends CConsoleCommand
{
	public function actionSend($id)
	{
		$model = Mails::model()->findByPk($id);
		if ($model)
		{
			include_once('protected/extensions/phpmailer/class.phpmailer.php');
			$mail = new PHPMailer(true);
			$mail->CharSet = 'utf-8';
			$mail->IsSMTP();
			$mail->IsHTML(false);
			$mail->SMTPDebug = false;
			$mail->addCustomHeader('X-Code: '.$model->hash);

			$mail->FromName = $model->from_name;
			$mail->From = $model->replyto;
			$mail->Subject = $model->title;
			$mail->Body = $model->message;
			$mail->AddReplyTo($model->replyto);
			$mail->AddAddress($model->mailto);

			$mail->SMTPAuth = true;
			$mail->Host = Yii::app()->params['smtpHost'];
			$mail->Port = Yii::app()->params['smtpPort'];
			$mail->Username = Yii::app()->params['smtpEmail'];
			$mail->Password = Yii::app()->params['smtpPassword'];

			if ($mail->Send())
			{
				$model->sended = 1;
				$model->sdate = date('Y-m-d H:i:s');
			}
			else
				$model->error = 'Error: '.$mail->ErrorInfo;
			$model->save(false);
		}
	}
}