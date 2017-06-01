<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/31/2015
 * Time: 12:30 AM
 */

require('../shittalk_functions.php');

createshittalk();
echo "Created shittalk table";


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
      `upvotes` INT NOT NULL DEFAULT 0,
      `downvotes` INT NOT NULL DEFAULT 0,
      `highlight` TINYINT NULL,
      `date_created` DATETIME NULL,
      `custom` TINYINT NULL,
      PRIMARY KEY (`id`),
      UNIQUE INDEX `id_UNIQUE` (`id` ASC));";
    $result = mySqlQuery($sql);
    return $result;
}