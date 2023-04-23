CREATE DATABASE IF NOT EXISTS `test-care`;

USE `test-care`;

CREATE TABLE IF NOT EXISTS `Patient` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) DEFAULT NULL,
    `sex` VARCHAR(255) DEFAULT NULL,
    `religion` VARCHAR(255) DEFAULT NULL,
    `phone` VARCHAR(255) DEFAULT NULL,
    `address` VARCHAR(255) DEFAULT NULL,
    `nik` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
)