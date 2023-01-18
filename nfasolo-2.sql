-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Gen 14, 2023 alle 17:20
-- Versione del server: 10.6.11-MariaDB-0ubuntu0.22.04.1
-- Versione PHP: 8.1.2-1ubuntu2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nfasolo`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `favourites`
--

CREATE TABLE `favourites` (
  `user_id` varchar(50) NOT NULL,
  `guitar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `guitars`
--

CREATE TABLE `guitars` (
  `ID` int(5) NOT NULL,
  `Model` varchar(100) NOT NULL,
  `Brand` varchar(100) NOT NULL,
  `Color` varchar(100) NOT NULL,
  `Price` varchar(100) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Strings` int(2) NOT NULL,
  `Frets` int(2) NOT NULL,
  `Body` varchar(100) NOT NULL,
  `Fretboard` varchar(100) NOT NULL,
  `Pickup_Configuration` varchar(3) NOT NULL,
  `Pickup_Type` varchar(100) NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Alt` varchar(100) NOT NULL,
  `Description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dump dei dati per la tabella `guitars`
--

INSERT INTO `guitars` (`ID`, `Model`, `Brand`, `Color`, `Price`, `Type`, `Strings`, `Frets`, `Body`, `Fretboard`, `Pickup_Configuration`, `Pickup_Type`, `Image`, `Alt`, `Description`) VALUES
(4001, 'CS-10', '<span lang=\"en\">Eko</span>', 'Naturale', '€ 58,00', 'Classica', 6, 18, 'Tiglio', 'Betulla', '-', '-', '/images/CS-10.jpg', 'Eko CS-10', 'La CS-10 <span lang=\"en\">Natural</span> è la chitarra classica della serie \"Studio\" di casa <span lang=\"en\">Eko</span>. Presenta corpo in tiglio e tastiera in betulla. Lo strumento ideale per iniziare lo studio della chitarra, dal costo contenuto e fornito di custodia morbida.'),
(4002, 'MIA A400CE XII', '<span lang=\"en\">Eko</span>', 'Naturale', '€ 489,00', 'Acustica', 12, 20, 'Cedro', 'Palissandro', '-', '-', '/images/MIAA400CEXII.jpg', 'Eko MIA A400CE XII', 'La MIA A400CE XII è la chitarra acustica 12 corde elettrificata di casa <span lang=\"en\">Eko</span>. Rresenta corpo in cedro e tastiera in palissandro. Ideale per il chitarrista che fa attività <span lang=\"en\">live</span> e in studio di registrazione.'),
(4003, 'JTC-20S', '<span lang=\"es\">Josè Torres</span>', 'Naturale', '€ 249,00', 'Classica', 6, 18, 'Cedro', 'Palissandro', '-', '-', '/images/JTC-20S.jpg', 'Josè Torres JTC-20S', 'Questa chitarra è progettata per chitarristi esperti che hanno bisogno di utilizzare chitarre di fascia più alta come strumento per studiare ed esercitarsi. È facile prendersene cura, ma riesce a soddisfare esigenze sonore diverse.'),
(4004, '<span lang=\"en\">YELLOWSTONE-DN-BLS</span>', '<span lang=\"en\">Soundsation</span>', '<span lang=\"en\">Blue Sunburst</span>', '€ 105,00', 'Acustica', 6, 20, 'Tiglio', '<span lang=\"en\">Blackwood</span>', '-', '-', '/images/YELLOWSTONE-DN-BLS.jpg', 'Soundsation YELLOWSTONE-DN-BLS', '<span lang=\'en\'>Soundsation YELLOWSTONE-DN-BLS</span> è una chitarra dall\'alto rapporto qualità-prezzo e che non tralascia una certa piacevolezza allo sguardo. È l\'ideale sia per i principianti che per i chitarristi più avanzati che sono alla ricerca di un buon strumento per il tempo libero.'),
(4005, '<span lang=\"en\">Bobcat S66B Bigsby</span>', '<span lang=\"en\">Vox</span>', '<span lang=\"en\">Sapphire Blue</span>', '€ 1.699,00', 'Semiacustica', 6, 21, 'Acero', 'Ebano', 'SSS', '<span lang=\"en\">VOX S66</span>', '/images/BobcatS66BBigsby.jpg', 'Vox Bobcat S66B Bigsby', '<span lang=\'en\'>Bobcat S66B Sapphire Blue</span> è la chitarra elettrica <span lang=\'en\'>semi-hollow</span> di <span lang=\'en\'>Vox</span> riedizione dei modelli prodotti in Italia nella metà degli anni \'60. La storica <span lang=\'en\'>Bobcat</span>, insolitamente per chitarre a corpo cavo, presentava tre pickup <span lang=\'en\'>single coil</span>, segno distintivo rispetto le altre <span lang=\'en\'>hollow body</span>. <span lang=\'en\'>Vox</span> ha mantenuto invariato il <span lang=\'en\'>design</span> storico di queste chitarre, aggiornandole per la scena musicale odierna migliorando la loro suonabilità, controllando il <span lang=\'en\'>feedback</span> acustico e aumentando le prestazioni dei <span lang=\'en\'>pickup</span>.'),
(4006, '<span lang=\'en\'>Stratocaster Classic Series \'50s</span>', '<span lang=\"en\">Fender</span>', '<span lang=\"en\">Yellow Sunburst</span>', '€ 1.100,00', 'Elettrica', 6, 21, 'Ontano', 'Acero', 'SSS', '<span lang=\"en\">V-Mod Single-Coil Strat</span>', '/images/StratocasterClassicSeries50s.jpg', 'Fender Stratocaster Classic Series \'50s', 'Il <span lang=\'en\'>Fender Classic Series Stratocaster</span> degli anni \'50 reintroduce i musicisti alla classica atmosfera anni \'50, fornendo gli stessi toni e sensazioni di quando la <span lang=\'en\'>Strat</span> è stata presentata per la prima volta. Costruito da un corpo in ontano accoppiato con un manico e una tastiera in acero, la <span lang=\'en\'>Stratocaster</span> degli anni \'50 offre toni ben bilanciati con una caratteristica brillante e stupefacente. Il suo set di <span lang=\'en\'>pickup</span> a bobina singola in stile <span lang=\'en\'>vintage</span> offre ai musicisti le stesse sensazioni e qualità tonali dei <span lang=\'en\'>pickup</span> che hanno dato il via a tutto per la <span lang=\'en\'>Strat</span>, offrendo una bella versatilità e caratteristiche classiche <span lang=\'en\'>Fender</span> che ogni <span lang=\'en\'>fan</span> amerà.'),
(4007, 'AM53-SRF', '<span lang=\"en\">Ibanez</span>', 'Rosso', '€ 303,00', 'Semiacustica', 6, 22, 'Tiglio', 'Betulla', 'HH', '<span lang=\"en\">Infinity R</span>', '/images/AM53-SRF.jpg', 'Ibanez AM53-SRF', '<span lang=\'en\'>Ibanez</span> introdusse la serie <span lang=\'en\'>Artcore</span> nel 2002 ed è stata la chitarra <span lang=\'en\'>hollow body</span> preferita dai musicisti degli ultimi 10 anni. La combinazione <span lang=\'en\'>Artcore</span> di lavorazione di qualità e convenienza ha creato legioni di <span lang=\'en\'>fan</span> provenienti da diversi generi come <span lang=\'en\'>blues</span>, <span lang=\'en\'>country</span>, <span lang=\'en\'>rock</span> e <span lang=\'en\'>jazz</span>. I musicisti possono trovare dalla purezza di una <span lang=\'en\'>jazz-box</span> vecchia scuola ad una <span lang=\'en\'>rocker semi-hollow</span> ibrida. <span lang=\'en\'>Artcore</span> è molto rispettata per il suo suono, il <span lang=\'en\'>sustain</span> e il modo in cui tengono l\'accordatura e per come questa serie continui a spingere i confini della costruzione della chitarra.'),
(4008, '<span lang=\'en\'>Les Paul Classic Heritage</span>', '<span lang=\"en\">Gibson</span>', '<span lang=\"en\">Cherry Sunburst</span>', '€ 1.995,00', 'Elettrica', 6, 22, 'Mogano', 'Palissandro', 'HH', '<span lang=\"en\">Burstbucker 61R & 61T</span>', '/images/LesPaulClassicHeritage.jpg', 'Gibson Les Paul Classic Heritage', 'La <span lang=\'en\'>Gibson Les Paul Classic Heritage</span> combina il modello <span lang=\'en\'>Les Paul</span> dei primi anni \'60 con alcune modifiche funzionali e collaudate nel tempo. Come da consueto è realizzata con un manico sottile affusolato in mogano e tastiera in palissandro rilegata. I <span lang=\'en\'>pickup</span> a bobina aperta <span lang=\'en\'>Burstbucker 61R & 61T</span>, offrono i classici suoni <span lang=\'en\'>Gibson</span> dell\'epoca con un pò di <span lang=\'en\'>punch</span> in più grazie alle bobine aperte.'),
(4009, '<span lang=\'en\'>Explorer EX 1984</span>', '<span lang=\"en\">Epiphone</span>', '<span lang=\"en\">Alpine White</span>', '€ 660,00', 'Elettrica', 6, 22, 'Mogano', 'Palissandro', 'HH', '<span lang=\"en\">EMG-85 & 81</span> (attivi)', '/images/ExplorerEX1984.jpg', 'Epiphone Explorer EX 1984', 'La <span lang=\'en\'>1984 Explorer EX</span> è il ritorno della \'1984\' con una forma classica che si distingue sul palco. Originariamente introdotta nel 1958, il corpo dalla forma radicale e futuristica della <span lang=\'en\'>Explorer</span> è stato adottato da allora come lo strumento preferito dai chitarristi <span lang=\'en\'>hard rock</span> e <span lang=\'en\'>metal</span>. Con un nuovo ed elegante aggiornamento del <span lang=\'en\'>design</span> classico abbinato a <span lang=\'en\'>pickup EMG</span> ad elevato guadagno, la \'1984\' è una <span lang=\'en\'>Explorer</span> completamente nuova.');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pw_hash` char(60) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`user_id`,`guitar_id`),
  ADD KEY `pk_guitarid` (`guitar_id`);

--
-- Indici per le tabelle `guitars`
--
ALTER TABLE `guitars`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `pk_guitarid` FOREIGN KEY (`guitar_id`) REFERENCES `guitars` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pk_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
