DROP DATABASE IF EXISTS `dms`;

CREATE DATABASE `dms` CHARSET utf8;

USE `dms`;

-- TABLES
CREATE TABLE `branch` (
    `branch_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `branch_name` VARCHAR(50) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY(`branch_id`),
    CONSTRAINT `uq_branch_name` UNIQUE KEY(`branch_name`)
);

CREATE TABLE `department` (
    `department_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `department_name` VARCHAR(50) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY(`department_id`),
    CONSTRAINT `uq_department_name` UNIQUE KEY(`department_name`)
);

CREATE TABLE `branch_department` (
    `branch_id` TINYINT UNSIGNED NOT NULL,
    `department_id` TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY(`branch_id`, `department_id`)
);

CREATE TABLE `user` (
    `user_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(30) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `salt` VARCHAR(33) NOT NULL,
    `passwd` VARCHAR(65) NOT NULL,
    `active` TINYINT NOT NULL DEFAULT 0,
    `last_login` DATETIME,
    `remember_token` VARCHAR(100),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `is_admin` TINYINT NOT NULL DEFAULT 0,
    `branch_id` TINYINT UNSIGNED,
    `department_id` TINYINT UNSIGNED,
    PRIMARY KEY(`user_id`),
    CONSTRAINT `uq_email` UNIQUE KEY(`email`),
    CONSTRAINT `uq_username` UNIQUE KEY(`username`)
);

CREATE TABLE `document_category` (
    `category_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_name` VARCHAR(50) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY(`category_id`),
    CONSTRAINT `uq_category_name` UNIQUE KEY(`category_name`)
);

CREATE TABLE `document` (
    `document_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `creation_date` DATE NOT NULL,
    `user_id` SMALLINT UNSIGNED,
    `category_id` TINYINT UNSIGNED,
    `branch_id` TINYINT UNSIGNED,
    `department_id` TINYINT UNSIGNED,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY(`document_id`),
    CONSTRAINT `uq_title` UNIQUE KEY(`title`)
);

CREATE TABLE `document_file` (
    `file_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(255) NOT NULL,
    `document_id` INT UNSIGNED,
    PRIMARY KEY(`file_id`),
    CONSTRAINT `uq_filename` UNIQUE KEY(`filename`)
);

-- TABLE INDEXES
ALTER TABLE `user` ADD INDEX `ix_user_username`(`username`);
ALTER TABLE `user` ADD INDEX `ix_user_passwd`(`passwd`);
ALTER TABLE `user` ADD INDEX `ix_user_salt`(`salt`);
ALTER TABLE `user` ADD INDEX `ix_user_active`(`active`);

ALTER TABLE `document` ADD INDEX `creation_date`(`creation_date`);
ALTER TABLE `document` ADD FULLTEXT INDEX `ftx_title_desc`(`title`, `description`);

-- FOREIGN KEYS
ALTER TABLE `branch_department`
ADD CONSTRAINT `fk_branch_department_branch`
FOREIGN KEY( `branch_id` ) REFERENCES `branch`( `branch_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `branch_department`
ADD CONSTRAINT `fk_branch_department_department`
FOREIGN KEY( `department_id` ) REFERENCES `department`( `department_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `user`
ADD CONSTRAINT `fk_user_branch`
FOREIGN KEY( `branch_id` ) REFERENCES `branch`( `branch_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `user`
ADD CONSTRAINT `fk_user_department`
FOREIGN KEY( `department_id` ) REFERENCES `department`( `department_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `document`
ADD CONSTRAINT `fk_document_user`
FOREIGN KEY( `user_id` ) REFERENCES `user`( `user_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `document`
ADD CONSTRAINT `fk_document_category`
FOREIGN KEY( `category_id` ) REFERENCES `document_category`( `category_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `document`
ADD CONSTRAINT `fk_document_branch`
FOREIGN KEY( `branch_id` ) REFERENCES `branch`( `branch_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `document`
ADD CONSTRAINT `fk_document_department`
FOREIGN KEY( `department_id` ) REFERENCES `department`( `department_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `document_file`
ADD CONSTRAINT `fk_document_file`
FOREIGN KEY( `document_id` ) REFERENCES `document`( `document_id` )
ON DELETE CASCADE ON UPDATE RESTRICT;
