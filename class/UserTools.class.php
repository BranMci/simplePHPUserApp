<?php
//UserTools.class.php

require_once 'User.class.php';
require_once 'DB.class.php';

class UserTools {
	//Log the user in. First checks to see if 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	public function login($username, $password) {
		$hashedPassword = md5($password);
		$result = mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'");

		if(mysql_num_rows($result) == 1) {
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['login_time']);
		unset($_SESSION['logged_in']);
		session_destroy();
	}

	//Check to see if a username exists.
	//This is called during registration to make sure all usernames are unique/
	public function checkUsernameExists($username) {
		$result = mysql_query("select id from users where username='$username'");
		if(mysql_num_rows($result) == 0) {
			return false;
		} else {
			return true;
		}
	}

	public function get($id) {
		$db = new DB();
		$result = $db->select('users', "id = $id");

		return new User($result);
	}

}


?>