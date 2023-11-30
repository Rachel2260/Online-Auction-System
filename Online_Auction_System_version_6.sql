-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:8889
-- 生成日期： 2023-11-29 23:22:20
-- 服务器版本： 5.7.39
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `Online_Auction_System`
--

-- --------------------------------------------------------

--
-- 表的结构 `Auction`
--

CREATE TABLE `Auction` (
  `auction_ID` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `end_time` datetime NOT NULL,
  `starting_price` decimal(10,2) NOT NULL,
  `reserve_price` decimal(10,2) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Auction`
--

INSERT INTO `Auction` (`auction_ID`, `item_name`, `description`, `category`, `end_time`, `starting_price`, `reserve_price`, `user_ID`) VALUES
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
(28, 'Designer Sunglasses', 'Fashionable designer sunglasses for a trendy look.', 'others', '2023-12-23 21:15:00', '70.00', '80.00', 16),
(29, 'Collectible Vinyl Records', 'A set of collectible vinyl records for music lovers.', 'others', '2023-12-24 14:30:00', '120.00', '150.00', 17);

-- --------------------------------------------------------

--
-- 表的结构 `Bid`
--

CREATE TABLE `Bid` (
  `bid_ID` int(11) NOT NULL,
  `bid_price` decimal(10,2) NOT NULL,
  `time_of_bid` datetime NOT NULL,
  `auction_ID` int(11) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Bid`
--

INSERT INTO `Bid` (`bid_ID`, `bid_price`, `time_of_bid`, `auction_ID`, `user_ID`) VALUES
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
(25, '110.00', '2023-11-29 08:07:14', 11, 22),
(26, '120.00', '2023-11-29 08:10:09', 11, 22),
(27, '130.00', '2023-11-29 08:10:58', 11, 18);

-- --------------------------------------------------------

--
-- 表的结构 `History`
--

CREATE TABLE `History` (
  `history_ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `auction_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `Transaction`
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
-- 转存表中的数据 `Transaction`
--

INSERT INTO `Transaction` (`transaction_ID`, `transaction_time`, `transaction_amount`, `transaction_status`, `user_ID`, `payment_method`) VALUES
(1, '2023-11-20 12:13:11', '110.00', 'Completed', 2, 'Credit Card'),
(2, '2023-11-20 14:13:11', '220.00', 'Pending', 3, 'PayPal'),
(3, '2023-11-21 12:00:00', '160.00', 'Completed', 1, 'Debit'),
(4, '2023-11-21 13:00:00', '550.00', 'Pending', 2, 'Bank Transfer');

-- --------------------------------------------------------

--
-- 表的结构 `User`
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
-- 转存表中的数据 `User`
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
(12, 'Adam', 'newpassword', '555-6060', 'new.user@example.com', '789 Elm St, Anytown', 'buyer'),
(13, 'Henrrytest', '$2y$10$PamhbZ/kAt5kvkbxKn.I9OHiI4x6CxoHxtyFI0OzBK0bL68qsVlEe', NULL, 'Henrrytest@example.com', NULL, 'buyer'),
(14, 'guatest', '$2y$10$qmVfPOnRytoL10fh0jmJAuIZxsVEMvgvbxKIOsu10E.F2XPUp1BVO', NULL, 'guatest@example.com', NULL, 'buyer'),
(15, 'bobtest', '$2y$10$qHUBrh.pvynf7thxfDFSm.nEW6xBBMNazMsj/9DFEWwT6RtwyMKvO', NULL, 'bobtest@example.com', NULL, 'buyer'),
(16, 'ethan', '$2y$10$m3XMnu0bp3cN.IXlxYZ9DeEGTKBJz3K2q9WcbZmFljBSW15cEMDii', NULL, 'ethan@example.com', NULL, 'buyer'),
(17, 'guagua', '$2y$10$KCTsbUHnryYeLNOgTVWTx.TWCrOrAZcVdvs1Q0XVctnCWYyMX7f56', NULL, 'guagua@example.com', NULL, 'buyer'),
(18, 'testLinqing', '$2y$10$65KF8ScoXDJgjAoIOB4y5ek/zfRn1LCaa.HYUf7YkCCZPME1RHQRS', NULL, 'testLinqing@example.com', NULL, 'buyer'),
(19, 'testMelanie', '$2y$10$yAygEdyK37gl9Sc9Hr04gut1KCW2VEd.f5cLP/v2n7a3.7Y698ab2', NULL, 'testMelanie@example.com', NULL, 'buyer'),
(20, 'Aliwong', '$2y$10$WRIMS3TanxBHxjyQtv6nSOSJwW.CwhTdg5FsF7qIsMuesJNlafTWi', NULL, 'Aliwong@example.com', NULL, 'seller'),
(21, 'testLinqing', '$2y$10$TpZLvsDH3rSyShhj9XC5ouK7gb4.6oUopIeDZZkMXmmvxbPczSy7W', NULL, 'testLinqingg@example.com', NULL, 'buyer'),
(22, 'realreceiver', '$2y$10$s4twl/xkCwghdGjOU0WYE.3T70YnCk.Mp9XDZ9twghRhXPYDgf6.m', NULL, '958375266@qq.com', NULL, 'buyer');

-- --------------------------------------------------------

--
-- 表的结构 `watch`
--

CREATE TABLE `watch` (
  `user_ID` int(11) NOT NULL,
  `auction_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `watch`
--

INSERT INTO `watch` (`user_ID`, `auction_ID`) VALUES
(2, 1),
(3, 2),
(1, 3),
(2, 4);

--
-- 转储表的索引
--

--
-- 表的索引 `Auction`
--
ALTER TABLE `Auction`
  ADD PRIMARY KEY (`auction_ID`),
  ADD KEY `auction_ibfk_1` (`user_ID`);

--
-- 表的索引 `Bid`
--
ALTER TABLE `Bid`
  ADD PRIMARY KEY (`bid_ID`),
  ADD KEY `bid_ibfk_1` (`auction_ID`),
  ADD KEY `bid_ibfk_3` (`user_ID`);

--
-- 表的索引 `History`
--
ALTER TABLE `History`
  ADD PRIMARY KEY (`history_ID`),
  ADD KEY `auction_ID` (`auction_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- 表的索引 `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `transaction_ibfk_1` (`user_ID`);

--
-- 表的索引 `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 表的索引 `watch`
--
ALTER TABLE `watch`
  ADD PRIMARY KEY (`user_ID`,`auction_ID`),
  ADD KEY `watch_ibfk_2` (`auction_ID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `Auction`
--
ALTER TABLE `Auction`
  MODIFY `auction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- 使用表AUTO_INCREMENT `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bid_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `History`
--
ALTER TABLE `History`
  MODIFY `history_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `User`
--
ALTER TABLE `User`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 限制导出的表
--

--
-- 限制表 `Auction`
--
ALTER TABLE `Auction`
  ADD CONSTRAINT `auction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- 限制表 `Bid`
--
ALTER TABLE `Bid`
  ADD CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`auction_ID`) REFERENCES `Auction` (`auction_ID`),
  ADD CONSTRAINT `bid_ibfk_3` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- 限制表 `History`
--
ALTER TABLE `History`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`auction_ID`) REFERENCES `Auction` (`auction_ID`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- 限制表 `Transaction`
--
ALTER TABLE `Transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`);

--
-- 限制表 `watch`
--
ALTER TABLE `watch`
  ADD CONSTRAINT `watch_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `User` (`user_ID`),
  ADD CONSTRAINT `watch_ibfk_2` FOREIGN KEY (`auction_ID`) REFERENCES `Auction` (`auction_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
