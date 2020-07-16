-- --------------------------------------------------------
-- Strežnik:                     127.0.0.1
-- Verzija strežnika:            10.4.11-MariaDB - mariadb.org binary distribution
-- Operacijski sistem strežnika: Win64
-- HeidiSQL Različica:           9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dn3
DROP DATABASE IF EXISTS `dn3`;
CREATE DATABASE IF NOT EXISTS `dn3` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `dn3`;

-- Dumping structure for tabela dn3.job_applications
DROP TABLE IF EXISTS `job_applications`;
CREATE TABLE IF NOT EXISTS `job_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11),
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `last_name` varchar(70) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `job_title` varchar(70) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `job_text` text DEFAULT NULL,
  `star_rate` tinyint(4) NOT NULL,
  `job_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table dn3.job_applications: ~6 rows (približno)
/*!40000 ALTER TABLE `job_applications` DISABLE KEYS */;
INSERT INTO `job_applications` (`id`, `user_id`, `first_name`, `last_name`, `job_title`, `job_text`, `star_rate`, `job_date`) VALUES
	(1, 1, 'Janez', 'Novak', 'Prvi primer prošnje...', 'Chuck Norris can write infinite recursion functions ... and have them return.', 2, '2020-05-31'),
	(2, 2, 'Jože', 'Božič', 'Drugi primer prošnje...', 'Chuck can hit you so hard your web app will turn into swing application.', 2, '2020-05-31'),
	(3, 3, 'Neki', 'Neznanec', 'Tretji primer prošnje...', 'The functions Chuck Norris writes have no arguments, because nobody argues with Chuck Norris.', 3, '2020-05-31'),
	(4, 1, 'Boris', 'Grm', 'Četrti primer prošnje...', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 4, '2020-05-31'),
	(5, 2, 'Darko', 'Ragneš', 'Peti primer prošnje...', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent viverra, nunc a ullamcorper laoreet, quam nunc pretium enim, id efficitur odio erat vitae ante. Duis sit amet purus nec neque accumsan vestibulum non vel enim. Sed faucibus pellentesque quam, non faucibus sapien varius in.', 5, '2020-05-31'),
	(6, 4, 'Marko', 'Markovič', 'Šesti primer prošnje...', 'Donec placerat congue erat id fermentum. Quisque eget dignissim ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', 4, '2020-05-31');
/*!40000 ALTER TABLE `job_applications` ENABLE KEYS */;

-- Dumping structure for tabela dn3.job_users
DROP TABLE IF EXISTS `job_users`;
CREATE TABLE IF NOT EXISTS `job_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) NOT NULL,
  `username` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- Dumping structure for tabela dn3.job_users_shadow
DROP TABLE IF EXISTS `job_users_shadow`;
CREATE TABLE IF NOT EXISTS `job_users_shadow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) NOT NULL,
  `username` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- Dumping data for table dn3.job_users_shadow: ~4 rows (približno)
/*!40000 ALTER TABLE `job_users_shadow` DISABLE KEYS */;
INSERT INTO `job_users_shadow` (`id`, `is_admin`, `username`, `password`) VALUES
	(1, 1, 'user', '$2y$10$6QZqRs9p/3mOUEVSnu60MuVBeYa24mt945zAIZaWj0amcNwsw7uxC'),
	(2, 1, 'student', '$2y$10$r0PrTFgj8yFPYy1VwvIoj.309SYaXqDaF/EJARooyhat/1gPw0zo2'),
	(3, 1, 'asistent', '$2y$10$xXvdnL5FadXAwctopETgZu.TIUcLGyNQUajTHLPIwA0.Q3C9ouoaW'),
	(4, 0, 'uporabnik1', '$2y$10$q6t2BsYWJDabNhUnNh.P1exTLV34HMWBtD62nZaJLcsL.Q0i4TUYu');
/*!40000 ALTER TABLE `job_users_shadow` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
