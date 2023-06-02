-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2023 at 01:04 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vodsite_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
('C00001', 'action'),
('C00002', 'adventure'),
('C00003', 'comedy'),
('C00004', 'suspense');

-- --------------------------------------------------------

--
-- Table structure for table `confirmation`
--

CREATE TABLE `confirmation` (
  `id` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date_created` date NOT NULL,
  `date_confirmed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `confirmation`
--

INSERT INTO `confirmation` (`id`, `username`, `email`, `password`, `code`, `date_created`, `date_confirmed`) VALUES
('CO00001', 'vinshent', 'vinshentwianata@gmail.com', 'a', 'GH9O0pfJZjuroTpWz69C9', '2023-05-15', '2023-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `dtrans`
--

CREATE TABLE `dtrans` (
  `id` varchar(8) NOT NULL,
  `htrans` varchar(6) NOT NULL,
  `subscription_model_id` varchar(6) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dtrans`
--

INSERT INTO `dtrans` (`id`, `htrans`, `subscription_model_id`, `qty`, `subtotal`) VALUES
('D0000001', 'H00001', 'M00002', 1, 399999),
('D0000002', 'H00002', 'M00001', 1, 59999),
('D0000003', 'H00003', 'M00001', 1, 59999),
('D0000004', 'H00004', 'M00002', 1, 399999),
('D0000005', 'H00005', 'M00002', 1, 399999),
('D0000006', 'H00006', 'M00002', 1, 399999),
('D0000007', 'H00007', 'M00002', 1, 399999),
('D0000008', 'H00008', 'M00002', 1, 399999),
('D0000009', 'H00009', 'M00002', 1, 399999),
('D0000010', 'H00010', 'M00002', 1, 399999),
('D0000011', 'H00011', 'M00002', 1, 399999),
('D0000012', 'H00012', 'M00002', 1, 399999),
('D0000013', 'H00013', 'M00002', 1, 399999),
('D0000014', 'H00014', 'M00002', 1, 399999),
('D0000015', 'H00015', 'M00002', 1, 399999),
('D0000016', 'H00016', 'M00002', 1, 399999),
('D0000017', 'H00017', 'M00002', 1, 399999),
('D0000018', 'H00018', 'M00002', 1, 399999),
('D0000019', 'H00019', 'M00002', 1, 399999),
('D0000020', 'H00020', 'M00002', 1, 399999),
('D0000021', 'H00021', 'M00002', 1, 399999),
('D0000022', 'H00022', 'M00002', 1, 399999),
('D0000023', 'H00023', 'M00002', 1, 399999),
('D0000024', 'H00024', 'M00002', 1, 399999),
('D0000025', 'H00025', 'M00002', 1, 399999),
('D0000026', 'H00026', 'M00002', 1, 399999),
('D0000027', 'H00027', 'M00002', 1, 399999),
('D0000028', 'H00028', 'M00002', 1, 399999),
('D0000029', 'H00029', 'M00002', 1, 399999),
('D0000030', 'H00030', 'M00002', 1, 399999),
('D0000031', 'H00031', 'M00002', 1, 399999),
('D0000032', 'H00032', 'M00002', 1, 399999),
('D0000033', 'H00033', 'M00002', 1, 399999),
('D0000034', 'H00034', 'M00002', 1, 399999),
('D0000035', 'H00035', 'M00002', 1, 399999),
('D0000036', 'H00036', 'M00002', 1, 399999),
('D0000037', 'H00037', 'M00002', 1, 399999),
('D0000038', 'H00038', 'M00002', 1, 399999),
('D0000039', 'H00039', 'M00002', 1, 399999),
('D0000040', 'H00040', 'M00002', 1, 399999),
('D0000041', 'H00041', 'M00002', 1, 399999),
('D0000042', 'H00042', 'M00002', 1, 399999),
('D0000043', 'H00043', 'M00002', 1, 399999),
('D0000044', 'H00044', 'M00002', 1, 399999),
('D0000045', 'H00045', 'M00002', 1, 399999),
('D0000046', 'H00046', 'M00002', 1, 399999),
('D0000047', 'H00047', 'M00002', 1, 399999),
('D0000048', 'H00048', 'M00002', 1, 399999),
('D0000049', 'H00049', 'M00002', 1, 399999),
('D0000050', 'H00050', 'M00002', 1, 399999),
('D0000051', 'H00051', 'M00002', 1, 399999),
('D0000052', 'H00052', 'M00002', 1, 399999),
('D0000053', 'H00053', 'M00002', 1, 399999),
('D0000054', 'H00054', 'M00002', 1, 399999),
('D0000055', 'H00055', 'M00002', 1, 399999),
('D0000056', 'H00056', 'M00002', 1, 399999),
('D0000057', 'H00057', 'M00001', 1, 59999),
('D0000058', 'H00058', 'M00001', 1, 59999),
('D0000059', 'H00059', 'M00001', 1, 59999);

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` varchar(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `age_rating` varchar(5) NOT NULL,
  `release_date` date NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `imdb` varchar(255) NOT NULL,
  `score` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `title`, `description`, `age_rating`, `release_date`, `link`, `thumbnail`, `imdb`, `score`) VALUES
('F00001', 'John Wick: Chapter 4', 'With the price on his head ever increasing, John Wick uncovers a path to defeating The High Table. But before he can earn his freedom, Wick must face off against a new enemy with powerful alliances across the globe and forces that turn old friends into foes.', 'R', '2023-03-22', 'movies/F00004/xk1VEq-dZd0nA1hBEDi-b.m3u8', 'thumbnail/johnwick.jpg', 'https://www.imdb.com/title/tt10366206', 0),
('F00002', 'All Quiet on the Western Front', 'Paul Baumer and his friends Albert and Muller, egged on by romantic dreams of heroism, voluntarily enlist in the German army. Full of excitement and patriotic fervour, the boys enthusiastically march into a war they believe in. But once on the Western Front, they discover the soul-destroying horror of World War I.', 'R', '2022-10-07', 'movies/F00004/xk1VEq-dZd0nA1hBEDi-b.m3u8', 'thumbnail/allquiet.jpg', 'https://www.imdb.com/title/tt1016150', 0),
('F00003', 'Inside', 'An art thief becomes trapped in a New York penthouse after his heist goes awry. Imprisoned with nothing but priceless works of art, he must use all his cunning and invention to survive.', 'R', '2023-03-09', 'movies/F00004/xk1VEq-dZd0nA1hBEDi-b.m3u8', 'thumbnail/VNsVa2EgXtUMOdprqGZcA.png', 'https://www.imdb.com/title/tt14781036', 0),
('F00004', 'La La Land', 'Mia, an aspiring actress, serves lattes to movie stars in between auditions and Sebastian, a jazz musician, scrapes by playing cocktail party gigs in dingy bars, but as success mounts they are faced with decisions that begin to fray the fragile fabric of their love affair, and the dreams they worked so hard to maintain in each other threaten to rip them apart.', 'PG-13', '2016-11-29', 'movies/F00004/xk1VEq-dZd0nA1hBEDi-b.m3u8', 'thumbnail/j1xsw0an6OcFMl2wJmt8A.png', 'https://www.imdb.com/title/tt3783958', 0),
('F00005', 'Old Boy', 'With no clue how he came to be imprisoned, drugged and tortured for 15 years, a desperate businessman seeks revenge on his captors.', 'R', '2003-11-21', 'movies/F00004/xk1VEq-dZd0nA1hBEDi-b.m3u8', 'thumbnail/oldboy.jpg', 'https://www.imdb.com/title/tt0364569/', 0),
('F00006', 'Portrait of a Lady on Fire', 'On an isolated island in Brittany at the end of the eighteenth century, a female painter is obliged to paint a wedding portrait of a young woman.', 'R', '2019-06-17', 'movies/F00004/xk1VEq-dZd0nA1hBEDi-b.m3u8', 'thumbnail/nnAHjjYKKNKKhvL2NVocR.jpg', 'https://www.imdb.com/title/tt8613070', 8.182),
('F00007', 'Eternal Sunshine of the Spotless Mind', 'Joel Barish, heartbroken that his girlfriend underwent a procedure to erase him from her memory, decides to do the same. However, as he watches his memories of her fade away, he realises that he still loves her, and may be too late to correct his mistake.', 'R', '2004-03-19', 'movies/F00007/0vdvSUrD7VWIXJpCrUANl.m3u8', 'thumbnail/SncmR2gmQ2wQLr7OKp-EY.jpg', 'https://www.imdb.com/title/tt0338013', 8.1),
('F00008', 'Aftersun', 'Summertime. In a camping, three little girls listen to an old mysterious story about a missing kid. They start to investigate.', 'Age R', '2022-05-01', 'movies/F00008/uxHOBlTcLB_3Xgctydzjj.m3u8', 'thumbnail/lI87Y1T7fciGGzWzgcDCc.jpg', 'https://www.imdb.com/title/tt19512922', 2);

-- --------------------------------------------------------

--
-- Table structure for table `film_category`
--

CREATE TABLE `film_category` (
  `id` varchar(8) NOT NULL,
  `category` varchar(6) NOT NULL,
  `film` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `film_category`
--

INSERT INTO `film_category` (`id`, `category`, `film`) VALUES
('C0000001', 'C00001', 'F00001'),
('C0000002', 'C00001', 'F00002'),
('C0000003', 'C00002', 'F00002'),
('C0000004', 'C00004', 'F00004'),
('C0000005', 'C00001', 'F00005'),
('C0000006', 'C00004', 'F00005');

-- --------------------------------------------------------

--
-- Table structure for table `history_user`
--

CREATE TABLE `history_user` (
  `id` varchar(8) NOT NULL,
  `user` varchar(6) NOT NULL,
  `film` varchar(6) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `watched` int(11) NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_user`
--

INSERT INTO `history_user` (`id`, `user`, `film`, `timestamp`, `watched`, `last_updated`) VALUES
('H0000001', 'U00001', 'F00001', 0, 1, '2023-05-07 00:00:00'),
('H0000002', 'U00001', 'F00002', 0, 0, '2023-04-30 00:00:00'),
('H0000003', 'U00002', 'F00001', 36, 0, '2023-05-08 00:00:00'),
('H0000004', 'U00002', 'F00002', 72, 0, '2023-05-09 00:00:00'),
('H0000005', 'U00001', 'F00004', 229, 0, '2023-05-12 00:00:00'),
('H0000006', 'U00002', 'F00005', 132, 0, '2023-05-27 18:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `htrans`
--

CREATE TABLE `htrans` (
  `id` varchar(6) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `total_cost` int(11) NOT NULL,
  `user` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `htrans`
--

INSERT INTO `htrans` (`id`, `purchase_date`, `total_cost`, `user`) VALUES
('H00001', '2023-05-23 12:02:03', 399999, 'U00004'),
('H00002', '2023-05-23 14:50:24', 59999, 'U00001'),
('H00003', '2023-05-25 19:24:59', 59999, 'U00002'),
('H00004', '2023-05-26 16:53:06', 399999, 'U00002'),
('H00005', '2023-05-26 16:53:22', 399999, 'U00002'),
('H00006', '2023-05-26 16:55:01', 399999, 'U00002'),
('H00007', '2023-05-26 16:57:07', 399999, 'U00002'),
('H00008', '2023-05-26 16:57:45', 399999, 'U00002'),
('H00009', '2023-05-26 16:57:55', 399999, 'U00002'),
('H00010', '2023-05-26 16:58:24', 399999, 'U00002'),
('H00011', '2023-05-26 16:58:29', 399999, 'U00002'),
('H00012', '2023-05-26 16:58:34', 399999, 'U00002'),
('H00013', '2023-05-26 16:58:59', 399999, 'U00002'),
('H00014', '2023-05-26 16:59:38', 399999, 'U00002'),
('H00015', '2023-05-26 16:59:45', 399999, 'U00002'),
('H00016', '2023-05-26 17:00:01', 399999, 'U00002'),
('H00017', '2023-05-26 17:00:15', 399999, 'U00002'),
('H00018', '2023-05-26 17:00:30', 399999, 'U00002'),
('H00019', '2023-05-26 17:00:35', 399999, 'U00002'),
('H00020', '2023-05-26 17:01:33', 399999, 'U00002'),
('H00021', '2023-05-26 17:01:45', 399999, 'U00002'),
('H00022', '2023-05-26 17:02:02', 399999, 'U00002'),
('H00023', '2023-05-26 17:02:10', 399999, 'U00002'),
('H00024', '2023-05-26 17:02:14', 399999, 'U00002'),
('H00025', '2023-05-26 17:02:25', 399999, 'U00002'),
('H00026', '2023-05-26 17:02:30', 399999, 'U00002'),
('H00027', '2023-05-26 17:02:40', 399999, 'U00002'),
('H00028', '2023-05-26 17:12:44', 399999, 'U00002'),
('H00029', '2023-05-26 17:13:07', 399999, 'U00002'),
('H00030', '2023-05-26 17:13:13', 399999, 'U00002'),
('H00031', '2023-05-26 17:13:15', 399999, 'U00002'),
('H00032', '2023-05-26 17:13:44', 399999, 'U00002'),
('H00033', '2023-05-26 17:14:01', 399999, 'U00002'),
('H00034', '2023-05-26 17:14:09', 399999, 'U00002'),
('H00035', '2023-05-26 17:15:05', 399999, 'U00002'),
('H00036', '2023-05-26 17:15:22', 399999, 'U00002'),
('H00037', '2023-05-26 17:15:26', 399999, 'U00002'),
('H00038', '2023-05-26 17:17:11', 399999, 'U00002'),
('H00039', '2023-05-26 17:17:21', 399999, 'U00002'),
('H00040', '2023-05-26 17:17:52', 399999, 'U00002'),
('H00041', '2023-05-26 17:18:07', 399999, 'U00002'),
('H00042', '2023-05-26 17:18:12', 399999, 'U00002'),
('H00043', '2023-05-26 17:18:37', 399999, 'U00002'),
('H00044', '2023-05-26 17:18:55', 399999, 'U00002'),
('H00045', '2023-05-26 17:18:58', 399999, 'U00002'),
('H00046', '2023-05-26 17:19:05', 399999, 'U00002'),
('H00047', '2023-05-26 17:19:20', 399999, 'U00002'),
('H00048', '2023-05-26 17:19:37', 399999, 'U00002'),
('H00049', '2023-05-26 17:19:42', 399999, 'U00002'),
('H00050', '2023-05-26 17:20:19', 399999, 'U00002'),
('H00051', '2023-05-26 17:21:11', 399999, 'U00002'),
('H00052', '2023-05-26 17:21:15', 399999, 'U00002'),
('H00053', '2023-05-26 17:21:33', 399999, 'U00002'),
('H00054', '2023-05-26 17:21:39', 399999, 'U00002'),
('H00055', '2023-05-26 17:22:49', 399999, 'U00002'),
('H00056', '2023-05-26 17:24:05', 399999, 'U00002'),
('H00057', '2023-05-26 17:38:42', 59999, 'U00002'),
('H00058', '2023-05-26 17:40:54', 59999, 'U00002'),
('H00059', '2023-05-26 17:41:28', 59999, 'U00002');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tier` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `name`, `description`, `tier`, `status`) VALUES
('L00001', 'Cool and New', 'The newests from our service', 1, 1),
('L00002', 'Interesting', 'owo whats this', 3, 1),
('L00003', 'lmao watch this', 'heheheheheh', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lists_member`
--

CREATE TABLE `lists_member` (
  `id` varchar(12) NOT NULL,
  `lists_id` varchar(6) NOT NULL,
  `film_id` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lists_member`
--

INSERT INTO `lists_member` (`id`, `lists_id`, `film_id`) VALUES
('LM0000000001', 'L00001', 'F00001'),
('LM0000000002', 'L00001', 'F00002'),
('LM0000000003', 'L00001', 'F00004'),
('LM0000000004', 'F00003', 'L00001'),
('LM0000000005', 'F00003', 'L00001'),
('LM0000000006', 'F00003', 'L00001'),
('LM0000000007', 'F00003', 'L00001'),
('LM0000000008', 'F00003', 'L00001'),
('LM0000000009', 'F00003', 'L00001'),
('LM0000000010', 'F00003', 'L00001'),
('LM0000000011', 'F00003', 'L00001'),
('LM0000000012', 'F00003', 'L00001'),
('LM0000000013', 'F00003', 'L00001'),
('LM0000000014', 'L00001', 'F00003'),
('LM0000000015', 'L00002', 'F00001');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` varchar(8) NOT NULL,
  `user` varchar(6) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `id` varchar(8) NOT NULL,
  `user` varchar(6) NOT NULL,
  `film` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recommendation`
--

INSERT INTO `recommendation` (`id`, `user`, `film`) VALUES
('R0000001', 'U00004', 'F00001'),
('R0000002', 'U00004', 'F00002'),
('R0000003', 'U00004', 'F00005'),
('R0000004', 'U00002', 'F00005');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_model`
--

CREATE TABLE `subscription_model` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `pricing_model` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscription_model`
--

INSERT INTO `subscription_model` (`id`, `name`, `price`, `pricing_model`) VALUES
('M00001', 'Monthly', 59999, 30),
('M00002', 'Yearly', 399999, 365);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_user`
--

CREATE TABLE `subscription_user` (
  `id` varchar(8) NOT NULL,
  `sub_model` varchar(6) NOT NULL,
  `user` varchar(6) NOT NULL,
  `purchase_date` date NOT NULL,
  `exp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscription_user`
--

INSERT INTO `subscription_user` (`id`, `sub_model`, `user`, `purchase_date`, `exp_date`) VALUES
('S0000001', 'M00001', 'U00002', '2023-05-26', '2023-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `profile`, `status`) VALUES
('U00001', 'a', 'a@gmail.com', 'a', '', 'Active'),
('U00002', 'c', 'c@gmail.com', 'c', '', 'Active'),
('U00003', 'b', 'c@gmail.com', 'c', '', 'Active'),
('U00004', 'vinshent', 'vinshentwianata@gmail.com', 'a', '', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confirmation`
--
ALTER TABLE `confirmation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film_category`
--
ALTER TABLE `film_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_user`
--
ALTER TABLE `history_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists_member`
--
ALTER TABLE `lists_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_model`
--
ALTER TABLE `subscription_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_user`
--
ALTER TABLE `subscription_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
