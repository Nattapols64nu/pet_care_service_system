-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 04:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet_care_service_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindb`
--

CREATE TABLE `admindb` (
  `ID` int(11) NOT NULL,
  `adminID` varchar(255) NOT NULL,
  `adminpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admindb`
--

INSERT INTO `admindb` (`ID`, `adminID`, `adminpassword`) VALUES
(2, 'adminpetcareservicesystem', '25d55ad283aa400af464c76d713c07ad');

-- --------------------------------------------------------

--
-- Table structure for table `catimages`
--

CREATE TABLE `catimages` (
  `id` int(11) NOT NULL,
  `catID` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `uploaded_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `catimages`
--

INSERT INTO `catimages` (`id`, `catID`, `image`, `uploaded_on`) VALUES
(3, 19, 'pawprint (1).png', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `catreceipt`
--

CREATE TABLE `catreceipt` (
  `ceslipID` int(11) NOT NULL,
  `ceslip` varchar(255) NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `catID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `catreceipt`
--

INSERT INTO `catreceipt` (`ceslipID`, `ceslip`, `uploaded_on`, `status`, `catID`) VALUES
(4, 'pawprint.png', '2024-10-30 10:12:23', '1', 19);

-- --------------------------------------------------------

--
-- Table structure for table `catservice`
--

CREATE TABLE `catservice` (
  `catID` int(11) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `catgender` enum('ผู้','เมีย') NOT NULL,
  `catage` varchar(100) NOT NULL,
  `catspicies` varchar(255) DEFAULT NULL,
  `catheat` enum('มี','ไม่มี') NOT NULL,
  `catbehavior` varchar(255) DEFAULT NULL,
  `cattick` enum('มี','ไม่มี') NOT NULL,
  `catcongen` varchar(255) NOT NULL,
  `catvac` enum('ครบ','ไม่ครบ') NOT NULL,
  `catrs` enum('ระบบปิด','ระบบเปิด') NOT NULL,
  `cattrans` text NOT NULL,
  `catservices` varchar(255) NOT NULL,
  `cdatetimestartc` datetime NOT NULL,
  `cdatetimeendc` datetime NOT NULL,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `line` varchar(100) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `catservice`
--

INSERT INTO `catservice` (`catID`, `catname`, `catgender`, `catage`, `catspicies`, `catheat`, `catbehavior`, `cattick`, `catcongen`, `catvac`, `catrs`, `cattrans`, `catservices`, `cdatetimestartc`, `cdatetimeendc`, `userID`, `username`, `phone`, `facebook`, `line`, `total_price`, `status`) VALUES
(19, 'gigi', 'เมีย', '9 เดือน', 'american short hair', 'ไม่มี', 'good', 'ไม่มี', 'ไม่มี', 'ครบ', 'ระบบเปิด', 'Phitsanulok', 'ฝากเลี้ยง', '2024-10-31 15:11:00', '2024-11-01 14:11:00', 5, 'test', '0807930288', 'Test Test', 'Test123', 200, 'สำเร็จ');

-- --------------------------------------------------------

--
-- Table structure for table `dogimages`
--

CREATE TABLE `dogimages` (
  `id` int(11) NOT NULL,
  `dogID` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `uploaded_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dogimages`
--

INSERT INTO `dogimages` (`id`, `dogID`, `image`, `uploaded_on`) VALUES
(3, 65, 'pawprint (1).png', '2024-10-30 03:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `dogreceipt`
--

CREATE TABLE `dogreceipt` (
  `deslipID` int(11) NOT NULL,
  `deslip` varchar(255) NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `dogID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dogreceipt`
--

INSERT INTO `dogreceipt` (`deslipID`, `deslip`, `uploaded_on`, `status`, `dogID`) VALUES
(10, 'pawprint.png', '2024-10-30 10:11:05', '1', 65);

-- --------------------------------------------------------

--
-- Table structure for table `dogservice`
--

CREATE TABLE `dogservice` (
  `dogID` int(11) NOT NULL,
  `dogname` varchar(255) NOT NULL,
  `doggender` enum('ผู้','เมีย') NOT NULL,
  `dogage` varchar(255) NOT NULL,
  `dogspicies` varchar(255) DEFAULT NULL,
  `dogbark` enum('เห่า','ไม่เห่า') NOT NULL,
  `dogbehavior` varchar(255) DEFAULT NULL,
  `dogtick` enum('มี','ไม่มี') NOT NULL,
  `dogcongen` varchar(255) NOT NULL,
  `dogvac` enum('ครบ','ไม่ครบ') NOT NULL,
  `dogrs` enum('ระบบปิด','ระบบเปิด') NOT NULL,
  `dogtrans` text NOT NULL,
  `dogservices` varchar(255) NOT NULL,
  `ddatetimestartd` datetime NOT NULL,
  `ddatetimeendd` datetime NOT NULL,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `line` varchar(100) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dogservice`
--

INSERT INTO `dogservice` (`dogID`, `dogname`, `doggender`, `dogage`, `dogspicies`, `dogbark`, `dogbehavior`, `dogtick`, `dogcongen`, `dogvac`, `dogrs`, `dogtrans`, `dogservices`, `ddatetimestartd`, `ddatetimeendd`, `userID`, `username`, `phone`, `facebook`, `line`, `total_price`, `status`) VALUES
(65, 'Bobo', 'ผู้', '8 ปี', 'บางแก้ว', 'เห่า', 'ร่าเริง', 'ไม่มี', 'clash', 'ครบ', 'ระบบปิด', 'ไม่ต้องการ', 'อาบน้ำ-ตัดขน,ฝากเลี้ยง', '2024-10-30 16:15:00', '2024-11-10 16:15:00', 5, 'test', '0807930288', 'Test Test', 'Test123', 3500, 'กำลังดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `line` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`userID`, `email`, `password`, `username`, `phone`, `facebook`, `line`) VALUES
(5, 'test@test.com', '81dc9bdb52d04dc20036dbd8313ed055', 'test', '0807930288', 'Test Test', 'Test123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindb`
--
ALTER TABLE `admindb`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `catimages`
--
ALTER TABLE `catimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catID` (`catID`);

--
-- Indexes for table `catreceipt`
--
ALTER TABLE `catreceipt`
  ADD PRIMARY KEY (`ceslipID`),
  ADD KEY `fk_catservice` (`catID`);

--
-- Indexes for table `catservice`
--
ALTER TABLE `catservice`
  ADD PRIMARY KEY (`catID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `dogimages`
--
ALTER TABLE `dogimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dogID` (`dogID`);

--
-- Indexes for table `dogreceipt`
--
ALTER TABLE `dogreceipt`
  ADD PRIMARY KEY (`deslipID`),
  ADD KEY `fk_dogservice` (`dogID`);

--
-- Indexes for table `dogservice`
--
ALTER TABLE `dogservice`
  ADD PRIMARY KEY (`dogID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admindb`
--
ALTER TABLE `admindb`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `catimages`
--
ALTER TABLE `catimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `catreceipt`
--
ALTER TABLE `catreceipt`
  MODIFY `ceslipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `catservice`
--
ALTER TABLE `catservice`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dogimages`
--
ALTER TABLE `dogimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dogreceipt`
--
ALTER TABLE `dogreceipt`
  MODIFY `deslipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dogservice`
--
ALTER TABLE `dogservice`
  MODIFY `dogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catimages`
--
ALTER TABLE `catimages`
  ADD CONSTRAINT `catimages_ibfk_1` FOREIGN KEY (`catID`) REFERENCES `catservice` (`catID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `catreceipt`
--
ALTER TABLE `catreceipt`
  ADD CONSTRAINT `fk_catservice` FOREIGN KEY (`catID`) REFERENCES `catservice` (`catID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `catservice`
--
ALTER TABLE `catservice`
  ADD CONSTRAINT `catservice_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `register` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `dogimages`
--
ALTER TABLE `dogimages`
  ADD CONSTRAINT `dogimages_ibfk_1` FOREIGN KEY (`dogID`) REFERENCES `dogservice` (`dogID`) ON DELETE CASCADE;

--
-- Constraints for table `dogreceipt`
--
ALTER TABLE `dogreceipt`
  ADD CONSTRAINT `fk_dogservice` FOREIGN KEY (`dogID`) REFERENCES `dogservice` (`dogID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dogservice`
--
ALTER TABLE `dogservice`
  ADD CONSTRAINT `dogservice_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `register` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
