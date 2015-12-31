<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/31/2015
 * Time: 12:30 AM
 */

require_once(__DIR__ . '/../shittalk_functions.php');

set_time_limit(0);
error_reporting(E_ALL);
ob_implicit_flush(TRUE);
ob_end_flush();

function createSchema()
{
    $sql = "CREATE DATABASE `shittalk_generator` /*!40100 DEFAULT CHARACTER SET utf8 */;";
    $result = mySqlQuery($sql);
    return $result;
}

function createShittalkDB()
{
    $sql = "CREATE TABLE `shittalk_generator`.`shittalkDB` (
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