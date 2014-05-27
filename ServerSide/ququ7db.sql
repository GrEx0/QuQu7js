-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mag 27, 2014 alle 21:28
-- Versione del server: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ququ7db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `centri`
--

CREATE TABLE IF NOT EXISTS `centri` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) DEFAULT '0',
  `Via` varchar(50) DEFAULT '0',
  `Tel` varchar(50) DEFAULT '0',
  `Id_citta_ext` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `FK__citta` (`Id_citta_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `centri`
--

INSERT INTO `centri` (`Id`, `Nome`, `Via`, `Tel`, `Id_citta_ext`) VALUES
(8, 'ATM', 'Loreto', '031274578', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `citta`
--

CREATE TABLE IF NOT EXISTS `citta` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) DEFAULT '0',
  `Id_Provincia_ext` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK__provincie` (`Id_Provincia_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `citta`
--

INSERT INTO `citta` (`Id`, `Nome`, `Id_Provincia_ext`) VALUES
(1, 'Milano', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `operazioni`
--

CREATE TABLE IF NOT EXISTS `operazioni` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CodiceLettera` varchar(50) DEFAULT NULL,
  `Descrizione` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `operazioni`
--

INSERT INTO `operazioni` (`Id`, `CodiceLettera`, `Descrizione`) VALUES
(1, 'A', 'Ritiri'),
(2, 'B', 'Richieste Tessere'),
(3, 'C', 'Turisti');

-- --------------------------------------------------------

--
-- Struttura della tabella `provincie`
--

CREATE TABLE IF NOT EXISTS `provincie` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL DEFAULT '0',
  `Id_Regione_ext` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Provincie_regioni` (`Id_Regione_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `provincie`
--

INSERT INTO `provincie` (`Id`, `Nome`, `Id_Regione_ext`) VALUES
(1, 'Milano', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `regioni`
--

CREATE TABLE IF NOT EXISTS `regioni` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `regioni`
--

INSERT INTO `regioni` (`Id`, `Nome`) VALUES
(1, 'Lombardia');

-- --------------------------------------------------------

--
-- Struttura della tabella `sportelli`
--

CREATE TABLE IF NOT EXISTS `sportelli` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NumeroSportello` int(11) DEFAULT NULL,
  `Id_Centro_ext` int(11) DEFAULT NULL,
  `Id_operazione_ext` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Centro_ext` (`Id_Centro_ext`),
  KEY `Id_operazione_ext` (`Id_operazione_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `sportelli`
--

INSERT INTO `sportelli` (`Id`, `NumeroSportello`, `Id_Centro_ext`, `Id_operazione_ext`) VALUES
(1, 1, 8, 1),
(2, 2, 8, 1),
(3, 3, 8, 1),
(4, 4, 8, 2),
(5, 5, 8, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `WaitingTime` varchar(50) DEFAULT '0',
  `ServingTime` varchar(50) DEFAULT '0',
  `Id_operazione_ext` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `FK_Stats_operazioni` (`Id_operazione_ext`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `OraEmissione` time NOT NULL DEFAULT '00:00:00',
  `OraChiamata` time DEFAULT '00:00:00',
  `OraFine` time DEFAULT '00:00:00',
  `Data` varchar(50) DEFAULT '0',
  `Numero` int(11) DEFAULT '0',
  `Id_centro_ext` int(11) DEFAULT '0',
  `Id_operazione_ext` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `FK_ticketn_operazioni` (`Id_operazione_ext`),
  KEY `FK_ticketn_centri` (`Id_centro_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dump dei dati per la tabella `ticket`
--

INSERT INTO `ticket` (`Id`, `OraEmissione`, `OraChiamata`, `OraFine`, `Data`, `Numero`, `Id_centro_ext`, `Id_operazione_ext`) VALUES
(1, '10:12:10', '10:18:20', '10:40:21', '28/05/14', 1, 8, 1),
(2, '10:23:10', '10:24:20', '10:45:21', '28/05/14', 2, 8, 1),
(3, '10:23:30', '10:25:30', '10:50:21', '28/05/14', 3, 8, 1),
(4, '10:24:00', '10:40:30', '10:59:30', '28/05/14', 4, 8, 1),
(5, '10:24:30', '10:45:58', '11:08:30', '28/05/14', 5, 8, 1),
(6, '10:24:55', '10:51:30', '11:15:30', '28/05/14', 6, 8, 1),
(7, '10:36:55', '11:00:30', '11:15:30', '28/05/14', 7, 8, 1),
(8, '10:24:00', '10:40:30', '10:59:30', '28/05/14', 4, 8, 2),
(9, '10:23:10', '10:24:20', '10:45:21', '28/05/14', 2, 8, 2),
(10, '10:24:30', '10:45:58', '11:08:30', '28/05/14', 5, 8, 2),
(12, '10:37:30', '00:00:00', '00:00:00', '28/05/14', 8, 8, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utentiattivi`
--

CREATE TABLE IF NOT EXISTS `utentiattivi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DeviceToken` varchar(50) DEFAULT '0',
  `WaitingTime` varchar(50) DEFAULT NULL,
  `Id_Ticket_ext` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_utentiattivi_ticket` (`Id_Ticket_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dump dei dati per la tabella `utentiattivi`
--

INSERT INTO `utentiattivi` (`Id`, `DeviceToken`, `WaitingTime`, `Id_Ticket_ext`) VALUES
(13, '934939449', NULL, 12);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `centri`
--
ALTER TABLE `centri`
  ADD CONSTRAINT `FK__citta` FOREIGN KEY (`Id_citta_ext`) REFERENCES `citta` (`Id`);

--
-- Limiti per la tabella `citta`
--
ALTER TABLE `citta`
  ADD CONSTRAINT `FK__provincie` FOREIGN KEY (`Id_Provincia_ext`) REFERENCES `provincie` (`Id`);

--
-- Limiti per la tabella `provincie`
--
ALTER TABLE `provincie`
  ADD CONSTRAINT `FK_Provincie_regioni` FOREIGN KEY (`Id_Regione_ext`) REFERENCES `regioni` (`Id`);

--
-- Limiti per la tabella `sportelli`
--
ALTER TABLE `sportelli`
  ADD CONSTRAINT `sportelli_ibfk_1` FOREIGN KEY (`Id_Centro_ext`) REFERENCES `centri` (`Id`),
  ADD CONSTRAINT `sportelli_ibfk_2` FOREIGN KEY (`Id_operazione_ext`) REFERENCES `operazioni` (`Id`);

--
-- Limiti per la tabella `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `FK_Stats_operazioni` FOREIGN KEY (`Id_operazione_ext`) REFERENCES `operazioni` (`Id`);

--
-- Limiti per la tabella `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_ticketn_centri` FOREIGN KEY (`Id_centro_ext`) REFERENCES `centri` (`Id`),
  ADD CONSTRAINT `FK_ticketn_operazioni` FOREIGN KEY (`Id_operazione_ext`) REFERENCES `operazioni` (`Id`);

--
-- Limiti per la tabella `utentiattivi`
--
ALTER TABLE `utentiattivi`
  ADD CONSTRAINT `FK_utentiattivi_ticket` FOREIGN KEY (`Id_Ticket_ext`) REFERENCES `ticket` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
