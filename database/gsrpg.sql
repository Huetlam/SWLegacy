-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2022 at 06:38 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsrpg`
--

-- --------------------------------------------------------

--
-- Table structure for table `battles`
--

CREATE TABLE `battles` (
  `battleID` int(5) NOT NULL,
  `battlename` varchar(50) NOT NULL,
  `battlestatus` int(1) NOT NULL COMMENT '1=done\r\n2=started\r\n3=notstarted',
  `planetID` int(4) NOT NULL,
  `battlenumber` int(3) NOT NULL,
  `factionID` int(3) NOT NULL,
  `userID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `battles`
--

INSERT INTO `battles` (`battleID`, `battlename`, `battlestatus`, `planetID`, `battlenumber`, `factionID`, `userID`) VALUES
(1, 'Battle of Corellia', 1, 12, 1, 3, 1),
(2, 'Battle of Malastare', 1, 11, 1, 0, 0),
(5, 'Battle of Coruscant', 1, 2, 1, 3, 0),
(6, 'Battle of Coruscant', 1, 2, 2, 1, 0),
(7, 'Battle of Coruscant', 1, 2, 3, 3, 0),
(8, 'Battle of Coruscant', 1, 2, 4, 1, 0),
(9, 'Battle of Coruscant', 1, 2, 5, 3, 0),
(10, 'Battle of Coruscant', 1, 2, 6, 3, 0),
(11, 'Battle of Coruscant', 1, 2, 7, 1, 0),
(12, 'Battle of Coruscant', 1, 2, 8, 3, 0),
(13, 'Battle of Coruscant', 1, 2, 9, 1, 0),
(14, 'Battle of Geonosis', 1, 9, 1, 1, 0),
(15, 'Battle of Trala', 1, 13, 1, 1, 0),
(16, 'Battle of Corellia', 1, 12, 2, 3, 0),
(17, 'Battle of Trala', 1, 13, 2, 1, 0),
(18, 'Battle of Corellia', 2, 12, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `battles_fleets`
--

CREATE TABLE `battles_fleets` (
  `battles_fleetsID` bigint(15) NOT NULL,
  `battleID` int(5) NOT NULL,
  `fleetID` bigint(10) NOT NULL,
  `fleetstatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `battles_fleets`
--

INSERT INTO `battles_fleets` (`battles_fleetsID`, `battleID`, `fleetID`, `fleetstatus`) VALUES
(1, 1, 2, 1),
(2, 1, 1, 2),
(3, 2, 3, 1),
(4, 2, 4, 2),
(9, 5, 6, 1),
(10, 5, 5, 2),
(11, 6, 5, 1),
(12, 6, 6, 2),
(13, 7, 6, 1),
(14, 7, 5, 2),
(15, 8, 5, 1),
(16, 8, 6, 2),
(17, 9, 8, 1),
(18, 10, 8, 1),
(19, 11, 9, 1),
(20, 12, 8, 1),
(21, 13, 10, 1),
(22, 14, 10, 1),
(23, 15, 10, 1),
(24, 15, 8, 2),
(25, 16, 12, 1),
(26, 16, 11, 2),
(27, 17, 13, 1),
(28, 17, 10, 2),
(29, 18, 12, 1),
(30, 18, 11, 2);

-- --------------------------------------------------------

--
-- Table structure for table `battles_fleets_units`
--

CREATE TABLE `battles_fleets_units` (
  `battles_fleets_unitsID` int(4) NOT NULL,
  `battleID` int(3) NOT NULL,
  `fleetID` int(4) NOT NULL,
  `unitID` int(4) NOT NULL,
  `amount` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `battles_fleets_units`
--

INSERT INTO `battles_fleets_units` (`battles_fleets_unitsID`, `battleID`, `fleetID`, `unitID`, `amount`) VALUES
(1, 1, 2, 11, 10),
(2, 1, 2, 12, 20),
(3, 1, 1, 14, 20),
(4, 1, 1, 16, 10),
(5, 1, 1, 13, 10),
(14, 5, 6, 14, 29),
(15, 5, 6, 16, 29),
(16, 0, 5, 12, 36),
(17, 0, 5, 11, 18),
(18, 0, 6, 14, 29),
(19, 0, 6, 16, 29),
(20, 6, 5, 12, 64),
(21, 6, 5, 11, 32),
(22, 0, 5, 12, 64),
(23, 0, 5, 11, 32),
(24, 0, 6, 14, 19),
(25, 0, 6, 16, 19),
(26, 7, 6, 14, 66),
(27, 7, 6, 16, 66),
(28, 0, 5, 12, 104),
(29, 0, 5, 11, 52),
(30, 0, 6, 14, 66),
(31, 0, 6, 16, 66),
(32, 8, 5, 12, 119),
(33, 8, 5, 11, 120),
(34, 8, 5, 12, 119),
(35, 8, 5, 11, 120),
(36, 8, 6, 14, 11),
(37, 8, 6, 16, 11),
(38, 9, 8, 14, 20),
(39, 9, 8, 16, 15),
(40, 10, 8, 14, 20),
(41, 10, 8, 16, 15),
(42, 11, 9, 12, 20),
(43, 11, 9, 11, 30),
(44, 12, 8, 14, 20),
(45, 12, 8, 16, 15),
(46, 13, 10, 12, 110),
(47, 13, 10, 11, 70),
(48, 14, 10, 12, 110),
(49, 14, 10, 11, 70),
(50, 15, 10, 12, 110),
(51, 15, 10, 11, 70),
(52, 15, 8, 14, 20),
(53, 15, 8, 16, 15),
(54, 15, 8, 14, 20),
(55, 15, 8, 16, 15),
(56, 16, 12, 11, 10),
(57, 16, 11, 16, 117),
(58, 16, 11, 14, 112),
(59, 16, 11, 16, 117),
(60, 16, 11, 14, 112),
(61, 17, 13, 13, 1),
(62, 17, 10, 12, 137),
(63, 17, 10, 11, 87),
(64, 18, 12, 11, 1),
(65, 18, 11, 16, 106),
(66, 18, 11, 14, 102);

-- --------------------------------------------------------

--
-- Table structure for table `battles_losses`
--

CREATE TABLE `battles_losses` (
  `battles_lossesID` bigint(15) NOT NULL,
  `battleID` int(5) NOT NULL,
  `fleetID` int(4) NOT NULL,
  `unitID` int(7) NOT NULL,
  `amount` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `battles_losses`
--

INSERT INTO `battles_losses` (`battles_lossesID`, `battleID`, `fleetID`, `unitID`, `amount`) VALUES
(1, 1, 1, 14, -1),
(2, 1, 1, 16, -1),
(3, 1, 1, 13, -1),
(4, 1, 2, 12, 18),
(5, 1, 2, 11, 9),
(6, 2, 3, 12, 10),
(7, 2, 3, 11, 5),
(8, 2, 4, 14, 10),
(9, 2, 4, 16, 10),
(14, 5, 5, 12, -16),
(15, 5, 5, 11, -8),
(16, 5, 6, 14, 10),
(17, 5, 6, 16, 10),
(18, 6, 5, 12, -40),
(19, 6, 5, 11, -20),
(20, 6, 6, 14, -16),
(21, 6, 6, 16, -16),
(22, 7, 5, 12, -15),
(23, 7, 5, 11, -8),
(24, 7, 6, 14, 55),
(25, 7, 6, 16, 55),
(26, 8, 5, 12, -11),
(27, 8, 5, 11, -11),
(28, 8, 6, 14, -121),
(29, 8, 6, 16, -121),
(30, 9, 8, 14, 0),
(31, 9, 8, 16, 0),
(32, 10, 8, 14, 0),
(33, 10, 8, 16, 0),
(34, 11, 9, 12, 0),
(35, 11, 9, 11, 0),
(36, 12, 8, 14, 0),
(37, 12, 8, 16, 0),
(38, 13, 10, 12, 0),
(39, 13, 10, 11, 0),
(40, 13, 10, 12, 0),
(41, 13, 10, 11, 0),
(42, 14, 10, 12, 0),
(43, 14, 10, 11, 0),
(44, 15, 10, 12, -27),
(45, 15, 10, 11, -17),
(46, 15, 8, 14, -82),
(47, 15, 8, 16, -62),
(48, 16, 11, 16, 11),
(49, 16, 11, 14, 10),
(50, 16, 12, 11, 9),
(51, 17, 13, 13, 1),
(52, 17, 10, 12, 0),
(53, 17, 10, 11, 0),
(54, 18, 12, 11, 0),
(55, 18, 11, 16, 0),
(56, 18, 11, 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE `demo` (
  `d_id` int(11) NOT NULL,
  `message` varchar(100) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `demo`
--

INSERT INTO `demo` (`d_id`, `message`, `created_on`) VALUES
(1, 'New Turn', '2022-08-22 23:38:12'),
(2, 'New Turn', '2022-08-23 22:00:52'),
(3, 'New Turn', '2022-08-26 21:55:08'),
(4, 'New Turn', '2022-08-29 22:21:17'),
(5, 'New Turn', '2022-08-31 22:13:09'),
(6, 'New Turn', '2022-09-05 22:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `faction`
--

CREATE TABLE `faction` (
  `factionID` int(3) NOT NULL,
  `factionname` varchar(30) NOT NULL,
  `factionname2` varchar(40) NOT NULL,
  `factionimg` varchar(40) NOT NULL,
  `factionincome` bigint(16) NOT NULL DEFAULT 0,
  `factioncapital` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faction`
--

INSERT INTO `faction` (`factionID`, `factionname`, `factionname2`, `factionimg`, `factionincome`, `factioncapital`) VALUES
(1, 'Galactic Empire', 'Imperial', 'empire.png', 1010220000, 2),
(2, 'Rebel Alliance', 'Rebel', 'logo.png', 108732473, 11);

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets` (
  `fleetID` int(4) NOT NULL,
  `fleetname` varchar(30) NOT NULL,
  `userID` int(3) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`fleetID`, `fleetname`, `userID`, `image`) VALUES
(8, 'Coruscant Defense Fleet', 2, 'ackbar.png'),
(11, 'Corellia Defense Fleet', 2, 'cr90.png'),
(12, 'Corellia Attack Fleet', 1, 'army.png'),
(13, 'Trala Attack Fleet', 2, 'ackbar.png'),
(14, 'Example Fleet', 6, 'fleet.png');

-- --------------------------------------------------------

--
-- Table structure for table `fleets_units`
--

CREATE TABLE `fleets_units` (
  `fleets_unitsID` int(5) NOT NULL,
  `fleetID` int(4) NOT NULL,
  `unitID` int(4) NOT NULL,
  `amount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fleets_units`
--

INSERT INTO `fleets_units` (`fleets_unitsID`, `fleetID`, `unitID`, `amount`) VALUES
(1, 1, 14, 21),
(2, 1, 16, 11),
(3, 1, 13, 11),
(4, 2, 12, 2),
(5, 2, 11, 1),
(6, 3, 12, 10),
(7, 3, 11, 5),
(8, 4, 14, 10),
(9, 4, 16, 10),
(10, 5, 12, 130),
(11, 5, 11, 131),
(12, 6, 14, 132),
(13, 6, 16, 132),
(14, 5, 16, 15),
(15, 8, 14, 102),
(16, 8, 16, 77),
(17, 9, 12, 20),
(18, 9, 11, 30),
(19, 10, 12, 137),
(20, 10, 11, 87),
(21, 11, 16, 106),
(22, 11, 14, 102),
(23, 12, 11, 1),
(24, 13, 13, 0),
(25, 14, 17, 2),
(26, 14, 18, 4);

-- --------------------------------------------------------

--
-- Table structure for table `fleet_location`
--

CREATE TABLE `fleet_location` (
  `locationID` int(11) NOT NULL,
  `fleetID` int(3) NOT NULL,
  `planetID` int(3) NOT NULL,
  `fleetstatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fleet_location`
--

INSERT INTO `fleet_location` (`locationID`, `fleetID`, `planetID`, `fleetstatus`) VALUES
(1, 1, 12, 1),
(2, 2, 12, 1),
(3, 4, 11, 1),
(4, 5, 2, 1),
(5, 3, 5, 1),
(6, 6, 0, 1),
(7, 9, 2, 1),
(8, 8, 11, 2),
(9, 11, 12, 2),
(10, 10, 13, 2),
(11, 13, 11, 1),
(12, 14, 1, 2),
(13, 12, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `planets`
--

CREATE TABLE `planets` (
  `planetID` int(3) NOT NULL,
  `planetname` varchar(30) NOT NULL,
  `planetimg` varchar(30) NOT NULL,
  `planetincome` bigint(16) NOT NULL,
  `hyperlaneID` int(5) DEFAULT NULL,
  `positionID` int(5) DEFAULT NULL,
  `factionID` int(4) NOT NULL DEFAULT 1,
  `userID` int(4) NOT NULL DEFAULT 0,
  `morale` int(3) NOT NULL DEFAULT 100,
  `boost` decimal(4,3) DEFAULT NULL,
  `sectorID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `planets`
--

INSERT INTO `planets` (`planetID`, `planetname`, `planetimg`, `planetincome`, `hyperlaneID`, `positionID`, `factionID`, `userID`, `morale`, `boost`, `sectorID`) VALUES
(1, 'Tatooine', 'tatooine.png', 10000, NULL, NULL, 1, 0, 100, NULL, 3),
(2, 'Coruscant', 'coruscant.png', 1000000000, NULL, NULL, 1, 0, 100, '1.452', 1),
(5, 'Kuat', 'kuat1.png', 10000000, NULL, NULL, 1, 0, 0, NULL, 2),
(9, 'Geonosis', 'Geonosis.png', 200000, NULL, NULL, 1, 0, 0, NULL, 3),
(11, 'Malastare', 'malastare.png', 8732473, NULL, NULL, 3, 0, 0, NULL, 5),
(12, 'Corellia', 'corellia.png', 100000000, NULL, NULL, 3, 0, 100, NULL, 6),
(13, 'Trala', 'purple.png', 10000, NULL, NULL, 1, 0, 100, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `regionID` int(2) NOT NULL,
  `regionname` varchar(30) NOT NULL,
  `regiondistanceID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`regionID`, `regionname`, `regiondistanceID`) VALUES
(1, 'Deep Core', 1),
(2, 'Core Worlds', 2),
(3, 'Colonies', 3),
(4, 'Inner Rim', 4),
(5, 'Expansion Region', 5),
(6, 'Mid Rim', 6),
(7, 'Outer Rim Territories', 7),
(8, 'Unknown Regions', 8);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleID` int(5) NOT NULL,
  `rolename` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `rolename`) VALUES
(1, 'Galactic Empire'),
(2, 'Rebel Alliance');

-- --------------------------------------------------------

--
-- Table structure for table `roles_factions`
--

CREATE TABLE `roles_factions` (
  `role_factionID` int(6) NOT NULL,
  `roleID` int(6) NOT NULL,
  `factionID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles_factions`
--

INSERT INTO `roles_factions` (`role_factionID`, `roleID`, `factionID`) VALUES
(3, 1, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles_units`
--

CREATE TABLE `roles_units` (
  `roles_unitsID` int(6) NOT NULL,
  `roleID` int(6) NOT NULL,
  `unitclassID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles_units`
--

INSERT INTO `roles_units` (`roles_unitsID`, `roleID`, `unitclassID`) VALUES
(27, 1, 1),
(28, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE `roles_users` (
  `roles_usersID` int(6) NOT NULL,
  `roleID` int(6) NOT NULL,
  `userID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `sectorID` int(4) NOT NULL,
  `sectorname` varchar(40) NOT NULL,
  `regionID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`sectorID`, `sectorname`, `regionID`) VALUES
(1, 'Coruscant Sector', 2),
(2, 'Kuat Sector', 2),
(3, 'Arkanis Sector', 7),
(5, 'Dustig Sector', 6),
(6, 'Corellian Sector', 2);

-- --------------------------------------------------------

--
-- Table structure for table `statuskey`
--

CREATE TABLE `statuskey` (
  `statusID` int(1) NOT NULL,
  `statustype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statuskey`
--

INSERT INTO `statuskey` (`statusID`, `statustype`) VALUES
(1, 'Attacking'),
(2, 'Defending'),
(4, 'Moving');

-- --------------------------------------------------------

--
-- Table structure for table `strategies`
--

CREATE TABLE `strategies` (
  `strategyID` int(2) NOT NULL,
  `strategyname` varchar(80) NOT NULL,
  `strategytype` int(1) NOT NULL COMMENT '1=attack\r\n2=defend\r\n3=both'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `strategies`
--

INSERT INTO `strategies` (`strategyID`, `strategyname`, `strategytype`) VALUES
(1, 'Marq Sabel', 2);

-- --------------------------------------------------------

--
-- Table structure for table `strategy_strategy`
--

CREATE TABLE `strategy_strategy` (
  `strategy_strategyID` int(3) NOT NULL,
  `attackingstrategyID` int(2) NOT NULL,
  `defendingstrategyID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unitclass`
--

CREATE TABLE `unitclass` (
  `unitclassID` int(3) NOT NULL,
  `unitname` varchar(100) NOT NULL,
  `unittypeID` int(11) NOT NULL,
  `health` int(4) NOT NULL,
  `power` int(4) NOT NULL,
  `shielding` int(4) NOT NULL,
  `carrycapacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unitclass`
--

INSERT INTO `unitclass` (`unitclassID`, `unitname`, `unittypeID`, `health`, `power`, `shielding`, `carrycapacity`) VALUES
(1, 'Imperial I-class Star Destroyer', 3, 200, 168, 350, 36000),
(2, 'MC75 Star Cruiser', 3, 100, 48, 150, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unitID` int(5) NOT NULL,
  `unitname` varchar(50) NOT NULL,
  `unitclassID` int(3) NOT NULL,
  `health` int(4) NOT NULL,
  `power` int(4) NOT NULL,
  `shielding` int(4) NOT NULL,
  `carrycapacity` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unittype`
--

CREATE TABLE `unittype` (
  `typeID` int(3) NOT NULL,
  `unittype` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unittype`
--

INSERT INTO `unittype` (`typeID`, `unittype`) VALUES
(1, 'Trooper'),
(2, 'Starfighter'),
(3, 'Starship'),
(4, 'Vehicle');

-- --------------------------------------------------------

--
-- Table structure for table `unit_faction`
--

CREATE TABLE `unit_faction` (
  `unit_factionID` int(6) NOT NULL,
  `unitID` int(4) NOT NULL,
  `factionID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unit_user`
--

CREATE TABLE `unit_user` (
  `unit_userID` int(10) NOT NULL,
  `userID` int(4) NOT NULL,
  `unitID` int(4) NOT NULL,
  `amount` int(3) NOT NULL,
  `availableamount` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(3) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `level` int(1) NOT NULL DEFAULT 0,
  `factionID` int(2) NOT NULL DEFAULT 1,
  `credits` bigint(17) NOT NULL DEFAULT 0,
  `income` bigint(16) NOT NULL DEFAULT 0,
  `upkeep` int(16) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `email`, `level`, `factionID`, `credits`, `income`, `upkeep`) VALUES
(1, 'Huetlam', 'password', NULL, 2, 1, 1114267813709, 1010220000, 160000000),
(2, 'Huey', 'password', 'huey@gmail.com', 1, 3, 1100895594958, 108732473, 120000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `battles`
--
ALTER TABLE `battles`
  ADD PRIMARY KEY (`battleID`);

--
-- Indexes for table `battles_fleets`
--
ALTER TABLE `battles_fleets`
  ADD PRIMARY KEY (`battles_fleetsID`);

--
-- Indexes for table `battles_fleets_units`
--
ALTER TABLE `battles_fleets_units`
  ADD PRIMARY KEY (`battles_fleets_unitsID`);

--
-- Indexes for table `battles_losses`
--
ALTER TABLE `battles_losses`
  ADD PRIMARY KEY (`battles_lossesID`);

--
-- Indexes for table `demo`
--
ALTER TABLE `demo`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `faction`
--
ALTER TABLE `faction`
  ADD PRIMARY KEY (`factionID`);

--
-- Indexes for table `fleets`
--
ALTER TABLE `fleets`
  ADD PRIMARY KEY (`fleetID`);

--
-- Indexes for table `fleets_units`
--
ALTER TABLE `fleets_units`
  ADD PRIMARY KEY (`fleets_unitsID`);

--
-- Indexes for table `fleet_location`
--
ALTER TABLE `fleet_location`
  ADD PRIMARY KEY (`locationID`);

--
-- Indexes for table `planets`
--
ALTER TABLE `planets`
  ADD PRIMARY KEY (`planetID`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`regionID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `roles_factions`
--
ALTER TABLE `roles_factions`
  ADD PRIMARY KEY (`role_factionID`);

--
-- Indexes for table `roles_units`
--
ALTER TABLE `roles_units`
  ADD PRIMARY KEY (`roles_unitsID`);

--
-- Indexes for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD PRIMARY KEY (`roles_usersID`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`sectorID`);

--
-- Indexes for table `statuskey`
--
ALTER TABLE `statuskey`
  ADD PRIMARY KEY (`statusID`);

--
-- Indexes for table `strategies`
--
ALTER TABLE `strategies`
  ADD PRIMARY KEY (`strategyID`);

--
-- Indexes for table `strategy_strategy`
--
ALTER TABLE `strategy_strategy`
  ADD PRIMARY KEY (`strategy_strategyID`);

--
-- Indexes for table `unitclass`
--
ALTER TABLE `unitclass`
  ADD PRIMARY KEY (`unitclassID`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unitID`);

--
-- Indexes for table `unittype`
--
ALTER TABLE `unittype`
  ADD PRIMARY KEY (`typeID`);

--
-- Indexes for table `unit_faction`
--
ALTER TABLE `unit_faction`
  ADD PRIMARY KEY (`unit_factionID`);

--
-- Indexes for table `unit_user`
--
ALTER TABLE `unit_user`
  ADD PRIMARY KEY (`unit_userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `battles`
--
ALTER TABLE `battles`
  MODIFY `battleID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `battles_fleets`
--
ALTER TABLE `battles_fleets`
  MODIFY `battles_fleetsID` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `battles_fleets_units`
--
ALTER TABLE `battles_fleets_units`
  MODIFY `battles_fleets_unitsID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `battles_losses`
--
ALTER TABLE `battles_losses`
  MODIFY `battles_lossesID` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `demo`
--
ALTER TABLE `demo`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faction`
--
ALTER TABLE `faction`
  MODIFY `factionID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fleets`
--
ALTER TABLE `fleets`
  MODIFY `fleetID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `fleets_units`
--
ALTER TABLE `fleets_units`
  MODIFY `fleets_unitsID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `fleet_location`
--
ALTER TABLE `fleet_location`
  MODIFY `locationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `planets`
--
ALTER TABLE `planets`
  MODIFY `planetID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `regionID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles_factions`
--
ALTER TABLE `roles_factions`
  MODIFY `role_factionID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles_units`
--
ALTER TABLE `roles_units`
  MODIFY `roles_unitsID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `roles_users`
--
ALTER TABLE `roles_users`
  MODIFY `roles_usersID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `sectorID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `statuskey`
--
ALTER TABLE `statuskey`
  MODIFY `statusID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `strategies`
--
ALTER TABLE `strategies`
  MODIFY `strategyID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `strategy_strategy`
--
ALTER TABLE `strategy_strategy`
  MODIFY `strategy_strategyID` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unitclass`
--
ALTER TABLE `unitclass`
  MODIFY `unitclassID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unitID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unittype`
--
ALTER TABLE `unittype`
  MODIFY `typeID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit_faction`
--
ALTER TABLE `unit_faction`
  MODIFY `unit_factionID` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_user`
--
ALTER TABLE `unit_user`
  MODIFY `unit_userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `newturnincomesuccess` ON SCHEDULE EVERY 1 DAY STARTS '2022-07-07 21:34:59' ENDS '2023-07-31 18:34:49' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    
UPDATE `faction` SET `faction`.`factionincome` = (SELECT SUM(`planets`.`planetincome`) FROM `planets` WHERE `planets`.`factionID` = `faction`.`factionID`);

UPDATE `user` JOIN faction on user.factionID = faction.factionID SET `user`.`income` = `faction`.`factionincome` WHERE `user`.`factionID` = `faction`.`factionID`;
   
UPDATE `user` SET `credits` = `credits`+`income`;

UPDATE `user` SET `credits` = `credits`-`upkeep`;

INSERT INTO `demo` (`message`, `created_on`) VALUES ('New Turn', CURRENT_TIMESTAMP);

END$$

CREATE DEFINER=`root`@`localhost` EVENT `test` ON SCHEDULE AT '2022-07-12 11:13:48' ON COMPLETION PRESERVE DISABLE DO UPDATE battles SET battlestatus = 2 WHERE battleID = 5$$

CREATE DEFINER=`root`@`localhost` EVENT `battletest` ON SCHEDULE AT '2022-07-12 11:16:02' ON COMPLETION PRESERVE DISABLE DO UPDATE battles SET battlestatus = 1 WHERE battleID = 5$$

CREATE DEFINER=`root`@`localhost` EVENT `battleofKuat` ON SCHEDULE AT '2022-07-31 16:20:21' ON COMPLETION PRESERVE DISABLE DO UPDATE battles SET battlestatus = 2 WHERE battleID = 18$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
