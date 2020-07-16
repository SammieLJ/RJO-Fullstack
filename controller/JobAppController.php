<?php

require_once("model/JobAppDB.php");
require_once("model/User.php");
require_once("ViewHelper.php");
define("No_ENTRIES_PER_PAGE", 6); // tukaj poljubno lahko nastaviš, koliko se bo prilog prikazalo

class JobAppController {

    public static function index() {
        if (User::isLoggedIn()) {
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            // set pageno into SESSION, that can be easier navigated back
            $_SESSION['pageno'] = $pageno;

            $no_of_records_per_page = No_ENTRIES_PER_PAGE; 
            $offset = ($pageno-1) * $no_of_records_per_page;

            if (User::isAdmin()) {
                $total_rows = JobAppDB::countTable();
            } else {
                $total_rows = JobAppDB::countTableByUser(User::getUserId());
            }
            
            $total_pages = ceil($total_rows[0]["count(*)"] / $no_of_records_per_page);
            //var_dump($total_pages);

            if (User::isAdmin()) {
                $jobapps = JobAppDB::getDataOnPage($offset, $no_of_records_per_page);
            } else {
                $jobapps = JobAppDB::getDataOnPageByUser($offset, $no_of_records_per_page, User::getUserId());
            }

            if (isset($jobapps) && !empty($jobapps)) {
                ViewHelper::render("view/jobappl-list.php", [
                    "jobapps" => $jobapps, 
                    "loggedIn" => User::isLoggedIn(),
                    "total_pages" => $total_pages
                ]);
            } else {
                ViewHelper::render("view/jobappl-empty-list.php");
            }
        } else {
            //ViewHelper::render("view/jobappl-add.php", ["formAction" => "jobs/add"]);
            ViewHelper::render("view/user-login-form.php", ["formAction" => "login"]);
        }
        
    }

    public static function addForm($data = [], $errors = []) {
        if (empty($data)) {
            $data["first"] = ""; $data["last"] = ""; $data["title"] = ""; $data["opis_vloge"] = ""; 
        }
        $vars = ["formAction" => "jobs/add", "data" => $data, "errors" => $errors];
        ViewHelper::render("view/jobappl-add.php", $vars);
    }
    
    public static function showAddForm($data = [], $errors = []) {
        ViewHelper::render("view/jobappl-add.php", ["data" => $data, "formAction" => "jobs/add", "errors" => $errors]);
        //ViewHelper::redirect(BASE_URL . "jobs/edit");  
    }

    public static function add() {
        $rules = [
            "first" =>  ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "last" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "title" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opis_vloge" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        //var_dump($data);

        // check if text in 4 fields is empty
        $errors["first"] = empty($data["first"]) ? "Enter your first name." : "";
        $errors["last"] = empty($data["last"]) ? "Enter your last name." : "";
        $errors["title"] = empty($data["title"]) ? "Enter your title." : "";
        $errors["opis_vloge"] = empty($data["opis_vloge"]) ? "Enter your application description." : "";

        // check for min length in 4 fields
        $errors["first"] = empty($errors["first"]) && strlen($data["first"]) < 3 ? "First name is to short, 3 char min." : $errors["first"];
        $errors["last"] = empty($errors["last"]) && strlen($data["last"]) < 3  ? "Last name is to short, 3 char min." : $errors["last"];
        $errors["title"] = empty($errors["title"]) && strlen($data["title"]) < 5 ? "Address is to short, 5 char min." : $errors["title"];
        $errors["opis_vloge"] = empty($errors["opis_vloge"]) && strlen($data["opis_vloge"]) < 10 ? "Description is to short, 10 char min." : $errors["opis_vloge"];

        // check for length in 4 fields
        $errors["first"] = empty($errors["first"]) && strlen($data["first"]) > 50 ? "First name is to long, 50 char max." :  $errors["first"];
        $errors["last"] = empty($errors["last"]) && strlen($data["last"]) > 70 ? "Last name is to long, 70 char max." : $errors["last"];
        $errors["title"] = empty($errors["title"]) && strlen($data["title"]) > 70 ? "Address is to long, 70 char max." : $errors["title"];
        $errors["opis_vloge"] = empty($errors["opis_vloge"]) && strlen($data["opis_vloge"]) > 400 ? "Description is to long, 400 char max." : $errors["opis_vloge"];

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            JobAppDB::insert(User::getUserId(), $data["first"], $data["last"], $data["title"], $data["opis_vloge"], 0); // last is 0 stars
            //ViewHelper::redirect(BASE_URL . "jobs/");
            ViewHelper::render("view/jobappl-submit.php", ["errorMessage" => ""]); // potrditvena stran oddane vloge
        } else {
            self::showAddForm($data, $errors);
        }
    }

