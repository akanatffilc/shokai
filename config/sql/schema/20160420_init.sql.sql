# テーブルのダンプ user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `fb_id` text NOT NULL,
  `fb_token` text NOT NULL,
  `fb_token_expires_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_deactivated` boolean DEFAULT NULL,
  `deactivated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
