
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ac_blocked
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_blocked`;

CREATE TABLE `ac_blocked` (
  `users_id` int(11) DEFAULT NULL,
  `blocked_users_id` int(11) DEFAULT NULL,
  `is_reported` tinyint(4) NOT NULL DEFAULT '0',
  `dt_updated` datetime DEFAULT NULL,
  UNIQUE KEY `user_id` (`users_id`,`blocked_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ac_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_contacts`;

CREATE TABLE `ac_contacts` (
  `users_id` int(11) NOT NULL,
  `contacts_id` int(11) NOT NULL,
  `dt_updated` datetime NOT NULL,
  UNIQUE KEY `users_id` (`users_id`,`contacts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ac_groupchat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_groupchat`;

CREATE TABLE `ac_groupchat` (
  `group_id` int(11) NOT NULL,
  `gc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ac_guests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_guests`;

CREATE TABLE `ac_guests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dt_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ac_guests_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_guests_messages`;

CREATE TABLE `ac_guests_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_to` int(11) DEFAULT '0',
  `m_from` int(11) DEFAULT '0',
  `g_to` int(11) DEFAULT '0',
  `g_from` int(11) DEFAULT '0',
  `messages_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ac_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_messages`;

CREATE TABLE `ac_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_from` int(11) NOT NULL DEFAULT '0',
  `m_to` int(11) NOT NULL,
  `g_to` int(11) DEFAULT '0',
  `g_from` int(11) DEFAULT '0',
  `g_random` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `m_from_delete` tinyint(1) NOT NULL DEFAULT '0',
  `m_to_delete` tinyint(1) NOT NULL DEFAULT '0',
  `dt_updated` datetime DEFAULT NULL,
  `m_reply_id` int(11) DEFAULT '0',
  `reply_user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ac_profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_profiles`;

CREATE TABLE `ac_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_small` tinyint(4) DEFAULT '0',
  `dark_mode` tinyint(4) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:offline;1:online;2:away;3:busy',
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ac_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_settings`;

CREATE TABLE `ac_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_value` text COLLATE utf8mb4_unicode_ci,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `ac_settings` WRITE;
/*!40000 ALTER TABLE `ac_settings` DISABLE KEYS */;

INSERT INTO `ac_settings` (`id`, `s_name`, `s_value`, `dt_updated`)
VALUES
	(1,'admin_user_id','1','2019-10-19 05:57:53'),
	(2,'pagination_limit','5','2019-10-19 05:57:53'),
	(3,'include_url',NULL,'2019-10-19 05:57:53'),
	(4,'exclude_url',NULL,'2019-10-19 05:57:53'),
	(5,'img_upload_path','upload','2019-03-06 00:00:00'),
	(6,'assets_path','assets','2019-10-19 05:57:53'),
	(8,'is_groups','0','2019-10-19 05:57:53'),
	(9,'groups_table',NULL,'2019-10-19 05:57:53'),
	(10,'groups_col_id',NULL,'2019-10-19 05:57:53'),
	(11,'groups_col_name',NULL,'2019-10-19 05:57:53'),
	(12,'users_table','users','2019-10-19 05:57:53'),
	(13,'users_col_id','id','2019-10-19 05:57:53'),
	(14,'users_col_email','email','2019-10-19 05:57:53'),
	(15,'ug_table',NULL,'2019-10-19 05:57:53'),
	(16,'ug_col_user_id',NULL,'2019-10-19 05:57:53'),
	(17,'ug_col_group_id',NULL,'2019-10-19 05:57:53'),
	(18,'include_or_exclude','0','2019-10-19 05:57:53'),
	(19,'guest_mode','0','2019-10-19 05:57:53'),
	(20,'guest_group_id',NULL,'2019-10-19 05:57:53'),
	(21,'site_name','AddChat Pro','2019-10-19 05:57:53'),
	(22,'theme_colour',NULL,'2019-10-19 05:57:53'),
	(23,'site_logo',NULL,'2019-09-06 08:25:52'),
	(24,'chat_icon',NULL,'2019-09-06 08:24:20'),
	(25,'notification_type','0','2019-10-19 05:57:53'),
	(26,'pusher_app_id',NULL,'2019-10-19 05:57:53'),
	(27,'pusher_key',NULL,'2019-10-19 05:57:53'),
	(28,'pusher_secret',NULL,'2019-10-19 05:57:53'),
	(29,'pusher_cluster',NULL,'2019-10-19 05:57:53'),
	(30,'footer_text','AddChat | by Classiebit','2019-10-19 05:57:53'),
	(31,'footer_url','https://classiebit.com/addchat-codeigniter-pro','2019-10-19 05:57:53'),
	(32, 'hide_email', '0', '2019-11-13 10:44:05');


/*!40000 ALTER TABLE `ac_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ac_users_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac_users_messages`;

CREATE TABLE `ac_users_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `buddy_id` int(11) NOT NULL,
  `messages_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id` (`users_id`,`buddy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
