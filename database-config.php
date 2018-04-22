<?php
// Connect to the database
$hostname = "mysql.mferre08.vdwp1718.bbkweb.org";
$username = "mferre08";
$password = "AeW1Chaiph";
$database = "mferre08";

// Expose function to connect to database to avoid repetitive use of "global" keyword and mysqli_connect.
function connect_to_database() {
	global $hostname, $username, $password, $database;
	return mysqli_connect($hostname, $username, $password, $database);
}