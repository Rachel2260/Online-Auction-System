-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2023-11-30 10:52:58
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
  PRIMARY KEY (`auction_ID`),
  KEY `auction_ibfk_1` (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `auction`
--

INSERT INTO `auction` (`auction_ID`, `item_name`, `description`, `category`, `end_time`, `starting_price`, `reserve_price`, `user_ID`) VALUES
(1, 'Vintage Clock', 'An old vintage clock from the 1930s.', 'Antiques', '2023-11-27 12:09:09', '100.00', '150.00', 1),
(2, 'Modern Art Painting', 'Abstract modern art piece by a local artist.', 'Art', '2023-11-25 12:09:09', '200.00', '300.00', 1),
(3, 'Antique Chair', 'A wooden chair from the 18th century.', 'others', '2023-11-28 10:00:00', '150.00', '200.00', 2),
(4, 'Diamond Ring', 'Elegant diamond ring.', 'Jewelry', '2023-11-28 11:00:00', '500.00', '700.00', 3),
(5, 'Antique Vase', 'An ancient vase from the 18th century.', 'Antiques', '2023-11-25 08:00:00', '150.00', '200.00', 8),
(6, 'Abstract Art Sculpture', 'Unique abstract art sculpture by a renowned artist.', 'Art', '2023-11-26 10:30:00', '200.00', '300.00', 9),
(7, 'Rare First Edition Book', 'A first edition of a classic novel.', 'others', '2023-11-27 15:45:00', '50.00', '70.00', 10),
(8, 'Vintage Leather Jacket', 'Stylish vintage leather jacket from the 1980s.', 'others', '2023-11-28 18:20:00', '90.00', '120.00', 11),
(9, 'Collectible Action Figures Set', 'Limited edition collectible action figures set.', 'others', '2023-11-29 22:00:00', '40.00', '60.00', 12),
(10, 'Vintage Painting', 'A classic painting from the 19th century.', 'Art', '2023-12-01 15:30:00', '200.00', '250.00', 8),
(11, 'Rare Book Collection', 'A collection of rare and antique books.', 'others', '2023-12-02 12:45:00', '50.00', '60.00', 9),
(12, 'Fashionable Hat', 'Stylish hat from a popular designer brand.', 'others', '2023-12-03 18:00:00', '80.00', '100.00', 10),
(13, 'Limited Edition Collectible Toy', 'Exclusive collectible toy with unique features.', 'others', '2023-12-04 21:15:00', '30.00', '40.00', 11),
(14, 'Vintage Vinyl Records Set', 'A set of classic vinyl records from the 1970s.', 'others', '2023-12-05 14:30:00', '70.00', '80.00', 12),
(15, 'Antique Desk', 'A beautifully crafted antique desk.', 'others', '2023-12-06 12:30:00', '150.00', '200.00', 8),
(16, 'Contemporary Art Installation', 'A modern art installation by a rising artist.', 'Art', '2023-12-07 14:45:00', '250.00', '300.00', 9),
(17, 'Rare Book Set', 'A complete set of rare and valuable books.', 'others', '2023-12-08 17:00:00', '80.00', '100.00', 10),
(18, 'Designer Handbag', 'Fashionable designer handbag with exquisite details.', 'others', '2023-12-09 19:15:00', '120.00', '150.00', 11),
(19, 'Limited Edition Watch', 'Exclusive limited edition watch with unique features.', 'others', '2023-12-10 21:30:00', '180.00', '200.00', 12),
(20, 'Vintage Teapot Set', 'A charming teapot set from the early 20th century.', 'Antiques', '2023-12-15 16:30:00', '50.00', '70.00', 8),
(21, 'Abstract Canvas Painting', 'Unique abstract canvas painting by a contemporary artist.', 'Art', '2023-12-16 18:45:00', '100.00', '120.00', 9),
(22, 'Rare First Edition Novels', 'A collection of first edition novels from renowned authors.', 'others', '2023-12-17 20:00:00', '80.00', '100.00', 10),
(23, 'Fashionable Scarf', 'Stylish scarf with intricate patterns.', 'others', '2023-12-18 21:15:00', '30.00', '40.00', 11),
(24, 'Vintage Vinyl Record Player', 'Classic vintage vinyl record player in excellent condition.', 'Electronics', '2023-12-19 22:30:00', '150.00', '180.00', 12),
(25, 'Vintage Dining Table Set', 'A complete vintage dining table set for your home.', 'others', '2023-12-20 15:30:00', '200.00', '250.00', 13),
(26, 'Impressionist Artwork', 'An exquisite impressionist artwork to enhance your art collection.', 'Art', '2023-12-21 12:45:00', '180.00', '200.00', 14),
(27, 'Rare Book Collection II', 'Another set of rare and valuable books for book enthusiasts.', 'others', '2023-12-22 18:00:00', '90.00', '100.00', 15),
(28, 'Designer Sunglasses', 'Fashionable designer sunglasses for a trendy look.', 'others', '2023-11-28 21:15:00', '70.00', '80.00', 16),
(29, 'Collectible Vinyl Records', 'A set of collectible vinyl records for music lovers.', 'others', '2023-12-24 14:30:00', '120.00', '150.00', 17);

--
-- 限制导出的表
--

--
-- 限制表 `auction`
--
ALTER TABLE `auction`
  ADD CONSTRAINT `auction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
