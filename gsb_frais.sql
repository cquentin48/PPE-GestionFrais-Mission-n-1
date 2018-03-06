-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2018 at 07:22 AM
-- Server version: 5.7.14
-- PHP Version: 7.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsb_frais`
--

-- --------------------------------------------------------

--
-- Table structure for table `etat`
--

CREATE TABLE `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Table structure for table `fichefrais`
--

CREATE TABLE `fichefrais` (
  `idvisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbjustificatifs` int(11) DEFAULT NULL,
  `montantvalide` decimal(10,2) DEFAULT NULL,
  `datemodif` date DEFAULT NULL,
  `idetat` char(2) DEFAULT 'CR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fichefrais`
--

INSERT INTO `fichefrais` (`idvisiteur`, `mois`, `nbjustificatifs`, `montantvalide`, `datemodif`, `idetat`) VALUES
('a17', '201710', 0, '783.72', '2018-01-04', 'VA'),
('a17', '201711', 0, '0.00', '2017-12-28', 'CL'),
('a17', '201801', 0, '0.00', '2018-01-04', 'CR'),
('a17', '201802', 0, '80.00', '2018-02-26', 'CR');

-- --------------------------------------------------------

--
-- Table structure for table `fraisforfait`
--

CREATE TABLE `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Table structure for table `lignefraisforfait`
--

CREATE TABLE `lignefraisforfait` (
  `idvisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idfraisforfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idvisiteur`, `mois`, `idfraisforfait`, `quantite`) VALUES
('a17', '201710', 'ETP', 1),
('a17', '201710', 'KM', 6),
('a17', '201710', 'NUI', 20),
('a17', '201710', 'REP', 10),
('a17', '201711', 'ETP', 0),
('a17', '201711', 'KM', 0),
('a17', '201711', 'NUI', 0),
('a17', '201711', 'REP', 0),
('a17', '201801', 'ETP', 0),
('a17', '201801', 'KM', 0),
('a17', '201801', 'NUI', 0),
('a17', '201801', 'REP', 0),
('a17', '201802', 'ETP', 0),
('a17', '201802', 'KM', 0),
('a17', '201802', 'NUI', 4),
('a17', '201802', 'REP', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lignefraishorsforfait`
--

CREATE TABLE `lignefraishorsforfait` (
  `id` int(11) NOT NULL,
  `idvisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idvisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(1, 'a17', '201710', 'gf', '2017-10-28', '10.00'),
(2, 'a17', '201711', 'gf', '2017-11-21', '15.00'),
(3, 'a17', '201801', 'REFUSE : gf', '2018-01-04', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `visiteur`
--

CREATE TABLE `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `comptable` tinyint(1) NOT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(64) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateembauche` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `comptable`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateembauche`) VALUES
('a131', 'Villechalane', 'Louis', 0, 'lvillachane', 'ca3983640f22d6a38a0708731ac697146026828b88594f9522ae5517960bd56d', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21'),
('a17', 'Andre', 'David', 0, 'dandre', '165a63d5371a0ccb21b23e8881d59116bfd8377d9cad418de1215da4af09e39d', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'Bedos', 'Christian', 0, 'cbedos', '7461ef03c6debab576933c6e42e71bfdd9f070da3abbb5d8758fa1fc3fe65fc0', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12'),
('a93', 'Tusseau', 'Louis', 0, 'ltusseau', '227daca101749f45a829988faf79144d87d1d2e7a90ce07896ec56e697b7a449', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01'),
('a999', 'Andre', 'David', 0, 'dandres', '532eaabd9574880dbf76b9b8cc00832c20a6ec113d682299550d7a6e0f345e25', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('b13', 'Bentot', 'Pascal', 0, 'pbentot', 'e0020387b3eaa7414296fdfa7af5cfe48f6cf514f4350df2ff23b138e5e80e9e', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09'),
('b16', 'Bioret', 'Luc', 0, 'lbioret', '4dcb2c67707621b6bfa81c71db8ea33f6bfe217275bad06241d1f0cdd9171fd3', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11'),
('b19', 'Bunisset', 'Francis', 0, 'fbunisset', '57b592489c1851ed5db43ab164cb2e3fbf88a3eeeba963518f41798260d0fdaa', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21'),
('b25', 'Bunisset', 'Denise', 0, 'dbunisset', '4de535fc4bb81bf16f8396701c72b84dbcfaa1232823cbc62fbf9d8295840921', '23 rue Manin', '75019', 'paris', '2010-12-05'),
('b28', 'Cacheux', 'Bernard', 0, 'bcacheux', '9be0be929c729fe93b16b974b6a7f79ce77ecb399135f23ba8c47318bc3f0885', '114 rue Blanche', '75017', 'Paris', '2009-11-12'),
('b34', 'Cadic', 'Eric', 0, 'ecadic', 'ed5c1022a39ba567bf81c922e7bebcefe1ae1bb29f1ee4d68cb571096ab699cd', '123 avenue de la République', '75011', 'Paris', '2008-09-23'),
('b4', 'Charoze', 'Catherine', 0, 'ccharoze', '659d7ec12a1ed4710ca30bacba2049029cba5f6f8946f55d5150301b2c2bb620', '100 rue Petit', '75019', 'Paris', '2005-11-12'),
('b50', 'Clepkens', 'Christophe', 0, 'cclepkens', '7e9353475b3d90a2ffbedd346b8fd143ff42d8808b43aa8b804465d98827925c', '12 allée des Anges', '93230', 'Romainville', '2003-08-11'),
('b59', 'Cottin', 'Vincenne', 0, 'vcottin', '264fa0634d763fefc9de03d9412af78b553304a1e59bc7c1faf8fd5b4fd26e48', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18'),
('c14', 'Daburon', 'François', 0, 'fdaburon', '2558ad19d564eeafadc7395065d14f6fc244e21c9510079838d5d5c2aa660385', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11'),
('c3', 'De', 'Philippe', 0, 'pde', '80a51081489841526217f5958fe37b1231a8385aa6195c4d5f13cda07ef112b1', '13 rue Barthes', '94000', 'Créteil', '2010-12-14'),
('c54', 'Debelle', 'Michel', 0, 'mdebelle', 'e87f267d00031b3853d13ea6c4abd3aa8ba9a7362f151b23b1d8ab7a36237661', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23'),
('d13', 'Debelle', 'Jeanne', 0, 'jdebelle', '8447a77dcc8a1ab290625d2de92107ad506fe226f21ccc7b94db5576957371e9', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11'),
('d51', 'Debroise', 'Michel', 0, 'mdebroise', 'd908f177158faee7d45535e52ca19d1182a4cfc2ac2c44cc6d56540a36b43e08', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17'),
('e22', 'Desmarquest', 'Nathalie', 0, 'ndesmarquest', '045758ae4faff6e3a69776daea65b425c06df1806fb9fee23001b51ce8ad92f7', '14 Place d Arc', '45000', 'Orléans', '2005-11-12'),
('e24', 'Desnost', 'Pierre', 0, 'pdesnost', '9afdf4579e4688162115b09e0a72a810a3a0db98c3142d2a524d2fbb7a1d83a9', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05'),
('e39', 'Dudouit', 'Frédéric', 0, 'fdudouit', '82189fa33089b33bda4fe93c84cc0ef3e9b5746222735ea948f85aa4faa92b8c', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01'),
('e49', 'Duncombe', 'Claude', 0, 'cduncombe', '1a96aed84026e53d447df5b3501f468b6b1a104d496183b80010aec0ed6e57e3', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10'),
('e5', 'Enault-Pascreau', 'Céline', 0, 'cenault', '5044827970b11b704c3f4bd8025c38a334df3a194247e6b03c3a330eab07316c', '25 place de la gare', '23200', 'Gueret', '1995-09-01'),
('e52', 'Eynde', 'Valérie', 0, 'veynde', '9d3744e22dcada1717408fdf079bff21f3f8cb514e3402b19d990df01f33325e', '3 Grand Place', '13015', 'Marseille', '1999-11-01'),
('f21', 'Finck', 'Jacques', 0, 'jfinck', '577d67f320202216ee7f2fe26b363daada983b0d06521a7c89aeb049eafc97f5', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10'),
('f39', 'Frémont', 'Fernande', 0, 'ffremont', 'b409a4db2e8a88fb10f427ef3ff3452dd3489b75648a7593f6ad74d4572ae06b', '4 route de la mer', '13012', 'Allauh', '1998-10-01'),
('f4', 'Gest', 'Alain', 0, 'agest', 'a8a5b00ccbc425791ae7e9bdca16fc7e108c9d58e6d70b0c66f327b82b083ec9', '30 avenue de la mer', '13025', 'Berre', '1985-11-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD PRIMARY KEY (`idvisiteur`,`mois`),
  ADD KEY `idetat` (`idetat`);

--
-- Indexes for table `fraisforfait`
--
ALTER TABLE `fraisforfait`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD PRIMARY KEY (`idvisiteur`,`mois`,`idfraisforfait`),
  ADD KEY `idfraisforfait` (`idfraisforfait`);

--
-- Indexes for table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idvisiteur` (`idvisiteur`,`mois`);

--
-- Indexes for table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idetat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fichefrais_ibfk_2` FOREIGN KEY (`idvisiteur`) REFERENCES `visiteur` (`id`);

--
-- Constraints for table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idvisiteur`,`mois`) REFERENCES `fichefrais` (`idvisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idfraisforfait`) REFERENCES `fraisforfait` (`id`);

--
-- Constraints for table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idvisiteur`,`mois`) REFERENCES `fichefrais` (`idvisiteur`, `mois`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
