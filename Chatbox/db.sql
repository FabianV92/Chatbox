CREATE DATABASE chatbox;
USE chatbox;

DROP TABLE IF EXISTS `msgs`;
CREATE TABLE `msgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(12) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `msg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user` varchar(12) NOT NULL,
  `joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `hash` varchar(255) DEFAULT NULL,
  `salt` varchar(22) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

