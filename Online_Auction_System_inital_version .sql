-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 22, 2023 at 01:42 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Online_Auction_System`
--

-- --------------------------------------------------------

--
-- Table structure for table `Auction`
--

CREATE TABLE `Auction` (
  `auction_ID` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `features` text,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `starting_price` decimal(10,2) NOT NULL,
  `reserve_price` decimal(10,2) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auction_ID`, `item_name`, `description`, `category`, `features`, `start_time`, `end_time`, `starting_price`, `reserve_price`, `user_ID`) VALUES
(1, 'Vintage Clock', 'An old vintage clock from the 1930s.', 'Antiques', 'Wooden, pendulum', '2023-11-20 12:09:09', '2023-11-27 12:09:09', '100.00', '150.00', 1),
(2, 'Modern Art Painting', 'Abstract modern art piece by a local artist.', 'Art', 'Canvas, acrylic', '2023-11-20 12:09:09', '2023-11-25 12:09:09', '200.00', '300.00', 1),
(3, 'Antique Chair', 'A wooden chair from the 18th century.', 'Furniture', 'Oak, hand-carved', '2023-11-21 10:00:00', '2023-11-28 10:00:00', '150.00', '200.00', 2),
(4, 'Diamond Ring', 'Elegant diamond ring.', 'Jewelry', '18k Gold, 1ct diamond', '2023-11-21 11:00:00', '2023-11-28 11:00:00', '500.00', '700.00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `bid_ID` int(11) NOT NULL,
  `bid_price` decimal(10,2) NOT NULL,
  `time_of_bid` datetime NOT NULL,
  `auction_ID` int(11) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`bid_ID`, `bid_price`, `time_of_bid`, `auction_ID`, `user_ID`) VALUES
