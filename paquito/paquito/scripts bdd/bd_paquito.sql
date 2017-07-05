-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 02 Mai 2016 à 02:17
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS bd_paquito;
USE bd_paquito;

-- --------------------------------------------------------

--
-- Structure de la table `archlinuxfield`
--

CREATE TABLE IF NOT EXISTS `archlinuxfield` (
  `IdArchlinux` int(11) NOT NULL AUTO_INCREMENT,
  `Name_All` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`IdArchlinux`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=680 ;

-- --------------------------------------------------------

--
-- Structure de la table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `IdAuthors` int(11) NOT NULL AUTO_INCREMENT,
  `Author_Name` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`IdAuthors`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=206 ;

-- --------------------------------------------------------

--
-- Structure de la table `build_package`
--

CREATE TABLE IF NOT EXISTS `build_package` (
  `IdConfigurationFile` int(11) NOT NULL,
  `idPackage` int(11) NOT NULL,
  PRIMARY KEY (`IdConfigurationFile`,`idPackage`),
  KEY `idPackage` (`idPackage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `centosfield`
--

CREATE TABLE IF NOT EXISTS `centosfield` (
  `IdCentos` int(11) NOT NULL AUTO_INCREMENT,
  `Name_All` varchar(200) NOT NULL,
  `Six_Six` varchar(200) DEFAULT NULL,
  `Seven_Zero` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`IdCentos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=153 ;

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE IF NOT EXISTS `commands` (
  `IdCommands` int(11) NOT NULL AUTO_INCREMENT,
  `Commands_Field` varchar(10) NOT NULL,
  `Command` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`IdCommands`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Structure de la table `configurationfile`
--

CREATE TABLE IF NOT EXISTS `configurationfile` (
  `IdConfigurationFile` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT 'paquito',
  `Version` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Homepage` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Summary` text CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `Copyright` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Maintainer` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`IdConfigurationFile`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- Structure de la table `configurationfile_command`
--

CREATE TABLE IF NOT EXISTS `configurationfile_command` (
  `IdConfigurationFile` int(11) NOT NULL,
  `IdCommands` int(11) NOT NULL,
  PRIMARY KEY (`IdConfigurationFile`,`IdCommands`),
  KEY `IdCommands` (`IdCommands`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `debianfield`
--

CREATE TABLE IF NOT EXISTS `debianfield` (
  `IdDebian` int(11) NOT NULL AUTO_INCREMENT,
  `Name_All` varchar(200) NOT NULL,
  `Stable` varchar(200) DEFAULT NULL,
  `Testing` varchar(200) DEFAULT NULL,
  `Wheezy` varchar(200) DEFAULT NULL,
  `Jessie` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`IdDebian`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=835 ;

-- --------------------------------------------------------

--
-- Structure de la table `dependence`
--

CREATE TABLE IF NOT EXISTS `dependence` (
  `IdDependence` int(11) NOT NULL AUTO_INCREMENT,
  `Dependence_Name` varchar(200) NOT NULL,
  `Dependence_Field` varchar(20) NOT NULL,
  `debian_Field` int(11) DEFAULT NULL,
  `Archlinux_Field` int(11) DEFAULT NULL,
  `Centos_Field` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDependence`),
  KEY `debian_Field` (`debian_Field`,`Archlinux_Field`,`Centos_Field`),
  KEY `Archlinux_Field` (`Archlinux_Field`),
  KEY `Centos_Field` (`Centos_Field`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=838 ;

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `IdFile` int(11) NOT NULL AUTO_INCREMENT,
  `File_Field` varchar(20) CHARACTER SET latin1 NOT NULL,
  `Destination` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Source` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Permission` int(11) NOT NULL DEFAULT '755',
  PRIMARY KEY (`IdFile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`email`, `mdp`, `admin`) VALUES
('admin@admin.fr', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
('e1@yahoo.fr', 'ae23b94ccaf714337e4ce5ba99ef3dc257e300df', 0),
('e2@yahoo.fr', '32d332da761f44df7959e5887b6b94cb4667d781', 0);

-- --------------------------------------------------------

--
-- Structure de la table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `IdPackage` int(11) NOT NULL AUTO_INCREMENT,
  `Package_Name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `Type` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`IdPackage`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=118 ;

-- --------------------------------------------------------

--
-- Structure de la table `package_dependence`
--

CREATE TABLE IF NOT EXISTS `package_dependence` (
  `IdPackage` int(11) NOT NULL,
  `IdDependence` int(11) NOT NULL,
  PRIMARY KEY (`IdPackage`,`IdDependence`),
  KEY `IdDependence` (`IdDependence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `package_files`
--

CREATE TABLE IF NOT EXISTS `package_files` (
  `IdPackage` int(11) NOT NULL,
  `IdFiles` int(11) NOT NULL,
  PRIMARY KEY (`IdPackage`,`IdFiles`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `prticipated_autors`
--

CREATE TABLE IF NOT EXISTS `prticipated_autors` (
  `IdAuthors` int(11) NOT NULL,
  `IdConfigurationFile` int(11) NOT NULL,
  PRIMARY KEY (`IdAuthors`,`IdConfigurationFile`),
  KEY `IdConfigurationFile` (`IdConfigurationFile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `repository`
--

CREATE TABLE IF NOT EXISTS `repository` (
  `Link` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `IdConfigurationFile` int(11) NOT NULL,
  PRIMARY KEY (`Link`),
  KEY `IdConfigurationFile` (`IdConfigurationFile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `build_package`
--
ALTER TABLE `build_package`
  ADD CONSTRAINT `build_package_ibfk_1` FOREIGN KEY (`IdConfigurationFile`) REFERENCES `configurationfile` (`IdConfigurationFile`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `build_package_ibfk_2` FOREIGN KEY (`idPackage`) REFERENCES `package` (`IdPackage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `configurationfile_command`
--
ALTER TABLE `configurationfile_command`
  ADD CONSTRAINT `configurationfile_command_ibfk_1` FOREIGN KEY (`IdConfigurationFile`) REFERENCES `configurationfile` (`IdConfigurationFile`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `configurationfile_command_ibfk_2` FOREIGN KEY (`IdCommands`) REFERENCES `commands` (`IdCommands`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dependence`
--
ALTER TABLE `dependence`
  ADD CONSTRAINT `dependence_ibfk_1` FOREIGN KEY (`debian_Field`) REFERENCES `debianfield` (`IdDebian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dependence_ibfk_2` FOREIGN KEY (`Archlinux_Field`) REFERENCES `archlinuxfield` (`IdArchlinux`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dependence_ibfk_3` FOREIGN KEY (`Centos_Field`) REFERENCES `centosfield` (`IdCentos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `package_dependence`
--
ALTER TABLE `package_dependence`
  ADD CONSTRAINT `package_dependence_ibfk_1` FOREIGN KEY (`IdPackage`) REFERENCES `package` (`IdPackage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_dependence_ibfk_2` FOREIGN KEY (`IdDependence`) REFERENCES `dependence` (`IdDependence`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `prticipated_autors`
--
ALTER TABLE `prticipated_autors`
  ADD CONSTRAINT `prticipated_autors_ibfk_1` FOREIGN KEY (`IdAuthors`) REFERENCES `authors` (`IdAuthors`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prticipated_autors_ibfk_2` FOREIGN KEY (`IdConfigurationFile`) REFERENCES `configurationfile` (`IdConfigurationFile`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
