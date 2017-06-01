<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/31/2015
 * Time: 12:30 AM
 */

ini_set('display_errors', true);
error_reporting(E_ALL);
if(is_readable('../shittalk_functions.php')) {
    echo('ok!');
}
include('../shittalk_functions.php');

createshittalk();
echo "hey";

//function mySqlQuery($query)
//{
//    $servername = 'shittalk.cinwj67fm5hu.us-east-1.rds.amazonaws.com';
//    $username = "shittalk";
//    $password = "shittalk";
//    $dbname = "shittalk";
//
//    $conn = new mysqli($servername, $username, $password, $dbname);
//
//    // Check connection
//    if ($conn->connect_error) {
//        die("Connection failed: " . $conn->connect_error);
//    }
//    $result = $conn->query($query);
//
//    $conn->close();
//
//    return $result;
//}

function createSchema()
{
    $sql = "CREATE DATABASE `shittalk` /*!40100 DEFAULT CHARACTER SET utf8 */;";
    $result = mySqlQuery($sql);
    return $result;
}

function createshittalk()
{
    $sql = "CREATE TABLE `shittalk`.`shittalk` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `text` TEXT NULL,
      `category` TEXT NULL,
      `downloads` INT NULL,
      `views` INT NULL,
      `upvotes` INT NULL,
      `downvotes` INT NULL,
      `highlight` TINYINT NULL,
      `date_created` DATETIME NULL,
      `custom` TINYINT NULL,
      PRIMARY KEY (`id`),
      UNIQUE INDEX `id_UNIQUE` (`id` ASC));";
    $result = mySqlQuery($sql);
    return $result;
}