    public static function editForm() {
        if (isset($_GET["editID"]) && !empty($_GET["editID"])) {
            $data = JobAppDB::get($_GET["editID"]);
            ViewHelper::render("view/jobappl-edit.php", ["data" => $data, "formAction" => "jobs/edit", "errors" => ""]);
            //ViewHelper::redirect(BASE_URL . "jobs/edit");
        } else {
            //var_dump($_GET["editID"]);
            $pageno = empty($_SESSION['pageno']) ? "" : "?pageno=".$_SESSION['pageno'];
            ViewHelper::redirect(BASE_URL . "jobs".$pageno);
        }    
    } 
    
    public static function showEditForm($data = [], $errors = []) {
        ViewHelper::render("view/jobappl-edit.php", ["data" => $data, "formAction" => "jobs/edit", "errors" => $errors]);
        //ViewHelper::redirect(BASE_URL . "jobs/edit");  
    } 

    public static function edit() {
        $rules = [
            "id"   => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "first" =>  ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "last" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "title" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opis_vloge" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "token" => ["filter" => FILTER_UNSAFE_RAW]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        // check if text in 4 fields is empty and check for CSRF token
        $errors["first"] = empty($data["first"]) ? "Enter your first name." : "";
        $errors["last"] = empty($data["last"]) ? "Enter your last name." : "";
        $errors["title"] = empty($data["title"]) ? "Enter your address." : "";
        $errors["opis_vloge"] = empty($data["opis_vloge"]) ? "Enter your application description." : "";
        $errors["id"] = empty($data["id"]) ? "ID is missing." : "";
        $errors["token"] = $_SESSION['token'] == $data["token"] ? "" : "Token is wrong or missing!";

        // check for min length in 4 fields
        $errors["first"] = empty($errors["first"]) && strlen($data["first"]) < 3 ? "First name is to short, 3 char min." : $errors["first"];
        $errors["last"] = empty($errors["last"]) && strlen($data["last"]) < 3  ? "Last name is to short, 3 char min." : $errors["last"];
        $errors["title"] = empty($errors["title"]) && strlen($data["title"]) < 5 ? "Address is to short, 5 char min." : $errors["title"];
        $errors["opis_vloge"] = empty($errors["opis_vloge"]) && strlen($data["opis_vloge"]) < 10 ? "Description is to short, 10 char min." : $errors["opis_vloge"];

        // check for length in 4 fields
        $errors["first"] = empty($errors["first"]) && strlen($data["first"]) > 50 ? "First name is to long, 50 char max." :  $errors["first"];
        $errors["last"] = empty($errors["last"]) && strlen($data["last"]) > 70 ? "Last name is to long, 70 char max." : $errors["last"];
        $errors["title"] = empty($errors["title"]) && strlen($data["title"]) > 70 ? "Address is to long, 70 char max." : $errors["title"];
        $errors["opis_vloge"] = empty($errors["opis_vloge"]) && strlen($data["opis_vloge"]) > 400 ? "Description is to long, 400 char max." : $errors["opis_vloge"];

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            JobAppDB::update($data["id"], $data["first"], $data["last"], $data["title"], $data["opis_vloge"]);
            $pageno = empty($_SESSION['pageno']) ? "" : "?pageno=".$_SESSION['pageno'];
            ViewHelper::redirect(BASE_URL . "jobs".$pageno);
        } else {
            self::showEditForm($data, $errors);
        }
    }

    public static function delete() {
        if (!User::isLoggedIn()) {
            throw new Exception("Login required.");
        }

        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "delete_confirmation" => [
                "filter" => FILTER_VALIDATE_BOOLEAN
            ],
            "token" => FILTER_UNSAFE_RAW
        ];
        $data = filter_input_array(INPUT_GET, $rules);

        $errors["id"] = $data["id"] === null ? "Cannot delete without a valid ID." : "";
        $errors["delete_confirmation"] = $data["delete_confirmation"] === null ? "Forgot to check the delete box?" : "";
        $errors["token"] = $_SESSION['token'] == $data["token"] ? "" : "Token is wrong or missing!";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        $pageno = empty($_SESSION['pageno']) ? "" : "?pageno=".$_SESSION['pageno'];
        if ($isDataValid) {
            JobAppDB::delete($data["id"]);
            $url = BASE_URL . "jobs".$pageno;
        } else {
            if ($data["id"] !== null) {
                $url = BASE_URL . "jobs/edit?editID=" . $data["id"].$pageno;
            } else {
                $url = BASE_URL . "jobs".$pageno;
            }
        }

        ViewHelper::redirect($url);
    }

    public static function updateStarRatingApi() {
        if (isset($_GET["ID"]) && !empty($_GET["ID"]) && isset($_GET["ratingValue"]) && !empty($_GET["ratingValue"])) {
            $ratingID = str_replace("rating", "", $_GET["ID"]);
            $hits = JobAppDB::update_star_rating($ratingID, $_GET["ratingValue"]);
        } else {
            $hits = [];
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }
}