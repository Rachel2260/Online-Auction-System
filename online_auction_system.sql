-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2023-12-03 00:06:48
-- 服务器版本： 8.0.31
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `online_auction_system`
--

-- --------------------------------------------------------

--
-- 表的结构 `auction`
--

DROP TABLE IF EXISTS `auction`;
CREATE TABLE IF NOT EXISTS `auction` (
  `auction_ID` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `end_time` datetime NOT NULL,
  `starting_price` decimal(10,2) NOT NULL,
  `reserve_price` decimal(10,2) DEFAULT NULL,
  `user_ID` int DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`auction_ID`),
  KEY `auction_ibfk_1` (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `auction`
--

INSERT INTO `auction` (`auction_ID`, `item_name`, `description`, `category`, `end_time`, `starting_price`, `reserve_price`, `user_ID`, `filename`) VALUES
(1, 'Vintage Clock', 'An old vintage clock from the 1930s.', 'Antiques', '2023-11-27 12:09:09', '100.00', '150.00', 1, NULL),
(2, 'Modern Art Painting', 'Abstract modern art piece by a local artist.', 'Art', '2023-11-25 12:09:09', '200.00', '300.00', 1, NULL),
(3, 'Antique Chair', 'A wooden chair from the 18th century.', 'others', '2023-11-28 10:00:00', '150.00', '200.00', 2, NULL),
(4, 'Diamond Ring', 'Elegant diamond ring.', 'Jewelry', '2023-11-28 11:00:00', '500.00', '700.00', 3, NULL),
(5, 'Antique Vase', 'An ancient vase from the 18th century.', 'Antiques', '2023-11-25 08:00:00', '150.00', '200.00', 8, NULL),
(6, 'Abstract Art Sculpture', 'Unique abstract art sculpture by a renowned artist.', 'Art', '2023-11-26 10:30:00', '200.00', '300.00', 9, NULL),
(7, 'Rare First Edition Book', 'A first edition of a classic novel.', 'others', '2023-11-27 15:45:00', '50.00', '70.00', 10, NULL),
(8, 'Vintage Leather Jacket', 'Stylish vintage leather jacket from the 1980s.', 'others', '2023-11-28 18:20:00', '90.00', '120.00', 11, NULL),
(9, 'Collectible Action Figures Set', 'Limited edition collectible action figures set.', 'others', '2023-11-29 22:00:00', '40.00', '60.00', 12, NULL),
(10, 'Vintage Painting', 'A classic painting from the 19th century.', 'Art', '2023-12-01 15:30:00', '200.00', '250.00', 8, NULL),
(11, 'Rare Book Collection', 'A collection of rare and antique books.', 'others', '2023-12-02 12:45:00', '50.00', '60.00', 9, NULL),
(12, 'Fashionable Hat', 'Stylish hat from a popular designer brand.', 'others', '2023-12-03 18:00:00', '80.00', '100.00', 10, NULL),
(13, 'Limited Edition Collectible Toy', 'Exclusive collectible toy with unique features.', 'others', '2023-12-04 21:15:00', '30.00', '30.00', 11, NULL),
(14, 'Vintage Vinyl Records Set', 'A set of classic vinyl records from the 1970s.', 'others', '2023-12-05 14:30:00', '70.00', '80.00', 12, NULL),
(15, 'Antique Desk', 'A beautifully crafted antique desk.', 'others', '2023-12-06 12:30:00', '150.00', '200.00', 8, NULL),
(16, 'Contemporary Art Installation', 'A modern art installation by a rising artist.', 'Art', '2023-12-07 14:45:00', '250.00', '300.00', 9, NULL),
(17, 'Rare Book Set', 'A complete set of rare and valuable books.', 'others', '2023-12-08 17:00:00', '80.00', '100.00', 10, NULL),
(18, 'Designer Handbag', 'Fashionable designer handbag with exquisite details.', 'others', '2023-12-09 19:15:00', '120.00', '150.00', 11, NULL),
(19, 'Limited Edition Watch', 'Exclusive limited edition watch with unique features.', 'others', '2023-12-10 21:30:00', '180.00', '200.00', 12, NULL),
(20, 'Vintage Teapot Set', 'A charming teapot set from the early 20th century.', 'Antiques', '2023-12-15 16:30:00', '50.00', '70.00', 8, NULL),
(21, 'Abstract Canvas Painting', 'Unique abstract canvas painting by a contemporary artist.', 'Art', '2023-12-16 18:45:00', '100.00', '120.00', 9, NULL),
(22, 'Rare First Edition Novels', 'A collection of first edition novels from renowned authors.', 'others', '2023-12-17 20:00:00', '80.00', '100.00', 10, NULL),
(23, 'Fashionable Scarf', 'Stylish scarf with intricate patterns.', 'others', '2023-12-18 21:15:00', '30.00', '40.00', 11, NULL),
(24, 'Vintage Vinyl Record Player', 'Classic vintage vinyl record player in excellent condition.', 'Electronics', '2023-12-19 22:30:00', '150.00', '180.00', 12, NULL),
(25, 'Vintage Dining Table Set', 'A complete vintage dining table set for your home.', 'others', '2023-12-20 15:30:00', '200.00', '250.00', 13, NULL),
(26, 'Impressionist Artwork', 'An exquisite impressionist artwork to enhance your art collection.', 'Art', '2023-12-21 12:45:00', '180.00', '200.00', 14, NULL),
(27, 'Rare Book Collection II', 'Another set of rare and valuable books for book enthusiasts.', 'others', '2023-12-22 18:00:00', '90.00', '100.00', 15, NULL),
(28, 'Designer Sunglasses', 'Fashionable designer sunglasses for a trendy look.', 'others', '2023-11-28 21:15:00', '70.00', '80.00', 16, NULL),
(29, 'Collectible Vinyl Records', 'A set of collectible vinyl records for music lovers.', 'others', '2023-12-24 14:30:00', '120.00', '150.00', 17, NULL),
(30, 'dsadad', 'dsadasdsaeww', 'Art', '2023-12-02 21:19:00', '1.00', '1.00', 10, NULL),
(31, 'eqwe', 'qew', 'Art', '2023-12-03 09:02:00', '123.00', '123.00', 23, ''),
(32, '3132', '31232', 'Jewelry', '2023-12-03 06:03:00', '321.00', '321.00', 23, '微信图片_20231031233351.jpg'),
(33, '3132d', '', 'Art', '2023-12-03 09:09:00', '321.00', '321.00', 23, '微信图片_20231031233351.jpg'),
(34, 'ewq', 'dsad', 'Art', '2023-12-03 05:14:00', '12.00', '12.00', 23, 'try.png.png');

-- --------------------------------------------------------

--
-- 表的结构 `bid`
--

DROP TABLE IF EXISTS `bid`;
CREATE TABLE IF NOT EXISTS `bid` (
  `bid_ID` int NOT NULL AUTO_INCREMENT,
  `bid_price` decimal(10,2) NOT NULL,
  `time_of_bid` datetime NOT NULL,
  `auction_ID` int DEFAULT NULL,
  `user_ID` int DEFAULT NULL,
  PRIMARY KEY (`bid_ID`),
  KEY `bid_ibfk_1` (`auction_ID`),
  KEY `bid_ibfk_3` (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `bid`
--

INSERT INTO `bid` (`bid_ID`, `bid_price`, `time_of_bid`, `auction_ID`, `user_ID`) VALUES
(1, '110.00', '2023-11-20 12:12:21', 1, 2),
(2, '220.00', '2023-11-20 13:12:21', 2, 3),
(3, '160.00', '2023-11-21 10:10:10', 1, 1),
(4, '550.00', '2023-11-21 11:15:15', 2, 2),
(5, '150.00', '2023-11-25 14:30:00', 3, 11),
(6, '500.00', '2023-11-25 15:45:00', 4, 12),
(7, '150.00', '2023-11-26 10:00:00', 5, 13),
(8, '200.00', '2023-11-26 11:15:00', 6, 14),
(9, '50.00', '2023-11-27 08:00:00', 7, 15),
(10, '90.00', '2023-11-27 09:30:00', 8, 16),
(11, '80.00', '2023-11-28 10:45:00', 9, 17),
(12, '200.00', '2023-11-28 12:00:00', 10, 18),
(13, '70.00', '2023-11-29 14:30:00', 11, 19),
(14, '120.00', '2023-11-29 16:00:00', 12, 7),
(16, '70.00', '2023-11-30 19:30:00', 14, 9),
(18, '250.00', '2023-12-02 08:30:00', 16, 11),
(19, '80.00', '2023-12-02 09:45:00', 17, 12),
(20, '120.00', '2023-12-03 12:15:00', 18, 13),
(21, '180.00', '2023-12-03 13:30:00', 19, 14),
(22, '80.00', '2023-11-29 07:56:55', 11, 18),
(23, '90.00', '2023-11-29 07:59:39', 11, 22),
(24, '100.00', '2023-11-29 08:00:48', 11, 18),
(28, '80.00', '2023-11-30 04:17:06', 28, 22),
(29, '100.00', '2023-11-30 04:17:34', 23, 22),
(30, '80.00', '2023-11-30 12:44:02', 14, 22),
(31, '12313.00', '2023-12-02 12:18:00', 30, 18),
(32, '50.00', '2023-12-02 01:55:16', 13, 18),
(33, '123.00', '2023-12-02 09:44:03', 34, 18),
(34, '70.00', '2023-12-02 23:18:43', 20, 24),
(35, '80.00', '2023-12-02 23:19:10', 20, 18),
(36, '90.00', '2023-12-02 23:28:45', 20, 18),
(37, '100.00', '2023-12-02 23:33:05', 20, 18),
(38, '100.00', '2023-12-02 23:34:22', 13, 24),
(39, '100.00', '2023-12-02 23:36:14', 17, 18),
(40, '100.00', '2023-12-02 23:44:11', 27, 18),
(41, '120.00', '2023-12-02 23:49:26', 17, 18),
(42, '130.00', '2023-12-02 23:50:33', 17, 18),
(43, '80.00', '2023-12-02 23:59:14', 22, 18);

-- --------------------------------------------------------

--
-- 表的结构 `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `history_ID` int NOT NULL AUTO_INCREMENT,
  `user_ID` int DEFAULT NULL,
  `auction_ID` int DEFAULT NULL,
  PRIMARY KEY (`history_ID`),
  KEY `auction_ID` (`auction_ID`),
  KEY `user_ID` (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `history`
--

INSERT INTO `history` (`history_ID`, `user_ID`, `auction_ID`) VALUES
(1, 21, 13),
(2, 21, 23),
(3, 22, 11),
(4, 22, 11),
(5, 22, 11),
(6, 22, 11),
(7, 22, 28),
(8, 22, 23),
(9, 22, 28),
(10, 22, 28),
(11, 22, 28),
(12, 22, 28),
(13, 22, 28),
(14, 22, 28),
(15, 22, 28),
(16, 22, 28),
(17, 22, 28),
(18, 22, 28),
(19, 22, 28),
(20, 22, 28),
(21, 22, 28),
(22, 22, 28),
(23, 22, 28),
(24, 22, 28),
(25, 22, 28),
(26, 22, 28),
(27, 22, 28),
(28, 22, 28),
(29, 22, 28),
(30, 22, 28),
(31, 22, 28),
(32, 22, 28),
(33, 22, 28),
(34, 22, 23),
(35, 22, 28),
(36, 22, 28),
(37, 22, 28),
(38, 22, 28),
(39, 22, 28),
(40, 22, 28),
(41, 22, 28),
(42, 22, 11),
(43, 22, 28),
(44, 22, 23),
(45, 22, 28),
(46, 22, 28),
(47, 22, 28),
(48, 22, 28),
(49, 22, 28),
(50, 22, 28),
(51, 22, 28),
(52, 22, 28),
(53, 22, 28),
(54, 22, 28),
(55, 22, 28),
(56, 22, 28),
(57, 22, 28),
(58, 22, 28),
(59, 22, 28),
(60, 22, 28),
(61, 22, 13),
(62, 22, 28),
(63, 22, 28),
(64, 10, 7),
(65, 10, 20),
(66, 10, 22),
(67, 10, 17),
(68, 10, 13),
(69, 10, 7),
(70, 10, 9),
(71, 10, 13),
(72, 10, 22),
(73, 10, 12),
(74, 10, 17),
(75, 10, 14),
(76, 10, 14),
(77, 10, 14),
(78, 10, 14),
(79, 10, 14),
(80, 10, 14),
(81, 10, 14),
(82, 10, 14),
(83, 10, 14),
(84, 10, 14),
(85, 10, 14),
(86, 10, 14),
(87, 10, 14),
(88, 10, 14),
(89, 10, 14),
(90, 10, 14),
(91, 10, 14),
(92, 10, 14),
(93, 10, 14),
(94, 10, 14),
(95, 10, 14),
(96, 10, 14),
(97, 10, 14),
(98, 10, 14),
(99, 10, 14),
(100, 10, 14),
(101, 10, 14),
(102, 10, 14),
(103, 10, 14),
(104, 10, 22),
(105, 10, 17),
(106, 10, 13),
(107, 10, 7),
(108, 10, 7),
(109, 10, 12),
(110, 22, 14),
(111, 22, 13),
(112, 22, 23),
(113, 22, 14),
(114, 22, 28),
(115, 22, 28),
(116, 22, 28),
(117, 22, 28),
(118, 16, 8),
(119, 16, 8),
(120, 16, 9),
(121, 16, 11),
(122, 10, 13),
(123, 10, 22),
(124, 10, 7),
(125, 10, 13),
(126, 10, 13),
(127, 10, 17),
(128, 10, 13),
(129, 10, 22),
(130, 10, 13),
(131, 10, 22),
(132, 10, 20),
(133, 10, 6),
(134, 10, 5),
(135, 21, 30),
(136, 21, 30),
(137, 23, 30),
(138, 23, 30),
(139, 23, 13),
(140, 23, 20),
(141, 23, 3),
(142, 23, 7),
(143, 23, 30),
(144, 23, 2),
(145, 23, 2),
(146, 23, 15),
(147, 23, 9),
(148, 23, 13),
(149, 23, 30),
(150, 23, 30),
(151, 23, 13),
(152, 23, 30),
(153, 23, 13),
(154, 23, 30),
(155, 23, 30),
(156, 23, 30),
(157, 23, 30),
(158, 23, 30),
(159, 23, 30),
(160, 23, 30),
(161, 23, 5),
(162, 23, 1),
(163, 23, 24),
(164, 23, 24),
(165, 23, 24),
(166, 23, 24),
(167, 23, 13),
(168, 23, 13),
(169, 23, 30),
(170, 23, 30),
(171, 23, 8),
(172, 23, 17),
(173, 18, 30),
(174, 18, 30),
(175, 18, 30),
(176, 18, 30),
(177, 18, 13),
(178, 18, 13),
(179, 18, 13),
(180, 18, 30),
(181, 18, 13),
(182, 18, 13),
(183, 18, 13),
(184, 18, 13),
(185, 18, 13),
(186, 18, 13),
(187, 18, 13),
(188, 18, 13),
(189, 18, 13),
(190, 18, 13),
(191, 18, 13),
(192, 18, 13),
(193, 18, 13),
(194, 18, 20),
(195, 18, 9),
(196, 23, 13),
(197, 18, 13),
(198, 18, 14),
(199, 18, 13),
(200, 18, 13),
(201, 18, 20),
(202, 18, 20),
(203, 23, 30),
(204, 23, 20),
(205, 23, 20),
(206, 23, 20),
(207, 23, 7),
(208, 18, 11),
(209, 18, 11),
(210, 18, 7),
(211, 18, 30),
(212, 18, 11),
(213, 18, 30),
(214, 18, 14),
(215, 18, 10),
(216, 18, 11),
(217, 18, 10),
(218, 18, 12),
(219, 18, 30),
(220, 18, 11),
(221, 18, 11),
(222, 23, 20),
(223, 23, 7),
(224, 23, 14),
(225, 23, 14),
(226, 23, 14),
(227, 23, 14),
(228, 23, 14),
(229, 23, 14),
(230, 23, 14),
(231, 23, 14),
(232, 23, 14),
(233, 23, 14),
(234, 23, 13),
(235, 23, 9),
(236, 23, 11),
(237, 23, 11),
(238, 23, 32),
(239, 23, 32),
(240, 23, 32),
(241, 23, 13),
(242, 23, 6),
(243, 23, 34),
(244, 23, 14),
(245, 23, 9),
(246, 23, 9),
(247, 23, 34),
(248, 23, 34),
(249, 23, 34),
(250, 23, 34),
(251, 23, 34),
(252, 23, 34),
(253, 23, 34),
(254, 23, 34),
(255, 23, 34),
(256, 23, 34),
(257, 23, 33),
(258, 23, 7),
(259, 23, 9),
(260, 23, 34),
(261, 23, 33),
(262, 23, 31),
(263, 23, 31),
(264, 23, 31),
(265, 23, 34),
(266, 23, 34),
(267, 23, 31),
(268, 23, 31),
(269, 23, 14),
(270, 23, 14),
(271, 23, 34),
(272, 23, 32),
(273, 23, 31),
(274, 23, 9),
(275, 23, 1),
(276, 23, 11),
(277, 23, 11),
(278, 23, 11),
(279, 23, 34),
(280, 23, 34),
(281, 23, 20),
(282, 23, 9),
(283, 18, 34),
(284, 18, 30),
(285, 18, 20),
(286, 18, 34),
(287, 18, 34),
(288, 18, 34),
(289, 18, 7),
(290, 18, 20),
(291, 18, 30),
(292, 18, 30),
(293, 18, 30),
(294, 18, 30),
(295, 18, 30),
(296, 18, 30),
(297, 18, 30),
(298, 18, 30),
(299, 18, 34),
(300, 18, 34),
(301, 18, 34),
(302, 18, 30),
(303, 18, 30),
(304, 18, 30),
(305, 18, 10),
(306, 18, 30),
(307, 18, 30),
(308, 18, 20),
(309, 18, 20),
(310, 18, 20),
(311, 18, 14),
(312, 18, 11),
(313, 18, 10),
(314, 18, 34),
(315, 18, 30),
(316, 18, 30),
(317, 18, 30),
(318, 18, 20),
(319, 18, 13),
(320, 18, 20),
(321, 18, 7),
(322, 18, 9),
(323, 18, 20),
(324, 18, 13),
(325, 18, 7),
(326, 18, 20),
(327, 18, 7),
(328, 18, 9),
(329, 18, 11),
(330, 18, 30),
(331, 18, 30),
(332, 24, 20),
(333, 24, 20),
(334, 24, 20),
(335, 24, 20),
(336, 24, 13),
(337, 18, 20),
(338, 24, 20),
(339, 24, 20),
(340, 18, 20),
(341, 18, 20),
(342, 18, 20),
(343, 24, 13),
(344, 24, 20),
(345, 24, 13),
(346, 24, 13),
(347, 24, 14),
(348, 24, 17),
(349, 18, 17),
(350, 18, 17),
(351, 18, 7),
(352, 18, 27),
(353, 18, 28),
(354, 18, 9),
(355, 18, 27),
(356, 18, 30),
(357, 18, 17),
(358, 18, 17),
(359, 18, 17),
(360, 18, 17),
(361, 18, 17),
(362, 18, 17),
(363, 18, 17),
(364, 18, 17),
(365, 18, 17),
(366, 18, 17),
(367, 18, 17),
(368, 18, 17),
(369, 18, 17),
(370, 18, 22),
(371, 18, 22),
(372, 18, 22),
(373, 18, 22),
(374, 18, 22),
(375, 18, 22);

-- --------------------------------------------------------

--
-- 表的结构 `marking`
--

DROP TABLE IF EXISTS `marking`;
CREATE TABLE IF NOT EXISTS `marking` (
  `auction_ID` int NOT NULL,
  `user_ID` int NOT NULL,
  `mark` int DEFAULT NULL,
  PRIMARY KEY (`auction_ID`,`user_ID`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `marking`
--

INSERT INTO `marking` (`auction_ID`, `user_ID`, `mark`) VALUES
(30, 18, 4),
(11, 18, 3),
(28, 22, 4);

-- --------------------------------------------------------

--
-- 表的结构 `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `transaction_ID` int NOT NULL AUTO_INCREMENT,
  `transaction_time` datetime NOT NULL,
  `transaction_amount` decimal(10,2) NOT NULL,
  `transaction_status` enum('Pending','Completed','Cancelled','Refunded') NOT NULL,
  `user_ID` int DEFAULT NULL,
  `payment_method` enum('Credit Card','Debit','PayPal','Bank Transfer') NOT NULL,
  PRIMARY KEY (`transaction_ID`),
  KEY `transaction_ibfk_1` (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `transaction`
--

INSERT INTO `transaction` (`transaction_ID`, `transaction_time`, `transaction_amount`, `transaction_status`, `user_ID`, `payment_method`) VALUES
(1, '2023-11-20 12:13:11', '110.00', 'Completed', 2, 'Credit Card'),
(2, '2023-11-20 14:13:11', '220.00', 'Pending', 3, 'PayPal'),
(3, '2023-11-21 12:00:00', '160.00', 'Completed', 1, 'Debit'),
(4, '2023-11-21 13:00:00', '550.00', 'Pending', 2, 'Bank Transfer');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_ID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('buyer','seller') NOT NULL,
  PRIMARY KEY (`user_ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_ID`, `username`, `password`, `phone_number`, `email`, `address`, `role`) VALUES
(1, 'john_doe', 'securepassword', '555-1010', 'john.doe@example.com', '123 Main St, Anytown', 'seller'),
(2, 'jane_smith', 'anotherpassword', '555-2020', 'jane.smith@example.com', '456 Oak St, Anytown', 'buyer'),
(3, 'alice_jones', 'mypassword123', '555-3030', 'alice.jones@example.com', '789 Pine St, Anytown', 'buyer'),
(4, 'bob_brown', 'password123', '555-4040', 'bob.brown@example.com', '1010 Willow St, Anytown', 'seller'),
(5, 'carol_white', 'pass456', '555-5050', 'carol.white@example.com', '1111 Maple St, Anytown', 'buyer'),
(6, 'alice_boom', 'password123', '123-456-7890', 'boom@example.com', '123 High St, City, Country', 'buyer'),
(7, 'johntest', '$2y$10$Uiprc1u9FmP8Ekpm71f6MuxnvM33KTdMv7.jH1aWJ8jJanlnvgWWy', NULL, 'johntest@example.com', NULL, 'buyer'),
(8, 'alicetest', '$2y$10$GStOpp9ZkrFu.cAQxPvn8ufgaGLI9zokXIQYCDv6wkM0S8sNm0Dwy', NULL, 'alicetest@example.com', NULL, 'seller'),
(9, 'ethantest', '$2y$10$E7cb7SLAmc41C7ECIR.HzOrR.ACJDEaW0Vv2.wgo/5twZjagqtj5i', NULL, 'ethantest@example.com', NULL, 'buyer'),
(10, 'testlogin', '$2y$10$9PNvO5SMnRaav0lUTAE.zemVX6/DdCE9DtJxFov5DXz4Wbi9hbTQ.', '', 'testlogin@example.com', 'ewdsadaw', 'seller'),
(11, 'Marrytes', '$2y$10$HmG.jz/S4wKsWn.fxTBguOk9XfNx4RSA.UNhGwI0p8BqoYggBVLc6', NULL, 'Marrytest@example.com', NULL, 'buyer'),
(12, 'Adam', 'newpassword', '555-6060', 'new.user@example.com', '789 Elm St, Anytown', 'buyer'),
(13, 'Henrrytest', '$2y$10$PamhbZ/kAt5kvkbxKn.I9OHiI4x6CxoHxtyFI0OzBK0bL68qsVlEe', NULL, 'Henrrytest@example.com', NULL, 'buyer'),
(14, 'guatest', '$2y$10$qmVfPOnRytoL10fh0jmJAuIZxsVEMvgvbxKIOsu10E.F2XPUp1BVO', NULL, 'guatest@example.com', NULL, 'buyer'),
(15, 'bobtest', '$2y$10$qHUBrh.pvynf7thxfDFSm.nEW6xBBMNazMsj/9DFEWwT6RtwyMKvO', NULL, 'bobtest@example.com', NULL, 'buyer'),
(16, 'ethan', '$2y$10$m3XMnu0bp3cN.IXlxYZ9DeEGTKBJz3K2q9WcbZmFljBSW15cEMDii', NULL, 'ethan@example.com', NULL, 'buyer'),
(17, 'guagua', '$2y$10$KCTsbUHnryYeLNOgTVWTx.TWCrOrAZcVdvs1Q0XVctnCWYyMX7f56', NULL, 'guagua@example.com', NULL, 'buyer'),
(18, 'testLinqing', '$2y$10$65KF8ScoXDJgjAoIOB4y5ek/zfRn1LCaa.HYUf7YkCCZPME1RHQRS', '', 'testLinqing@example.com', '', 'buyer'),
(19, 'testMelanie', '$2y$10$yAygEdyK37gl9Sc9Hr04gut1KCW2VEd.f5cLP/v2n7a3.7Y698ab2', NULL, 'testMelanie@example.com', NULL, 'buyer'),
(20, 'Aliwong', '$2y$10$WRIMS3TanxBHxjyQtv6nSOSJwW.CwhTdg5FsF7qIsMuesJNlafTWi', NULL, 'Aliwong@example.com', NULL, 'seller'),
(21, 'testLinqing', '$2y$10$TpZLvsDH3rSyShhj9XC5ouK7gb4.6oUopIeDZZkMXmmvxbPczSy7W', NULL, 'testLinqingg@example.com', NULL, 'buyer'),
(22, 'realreceiver', '$2y$10$s4twl/xkCwghdGjOU0WYE.3T70YnCk.Mp9XDZ9twghRhXPYDgf6.m', '123-123', '958375266@qq.com', 'ucl', 'buyer'),
(23, 'imsb', '$2y$10$KA3w/rQUOFCHymf8SRdhnOihvTIucCAkEu01QZBkg2X2.09mXIvYu', '15050125585', 'imsb@example.com', '', 'buyer'),
(24, 'testqinyi', '$2y$10$FN.nf4d10G6p5yz4ysz.2O3UdSGNXBy3TV3EcFWD1of0RlgUkKoY2', '1234563433', '1873904486@qq.com', 'this is adasasd', 'buyer');

-- --------------------------------------------------------

--
-- 表的结构 `watch`
--

DROP TABLE IF EXISTS `watch`;
CREATE TABLE IF NOT EXISTS `watch` (
  `user_ID` int NOT NULL,
  `auction_ID` int NOT NULL,
  PRIMARY KEY (`user_ID`,`auction_ID`),
  KEY `watch_ibfk_2` (`auction_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `watch`
--

INSERT INTO `watch` (`user_ID`, `auction_ID`) VALUES
(2, 1),
(3, 2),
(1, 3),
(2, 4),
(24, 13),
(24, 17),
(22, 23),
(23, 24),
(21, 30);

--
-- 限制导出的表
--

--
-- 限制表 `auction`
--
ALTER TABLE `auction`
  ADD CONSTRAINT `auction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`);

--
-- 限制表 `bid`
--
ALTER TABLE `bid`
  ADD CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`auction_ID`) REFERENCES `auction` (`auction_ID`),
  ADD CONSTRAINT `bid_ibfk_3` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`);

--
-- 限制表 `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`auction_ID`) REFERENCES `auction` (`auction_ID`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`);

--
-- 限制表 `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`);

--
-- 限制表 `watch`
--
ALTER TABLE `watch`
  ADD CONSTRAINT `watch_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`),
  ADD CONSTRAINT `watch_ibfk_2` FOREIGN KEY (`auction_ID`) REFERENCES `auction` (`auction_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
