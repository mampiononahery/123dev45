-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 03 Septembre 2016 à 21:13
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `owncloud_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `client_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` varchar(64) NOT NULL,
  `genre` varchar(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `dt_nais` date NOT NULL,
  `pays` varchar(40) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cp` varchar(20) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `tel_fixe` varchar(15) NOT NULL,
  `tel_mobile` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`client_id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`client_id`, `user`, `genre`, `nom`, `prenom`, `dt_nais`, `pays`, `adresse`, `cp`, `ville`, `tel_fixe`, `tel_mobile`, `email`) VALUES
(1, 'rado', 'MR', 'MORTIEL', 'Gauche', '1995-08-19', '0', '0', '0', 'Paris', '', '454545646', 'mortiel@gmail.com'),
(2, 'rado', 'MME', 'DOMINIQUES', 'Marie', '1992-08-19', '0', '0', '0', 'Paris', '023665478', '65212541', 'mariedom@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
