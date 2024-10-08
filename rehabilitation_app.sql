-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 08 oct. 2024 à 12:39
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rehabilitation_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
CREATE TABLE IF NOT EXISTS `exercises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `equipment_needed` varchar(100) DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sets` int DEFAULT NULL,
  `reps` int DEFAULT NULL,
  `muscle_group_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_muscle_group` (`muscle_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercises`
--

INSERT INTO `exercises` (`id`, `name`, `description`, `equipment_needed`, `video_link`, `created_at`, `sets`, `reps`, `muscle_group_id`) VALUES
(1, 'Squat', 'Un exercice pour renforcer les jambes et les cuisses', 'Aucun', 'https://www.youtube.com/watch?v=J_Zm4XvE__s&pp=ygUGc3F1YXRz', '2024-10-07 09:21:42', 3, 12, 1),
(2, 'Pompes', 'Un exercice pour renforcer le haut du corps', 'Aucun', 'https://www.youtube.com/watch?v=-odWnZiXhM4&pp=ygULdHV0byBwb21wZSA%3D', '2024-10-07 09:21:42', 4, 10, 3),
(50, 'Rotation du tronc avec bâton', 'Exercice de rotation du tronc avec un bâton pour améliorer la mobilité.', 'Bâton', 'https://www.youtube.com/watch?v=lien15', '2024-10-08 08:33:41', 3, 12, 6),
(49, 'Tirage avec élastique', 'Exercice pour renforcer le dos avec une bande élastique.', 'Élastique de résistance', 'https://www.youtube.com/watch?v=lien14', '2024-10-08 08:33:41', 3, 15, 2),
(48, 'Étirement du quadriceps', 'Étirement statique des quadriceps pour améliorer la flexibilité.', 'Aucun', 'https://www.youtube.com/watch?v=lien13', '2024-10-08 08:33:41', 2, 20, 1),
(47, 'Développé couché avec haltères', 'Renforcement du haut du corps avec haltères (1 ou 2 kg).', 'Haltères (1-2 kg)', 'https://www.youtube.com/watch?v=lien12', '2024-10-08 08:33:41', 3, 10, 3),
(46, 'Gainage latéral', 'Exercice de gainage pour renforcer les obliques.', 'Aucun', 'https://www.youtube.com/watch?v=lien11', '2024-10-08 08:33:41', 2, 30, 6),
(45, 'Pont fessier', 'Exercice pour renforcer les fessiers et les ischio-jambiers.', 'Aucun', 'https://www.youtube.com/watch?v=lien10', '2024-10-08 08:33:40', 3, 12, 1),
(44, 'Renforcement des quadriceps à la chaise', 'Renforcement des quadriceps à l\'aide d\'une chaise comme support.', 'Chaise', 'https://www.youtube.com/watch?v=lien9', '2024-10-08 08:33:40', 3, 15, 1),
(43, 'Presse à cuisses avec ballon de kiné', 'Exercice pour renforcer les jambes en utilisant un ballon de kiné.', 'Ballon de kiné', 'https://www.youtube.com/watch?v=lien8', '2024-10-08 08:33:40', 3, 12, 1),
(41, 'Rotation externe de l\'épaule avec élastique', 'Exercice pour renforcer l\'épaule avec une bande élastique.', 'Élastique de résistance', 'https://www.youtube.com/watch?v=lien6', '2024-10-08 08:33:40', 3, 15, 4),
(42, 'Flexion de l\'épaule avec haltères', 'Renforcement des épaules avec des haltères légers (1 ou 2 kg).', 'Haltères (1-2 kg)', 'https://www.youtube.com/watch?v=lien7', '2024-10-08 08:33:40', 3, 12, 4),
(40, 'Abduction de la hanche', 'Exercice pour renforcer les muscles de la hanche.', 'Aucun', 'https://www.youtube.com/watch?v=lien5', '2024-10-08 08:33:40', 3, 12, 6),
(38, 'Pompes contre un mur', 'Exercice pour renforcer le haut du corps tout en réduisant la charge avec le mur.', 'Aucun', 'https://www.youtube.com/watch?v=lien3', '2024-10-08 08:33:40', 3, 15, 3),
(39, 'Élévations latérales avec haltères', 'Renforcement des épaules avec des haltères légers (1 ou 2 kg).', 'Haltères (1-2 kg)', 'https://www.youtube.com/watch?v=lien4', '2024-10-08 08:33:40', 3, 12, 4),
(37, 'Étirement des ischio-jambiers', 'Étirement doux des ischio-jambiers pour améliorer la flexibilité.', 'Aucun', 'https://www.youtube.com/watch?v=IIO0aC9Jm0c&pp=ygUew6l0aXJlbWVudCBkZXMgaXNjaGlvLWphbWJpZXJz', '2024-10-08 08:33:40', 2, 10, 1),
(36, 'Squat assisté au mur', 'Exercice pour renforcer les jambes et les cuisses en utilisant un mur pour support.', 'Aucun', 'https://www.youtube.com/watch?v=5R4D6zaokL0&pp=ygUVc3F1YXQgYXNzaXN0w6kgYXUgbXVy', '2024-10-08 08:33:40', 3, 12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `muscle_groups`
--

DROP TABLE IF EXISTS `muscle_groups`;
CREATE TABLE IF NOT EXISTS `muscle_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `muscle_groups`
--

INSERT INTO `muscle_groups` (`id`, `name`) VALUES
(1, 'Jambes'),
(2, 'Dos'),
(3, 'Pectoraux'),
(4, 'Épaules'),
(5, 'Bras'),
(6, 'Abdominaux');

-- --------------------------------------------------------

--
-- Structure de la table `progress`
--

DROP TABLE IF EXISTS `progress`;
CREATE TABLE IF NOT EXISTS `progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `exercise_id` int NOT NULL,
  `progress_date` date NOT NULL,
  `score` int DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `exercise_id` (`exercise_id`)
) ;

--
-- Déchargement des données de la table `progress`
--

INSERT INTO `progress` (`id`, `user_id`, `exercise_id`, `progress_date`, `score`, `comment`) VALUES
(1, 1, 1, '2023-10-03', 8, 'Très bon progrès'),
(2, 1, 2, '2023-10-04', 7, 'Continuez ainsi'),
(3, 3, 1, '2024-10-07', 8, 'Mal aux jambes'),
(4, 3, 2, '2024-10-07', 2, 'mal aux pecs'),
(5, 3, 1, '2024-10-07', 1, 'Nul'),
(6, 3, 1, '2024-10-07', 1, 'knj'),
(7, 3, 2, '2024-10-07', 10, 'mal o cu'),
(8, 3, 38, '2024-10-08', 1, 'Aucun mur à disposition');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isKine` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `isKine`) VALUES
(1, 'user1', 'user1@example.com', '$2y$10$exampleHashedPassword1', '2024-10-07 09:21:41', 0),
(2, 'user2', 'user2@example.com', '$2y$10$exampleHashedPassword2', '2024-10-07 09:21:41', 0),
(3, 'Mathieu', 'Mathieu@gmail.com', '$2y$10$S7f1iq.ioIVS3a1OrIEjsOte8vderkyI2Yj4M7l1utVxzivY2mxDq', '2024-10-07 09:52:21', 1),
(4, 'Mathieu pas kine', 'mat@mat.mat', '$2y$10$M/8U5sU3CwIavl15BlgAH.KdUodSI4PbDoSloQWEBtc33231Qn2hW', '2024-10-08 07:39:15', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user_exercises`
--

DROP TABLE IF EXISTS `user_exercises`;
CREATE TABLE IF NOT EXISTS `user_exercises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `exercise_id` int NOT NULL,
  `assigned_date` date NOT NULL,
  `status` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `target_score` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_exercise` (`user_id`,`exercise_id`),
  KEY `exercise_id` (`exercise_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_exercises`
--

INSERT INTO `user_exercises` (`id`, `user_id`, `exercise_id`, `assigned_date`, `status`, `target_score`) VALUES
(1, 1, 1, '2023-10-01', 'not_started', NULL),
(2, 1, 2, '2023-10-02', 'in_progress', NULL),
(8, 3, 1, '0000-00-00', 'not_started', NULL),
(5, 3, 2, '2024-10-07', 'not_started', NULL),
(9, 4, 1, '2024-10-08', 'not_started', NULL),
(7, 4, 2, '2024-10-08', 'not_started', NULL),
(10, 4, 36, '0000-00-00', 'not_started', NULL),
(11, 4, 40, '2024-10-08', 'not_started', NULL),
(12, 3, 38, '0000-00-00', 'not_started', NULL),
(13, 3, 47, '0000-00-00', 'not_started', NULL),
(14, 4, 43, '2024-10-08', 'not_started', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
