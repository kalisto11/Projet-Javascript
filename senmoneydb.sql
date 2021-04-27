-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le :  mar. 27 avr. 2021 à 15:30
-- Version du serveur :  10.3.14-MariaDB
-- Version de PHP :  7.2.18

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
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `solde` int(11) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=MyISAM AUTO_INCREMENT=771831269 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`numero`, `code`, `solde`) VALUES
(701002030, 123, 50000),
(771831268, 0, 25000);

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `idTransaction` int(11) NOT NULL AUTO_INCREMENT,
  `dateTrans` date NOT NULL,
  `numero` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `typeTrans` varchar(100) NOT NULL,
  PRIMARY KEY (`idTransaction`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`idTransaction`, `dateTrans`, `numero`, `montant`, `typeTrans`) VALUES
(1, '2021-04-20', 771831268, 1000, 'transfert'),
(2, '2021-04-25', 701002030, 1000, 'reception'),
(3, '2021-04-20', 771831268, 1000, 'transfert'),
(4, '2021-04-25', 701002030, 1000, 'reception');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
