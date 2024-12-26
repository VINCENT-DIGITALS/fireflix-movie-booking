-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 07:39 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fireflix`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AID` int(10) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AID`, `password`, `email`, `username`) VALUES
(1, 'admin', 'fireflixcompany@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `AID` int(11) NOT NULL,
  `MID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `booked_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BID`, `UID`, `AID`, `MID`, `SID`, `ticket`, `total_cost`, `booked_at`) VALUES
(1, 1, 1, 302, 1, 1, 500, '2023-05-02'),
(2, 2, 1, 305, 23, 1, 200, '2023-05-02'),
(3, 3, 1, 306, 60, 1, 1000, '2023-05-02');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `MID` int(11) NOT NULL,
  `movie_name` varchar(50) NOT NULL,
  `synopsis` varchar(300) NOT NULL,
  `running_time` int(100) NOT NULL,
  `price` float NOT NULL,
  `discount` int(11) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `genre` varchar(50) NOT NULL,
  `trailer` varchar(100) NOT NULL,
  `releasedate` date NOT NULL,
  `screen` varchar(10) NOT NULL DEFAULT 'IMAX',
  `showdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`MID`, `movie_name`, `synopsis`, `running_time`, `price`, `discount`, `poster`, `archived_at`, `genre`, `trailer`, `releasedate`, `screen`, `showdate`) VALUES
(291, 'LASTTTTT!', '2222', 20, 23, 22, '', '2023-05-04 05:28:02', 'THRILLER', 'https://youtu.be/vh4CyH4OKoo', '0000-00-00', 'IMAX', '2023-05-02'),
(302, 'TODAYYYYYY!!', '23', 233, 23, 23, 'posters/deleter.jpg', '2023-05-04 05:28:07', '23', '23', '2023-03-27', 'IMAX', '2023-05-02'),
(303, '2333', '2323', 2323, 2323, 2323, 'posters/MOVIE INFORMATION.jpg', NULL, '23232', '23232', '2023-04-04', 'IMAX', '2023-05-02'),
(304, '10', '12345678999', 10, 200, 0, 'posters/MOVIE INFORMATION.jpg', NULL, 'THRILLER', 'https://youtu.be/vh4CyH4OKoo', '0000-00-00', 'IMAX', '0000-00-00'),
(305, 'John Strong', 'John Strong, HE IS STRONG AHAHAHA', 60, 10000, 0, 'posters/SMILE (2022).jpg', NULL, 'THRILLER', 'https://youtu.be/vh4CyH4OKoo', '2023-04-01', 'IMAX', '2023-05-02'),
(306, '2', '22', 2, 2, 2, 'posters/deleter.jpg', NULL, '2', '2', '0002-02-22', 'IMAX', '2023-05-02'),
(307, 'LAST LAST DATA', '2', 10, 2, 2, 'posters/SMILE (2022).jpg', NULL, 'HORROR', 'https://youtu.be/vh4CyH4OKoo', '2023-05-02', 'IMAX', '2023-05-03'),
(308, 'Wahskmn', 'hasgkn', 139, 100, 70, 'posters/Log.svg', NULL, 'Fantasy', 'https://youtu.be/vh4CyH4OKoo', '2023-05-11', 'IMAX', '2023-05-08'),
(309, 'Gagninss', 'grfajvduoklb\r\n', 200, 100, 24, 'products/deleter.jpg', NULL, 'Thriller', 'https://youtu.be/vh4CyH4OKoo', '2023-05-18', 'IMAX', '2023-05-09'),
(310, 'ano b yan/', 'vwwgeydh', 150, 75, 20, 'posters/The-Invitation-2-930x620.jpg', NULL, 'horror', 'https://youtu.be/vh4CyH4OKoo', '2023-05-19', 'IMAX', '2023-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `RID` int(10) NOT NULL,
  `UID` int(10) NOT NULL,
  `AID` int(10) NOT NULL,
  `review` varchar(200) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`RID`, `UID`, `AID`, `review`, `time`, `approved_at`) VALUES
(1, 1, 1, 'POGIPOGI POGIPOGI', '2023-05-04 05:59:40', NULL),
(2, 3, 1, 'POGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGIPOGI POGIPOGIPOGIPOGIPOGIPOG', '2023-05-03 06:02:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seating`
--

CREATE TABLE `seating` (
  `SID` int(10) NOT NULL,
  `AID` int(10) NOT NULL DEFAULT 1,
  `MID` int(10) NOT NULL,
  `BID` int(10) NOT NULL,
  `UID` int(10) NOT NULL,
  `taken` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seating`
--

INSERT INTO `seating` (`SID`, `AID`, `MID`, `BID`, `UID`, `taken`) VALUES
(1, 1, 302, 1, 2, '2023-05-05'),
(23, 1, 302, 3, 2, '2023-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `price_per_item` double NOT NULL,
  `quantity` int(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `product_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `name`, `type`, `price_per_item`, `quantity`, `description`, `archived_at`, `product_img`) VALUES
(1, 'Popcorn', 'Food', 45, 50, '', NULL, ''),
(2, 'Vincent', 'Food', 999999, 1, 'YIEEE MAHAL', NULL, 'products/DELTER (2022).jpg'),
(3, 'Sprtie', 'Drink', 30, 100, '', NULL, ''),
(5, 'Sting', 'Drink', 20, 100, '', NULL, ''),
(6, 'RC Cola', 'Drink', 30, 100, '', NULL, ''),
(42, 'John', 'Food', 100000, 1, 'POGI!!!', NULL, 'products/TEXAS.jpg'),
(43, 'SYA', 'Food', 1, 1, 'WALA KAYO', NULL, 'products/The-Invitation-2-930x620.jpg'),
(44, '4', 'Drink', 4, 4, '4', NULL, 'products/TEXAS.jpg'),
(45, 'Tacos', 'Drink', 30, 3, 'vyivrrcliuyg', NULL, 'products/The-Invitation-2-930x620.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UID` int(10) NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `contact_num` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `otp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UID`, `fullname`, `email`, `username`, `contact_num`, `password`, `otp`) VALUES
(1, 'John Vincent T. Macayanan', 'johnvincentmacayanan2017@gmail.com', 'user', '9497918144', 'POGIAKO', 'thwx5'),
(2, 'WHO', 'WHAT', 'WHO', '94979181440', 'user', NULL),
(3, 'John Vincent Macayanan', 'johnvincentmacayanan2018@gmail.com', '123456', '123456789', 'user123', ''),
(7, 'DONE', 'DONE@gmail.com', 'DONE', 'DONE', 'user123', ''),
(126, '5', '2@gmail.com', '2', '2', '2', NULL),
(127, '2', 'johnvincentmacayananpro@gmail.com', '2', '2', '2', NULL),
(128, 'John Vincent Macayanan', 'johnvincentmacayan2018@gmail.com', '2', '2', '22222', NULL),
(129, 'John Vincent Macayanan', 'johnvincentma2017@gmail.com', 'admin', '2', '22222222', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BID`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`RID`);

--
-- Indexes for table `seating`
--
ALTER TABLE `seating`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `MID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `RID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seating`
--
ALTER TABLE `seating`
  MODIFY `SID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