(1, '110.00', '2023-11-20 12:12:21', 1, 2),
(2, '220.00', '2023-11-20 13:12:21', 2, 3),
(3, '160.00', '2023-11-21 10:10:10', 1, 1),
(4, '550.00', '2023-11-21 11:15:15', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `transaction_ID` int(11) NOT NULL,
  `transaction_time` datetime NOT NULL,
  `transaction_amount` decimal(10,2) NOT NULL,
  `transaction_status` enum('Pending','Completed','Cancelled','Refunded') NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `payment_method` enum('Credit Card','Debit','PayPal','Bank Transfer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Transaction`
--

INSERT INTO `Transaction` (`transaction_ID`, `transaction_time`, `transaction_amount`, `transaction_status`, `user_ID`, `payment_method`) VALUES
(1, '2023-11-20 12:13:11', '110.00', 'Completed', 2, 'Credit Card'),
(2, '2023-11-20 14:13:11', '220.00', 'Pending', 3, 'PayPal'),
(3, '2023-11-21 12:00:00', '160.00', 'Completed', 1, 'Debit'),
(4, '2023-11-21 13:00:00', '550.00', 'Pending', 2, 'Bank Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('buyer','seller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_ID`, `username`, `password`, `phone_number`, `email`, `address`, `role`) VALUES
(1, 'john_doe', 'securepassword', '555-1010', 'john.doe@example.com', '123 Main St, Anytown', 'seller'),
(2, 'jane_smith', 'anotherpassword', '555-2020', 'jane.smith@example.com', '456 Oak St, Anytown', 'buyer'),
(3, 'alice_jones', 'mypassword123', '555-3030', 'alice.jones@example.com', '789 Pine St, Anytown', 'buyer'),
(4, 'bob_brown', 'password123', '555-4040', 'bob.brown@example.com', '1010 Willow St, Anytown', 'seller'),
(5, 'carol_white', 'pass456', '555-5050', 'carol.white@example.com', '1111 Maple St, Anytown', 'buyer'),
(6, 'alice_boom', 'password123', '123-456-7890', 'boom@example.com', '123 High St, City, Country', 'buyer'),
(7, 'johntest', '$2y$10$Uiprc1u9FmP8Ekpm71f6MuxnvM33KTdMv7.jH1aWJ8jJanlnvgWWy', NULL, 'johntest@example.com', NULL, 'buyer'),
(8, 'alicetest', '$2y$10$GStOpp9ZkrFu.cAQxPvn8ufgaGLI9zokXIQYCDv6wkM0S8sNm0Dwy', NULL, 'alicetest@example.com', NULL, 'seller'),
(9, 'ethantest', '$2y$10$E7cb7SLAmc41C7ECIR.HzOrR.ACJDEaW0Vv2.wgo/5twZjagqtj5i', NULL, 'ethantest@example.com', NULL, 'buyer'),
(10, 'testlogin', '$2y$10$9PNvO5SMnRaav0lUTAE.zemVX6/DdCE9DtJxFov5DXz4Wbi9hbTQ.', NULL, 'testlogin@example.com', NULL, 'seller'),
(11, 'Marrytes', '$2y$10$HmG.jz/S4wKsWn.fxTBguOk9XfNx4RSA.UNhGwI0p8BqoYggBVLc6', NULL, 'Marrytest@example.com', NULL, 'buyer'),
(13, 'Henrrytest', '$2y$10$PamhbZ/kAt5kvkbxKn.I9OHiI4x6CxoHxtyFI0OzBK0bL68qsVlEe', NULL, 'Henrrytest@example.com', NULL, 'buyer'),
(14, 'guatest', '$2y$10$qmVfPOnRytoL10fh0jmJAuIZxsVEMvgvbxKIOsu10E.F2XPUp1BVO', NULL, 'guatest@example.com', NULL, 'buyer'),
(15, 'bobtest', '$2y$10$qHUBrh.pvynf7thxfDFSm.nEW6xBBMNazMsj/9DFEWwT6RtwyMKvO', NULL, 'bobtest@example.com', NULL, 'buyer'),
(16, 'ethan', '$2y$10$m3XMnu0bp3cN.IXlxYZ9DeEGTKBJz3K2q9WcbZmFljBSW15cEMDii', NULL, 'ethan@example.com', NULL, 'buyer'),
(17, 'guagua', '$2y$10$KCTsbUHnryYeLNOgTVWTx.TWCrOrAZcVdvs1Q0XVctnCWYyMX7f56', NULL, 'guagua@example.com', NULL, 'buyer');

-- --------------------------------------------------------

--
-- Table structure for table `watch`
--

CREATE TABLE `watch` (
  `user_ID` int(11) NOT NULL,
  `auction_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `watch`
--

INSERT INTO `watch` (`user_ID`, `auction_ID`) VALUES
(2, 1),
(3, 2),
(1, 3),
(2, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Auction`
--
ALTER TABLE `Auction`
  ADD PRIMARY KEY (`auction_ID`),
  ADD KEY `auction_ibfk_1` (`user_ID`);

--
-- Indexes for table `Bid`
--
ALTER TABLE `Bid`
  ADD PRIMARY KEY (`bid_ID`),
  ADD KEY `auction_ID` (`auction_ID`),
  ADD KEY `bid_ibfk_2` (`user_ID`);

--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `transaction_ibfk_1` (`user_ID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `watch`
--
ALTER TABLE `watch`
  ADD PRIMARY KEY (`user_ID`,`auction_ID`),
  ADD KEY `auction_ID` (`auction_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Auction`
--
ALTER TABLE `Auction`
  ADD CONSTRAINT `auction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- Constraints for table `Bid`
--
ALTER TABLE `Bid`
  ADD CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`auction_ID`) REFERENCES `Auction` (`auction_ID`),
  ADD CONSTRAINT `bid_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- Constraints for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- Constraints for table `watch`
--
ALTER TABLE `watch`
  ADD CONSTRAINT `watch_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`),
  ADD CONSTRAINT `watch_ibfk_2` FOREIGN KEY (`auction_ID`) REFERENCES `Auction` (`auction_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
