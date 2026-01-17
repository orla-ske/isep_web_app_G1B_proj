-- Drop the old table
DROP TABLE IF EXISTS `petstridedb`.`Message`;

-- Create the corrected table
CREATE TABLE IF NOT EXISTS `petstridedb`.`Message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sender_id` INT NOT NULL,
  `receiver_id` INT NOT NULL,
  `content` TEXT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `is_read` VARCHAR(3) DEFAULT 'no',
  `job_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Message_sender_idx` (`sender_id` ASC),
  INDEX `fk_Message_receiver_idx` (`receiver_id` ASC),
  INDEX `fk_Message_job_idx` (`job_id` ASC),
  CONSTRAINT `fk_Message_sender`
    FOREIGN KEY (`sender_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Message_receiver`
    FOREIGN KEY (`receiver_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Message_job`
    FOREIGN KEY (`job_id`)
    REFERENCES `petstridedb`.`Job` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;