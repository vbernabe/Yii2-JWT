-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.8.3-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table tti_wave.doctor
CREATE TABLE IF NOT EXISTS `doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `specialization` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_user_doctor_id` (`user_id`),
  CONSTRAINT `fk_user_doctor_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table tti_wave.doctor: ~2 rows (approximately)
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` (`id`, `user_id`, `fname`, `lname`, `email`, `specialization`, `created_at`, `updated_at`) VALUES
	(1, 1, 'John', 'Doe', 'john_doe@gmail.com', 'General', '2022-08-01 14:14:21', '2022-08-01 14:14:21'),
	(2, 3, 'Mary', 'Lee', 'mary_lee@gmail.com', 'Cardio', '2022-08-01 14:14:21', '2022-08-01 14:14:21');
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;

-- Dumping structure for table tti_wave.doctor_patient_map
CREATE TABLE IF NOT EXISTS `doctor_patient_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_doctor` (`doctor_id`),
  KEY `fk_patient` (`patient_id`),
  CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table tti_wave.doctor_patient_map: ~3 rows (approximately)
/*!40000 ALTER TABLE `doctor_patient_map` DISABLE KEYS */;
INSERT INTO `doctor_patient_map` (`id`, `doctor_id`, `patient_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2022-08-01 15:03:06', NULL),
	(2, 1, 2, '2022-08-01 15:03:23', NULL),
	(3, 2, 1, '2022-08-01 15:03:40', NULL);
/*!40000 ALTER TABLE `doctor_patient_map` ENABLE KEYS */;

-- Dumping structure for table tti_wave.patient
CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `diagnosis` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `fk_patient_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table tti_wave.patient: ~2 rows (approximately)
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` (`id`, `user_id`, `fname`, `lname`, `email`, `diagnosis`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Juan', 'Luna', 'juan_luna@gmail.com', 'Diabetis', '2022-08-01 14:12:18', '2022-08-01 14:12:18'),
	(2, 4, 'Jane', 'Doe', 'jane_doe@gmail.com', 'Hypertension', '2022-08-01 14:12:18', '2022-08-01 14:12:18');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;

-- Dumping structure for table tti_wave.refresh_token
CREATE TABLE IF NOT EXISTS `refresh_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `token` varchar(1000) CHARACTER SET utf8mb3 NOT NULL,
  `ip` varchar(50) CHARACTER SET utf8mb3 NOT NULL,
  `agent` varchar(1000) CHARACTER SET utf8mb3 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_refresh_token_user` (`user_id`),
  CONSTRAINT `FK_refresh_token_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table tti_wave.refresh_token: ~2 rows (approximately)
/*!40000 ALTER TABLE `refresh_token` DISABLE KEYS */;
INSERT INTO `refresh_token` (`id`, `user_id`, `token`, `ip`, `agent`, `created_at`) VALUES
	(1, 1, 'O_5XdAFIqOkmUTRAmLNU239CBYdGCLMMHByB7qinep-LMXFor5j-mCwDrIYCUhO0A8It8v1N5vRFpnO_KLmIrt6gm_k-1eGEuTzv6lNgivjrZfArqnDDyBMBmm4-NAcAVg-2R74c2FQOBXNMAYPQHL6_-uRtOhYEF65oC4W-Vseg7y5QNHI1HixeLtZ14ZE04uCyVz3a', '::1', 'PostmanRuntime/7.29.2', '2022-08-02 07:44:51'),
	(2, 2, 'siU8Hf-Bg6y-eeqj1MGm0g4qYYNKMgfPtIc7pw6J3WxbtJD_zvXyD8RkUiV7BbInQqTCGunp2YoIEsUxAT2iFb-x6hXrr48vVrwacjbAuQp1sLHZeJ4hRMiVdQryTrMUhrL6DjH0sksvDG3Wy83Bzk1MQESImUUakyz41OabZmbSKJncluGwfqEX1QAI-S3bIcx3aDsV', '::1', 'PostmanRuntime/7.29.2', '2022-08-02 12:35:11');
/*!40000 ALTER TABLE `refresh_token` ENABLE KEYS */;

-- Dumping structure for table tti_wave.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table tti_wave.user: ~4 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `last_login`) VALUES
	(1, 'jdoe', '518dcf0c34b79f46da997317cda60c75d7985a57410639e94966485ffa1b9e07', '2022-08-01 22:07:09'),
	(2, 'juanl', '02fed264d31151a4908d5ee979c1d70571dcf86669ca99f6b7b31720c1b1a146', '2022-08-01 22:07:17'),
	(3, 'maryl', '021fb58baa7b5c8d248d12540206728a398286d671deaf80a62c93d08e970b06', '2022-08-01 22:07:26'),
	(4, 'janed', '564e9a02f1333a90baec363627f0d2ba3c20f8ea10c90adf8029242b9b8a3123', '2022-08-01 22:07:28');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
