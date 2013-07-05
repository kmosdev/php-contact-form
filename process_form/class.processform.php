<?php
require_once('class.phpmailer.php');
require_once('class.maillog.php');

class processForm {
	private $config;
	private $data;
	private $fields;
	private $mail;
	private $filtered;
	private $error = false;

	public function __construct($config,$data,$fields) {
		$this->config = $config;
		$this->data = $data;
		$this->fields = $fields;
	}

	/*
	* Process the form
	*/
	public function processForm() {
		$spam = $this->checkSpam();

		if($spam === false) {
			$this->cleanData();
			$useremail = $this->sendUserEmail();
			$adminemail = $this->sendAdminEmail();
			$this->logSubmissions();

			if($useremail !== true || $adminemail !== true) {
				$this->error = true;
			}
			
		} else {
			$this->error = true;
		}

		$this->goToResult();
	}

	/*
	* Clean data for bad characters
	*/
	public function cleanData() {
		foreach($this->fields as $field) {
			if(!empty($this->data[$field])) {
				$filtered[$field] = filter_var($this->data[$field],FILTER_SANITIZE_STRING);
			}
		}

		$this->filtered = $filtered;
	}

	/*
	* Check spam using the honeypot method
	* Other methods could be added here later
	*/
	public function checkSpam() {
		$spam = false;
		if(!empty($this->config['honeypot'])) {
			$hp = $this->config['honeypot'];
			if($this->data[$hp] != '') {
				$spam = true;
			}
		}

		return $spam;
	}

	/*
	* Send the email to the end user
	*/
	public function sendUserEmail() {
		$mail = new PHPMailer(true);
		$m = true;
		if(!empty($this->config['user_email'])) {
		  $mail->SetFrom($this->config['user_from_email'], $this->config['user_from_name']);
		  $mail->Subject = $this->config['user_subject'];
		  $mail->AddAddress($this->config['user_email'],$this->config['user_name']);
		  
		  $body = file_get_contents('email_template_user.html');
		  $body = preg_replace('#SITE_NAME#', $this->config['site_name'], $body);
		  $mail->AltBody = '';
		  $mail->MsgHTML($body);
		  //$mail->Body = '';
		  //$mail->MsgHTML('test');
		  //$mail->Body = 'test';

		  //add attachment
		  if(!empty($this->config['user_attachment'])) {
		  	$mail->AddAttachment($this->config['user_attachment']);
		  }

		  if(!$mail->Send()) {
			  $m = $mail->ErrorInfo;
			} else {
			  $m = true;
			}
		}
		$mail = null;
		return $m;
	}

	/*
	* Send the email to the admin
	*/
	public function sendAdminEmail() {
		$mail = new PHPMailer(true);
		$m = true;
		$body = '';
		foreach($this->fields as $field) {
			if(!empty($this->data[$field])) {
				$body .= $field . ': '. $this->data[$field]. "<br />";
			}
		}

		if(!empty($this->config['admin_email'])) {
		  $mail->SetFrom($this->config['admin_from_email'], $this->config['admin_from_name']);
		  $mail->Subject = $this->config['admin_subject'];
		  $mail->AddAddress($this->config['admin_email'],$this->config['admin_name']);
		  
		  //add attachment
		  if(!empty($this->config['admin_attachment'])) {
		  	$mail->AddAttachment($this->config['admin_attachment']);
		  }

		  $mail->MsgHtml($body);	  
		  if(!$mail->Send()) {
			  $m = $mail->ErrorInfo;
			} else {
			  $m = true;
			}
		}
		$mail = null;
		return $m;
	}

	/*
	* Log Submissions
	*/
	
	public function logSubmissions() {
		if($this->config['log_submissions'] === true) {
			$log = new MailLog();
			foreach($this->fields as $field) {
				$record[$field] = $this->filtered[$field];
			}

			$log->add($record);
			$log->close();
		} else {
			return;
		}
	}

	/*
	* Redirect to result page
	*/
	public function goToResult() {
		if($this->error === false) {
			header('Location:'.$this->config['thanks_page']);
		} else {
			header('Location:'.$this->config['error_page']);
		}
	}
}
?>