-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Kas 2020, 11:57:02
-- Sunucu sürümü: 10.4.8-MariaDB
-- PHP Sürümü: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `tuut.web`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(255) NOT NULL,
  `category_desc` varchar(255) NOT NULL,
  `category_url` varchar(255) NOT NULL,
  `category_view` int(11) NOT NULL,
  `category_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`, `category_desc`, `category_url`, `category_view`, `category_date`) VALUES
(1, 'Oyun', 'Oyun kategorisine ait tuut\'ların tamamı.', 'oyun', 0, '2020-04-14 14:21:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tuut_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `tuut_id`, `comment_text`, `comment_date`) VALUES
(1, 1, 1, 'Bunu annem bana hergün yapıyor.', '2020-05-14 20:11:31'),
(2, 1, 1, 'deneme', '2020-05-14 22:38:41'),
(3, 1, 1, 'dfsdf', '2020-05-14 22:41:50');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `comment_like_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `comment_likes`
--

INSERT INTO `comment_likes` (`comment_like_id`, `user_id`, `comment_id`, `comment_like_date`) VALUES
(3, 1, 1, '2020-05-18 15:57:01');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comment_unlikes`
--

CREATE TABLE `comment_unlikes` (
  `comment_unlike_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `comment_unlike_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `comment_unlikes`
--

INSERT INTO `comment_unlikes` (`comment_unlike_id`, `user_id`, `comment_id`, `comment_unlike_date`) VALUES
(2, 1, 3, '2020-05-18 15:57:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `follows`
--

CREATE TABLE `follows` (
  `user_id` int(11) NOT NULL,
  `follow_user_id` int(11) NOT NULL,
  `follow_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `follows`
--

INSERT INTO `follows` (`user_id`, `follow_user_id`, `follow_date`) VALUES
(1, 2, '2020-04-15 15:21:57');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tuut_id` int(11) NOT NULL,
  `like_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `tuut_id`, `like_date`) VALUES
(6, 1, 1, '2020-11-05 17:53:59');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` varchar(1000) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `pages`
--

INSERT INTO `pages` (`page_id`, `page_title`, `page_content`, `page_url`, `page_date`) VALUES
(1, 'İletişim', '&lt;p&gt;İletişim adreslerimiz;&lt;/p&gt;\r\n&lt;h2&gt;Telefon: &lt;strong&gt;&amp;nbsp;(0422) 212 73 91&lt;/strong&gt;&lt;/h2&gt;\r\n&lt;h2&gt;Mail: &lt;strong&gt;mail@nelerolduneler.com&lt;/strong&gt;&lt;/h2&gt;\r\n&lt;h2&gt;Reklam &amp;amp; Sponsorluk: &lt;strong&gt;reklam@izleyiciler.com&lt;/strong&gt;&lt;/h2&gt;', 'iletisim', '2020-04-15 15:28:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tuuts`
--

CREATE TABLE `tuuts` (
  `tuut_id` int(11) NOT NULL,
  `tuut_title` varchar(100) NOT NULL,
  `tuut_desc` varchar(300) NOT NULL,
  `tuut_img` varchar(255) NOT NULL,
  `tuut_url` varchar(255) NOT NULL,
  `tuut_view` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `tuut_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `tuuts`
--

INSERT INTO `tuuts` (`tuut_id`, `tuut_title`, `tuut_desc`, `tuut_img`, `tuut_url`, `tuut_view`, `user_id`, `category_id`, `tuut_date`) VALUES
(1, 'Günlük yaşantımın karantina olduğunu öğrendim.', '', 'ornek.jpg', 'aCgy1yU', 0, 1, 1, '2020-04-14 14:36:23'),
(2, 'Aynaya bakıyorum.', '', 'ornek2.jpg', 'aBgq1yN', 0, 1, 1, '2020-04-14 14:36:03'),
(3, '&#128540;', '', 'ornek3.jpg', 'cBsq1yY', 0, 1, 1, '2020-04-14 14:40:02'),
(5, '', '', 'pKty4w7uKl.jpg', 'pKty4w7uKl', 0, 1, 1, '2020-05-10 10:01:33'),
(6, 'deneme', 'deneme2', 'auZ0t5kPfA.jpg', 'auZ0t5kPfA', 0, 1, 1, '2020-05-10 10:01:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `unlikes`
--

CREATE TABLE `unlikes` (
  `unlike_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tuut_id` int(11) NOT NULL,
  `unlike_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_nick` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_img` varchar(255) NOT NULL,
  `user_url` varchar(255) NOT NULL,
  `user_rank` varchar(255) NOT NULL,
  `user_setting` varchar(255) NOT NULL,
  `user_activation` varchar(255) NOT NULL,
  `user_token` varchar(255) NOT NULL,
  `user_login_date` varchar(255) NOT NULL,
  `user_mail_date` varchar(255) NOT NULL,
  `user_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_nick`, `user_password`, `user_email`, `user_img`, `user_url`, `user_rank`, `user_setting`, `user_activation`, `user_token`, `user_login_date`, `user_mail_date`, `user_date`) VALUES
(1, 'Utku Kocaoğlu', 'karaoku', '$2y$10$Oe0pNeKMSVHp5z7cUCjyWeGtKoq1j0GZdyvSizuHV.ba5tfvc9yIK', 'kocaogluutku@gmail.com', 'author.png', 'karaoku', '1', '', '1', 'e2ee6f97cfffccfb2982580208c4768e', '2020-11-13 19:53:11', '2020-02-05 00:09:11', '2020-02-04 21:09:11'),
(2, 'Emrah Boz', 'kutgan', 'buk1999', 'utkuclashofclans@gmail.com', 'author2.jpg', 'kutgan', '', '', '1', '', '', '', '2020-04-15 15:00:21');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Tablo için indeksler `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_like_id`);

--
-- Tablo için indeksler `comment_unlikes`
--
ALTER TABLE `comment_unlikes`
  ADD PRIMARY KEY (`comment_unlike_id`);

--
-- Tablo için indeksler `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Tablo için indeksler `tuuts`
--
ALTER TABLE `tuuts`
  ADD PRIMARY KEY (`tuut_id`);

--
-- Tablo için indeksler `unlikes`
--
ALTER TABLE `unlikes`
  ADD PRIMARY KEY (`unlike_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `comment_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `comment_unlikes`
--
ALTER TABLE `comment_unlikes`
  MODIFY `comment_unlike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `tuuts`
--
ALTER TABLE `tuuts`
  MODIFY `tuut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `unlikes`
--
ALTER TABLE `unlikes`
  MODIFY `unlike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
