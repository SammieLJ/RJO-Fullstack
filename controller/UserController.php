<?php

require_once("model/UserDB.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class UserController {

    public static function loginFormInsecure() {
        ViewHelper::render("view/user-login-form.php", ["formAction" => "login-insecure"]);
    }

    public static function loginInsecure() {
        //$user = UserDB::getUserInsecure($_POST["username"], $_POST["password"]);
        // uporabiš lahko: FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_STRING
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $user = UserDB::getUserInsecure($username, $password);

        if ($user) {
            User::login($user);

            $vars = [
                "username" => $username,
                "password" => $password
            ];

            ViewHelper::render("view/user-login-success.php", $vars);
        } else {
            ViewHelper::render("view/user-login-form.php", [
                "errorMessage" => "Invalid username or password.",
                "formAction" => "login-insecure"
            ]);
        }
    }

    public static function loginForm() {
        ViewHelper::render("view/user-login-form.php", ["formAction" => "login"]);
    }

    public static function loggedIn() {
        if (User::isLoggedIn()) {
            $vars = [
                "username" => User::getUsername(),
                "password" => ""
            ];
    
            ViewHelper::render("view/user-login-success.php", $vars);
        } else {
            ViewHelper::render("view/user-login-form.php", [
                "errorMessage" => "Please, log in.",
                "formAction" => "login"
            ]);
        }  
    }

    public static function login() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $user = UserDB::getUser($data["username"], $data["password"]);

        $errorMessage =  empty($data["username"]) || empty($data["password"]) || $user == null ? "Invalid username or password." : "";

        if (empty($errorMessage)) {
            User::login($user);

            $vars = [
                "username" => $data["username"],
                "password" => $data["password"]
            ];

            ViewHelper::render("view/user-login-success.php", $vars);
        } else {
            ViewHelper::render("view/user-login-form.php", [
                "errorMessage" => $errorMessage,
                "formAction" => "login"
            ]);
        }
    }
    public static function registerNewAcc() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "confirm_password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $username_err = ""; $password_err=""; $confirm_password_err = "";
        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else {
            // preverim, če takšen uporabnik že obstaja v bazi
            //$user = UserDB::getUser($data["username"], $data["password"]); --> tole nima smisla, ker če uporabnik obstaja in drugo geslo, vseeno vrne napako, ker je collision v db
            $user = UserDB::getUserName($data["username"]);
            if ($user != null) {
                $username_err = "This user already exists in database.";
            }
        }

        // Validate password
        if(empty(trim($data["password"]))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($data["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($data["password"]);
        }
    
        // Validate confirm password
        if(empty(trim($data["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($data["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        //$errorMessage = empty($data["username"]) || empty($data["password"])  || empty($data["confirm_password"]) ? "Invalid username or password." : "";
        //$errorMessage = strcmp($data["password"], $data["confirm_password"]) !== 0 ? "" : "Two passwords are not equal.";

        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && $user == null){
            // vnesemo in ponovno preverimo, če sedaj dobimo uporabnika, uporabnika dodamo v sejo.
            UserDB::insertUser($data["username"], $data["password"]);
            $user = UserDB::getUser($data["username"], $data["password"]);
            User::login($user);

            $vars = [
                "username" => $data["username"],
                "password" => $data["password"]
            ];

            ViewHelper::render("view/user-login-success.php", $vars);
        } else {
            ViewHelper::render("view/user-register-form.php", [
                //"errorMessage" => $errorMessage,
                "formAction" => "register",
                "username" => $data["username"],
                "password" => $data["password"],
                "confirm_password" => $data["confirm_password"],
                "username_err" => $username_err,
                "password_err" => $password_err,
                "confirm_password_err" => $confirm_password_err,
            ]);
        }
    }
    public static function registerNewAccForm() {
        ViewHelper::render("view/user-register-form.php", [
            "formAction" => "register",
            "username" => "",
            "password" => "",
            "confirm_password" => "",
            "username_err" => "",
            "password_err" => "",
            "confirm_password_err" => "",
        ]);
    }
    public static function logout() {
        User::logout();

        ViewHelper::redirect(BASE_URL . "login");
    }
}