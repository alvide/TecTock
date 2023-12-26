CREATE TABLE `marca` (
  `ID` int(11) UNSIGNED NOT NULL,
  `nomemarca` varchar(100) NOT NULL,

   PRIMARY KEY (`ID`)
);

/* il tipo sostanzialmente è se un orologio è: al quarzo, automatico, cinetico, digitale, smartwatch */
CREATE TABLE `tipo` (
  `ID` int(11) UNSIGNED NOT NULL,
  `tipologia` varchar(100) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `descrizione` varchar(500) NOT NULL,

   PRIMARY KEY (`ID`)
);

CREATE TABLE `cassa` (
  `ID` int(11) UNSIGNED NOT NULL,
  `dimensioni` varchar(100) NOT NULL, /*misure in cm*/
  `misura` varchar(500) NOT NULL,   /*misure inteso come GRANDE, MEDIO, PICCOLO*/
  `forma` varchar(500) NOT NULL, /*quadrata, rettangolare, altro*/

   PRIMARY KEY (`ID`)
);

CREATE TABLE `cinturino` (
  `ID` int(11) UNSIGNED NOT NULL,
  `dimensioni` varchar(100) NOT NULL,
  `materiale` varchar(500) NOT NULL,

   PRIMARY KEY (`ID`)
);

CREATE TABLE `prodotto` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nomeorologio` varchar(400) NOT NULL,
  `immagine` varchar(300) NOT NULL,
  `descrizione` text NOT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `materiale` varchar(100) NOT NULL,
  `modello` varchar(100) NOT NULL,
  `sesso` CHAR DEFAULT NULL, /*si intende il carattere M/F per capire se è un orologio per uomo o donna*/
  `peso` varchar(100) DEFAULT NULL,
  `prezzo` decimal(5,2) UNSIGNED NOT NULL,

  `cinturino` int(10) UNSIGNED NOT NULL,
  `cassa` int(10) UNSIGNED NOT NULL,
  `tipologia` int(10) UNSIGNED NOT NULL,
  `nomemarca` int(10) UNSIGNED NOT NULL,

  PRIMARY KEY (`ID`),
  FOREIGN KEY (`tipologia`) REFERENCES `tipo` (`ID`),
  FOREIGN KEY (`nomemarca`) REFERENCES `marca` (`ID`),
   FOREIGN KEY (`cinturino`) REFERENCES `cinturino` (`ID`),
  FOREIGN KEY (`cassa`) REFERENCES `cassa` (`ID`)
);


CREATE TABLE `utente` (
  `ID` int(10) UNSIGNED NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,

  PRIMARY KEY (`ID`)
) ;

CREATE TABLE `recensione` (
  `ID` int(11) UNSIGNED NOT NULL,
  `prodotto` int(10) UNSIGNED NOT NULL,
  `utente` int(10) UNSIGNED NOT NULL,
  `contenuto` text,
  `punteggio` decimal(2,1) UNSIGNED NOT NULL DEFAULT '0.0',

  PRIMARY KEY (`ID`),
  FOREIGN KEY (`utente`) REFERENCES `utente` (`ID`)
) ;

