<?php

define(HOST, 'localhost');
define(DATABASE, 'localproject');
define(USERNAME, 'localproject');
define(PASSWORD, 'local');

$connection = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

if ($connection->errno) {
	echo 'Connecting to database failed with ' . $connection->errno . ': ' . $connection->error;
} else {
	return $connection;
}
