<?php

//User.class.php

require_once 'DB.class.php';

class User {

	public $id;
	public $username;
	public $hashedPassword;
	public $email;
	public $joinDate;

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		
	}
}