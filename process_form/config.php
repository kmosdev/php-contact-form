<?php
//the thanks page where the user will be redirected
//can be passed as a hidden field from form
if(!empty($_POST['thanks_page'])) {
	$config['thanks_page'] = $_POST['thanks_page'];
} else {
	$config['thanks_page'] = '/welcome/thanks.php';
}

//the error page where the user will be redirected on error
//can be passed as a hidden field from from
if(!empty($_POST['error_page'])) {
	$config['error_page'] = $_POST['error_page'];
} else {
	$config['error_page'] = '/welcome/thanks.php?error=true';
}

//site variables
$config['site_name'] = 'My Website';
$config['honeypot'] = 'name2'; //this is a blank input to trick spam bots

//user variables - these effect the email sent to the form submitter
$config['user_name'] = $_POST['name']; //the user's name in the email
$config['user_from_email'] = 'admin@mywebsite.com';
$config['user_from_name'] = 'Mrs. Website Admin';
$config['user_subject'] = 'Thanks you for contacting us';
$config['user_email'] = $_POST['email']; //comment out to not send a user email
$config['user_attachment'] = '/path/to/file-attachment'; //put a full path to attachment here if you want one sent

//admin variables
$config['admin_name'] = 'My Website';
$config['admin_from_email'] = 'admin@mywebsite.com'; //the from address on the admin email
$config['admin_from_name'] = 'My Website Admin';
$config['admin_subject'] = 'My Website Form Submitted';
$config['admin_email'] = 'admin@mywebsite.com'; //comment out to not send a admin email - this is where form submission notifications go
$config['admin_attachment'] = ''; //put a full path to attachment here if you want one sent

//the form fields we'll be processing
$fields = array('name','phone','email','schedule_tour','referrer');
$config['fields'] = $fields;

/*
* Log Submissions
*/
$config['log_submissions'] = true; //set to false to turn off
$config['timezone'] = 'America/New_York';
$config['dbfile'] = '/path/to/logs/maillog.db3'; //path to a sqlite file
?>