<?php
// Connect to the database
// The details for the DB are in the original file
$hostname = "";
$username = "";
$password = "";
$database = "";

// Expose function to connect to database to avoid repetitive use of "global" keyword and mysqli_connect.
function connect_to_database() {
	global $hostname, $username, $password, $database;
	return mysqli_connect($hostname, $username, $password, $database);
}