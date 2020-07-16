<?php

class User {
	public static function login($user) {
		$_SESSION["user"] = $user;

		if (empty($_SESSION['token'])) {
			// RANDOM STRING CREDITS : https://www.thecodedeveloper.com/generate-random-alphanumeric-string-with-php/
			//$length = 32;
			//$_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length); 

			// FOR PHP 7, CREDITS : https://stackoverflow.com/questions/6287903/how-to-properly-add-csrf-token-using-php
			$_SESSION['token'] = bin2hex(random_bytes(32));
		}
	}
	public static function isAdmin() {
		return $_SESSION["user"]["is_admin"];
	}

	public static function logout() {
		session_destroy();
	}

	public static function isLoggedIn() {
		return isset($_SESSION["user"]);
	}

	public static function getUsername() {
		return $_SESSION["user"]["username"];
	}

	public static function getUserId() {
		return $_SESSION["user"]["id"];
	}
}