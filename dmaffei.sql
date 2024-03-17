-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 30, 2024 alle 21:25
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmaffei`
--
CREATE DATABASE IF NOT EXISTS `dmaffei` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dmaffei`;

-- --------------------------------------------------------

--
-- Struttura della tabella `cassa`
--

DROP TABLE IF EXISTS `cassa`;
CREATE TABLE `cassa` (
  `ID` int(11) UNSIGNED NOT NULL,
  `dimensioni` varchar(100) NOT NULL,
  `misura` varchar(500) NOT NULL,
  `forma` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cassa`
--

INSERT INTO `cassa` (`ID`, `dimensioni`, `misura`, `forma`) VALUES
(13, '12x15', 'Grande', 'Ovale'),
(14, 'a', 'a', 'a'),
(15, '10x10x2', 'Grande', 'Ovale'),
(16, '10x5', 'Piccola', 'Rotonda'),
(17, '3x4x12', 'Grande', 'Cerchio'),
(18, '21x31x5', 'Medio', 'Ovale'),
(19, '21x34x2', 'Medio', 'Rotonda'),
(20, '49x49x13', 'Medio', 'Cerchio');

-- --------------------------------------------------------

--
-- Struttura della tabella `cinturino`
--

DROP TABLE IF EXISTS `cinturino`;
CREATE TABLE `cinturino` (
  `ID` int(11) UNSIGNED NOT NULL,
  `dimensioni` varchar(100) NOT NULL,
  `materiale` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cinturino`
--

INSERT INTO `cinturino` (`ID`, `dimensioni`, `materiale`) VALUES
(13, '20cmx3cm', 'Legno di abete'),
(14, 'a', 'a'),
(15, '20x3', 'Legno di noce e acciaio inox'),
(16, '10x2', 'Quercia'),
(17, '20x4', ' Acciaio inossidabile'),
(18, '44x3', 'Gomma'),
(19, '20x3', 'Pelle Italiana'),
(20, '20x3', 'Gomma');

-- --------------------------------------------------------

--
-- Struttura della tabella `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `ID` int(11) UNSIGNED NOT NULL,
  `nomemarca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `marca`
--

INSERT INTO `marca` (`ID`, `nomemarca`) VALUES
(20, 'Holzken'),
(21, 'Holzken'),
(22, 'Holzken'),
(23, 'Holzken'),
(24, 'a'),
(25, 'Holzken'),
(26, 'Holzkern'),
(27, ' Seizmont'),
(28, 'Sothebys'),
(29, 'TRIWA'),
(30, 'Suunto');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

DROP TABLE IF EXISTS `prodotto`;
CREATE TABLE `prodotto` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nomeorologio` varchar(400) NOT NULL,
  `immagine` varchar(300) NOT NULL,
  `descrizione` varchar(600) NOT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `materiale` varchar(100) NOT NULL,
  `modello` varchar(100) NOT NULL,
  `sesso` char(1) DEFAULT NULL,
  `peso` varchar(100) DEFAULT NULL,
  `prezzo` decimal(8,2) UNSIGNED NOT NULL,
  `cinturino` int(10) UNSIGNED NOT NULL,
  `cassa` int(10) UNSIGNED NOT NULL,
  `nomemarca` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`ID`, `nomeorologio`, `immagine`, `descrizione`, `keywords`, `materiale`, `modello`, `sesso`, `peso`, `prezzo`, `cinturino`, `cassa`, `nomemarca`) VALUES
(12, 'Askja', 'Askja.webp', 'Dotato di una funzione cronografo e di un pratico display per la data, il nostro modello Askja ha un quadrante in vero marmo grigio e un cinturino realizzato con ricco legno di noce e acciaio inossidabile grigio.  Questo modello naturalmente unico è dedicato al vulcano Askja in Islanda, dove la NASA ha eseguito dei rilevamenti geologici per preparare gli astronauti per le missioni nello spazio.', 'Orologio di legno marrone con cassa in marmo', 'Noce e Marmo', 'Akjasnicka', 'f', '150', '249.00', 15, 15, 20),
(13, 'Whakaari', 'Whakaari.webp', 'Whakaari (o White Island) è un\'isola vulcanica neozelandese, destinazione molto popolare nel turismo. L\'isola, con il punto più alto di 321 metri d\'altezza, fa sembrare il vulcano piuttosto piccolo, ma la maggior parte di questo si trova sott\'acqua.  Il nostro modello in legno di quercia unico e acciaio inox vi ricorderà ogni giorno quest\'isola impressionante.', 'Orologio in legno chiaro con cinturino che possiede un contorno un po\' di nero intorno', 'Legno di quercia', 'Whakaari 1-2-3-4', 'f', '112', '227.00', 16, 16, 26),
(14, 'Dante II', 'Dante II.webp', 'Questo orologio a carica automatica da uomo prende il suo potere dal tuo movimento. Non c\'è bisogno di agitare il braccio - anche la minima contrazione gli dà potere. Nessuna batteria, caricabatterie o sincronizzazione con il telefono. Funziona perché ti muovi.  Il quadrante nero intagliato rivela i veri eroi dell\'orologio e ti consente di vederli in azione. Il fondello trasparente espone il peso del rotore che carica l\'orologio mentre ti muovi. Può anche essere caricato manualmente ruotando la corona.  Si chiude in modo sicuro con una chiusura deployante. Ogni pezzo di metallo è realizzato in', 'Orologio Skeleton nero con movimento dorato', 'Acciaio inossidabile Vetro zaffiro', ' Seagull ST1646', 'f', '174', '209.00', 17, 17, 27),
(15, 'Audemars Piguet', 'Audemars Piguet.webp', 'Audemars Piguet Royal Oak Offshore con cassa in titanio da 44 mm e vetro zaffiro, resistente all\'acqua. all\'interno è presente il calibro automatico, con la funzione di cronografo come opzione aggiuntiva, un quadrante grigio con indicazione della data, il bracciale è in gomma; accessori: garanzia di vendita, scatola Bucherer.', 'Orologio in metallo con un sacco di robe piccole e inutili', 'Acciaio inox', 'Royal Oak Offshore', 'f', '254', '51120.00', 18, 18, 28),
(16, 'SSAB Fossil Free Steel', 'SSAB Fossil Free Steel.webp', 'RIWA x SSAB è il primo prodotto destinato al consumatore al mondo realizzato in acciaio privo di fonti fossili. La cassa dell\'orologio è realizzata utilizzando polvere di acciaio privo di fonti fossili proveniente da SSAB Oxelösund in Svezia. Lo schema dei colori del quadrante, così come i marcatori delle ore e le lancette di dimensioni maggiorate, sono ispirati alla produzione di acciaio di SSAB.  Questo orologio unico è dotato di un cinturino in pelle italiana di alta qualità e di un movimento automatico.  Il primo lotto di questo orologio è prodotto in quantità estremamente limitata.', 'Orologio principalmente nero con contorno della cassa argentato', 'Acciaio e quarzo', 'Skate Automatic', 'f', '126', '397.12', 19, 19, 29),
(17, 'SUUNTO VERTICAL', 'SUUNTO VERTICAL.webp', 'Orologio per l\'avventura, l\'allenamento e le esplorazioni outdoor con ricarica solare.​', 'Un obrobrio nero digitale con cinturino ARANCIONE', 'Titanio grado cinque', 'Titanium Solar Canyon', 'f', '74', '799.00', 20, 20, 30);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

DROP TABLE IF EXISTS `recensione`;
CREATE TABLE `recensione` (
  `ID` int(11) UNSIGNED NOT NULL,
  `prodotto` int(10) UNSIGNED NOT NULL,
  `utente` int(10) UNSIGNED NOT NULL,
  `contenuto` text DEFAULT NULL,
  `punteggio` decimal(2,0) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`ID`, `prodotto`, `utente`, `contenuto`, `punteggio`) VALUES
(4, 15, 1, 'Orologio molto bello. Economico e segna sempre l\'ora giusta.', '10'),
(5, 17, 1, 'Orologio bruttino e scomodo che non vale il prezzo dell\'acquisto.', '2');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

DROP TABLE IF EXISTS `utente`;
CREATE TABLE `utente` (
  `ID` int(10) UNSIGNED NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`ID`, `admin`, `nome`, `username`, `email`, `password`) VALUES
(1, 0, 'user', 'user', 'user@example.com', '$2y$10$shPpMTNpr17klPGTz6RF2e2W1O9rF00aLq864kMKo4DCB8TbvcqoS'),
(2, 1, 'admin', 'admin', 'admin@example.com', '$2y$10$HkqzRS01rUT/b9dfBeG1Pe360VuvPBjPGO7dFStsYXW0yUFm7ucyO');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cassa`
--
ALTER TABLE `cassa`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `cinturino`
--
ALTER TABLE `cinturino`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `nomemarca` (`nomemarca`),
  ADD KEY `cinturino` (`cinturino`),
  ADD KEY `cassa` (`cassa`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `utente` (`utente`),
  ADD KEY `prodotto` (`prodotto`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cassa`
--
ALTER TABLE `cassa`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `cinturino`
--
ALTER TABLE `cinturino`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `marca`
--
ALTER TABLE `marca`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
