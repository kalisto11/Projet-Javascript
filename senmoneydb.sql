-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 27 avr. 2021 à 14:15
-- Version du serveur :  5.7.26
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
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `numero` int(11) NOT NULL,
  `code` int(11) DEFAULT NULL,
  `solde` int(11) DEFAULT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`numero`, `code`, `solde`) VALUES
(771831268, 1234, 10000),
(781253645, 0, 15000);

-- --------------------------------------------------------

--
-- Structure de la table `transanctions`
--

CREATE TABLE IF NOT EXISTS `transanctions` (
  `idTransaction` int(11) NOT NULL AUTO_INCREMENT,
  `dateTrans` date NOT NULL,
  `numero` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `typeTrans` varchar(100) NOT NULL,
  PRIMARY KEY (`idTransaction`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transanctions`
--

INSERT INTO `transanctions` (`idTransaction`, `dateTrans`, `numero`, `montant`, `typeTrans`) VALUES
(1, '2021-04-26', 781253645, 2000, 'transfert'),
(2, '2021-04-25', 771831268, 1000, 'reception'),
(3, '2021-04-26', 781253645, 2000, 'transfert'),
(4, '2021-04-25', 771831268, 1000, 'reception');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
