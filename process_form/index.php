<?php
/*
* Form processing script
* Configuration for processing the email form
* Email sent to the end user can be edited in email_template_user.html
* Email sent to admin is generated to send values of $fields
*/
ini_set('error_reporting',E_WARNING);
require_once('class.processform.php');
require_once('config.php');

$data = $_POST;

$pform = new processForm($config,$data,$fields);

if(!empty($data)) {
	$pform->processForm();
}
?>