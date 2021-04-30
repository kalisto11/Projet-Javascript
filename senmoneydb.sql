-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 30 avr. 2021 à 23:15
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `senmoneydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
CREATE TABLE IF NOT EXISTS `comptes` (
  `numero` int(255) NOT NULL,
  `code` int(255) NOT NULL,
  `solde` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`numero`, `code`, `solde`) VALUES
(775460261, 1234, 4969000),
(781214796, 1234, 7996000),
(775270834, 1234, 4020000),
(775270861, 1234, 2015000);

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `numExpediteur` int(255) NOT NULL,
  `numDestinataire` int(255) NOT NULL,
  `montant` int(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `numExpediteur`, `numDestinataire`, `montant`, `date`) VALUES
(1, 'Envoi', 775460261, 775270834, 10000, '2021-04-30 21:34:14'),
(2, 'Reception', 775270834, 775460261, 10000, '2021-04-30 21:34:14'),
(3, 'Envoi', 775460261, 775270861, 5000, '2021-04-30 21:34:54'),
(4, 'Reception', 775270861, 775460261, 5000, '2021-04-30 21:34:54'),
(5, 'Envoi', 781214796, 775460261, 15000, '2021-04-30 21:35:21'),
(6, 'Reception', 775460261, 781214796, 15000, '2021-04-30 21:35:21'),
(7, 'Envoi', 775460261, 781214796, 2000, '2021-04-30 22:27:29'),
(8, 'Reception', 781214796, 775460261, 2000, '2021-04-30 22:27:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
