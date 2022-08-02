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

-- Dumping data for table tti_wave.doctor: ~2 rows (approximately)
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` (`id`, `user_id`, `fname`, `lname`, `email`, `specialization`, `created_at`, `updated_at`) VALUES
	(1, 1, 'John', 'Doe', 'john_doe@gmail.com', 'General', '2022-08-01 14:14:21', '2022-08-01 14:14:21'),
	(2, 3, 'Mary', 'Lee', 'mary_lee@gmail.com', 'Cardio', '2022-08-01 14:14:21', '2022-08-01 14:14:21');
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;

-- Dumping data for table tti_wave.doctor_patient_map: ~3 rows (approximately)
/*!40000 ALTER TABLE `doctor_patient_map` DISABLE KEYS */;
INSERT INTO `doctor_patient_map` (`id`, `doctor_id`, `patient_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2022-08-01 15:03:06', NULL),
	(2, 1, 2, '2022-08-01 15:03:23', NULL),
	(3, 2, 1, '2022-08-01 15:03:40', NULL);
/*!40000 ALTER TABLE `doctor_patient_map` ENABLE KEYS */;

-- Dumping data for table tti_wave.patient: ~2 rows (approximately)
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` (`id`, `user_id`, `fname`, `lname`, `email`, `diagnosis`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Juan', 'Luna', 'juan_luna@gmail.com', 'Diabetis', '2022-08-01 14:12:18', '2022-08-01 14:12:18'),
	(2, 4, 'Jane', 'Doe', 'jane_doe@gmail.com', 'Hypertension', '2022-08-01 14:12:18', '2022-08-01 14:12:18');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;

-- Dumping data for table tti_wave.refresh_token: ~2 rows (approximately)
/*!40000 ALTER TABLE `refresh_token` DISABLE KEYS */;
INSERT INTO `refresh_token` (`id`, `user_id`, `token`, `ip`, `agent`, `created_at`) VALUES
	(1, 1, 'O_5XdAFIqOkmUTRAmLNU239CBYdGCLMMHByB7qinep-LMXFor5j-mCwDrIYCUhO0A8It8v1N5vRFpnO_KLmIrt6gm_k-1eGEuTzv6lNgivjrZfArqnDDyBMBmm4-NAcAVg-2R74c2FQOBXNMAYPQHL6_-uRtOhYEF65oC4W-Vseg7y5QNHI1HixeLtZ14ZE04uCyVz3a', '::1', 'PostmanRuntime/7.29.2', '2022-08-02 07:44:51'),
	(2, 2, 'siU8Hf-Bg6y-eeqj1MGm0g4qYYNKMgfPtIc7pw6J3WxbtJD_zvXyD8RkUiV7BbInQqTCGunp2YoIEsUxAT2iFb-x6hXrr48vVrwacjbAuQp1sLHZeJ4hRMiVdQryTrMUhrL6DjH0sksvDG3Wy83Bzk1MQESImUUakyz41OabZmbSKJncluGwfqEX1QAI-S3bIcx3aDsV', '::1', 'PostmanRuntime/7.29.2', '2022-08-02 12:35:11');
/*!40000 ALTER TABLE `refresh_token` ENABLE KEYS */;

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
