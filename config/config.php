<?php 

return array(
	// select database
	'database' => 'mysql', // This is the database currently in use

	// Database setting
	'mysql' => array(
		'type' => 'mysql',
		'host' => 'localhost',
		'port' => '3306',
		'user' => 'root',
		'password' => '123456',
		'dbname' => 'test',
		'charset' => 'utf8',
		'fetch_model' => PDO::FETCH_ASSOC
	),

	'mssql' => array(
		'type' => 'mssql',
		'host' => 'localhost',
		'port' => '3306',
		'user' => 'root',
		'password' => '123456',
		'dbname' => 'test1',
		'charset' => 'utf8',
		'fetch_model' => PDO::FETCH_ASSOC
	),
	
	'drivers' => array(
		PDO::ATTR_ERRMODE => 'PDO::ERRMODE_EXCEPTION'
	),

	// Error setting
	'error' => array(
		'error_reporting' => 'E_ALL',
		'display_errors' => 1
	)

	// Other setting

);
