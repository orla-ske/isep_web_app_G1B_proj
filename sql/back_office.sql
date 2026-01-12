-- Admin Activity Log Table
CREATE TABLE IF NOT EXISTS `petstridedb`.`admin_activity_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `admin_id` INT NOT NULL,
  `action_type` VARCHAR(50) NULL,
  `target_table` VARCHAR(50) NULL,
  `target_id` INT NULL,
  `description` TEXT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_admin_activity_users_idx` (`admin_id` ASC),
  CONSTRAINT `fk_admin_activity_users`
    FOREIGN KEY (`admin_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- FAQ Table
CREATE TABLE IF NOT EXISTS `petstridedb`.`faq` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(500) NOT NULL,
  `answer` TEXT NOT NULL,
  `category` VARCHAR(100) NULL,
  `display_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_faq_users_idx` (`created_by` ASC),
  CONSTRAINT `fk_faq_users`
    FOREIGN KEY (`created_by`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- System Settings Table
CREATE TABLE IF NOT EXISTS `petstridedb`.`system_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `setting_type` VARCHAR(50) NULL,
  `description` TEXT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_settings_users_idx` (`updated_by` ASC),
  CONSTRAINT `fk_settings_users`
    FOREIGN KEY (`updated_by`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Reports Table
CREATE TABLE IF NOT EXISTS `petstridedb`.`reports` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `report_type` VARCHAR(50) NOT NULL,
  `reporter_id` INT NOT NULL,
  `target_type` VARCHAR(50) NULL,
  `target_id` INT NULL,
  `reason` TEXT NULL,
  `status` VARCHAR(50) DEFAULT 'pending',
  `admin_notes` TEXT NULL,
  `resolved_by` INT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_reports_reporter_idx` (`reporter_id` ASC),
  INDEX `fk_reports_resolver_idx` (`resolved_by` ASC),
  CONSTRAINT `fk_reports_reporter`
    FOREIGN KEY (`reporter_id`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reports_resolver`
    FOREIGN KEY (`resolved_by`)
    REFERENCES `petstridedb`.`users` (`id`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION
) ENGINE = InnoDB;