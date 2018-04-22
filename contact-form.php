<?php
// Input validation 
require "gump.class.php";

$gump  = new GUMP();
$_POST = $gump->sanitize($_POST); // Important to sanitize as it's safest to do so

// Get or set the validation rules
$gump->validation_rules(array(
    'user_name' => 'required|valid_name',
    'user_email' => 'required|valid_email|max_len,255|min_len,10',
    'subject' => 'min_len,5|max_len,200',
    'message' => 'required|min_len,10|max_len,500'
));

// Get or set the filtering rules for sanitanization
$gump->filter_rules(array(
    'user_name' => 'trim|sanitize_string',
    'user_email' => 'trim|sanitize_email',
    'subject' => 'trim|sanitize_string',
    'message' => 'trim|sanitize_string'
));


$validatedInput = $gump->run($_POST);

// Results of the validation 

if ($validatedInput === false) {
    echo $gump->get_readable_errors(true); // Returns human readable error text in an array or string
} else {
    $recipient   = "mferre08@mail.bbk.ac.uk";
    $mailheader  = "From: " . $validatedInput['user_email'];
    $wasMailSent = mail($recipient, $validatedInput['subject'], $validatedInput['message'], $mailheader);
    if ($wasMailSent) {
        readfile("thank-you-message.html"); // validation successful
    } else {
        readfile("error-message.html");
    }
} 
