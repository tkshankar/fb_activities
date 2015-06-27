CREATE TABLE IF NOT EXISTS `sg_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) NOT NULL,
  `post_id` text NOT NULL,
  `from_name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `from_category` varchar(90) NOT NULL,
  `from_id` int(11) NOT NULL,
  `page_owner` tinyint(1) NOT NULL,
  `to_name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `to_categerory` varchar(90) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `message_tags` text CHARACTER SET utf8 NOT NULL,
  `picture` text CHARACTER SET utf8 NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL,
  `name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `caption` varchar(90) NOT NULL,
  `description` text CHARACTER SET utf8mb4 NOT NULL,
  `source` varchar(90) NOT NULL,
  `properties` varchar(90) NOT NULL,
  `icon` varchar(90) NOT NULL,
  `type` varchar(90) NOT NULL,
  `likes_count` int(13) NOT NULL,
  `place` text NOT NULL,
  `story` text NOT NULL,
  `story_tags` tinyint(1) NOT NULL,
  `comments_count` int(13) NOT NULL,
  `object_id` varchar(90) NOT NULL,
  `application_name` varchar(90) NOT NULL,
  `application_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `updated_time` datetime NOT NULL,
  `data_aquired_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `sg_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) NOT NULL,
  `post_id` text NOT NULL,
  `user_id` text NOT NULL,
  `user_name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `data_aquired_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `sg_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) NOT NULL,
  `post_id` text NOT NULL,
  `comment_id` text NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `from_name` varchar(90) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `created_time` datetime NOT NULL,
  `data_aquired_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;