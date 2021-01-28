-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021-01-28 08:19:44
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `php_escape`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `chat` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `chats`
--

INSERT INTO `chats` (`id`, `thread_id`, `chat`, `user_id`, `time`) VALUES
(1, 1, 'testtesttest', 2, '2021-01-22 10:08:12'),
(2, 1, 'testtest', 1, '2021-01-22 10:09:15'),
(3, 1, 'testtest\r\n', 1, '2021-01-22 10:15:22'),
(4, 1, 'テストテストテスト', 1, '2021-01-27 06:29:37'),
(5, 1, 'testtest', 2, '2021-01-27 06:37:21'),
(6, 1, 'testtest', 1, '2021-01-27 06:59:39'),
(7, 1, 'testtest', 1, '2021-01-27 07:20:45');

-- --------------------------------------------------------

--
-- テーブルの構造 `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `contents` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `thr_status` int(11) NOT NULL DEFAULT '0' COMMENT '0:投稿可能 1:投稿不可',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `threads`
--

INSERT INTO `threads` (`id`, `title`, `contents`, `user_id`, `thr_status`, `created`) VALUES
(1, 'てすとタイトル1', 'testtesttest', 2, 0, '2021-01-22 10:08:03'),
(2, 'てすとタイトル2', 'aaaaaaaaaaaaaaaaaaaaa', 1, 1, '2021-01-22 10:09:43'),
(3, 'てすとタイトル2', 'testtesttest', 1, 0, '2021-01-27 06:29:17'),
(4, 'てすとタイトル３', 'テストテストテストテスト', 1, 0, '2021-01-27 06:30:14'),
(5, 'てすと', 'testtest', 2, 0, '2021-01-27 06:38:26'),
(6, 'てすとタイトル4', 'testtest', 1, 0, '2021-01-27 06:59:20'),
(7, 'testtest4', 'testtest', 1, 1, '2021-01-27 07:20:21');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '0.一般ユーザ 1.管理ユーザ',
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT '0:利用中　1:アカウントロック',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `user`, `name`, `mail`, `pass`, `address`, `role`, `user_status`, `created`, `updated`) VALUES
(1, 'takutaku', '土屋匠edt', 't.tsuchiya.carecon@gmail.com', 'takutaku', '北海道', 1, 0, '2021-01-22 09:59:57', NULL),
(2, 'test1', 'test1editedit', 'test1@gmail.com', 'testtest', '北海道', 0, 1, '2021-01-22 10:07:39', NULL),
(4, 'test2', 'test2', 'test2@gmail.com', 'testtest', '北海道', 0, 0, '2021-01-27 06:58:35', NULL),
(5, 'test3', 'test3', 'test3@gmail.com', 'testtest', '東京都', 0, 0, '2021-01-27 07:19:37', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
