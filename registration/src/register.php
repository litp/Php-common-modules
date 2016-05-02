<?php

$connection = require('conn.php');

function validate_username($username)
{
	$username = trim($username);
	if (strlen($username) >4 && strlen($username) < 127) {
		return true;
	} else {
		return false;
	}
}

function validate_password($password)
{
	if (strlen($password) > 6 && strlen($password) <127 ) {
		return true;
	} else {
		return false;
	}
}

function validate_safety_question($question) {
	return true;
}

function validate_safety_answer($answer) {
	return true;
}

function validate_birthday($birthdat) {
	return true;
}

function validate_real_name($realname) {
	return true;
}

function validate_telephone($telephone) {
	return true;
}

function validate_qq($qq) {
	return true;
}

if () {
	//save into database
	//show registration successfully page
} else {
	// show the registration page
	// with the error message
}

