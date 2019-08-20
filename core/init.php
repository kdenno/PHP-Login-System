<?php
// set session, allow users to login
session_start();

// set globals
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '5UB1xG03efyCp456%$#@#$!',
		'db' => 'loginsystem'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

// auto load classes when they are needed instead of using multiple require_once functions
spl_autoload_register(function ($class) {
	require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';
