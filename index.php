<?php

session_start();

require_once("controller/UserController.php");
require_once("controller/JobAppController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("FONTS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/fonts/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");
define("STAR_RATE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/star-rating-master/");
define("SVG_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/svg/");


$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "login-insecure" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::loginInsecure();
        } else {
            UserController::loginFormInsecure();
        }
    },
    "login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::loginForm();
        }
    },
    "logout" => function () {
        UserController::logout();
    },
    "logged" => function () {
        UserController::loggedIn();
    },
    "register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::registerNewAcc();
        } else {
            UserController::registerNewAccForm();
        }
    },
    "jobs" => function () {
        JobAppController::index();
    },
    "jobs/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JobAppController::add();
        } else {
            JobAppController::addForm();
        }
    },
    "jobs/edit" => function () {
        //var_dump($_GET["editID"]);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JobAppController::edit();
        } else {
            JobAppController::editForm();
        }
    },
    "jobs/delete" => function () {
        JobAppController::delete();
    },
    # API for star rate update
    "api/starate/update" => function () {
        JobAppController::updateStarRatingApi();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "login"); //prej jobs
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 
