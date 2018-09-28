-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2018 at 11:22 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` longtext NOT NULL,
  `articleStatus` tinyint(4) NOT NULL COMMENT '1 means published. 2 means in review. 3 means draft',
  `addedBy` int(11) NOT NULL COMMENT 'the id of the user who added the article',
  `publish_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `body`, `articleStatus`, `addedBy`, `publish_date`) VALUES
(1, 'Abdo Blog 0.1 Released!', 'Hello bloggers!\r\nI''m very happy to inform you that abdo blog 0.1 is now ready.\r\n\r\nnow this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum now this is lorem ipsum ', 1, 2, '2018-09-17 14:39:51'),
(3, 'LOL!', 'LEAGUE OF LEGENDS?', 1, 1, '2018-09-17 14:45:35'),
(4, 'BABABABABABABA', 'goaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaal', 2, 1, '2018-09-17 14:46:41'),
(5, 'new to new?', 'k is k', 1, 1, '2018-09-20 23:08:32'),
(6, 'Hello!', '<h1>HEEEEEE</h1>\r\n<p>No</p>', 1, 1, '2018-09-21 21:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `addedBy` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `commentStatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 means published. 2 means in review.',
  `publish_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `addedBy`, `comment`, `commentStatus`, `publish_date`) VALUES
(1, 3, 1, 'Hello, This is a comment(actually the first here).', 1, '2018-09-17 14:48:18'),
(2, 4, 4, 'VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT VERY LONG COMMENT ', 2, '2018-09-17 14:49:55'),
(6, 3, 3, 'elmagic2''s comment: Edit: Hello!', 1, '2018-09-17 15:28:07'),
(7, 5, 1, 'HIIIIIIIIIII!', 1, '2018-09-21 21:20:42'),
(8, 5, 1, 'HIIIIIIIIIII!', 1, '2018-09-21 21:20:47'),
(9, 5, 1, 'no?', 1, '2018-09-21 21:21:15'),
(10, 5, 1, 'no?', 1, '2018-09-21 21:21:15'),
(11, 5, 1, 'comment', 1, '2018-09-21 21:21:23'),
(12, 5, 1, 'so?', 1, '2018-09-21 21:22:37'),
(13, 5, 1, 'bla bla bla test', 1, '2018-09-21 21:22:49'),
(14, 1, 1, 'RESR', 1, '2018-09-21 21:26:30'),
(15, 1, 1, 'Nice work', 1, '2018-09-21 22:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userStatus` tinyint(4) NOT NULL DEFAULT '1',
  `userPermission` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1 for admins. 2 for mods. 3 for authors'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `userStatus`, `userPermission`) VALUES
(1, 'elmagicabdulah', '3e118bb9c1e25703f00720c47a7f387a19aca6c3', 'elmagic@me.com', 1, 1),
(2, 'elmagic1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'elmagic1@g.c', 1, 2),
(3, 'elmagic2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dd@dd', 0, 3),
(4, 'elmagic3', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'aaaaaaaaaaaaaaa', 1, 1),
(5, 'elmagic4', '3e118bb9c1e25703f00720c47a7f387a19aca6c3', 'elmagic4@me.com', 1, 3),
(6, 'elmagic5', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'elmagic5@gmail.com', 1, 3),
(7, 'elmagic6', '8cb2237d0679ca88db6464eac60da96345513964', 'elmagic6@yahoo.net', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`), ADD KEY `addedBy` (`addedBy`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`), ADD KEY `fk_addedBy_comments` (`addedBy`), ADD KEY `fk_post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
ADD CONSTRAINT `fk_addedBy_articles` FOREIGN KEY (`addedBy`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `fk_addedBy_comments` FOREIGN KEY (`addedBy`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
