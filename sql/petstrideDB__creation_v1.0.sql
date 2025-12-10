-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema petstridedb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `petstridedb` DEFAULT CHARACTER SET utf8 ;
USE `petstridedb` ;

-- -----------------------------------------------------
-- Table `petstridedb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `phone` VARCHAR(45) NULL,
  `password` VARCHAR(255) NULL,
  `city` VARCHAR(45) NULL,
  `role` VARCHAR(45) NULL,
  `email` VARCHAR(255) NULL,
  `profile_picture` TEXT NULL,
  `postal_code` VARCHAR(45) NULL,
  `address` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`forumTopic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`forumTopic` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_forumTopic_users1_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_forumTopic_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`ForumPost`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`ForumPost` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `content` TEXT NULL,
  `timestamp` TIMESTAMP NULL,
  `likes` INT NULL,
  `is_locked` VARCHAR(45) NULL,
  `Users_idUsers` INT NOT NULL,
  `Users_id` INT NOT NULL,
  `ForumTopic_id` INT NOT NULL,
  PRIMARY KEY (`id`, `Users_idUsers`),
  INDEX `fk_ForumPost_Users1_idx` (`Users_id` ASC) VISIBLE,
  INDEX `fk_ForumPost_ForumTopic1_idx` (`ForumTopic_id` ASC) VISIBLE,
  CONSTRAINT `fk_ForumPost_Users1`
    FOREIGN KEY (`Users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ForumPost_ForumTopic1`
    FOREIGN KEY (`ForumTopic_id`)
    REFERENCES `petstridedb`.`forumTopic` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`ForumComment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`ForumComment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `timestamp` TIMESTAMP NULL,
  `likes` INT NULL,
  `content` VARCHAR(255) NULL,
  `Users_id` INT NOT NULL,
  `ForumPost_id` INT NOT NULL,
  `ForumPost_Users_idUsers` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ForumComment_Users1_idx` (`Users_id` ASC) VISIBLE,
  INDEX `fk_ForumComment_ForumPost1_idx` (`ForumPost_id` ASC, `ForumPost_Users_idUsers` ASC) VISIBLE,
  CONSTRAINT `fk_ForumComment_Users1`
    FOREIGN KEY (`Users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ForumComment_ForumPost1`
    FOREIGN KEY (`ForumPost_id` , `ForumPost_Users_idUsers`)
    REFERENCES `petstridedb`.`ForumPost` (`id` , `Users_idUsers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Payment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Payment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` FLOAT NULL,
  `method` VARCHAR(45) NULL,
  `timestamp` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Job`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Job` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `location` VARCHAR(45) NULL,
  `user_id` INT NULL,
  `pet_id` INT NULL,
  `payment_status` INT NULL,
  `price` FLOAT NULL,
  `caregiver_id` INT NULL,
  `status` VARCHAR(45) NULL,
  `start_time` TIMESTAMP NULL,
  `end_time` TIMESTAMP NULL,
  `service_type` VARCHAR(45) NULL,
  `message_id` INT NULL,
  `Payment_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Job_Payment1_idx` (`Payment_id` ASC) VISIBLE,
  CONSTRAINT `fk_Job_Payment1`
    FOREIGN KEY (`Payment_id`)
    REFERENCES `petstridedb`.`Payment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Job_Agreement`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Job_Agreement` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  `content` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `last_updated` TIMESTAMP NULL,
  `Users_id` INT NOT NULL,
  `Job_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Job_Agreement_Users1_idx` (`Users_id` ASC) VISIBLE,
  INDEX `fk_Job_Agreement_Job1_idx` (`Job_id` ASC) VISIBLE,
  CONSTRAINT `fk_Job_Agreement_Users1`
    FOREIGN KEY (`Users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Job_Agreement_Job1`
    FOREIGN KEY (`Job_id`)
    REFERENCES `petstridedb`.`Job` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sender_id` INT NULL,
  `reciever_id` INT NULL,
  `content` VARCHAR(255) NULL,
  `timestamp` TIMESTAMP NULL,
  `is_read` VARCHAR(45) NULL,
  `Users_id` INT NOT NULL,
  `Job_Agreement_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Message_Users1_idx` (`Users_id` ASC) VISIBLE,
  INDEX `fk_Message_Job_Agreement1_idx` (`Job_Agreement_id` ASC) VISIBLE,
  CONSTRAINT `fk_Message_Users1`
    FOREIGN KEY (`Users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Message_Job_Agreement1`
    FOREIGN KEY (`Job_Agreement_id`)
    REFERENCES `petstridedb`.`Job_Agreement` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Rating`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Rating` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Feedback` TEXT NULL,
  `Stars` INT NULL,
  `Users_id` INT NOT NULL,
  `Job_Agreement_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Rating_Users1_idx` (`Users_id` ASC) VISIBLE,
  INDEX `fk_Rating_Job_Agreement1_idx` (`Job_Agreement_id` ASC) VISIBLE,
  CONSTRAINT `fk_Rating_Users1`
    FOREIGN KEY (`Users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Rating_Job_Agreement1`
    FOREIGN KEY (`Job_Agreement_id`)
    REFERENCES `petstridedb`.`Job_Agreement` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Pet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Pet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `weight` FLOAT NULL,
  `name` VARCHAR(45) NULL,
  `age` INT NULL,
  `breed` VARCHAR(255) NULL,
  `gender` VARCHAR(45) NULL,
  `height` FLOAT NULL,
  `photo_url` TEXT NULL,
  `is_active` VARCHAR(45) NULL,
  `owner_id` INT NULL,
  `vaccintation_status` VARCHAR(255) NULL,
  `color` VARCHAR(255) NULL,
  `Users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Pet_Users1_idx` (`Users_id` ASC) VISIBLE,
  CONSTRAINT `fk_Pet_Users1`
    FOREIGN KEY (`Users_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Device`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Device` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`device_distribution`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`device_distribution` (
  `id` INT NOT NULL,
  `Pet_id` INT NOT NULL,
  `Device_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_device_distribution_Pet1_idx` (`Pet_id` ASC) VISIBLE,
  INDEX `fk_device_distribution_Device1_idx` (`Device_id` ASC) VISIBLE,
  CONSTRAINT `fk_device_distribution_Pet1`
    FOREIGN KEY (`Pet_id`)
    REFERENCES `petstridedb`.`Pet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_device_distribution_Device1`
    FOREIGN KEY (`Device_id`)
    REFERENCES `petstridedb`.`Device` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Pet_tracking_data`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Pet_tracking_data` (
  `id` INT NOT NULL,
  `latitude` VARCHAR(45) NULL,
  `longitude` VARCHAR(45) NULL,
  `timestamp` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `petstridedb`.`Tracking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `petstridedb`.`Tracking` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Pet_tracking_data_id` INT NOT NULL,
  `Device_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Tracking_Pet_tracking_data1_idx` (`Pet_tracking_data_id` ASC) VISIBLE,
  INDEX `fk_Tracking_Device1_idx` (`Device_id` ASC) VISIBLE,
  CONSTRAINT `fk_Tracking_Pet_tracking_data1`
    FOREIGN KEY (`Pet_tracking_data_id`)
    REFERENCES `petstridedb`.`Pet_tracking_data` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tracking_Device1`
    FOREIGN KEY (`Device_id`)
    REFERENCES `petstridedb`.`Device` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
