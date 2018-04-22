<?php
// Input validation 
require "gump.class.php";
require "database-config.php";

$gump = new GUMP();
$_POST = $gump->sanitize($_POST);

$gump->validation_rules(array(
	'email_address' => 'required|valid_email|max_len,254|min_len,10',
));

$gump->filter_rules(array(
	'email_address' => 'trim|sanitize_email',
));


$validatedInput = $gump->run($_POST);

// Results of the validation

function saveSubscriber($subscriberEmailAddress) {
	// Create connection
	$link = connect_to_database();

	// Check connection
	if (mysqli_connect_errno()) {
		die("Connect failed: %s\n" + mysqli_connect_error());
	}
	
	// Data is good so insert into database
	$sql = "INSERT INTO mailing_list_subscribers (email_address)
	VALUES ('" . $subscriberEmailAddress . "')";

	// run the query
	$result = mysqli_query($link, $sql);

	mysqli_close($link);
	
	return $result;
}

if($validatedInput === false) {
	echo $gump->get_readable_errors(true);

} else {
	$wasSubscriberSaved = saveSubscriber($validatedInput['email_address']);
	if ($wasSubscriberSaved) {
		$email_headers = array(
			'From: Dance Venue <mferre08@mail.bbk.ac.uk>',
			'Content-Type: text/html',
		);
		$wasMailSent = @mail(
			$validatedInput['email_address'],
			'Successfully subscribed',
			file_get_contents('./subscription-confirmation.html'),
			join("\r\n", $email_headers)  // Convert email headers to a string, adding a new line between headers
		);
		if ($wasMailSent) {
			readfile("email-subscribed.html");
		} else {
			readfile("email-failed.html");
		}
	} else {
		readfile("email-already-subscribed.html");
	}
}


