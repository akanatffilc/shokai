# テーブルのダンプ user
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `shokai`.`user` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `fb_id` VARCHAR(255) NOT NULL,
  `fb_token` VARCHAR(255) NULL COMMENT 'basic user information necessary for logging into the app',
  `fb_token_expires_at` DATETIME NULL,
  `is_completed_init` TINYINT(1) NULL,
  `last_login` DATETIME NULL,
  `is_deactivated` TINYINT(1) NULL,
  `deactivated_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `ix_user_email_idx` (`email` ASC),
  INDEX `ix_user_fb_id_idx` (`fb_id` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`user_profile` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT NOT NULL,
  `name` VARCHAR(255) NULL,
  `first_name` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NULL,
  `gender` VARCHAR(45) NULL,
  `relationship_status` VARCHAR(255) NULL,
  `birthday` VARCHAR(255) NULL,
  `fb_profile_image_url` TEXT NULL,
  `fb_link` TEXT NULL,
  `locale` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `fk_user_profile_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_profile_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`friends_list` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id_a` BIGINT NOT NULL,
  `user_id_b` BIGINT NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_friends_list_user1_idx` (`user_id_a` ASC),
  INDEX `ix_friends_list_user_ids_idx` (`user_id_a` ASC, `user_id_b` ASC),
  INDEX `fk_friends_list_user2_idx` (`user_id_b` ASC),
  CONSTRAINT `fk_friends_list_user1`
    FOREIGN KEY (`user_id_a`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friends_list_user2`
    FOREIGN KEY (`user_id_b`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `shokai`.`favorites_list` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT NOT NULL,
  `friends_list_id` BIGINT NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_favorites_list_user1_idx` (`user_id` ASC),
  INDEX `fk_favorites_list_friends_list1_idx` (`friends_list_id` ASC),
  CONSTRAINT `fk_favorites_list_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favorites_list_friends_list1`
    FOREIGN KEY (`friends_list_id`)
    REFERENCES `shokai`.`friends_list` (`id`)
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

CREATE TABLE IF NOT EXISTS `shokai`.`match_list` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id_a` BIGINT NOT NULL,
  `user_id_b` BIGINT NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_match_user1_idx` (`user_id_a` ASC),
  INDEX `fk_match_user2_idx` (`user_id_b` ASC),
  INDEX `fk_match_users_idx` (`user_id_a` ASC, `user_id_b` ASC),
  CONSTRAINT `fk_match_user1`
    FOREIGN KEY (`user_id_a`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_match_user2`
    FOREIGN KEY (`user_id_b`)
    REFERENCES `shokai`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;