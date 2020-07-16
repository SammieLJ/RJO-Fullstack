<?php

require_once "DBInit.php";

class JobAppDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, first_name, last_name, job_title, job_text, star_rate, job_date FROM job_applications");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getDataOnPage($offset, $no_of_records_per_page) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, first_name, last_name, job_title, job_text, star_rate, job_date FROM job_applications 
        LIMIT :offset, :no_of_records_per_page");
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        $statement->bindParam(":no_of_records_per_page", $no_of_records_per_page, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getDataOnPageByUser($offset, $no_of_records_per_page, $id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, first_name, last_name, job_title, job_text, star_rate, job_date FROM job_applications WHERE user_id = :id 
        LIMIT :offset, :no_of_records_per_page");
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        $statement->bindParam(":no_of_records_per_page", $no_of_records_per_page, PDO::PARAM_INT);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function countTable() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT count(*) FROM job_applications");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function countTableByUser($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT count(*) FROM job_applications WHERE user_id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM job_applications WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, first_name as first, last_name as last, job_title as title, job_text as opis_vloge, star_rate, job_date FROM job_applications 
            WHERE id =:id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public static function insert($user_id, $first_name, $last_name, $job_title, $job_text, $star_rate) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO job_applications (user_id, first_name, last_name, job_title, job_text, star_rate, job_date)
            VALUES (:user_id, :first_name, :last_name, :job_title, :job_text, :star_rate, NOW())");
        $statement->bindParam(":user_id", $user_id);
        $statement->bindParam(":first_name", $first_name);
        $statement->bindParam(":last_name", $last_name);
        $statement->bindParam(":job_title", $job_title);
        $statement->bindParam(":job_text", $job_text);
        $statement->bindParam(":star_rate", $star_rate);
        //$statement->bindParam(":job_date", $job_date);
        $statement->execute();
    }

    public static function update($id, $first_name, $last_name, $job_title, $job_text) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE job_applications SET first_name = :first_name, last_name = :last_name, job_title = :job_title,
            job_text = :job_text WHERE id =:id");
        $statement->bindParam(":first_name", $first_name);
        $statement->bindParam(":last_name", $last_name);
        $statement->bindParam(":job_title", $job_title);
        $statement->bindParam(":job_text", $job_text);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function update_star_rating($id, $star_rate) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE job_applications SET star_rate = :star_rate WHERE id =:id");
        $statement->bindParam(":star_rate", $star_rate);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

}

