-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mag 26, 2014 alle 10:59
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
(3, 3, 8, 2),
(4, 4, 8, 2),
(5, 5, 8, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `OraEmissione` varchar(50) DEFAULT '0',
  `OraChiamata` varchar(50) DEFAULT '0',
  `OraFine` varchar(50) DEFAULT '0',
  `Data` varchar(50) DEFAULT '0',
  `Id_Centro_ext` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `FK__centri` (`Id_Centro_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `ticket`
--

INSERT INTO `ticket` (`Id`, `OraEmissione`, `OraChiamata`, `OraFine`, `Data`, `Id_Centro_ext`) VALUES
(1, '10:30:00', '10:50:00', '10:58:45', '14/05/14', 8),
(2, '10:32:00', '10:40:00', '10:45:00', '14/05/14', 8),
(3, '10:15:00', '10:31:00', '10:40:00', '14/05/14', 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `ticketoperazioni`
--

CREATE TABLE IF NOT EXISTS `ticketoperazioni` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Numero` int(11) NOT NULL DEFAULT '0',
  `Id_Operazione_ext` int(11) DEFAULT NULL,
  `Id_Ticket_ext` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Ticket_ext` (`Id_Ticket_ext`),
  KEY `FK_ticketoperazioni_operazioni` (`Id_Operazione_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `ticketoperazioni`
--

INSERT INTO `ticketoperazioni` (`Id`, `Numero`, `Id_Operazione_ext`, `Id_Ticket_ext`) VALUES
(1, 1, 1, 3),
(2, 2, 1, 3),
(3, 1, 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utentiattivi`
--

CREATE TABLE IF NOT EXISTS `utentiattivi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DeviceToken` varchar(50) DEFAULT '0',
  `Posizione` varchar(50) DEFAULT '0,0',
  `Id_Ticket_ext` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK__ticket` (`Id_Ticket_ext`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `utentiattivi`
--

INSERT INTO `utentiattivi` (`Id`, `DeviceToken`, `Posizione`, `Id_Ticket_ext`) VALUES
(1, '1233 456675 65343 4564 3', '0,0', 1);

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
-- Limiti per la tabella `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK__centri` FOREIGN KEY (`Id_Centro_ext`) REFERENCES `centri` (`Id`);

--
-- Limiti per la tabella `ticketoperazioni`
--
ALTER TABLE `ticketoperazioni`
  ADD CONSTRAINT `FK_ticketoperazioni_operazioni` FOREIGN KEY (`Id_Operazione_ext`) REFERENCES `operazioni` (`Id`),
  ADD CONSTRAINT `ticketoperazioni_ibfk_1` FOREIGN KEY (`Id_Ticket_ext`) REFERENCES `ticket` (`Id`);

--
-- Limiti per la tabella `utentiattivi`
--
ALTER TABLE `utentiattivi`
  ADD CONSTRAINT `FK__ticket` FOREIGN KEY (`Id_Ticket_ext`) REFERENCES `ticket` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
