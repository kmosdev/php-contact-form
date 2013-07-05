<html>
<head>
	<title>Form Template</title>
	<style type="text/css">
	/* h5validate errors*/
	.h5error {
		display: none;
		color: red;
	}

	/*honeypot*/
	.name2 {
		display: none;
	}
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="js/jquery.h5validate.js"></script>
</head>
<body>
<!-- Put this form outside of the process_form directory. Be sure to include jquery and h5validate -->
<form method="post" action="/standard_form/process_form/index.php" id="sp-form">
<div class="control-group">
	<label for="name">Full Name:</label>
	<div class="controls">
		<div id="e-name" class="h5error">Please enter your name</div>
		<input type="text" name="name" data-h5-errorid="e-name" required /><input type="text" name="name2" class="name2" value="" />
	</div>
</div>

<div class="control-group">
	<label for="email">Email:</label>
	<div class="controls">
		<div id="e-email" class="h5error">Please enter your email</div>
		<input type="text" name="email" data-h5-errorid="e-email" class="h5-email" required />
	</div>
</div>

<div class="control-group">
	<label for="phone">Phone:</label>
	<div class="controls">
		<div id="e-phone" class="h5error">Please enter your phone number</div>
		<input type="text" name="phone" data-h5-errorid="e-phone" class="h5-phone" required />
	</div>
</div>

<div class="control-group">
	<label for="comments">Comments:</label>
	<div class="controls">
		<textarea name="comments" data-h5-errorid="e-comments" class="h5-comments"></textarea>
	</div>
</div>   
<input type="hidden" name="referrer" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
<span class="button-wrap">
	<input type="submit" class="info-button" value="Submit" />
</span>
</form>
<span>
<script type="text/javascript">
$('#sp-form').h5Validate();
</script>
</span>
<div>
</body>
</html>