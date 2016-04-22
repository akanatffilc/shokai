# テーブルのダンプ user
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `shokai`.`user` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `fb_id` VARCHAR(255) NOT NULL,
  `fb_token` VARCHAR(255) NULL COMMENT 'basic user information necessary for logging into the app',
  `fb_token_expires_at` DATETIME NULL,
  `last_login` DATETIME NULL,
  `is_deactivated` TINYINT(1) NULL,
  `deactivated_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `ix_user_email_idx` (`email` ASC),
  INDEX `ix_user_fb_id_idx` (`fb_id` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`friends_list` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT NOT NULL,
  `fb_id` VARCHAR(255) NOT NULL,
  `is_favorite` VARCHAR(45) NULL,
  `email` VARCHAR(255) NOT NULL COMMENT 'fb list of friends\nupdated via batch process',
  `gender` VARCHAR(20) NULL,
  `profile_image_url` TEXT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_friends_list_user_idx` (`user_id` ASC),
  INDEX `ix_friends_list_fb_id_idx` (`fb_id` ASC),
  INDEX `ix_friends_list_user_id_fb_id_idx` (`user_id` ASC, `fb_id` ASC),
  CONSTRAINT `fk_friends_list_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`user_facilitated_matches` (
  `id` BIGINT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `match_id` BIGINT NOT NULL,
  `is_notification_sent` TINYINT(1) NULL COMMENT 'table to save matches and data on notifications sent',
  `notification_sent_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_match_details_user_idx` (`user_id` ASC),
  INDEX `fk_match_details_match1_idx` (`match_id` ASC),
  CONSTRAINT `fk_match_details_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_match_details_match1`
    FOREIGN KEY (`match_id`)
    REFERENCES `shokai`.`match` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`user_matches` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT NOT NULL,
  `match_id` BIGINT NOT NULL,
  `partner_fb_id` VARCHAR(255) NULL COMMENT 'who you are matched with',
  `partner_user_id` BIGINT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_my_matches_user1_idx` (`user_id` ASC),
  INDEX `fk_user_my_matches_match1_idx` (`match_id` ASC),
  CONSTRAINT `fk_user_my_matches_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_my_matches_match1`
    FOREIGN KEY (`match_id`)
    REFERENCES `shokai`.`match` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`match` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `fb_id_a` VARCHAR(255) NOT NULL,
  `fb_id_b` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;