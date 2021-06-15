-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 13 Janvier 2016 à 19:46
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `congedb`
--

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

CREATE TABLE IF NOT EXISTS `demande` (
`ID` int(11) NOT NULL,
  `CIN` varchar(10) NOT NULL,
  `DateDepart` date NOT NULL,
  `DateRetour` date NOT NULL,
  `DateDemande` date NOT NULL,
  `Etat` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `demande`
--

INSERT INTO `demande` (`ID`, `CIN`, `DateDepart`, `DateRetour`, `DateDemande`, `Etat`) VALUES
(30, 'JC45845', '2015-10-01', '2015-10-03', '2015-10-12', -1);

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE IF NOT EXISTS `personnel` (
  `cin` varchar(10) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `division` varchar(255) NOT NULL,
  `tel` varchar(12) NOT NULL,
  `adresse` text NOT NULL,
  `jourstot` int(2) NOT NULL,
  `joursrest` int(2) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `admin` int(1) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personnel`
--

INSERT INTO `personnel` (`cin`, `nom`, `prenom`, `grade`, `division`, `tel`, `adresse`, `jourstot`, `joursrest`, `login`, `pass`, `admin`, `email`) VALUES
('JC45845', 'Bader', 'Zakaria', 'Souschef', 'Division a', '0654124578', 'Rue salam agadir', 30, 30, 'ahmadi@', 'x5r6icPDWWSjw', 0, 'zakaria@gmail.com'),
('JC543210', 'Abainou', 'Yassine', 'Chef', 'Division a', '0615613669', 'Taroudant maroc', 30, 30, 'admin', 'x5DMfrGmEyxns', 1, 'AbainouSoft@gmail.com'),
('JC8080', 'Hilali', 'zakaria', 'SousChef', 'Division a', '062115114', 'Hay salam casa', 30, 30, 'hilali', 'x5r6icPDWWSjw', 0, 'y.abainou@gmail.com');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `demande`
--
ALTER TABLE `demande`
 ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
 ADD PRIMARY KEY (`cin`), ADD UNIQUE KEY `cin` (`cin`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `demande`
--
ALTER TABLE `demande`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
