<?php

require_once "DBInit.php";

class UserDB {

    // Returns true if a valid combination of a username and a password are provided.
    public static function getUserInsecure($username, $password) {
        $dbh = DBInit::getInstance();

        // COMPLETELY INSECURE: NEVER CONSTRUCT SQL QUERIES THIS WAY
        $stmt = $dbh->prepare("SELECT id, username FROM job_users 
            WHERE username = '$username' AND password = '$password'");
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public static function getUser($username, $password) {
        /* This function is more secure because
            1) It uses prepared statements and it binds variables;
            2) It does not store passwords in plain-text in the database

            For creating passwords, use: http://php.net/manual/en/function.password-hash.php
            For checking passwords, use: http://php.net/manual/en/function.password-verify.php
            For more information, see: http://php.net/manual/en/ref.password.php
        */
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT id, is_admin, username, password FROM job_users_shadow 
            WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user !== false && password_verify($password, $user["password"])) {
            unset($user["password"]);
            return $user;
        } else {
            return false;
        }
    }

    public static function getUserName($username) {
        /* This function is more secure because
            1) It uses prepared statements and it binds variables;
            2) It does not store passwords in plain-text in the database

            For creating passwords, use: http://php.net/manual/en/function.password-hash.php
            For checking passwords, use: http://php.net/manual/en/function.password-verify.php
            For more information, see: http://php.net/manual/en/ref.password.php
        */
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT id, is_admin, username, password FROM job_users_shadow 
            WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();

       return $user = $stmt->fetch();
    }

    // Returns true if user is administrator
    public static function isUserAdmin($username) {
        $dbh = DBInit::getInstance();

        // COMPLETELY INSECURE: NEVER CONSTRUCT SQL QUERIES THIS WAY
        $stmt = $dbh->prepare("SELECT username FROM job_users 
            WHERE username = '$username' AND is_admin=1");
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // inser new normal user (is_admin=0), hash password ("to shadow")
    public static function insertUser($user_name, $password) {
        $db = DBInit::getInstance();

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $statement = $db->prepare("INSERT INTO job_users_shadow (username, password, is_admin)
            VALUES (:username, :password, 0)");
        $statement->bindParam(":username", $user_name);
        $statement->bindParam(":password", $password_hashed);
        $statement->execute();
    }
}
