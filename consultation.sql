-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022 年 5 月10 日 18:53
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `consultation`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `eiyousi_item`
--

CREATE TABLE `eiyousi_item` (
  `id` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `possible_date` datetime NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `self_pr` varchar(300) DEFAULT NULL,
  `del_flg` tinyint(11) DEFAULT 0 COMMENT '権限(0:表示 1:非表示)',
  `created_ad` datetime NOT NULL DEFAULT current_timestamp(),
  `update_ad` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `eiyousi_item`
--

INSERT INTO `eiyousi_item` (`id`, `e_id`, `possible_date`, `specialty`, `price`, `area`, `self_pr`, `del_flg`, `created_ad`, `update_ad`) VALUES
(72, 80, '2022-05-03 18:39:00', '筋トレしてる方向け', '1時間3000円', '東京都', '1か月で2kgの減量に成功', 0, '2022-05-15 18:39:59', '2022-05-15 18:39:59'),
(73, 80, '2022-05-01 18:40:00', '筋トレしてる方向け', '1時間3000円', '東京都', '', 1, '2022-05-15 18:40:43', '2022-05-15 18:40:43');

-- --------------------------------------------------------

--
-- テーブルの構造 `eiyousi_matter`
--

CREATE TABLE `eiyousi_matter` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `furigana` varchar(50) NOT NULL,
  `tell` varchar(20) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(80) DEFAULT NULL,
  `token_sent_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `roll` tinyint(11) DEFAULT 0,
  `created_ad` datetime DEFAULT current_timestamp(),
  `update_ad` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `eiyousi_matter`
--

INSERT INTO `eiyousi_matter` (`id`, `name`, `furigana`, `tell`, `mail`, `file_name`, `file_path`, `password`, `token`, `token_sent_at`, `roll`, `created_ad`, `update_ad`) VALUES
(80, 'てすと', 'テスト', '00000000000', 'test@test.com', 'test.png', '../images/test.png', '$2y$10$h.5K.zQd8T85K7bK/23QYuqh1Qbfe01KoMRMGXI4hNVfYoR3WUhr2', NULL, '2022-05-15 18:40:24', 0, '2022-05-12 00:13:48', '2022-05-15 18:40:24');

-- --------------------------------------------------------

--
-- テーブルの構造 `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `favorite`
--

INSERT INTO `favorite` (`id`, `user_id`, `post_id`) VALUES
(459, 56, 72);

-- --------------------------------------------------------

--
-- テーブルの構造 `request_matter`
--

CREATE TABLE `request_matter` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `furigana` varchar(50) NOT NULL,
  `tell` varchar(20) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(80) DEFAULT NULL,
  `token_sent_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `roll` tinyint(11) DEFAULT 1,
  `created_ad` datetime DEFAULT current_timestamp(),
  `update_ad` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `request_matter`
--

INSERT INTO `request_matter` (`id`, `name`, `furigana`, `tell`, `mail`, `file_name`, `file_path`, `password`, `token`, `token_sent_at`, `roll`, `created_ad`, `update_ad`) VALUES
(56, 'てすと', 'テスト', '00000000000', 'test@test.com', 'test.png', '../images/test.png', '$2y$10$DR1ZvBVLTx/D96esg5isDONUi3hwJ5FkyZX6V75yIU3iKBuC2fKfG', NULL, '2022-05-15 18:41:47', 1, '2022-05-12 00:10:58', '2022-05-15 18:41:47');

-- --------------------------------------------------------

--
-- テーブルの構造 `reserve`
--

CREATE TABLE `reserve` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `del_flg` tinyint(4) DEFAULT 0 COMMENT '権限(0:表示 1:非表示)	',
  `created_ad` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `reserve`
--

INSERT INTO `reserve` (`id`, `item_id`, `r_id`, `del_flg`, `created_ad`) VALUES
(109, 73, 56, 0, '2022-05-15 18:41:26');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `eiyousi_item`
--
ALTER TABLE `eiyousi_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eiyousi_item_ibfk_9` (`e_id`);

--
-- テーブルのインデックス `eiyousi_matter`
--
ALTER TABLE `eiyousi_matter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tell` (`tell`,`mail`);

--
-- テーブルのインデックス `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- テーブルのインデックス `request_matter`
--
ALTER TABLE `request_matter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tell` (`tell`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- テーブルのインデックス `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserve_ibfk_2` (`r_id`),
  ADD KEY `item_id` (`item_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `eiyousi_item`
--
ALTER TABLE `eiyousi_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- テーブルの AUTO_INCREMENT `eiyousi_matter`
--
ALTER TABLE `eiyousi_matter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- テーブルの AUTO_INCREMENT `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- テーブルの AUTO_INCREMENT `request_matter`
--
ALTER TABLE `request_matter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- テーブルの AUTO_INCREMENT `reserve`
--
ALTER TABLE `reserve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `eiyousi_item`
--
ALTER TABLE `eiyousi_item`
  ADD CONSTRAINT `eiyousi_item_ibfk_1` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_10` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_11` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_12` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_13` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_14` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_2` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_3` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_4` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_5` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_6` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_7` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_8` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eiyousi_item_ibfk_9` FOREIGN KEY (`e_id`) REFERENCES `eiyousi_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `request_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `eiyousi_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `reserve`
--
ALTER TABLE `reserve`
  ADD CONSTRAINT `reserve_ibfk_2` FOREIGN KEY (`r_id`) REFERENCES `request_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserve_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `eiyousi_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
