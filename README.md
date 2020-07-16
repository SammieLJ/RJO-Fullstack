# RJO-Fullstack
Rate Job Offers web application full stack (html, css, jQuery, PHP7, MySQL)

## Idea for application
In early spring 2020, for Hackatlon, I have developed frontend client SPA application (using HTML, CSS, jQuery) that worked only in browser, no servrside. For storage was used browser localstorage. You can check project https://github.com/SammieLJ/RateJobOffers

So I decided that would be great idea, if I could make Fullstack version, using PHP7, web server with proper backend db (MySQL).

## Installation procedure

On Web server Apache/nginx/(or similar that spports PHP), create new folder "RJO-Fullstack" in "htdocs" or "/var/www".

In folder "RJO-Fullstack" get all code from guthub.

In folder "sql" you will find sql dump file "baza_uvoz.sql". Import using your favorite MySQL editor (web or standalone). You can rename db schema from "dn3" to your liking. If you will do refactoring in sql file, please don't forget to correct it below.

In folder "model" open file "DBInit.php", set yours MySQL user, password

```php
private static $host = "localhost";
private static $user = "root";
private static $password = "";
private static $schema = "DN3"; // set DB schema to your liking
 ```
 
 You have configured database and imported some testing data into MySQL.
 
 You can start application using "index.php" on root folder, accessing with your browser like https://localhost:8080/RJO-Fullstack/index.php
 
 ## Default users
 
 Admins are:
 User: user, Password: password
 User: student, Password: vaje
 User: asistent, Password: vaje
 
 Normal users are:
 User: uporabnik1, Password: nekogeslo
 User: uporabnik2, Password: drugogeslo
 
 You can clean db at your preference.
 
 ## Special thanks
 
 To Mr. David Jelec, for providing custom MVC framework written in PHP
