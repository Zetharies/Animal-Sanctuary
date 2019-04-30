-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2019 at 05:17 PM
-- Server version: 10.3.14-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id9375912_courseworkdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_requests`
--

CREATE TABLE `adoption_requests` (
  `id` int(11) NOT NULL,
  `animalid` int(11) NOT NULL,
  `animalName` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT 0
) ;

--
-- Dumping data for table `adoption_requests`
--

INSERT INTO `adoption_requests` (`id`, `animalid`, `animalName`, `userid`, `approval`) VALUES
(2, 1, 'Mr.Tuxedo Pants', 2, 0),
(3, 5, 'Bella', 2, 0),
(5, 4, 'Shelldon', 3, 0),
(6, 1, 'Mr.Tuxedo Pants', 3, 0),
(8, 1, 'Mr.Tuxedo Pants', 4, 0),
(9, 1, 'Mr.Tuxedo Pants', 5, 0),
(11, 1, 'Mr.Tuxedo Pants', 8, 0),
(12, 2, 'Hamsuke', 8, 0),
(13, 6, 'Don Fluffles', 8, 0),
(15, 1, 'Mr.Tuxedo Pants', 12, 0),
(16, 7, 'Shelldon', 2, 1),
(17, 8, 'Hazel', 2, 2),
(18, 8, 'Hazel', 4, 1),
(19, 5, 'Bella', 13, 0),
(20, 4, 'Shelldon', 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `animalid` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL
) ;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animalid`, `name`, `dob`, `description`, `availability`, `gender`, `type`) VALUES
(1, 'Mr.Tuxedo Pants', '2019-02-12', 'Mr Tuxedo Pants: A cat mixed with black and white fur.', 1, 'male', 'Cat'),
(2, 'Hamsuke', '2019-01-10', 'Hamsuke aka \'Sexy beast\' is a hamster that will one day bring the destruction of the world with how adorable he is.', 1, 'male', 'Hamster'),
(3, 'Puff daddy', '2019-01-06', 'Puff daddy is a puffer fish that likes to wander around its tank while staring at people from accross the room.', 1, 'other', 'Fish'),
(4, 'Shelldon', '2014-08-06', 'Shelldon is a pretty shy turtle, but is really an amazing pet when he does comes out of his shell.', 1, 'male', 'Other'),
(5, 'Bella', '2017-06-08', 'Bella is a Pure Bred Labrador. She likes to explore quite a bit so acquires lots of attention. She has already been vaccinated, dewormed and vet checked.', 1, 'female', 'Dog'),
(6, 'Don Fluffles', '2019-09-09', 'Take the most horrifying thing you can think of, and then multiply it by cancer. The Don sends his regards.', 1, 'male', 'Cat'),
(7, 'Shelldon', '2016-04-06', 'Shelldon is a Yorkshire Terrier who likes to take long walks around the park. He is a wanderer so don\'t let him out of your sight too long!', 0, 'male', 'Dog'),
(8, 'Hazel', '2017-04-06', 'Hazel the hedgehog is a spiky little fur ball that likes to cause a lot of trouble, be careful when holding her.', 0, 'female', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `animal_images`
--

CREATE TABLE `animal_images` (
  `id` int(11) NOT NULL,
  `animalName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'NotAvailable.jpg',
  `animalid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animal_images`
--

INSERT INTO `animal_images` (`id`, `animalName`, `image`, `animalid`) VALUES
(1, 'Mr.Tuxedo Pants', '1555005593Mrtuxedopants.png', 1),
(2, 'Mr.Tuxedo Pants', '1555005593Mrtuxedopants2.png', 1),
(3, 'Hamsuke', '1555006067Hamsuke1.jpg', 2),
(4, 'Hamsuke', '1555006067Hamsuke2.jpg', 2),
(5, 'Hamsuke', '1555006067Hamsuke3.jpg', 2),
(6, 'Puff Daddy', '1555006795PuffDaddy1.jpg', 3),
(7, 'Puff Daddy', '1555006795PuffDaddy2.jpg', 3),
(8, 'Puff Daddy', '1555006795PuffDaddy3.jpg', 3),
(9, 'Shelldon', '1555007697Shelldon1.jpg', 4),
(10, 'Shelldon', '1555007697Shelldon2.jpg', 4),
(11, 'Bella', '1555008216Bella1.jpg', 5),
(12, 'Bella', '1555008216Bella2.jpg', 5),
(13, 'Bella', '1555008216Bella3.jpg', 5),
(14, 'Bella', '1555008216Bella4.jpg', 5),
(15, 'Don Fluffles', '1555952084DonFluffles1.jpg', 6),
(16, 'Don Fluffles', '1555952084DonFluffles2.jpg', 6),
(17, 'Don Fluffles', '1555952084DonFluffles3.jpg', 6),
(18, 'Shelldon', '1556567077Shelldon1_dog.jpg', 7),
(19, 'Shelldon', '1556567077Shelldon2_dog.jpg', 7),
(20, 'Shelldon', '1556567077Shelldon3_dog.jpg', 7),
(21, 'Hazel', '1556567679Hazel1.jpg', 8),
(22, 'Hazel', '1556567679Hazel2.jpg', 8);

-- --------------------------------------------------------

--
-- Table structure for table `animal_owners`
--

CREATE TABLE `animal_owners` (
  `id` int(11) NOT NULL,
  `animalid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animal_owners`
--

INSERT INTO `animal_owners` (`id`, `animalid`, `userid`) VALUES
(1, 7, 2),
(2, 8, 4),
(3, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Zeth', '$2y$10$rMbNeIJCCk/K9GMRTUFkB.eDDMsBnU0ByKPvga5JUNpUt6ysQefsW', '2019-04-07 14:24:32'),
(2, 'Lol', '$2y$10$1vlMKHHyiNVj2PoP0GrmWO/Umw/0C1jZqfsVz.RC7Bf04fbhZ/EC2', '2019-04-07 17:02:10'),
(3, 'test', '$2y$10$GR6MQUd2UjGpXVkfbM53zuGziHvQfPGXNNtv4PymmiqjGRN9IdhgC', '2019-04-18 15:35:01'),
(4, 'Johnny', '$2y$10$42y9uz8hdt7P6.5rqBFXbu3LPRidDwdCtTz.WtqsCpru973LqqSgW', '2019-04-22 16:13:43'),
(5, 'MohamedN', '$2y$10$U8TRISbcH9CyUYmuLztmMOF0QYID9WnZAk01iSG7rmYpjZKFopypq', '2019-04-22 19:27:36'),
(6, 'okwir', '$2y$10$0Jt4cEn2ohRAVyVOCBtHfOHnCSUx0f1QHRgDBv45lzDfre829l1H.', '2019-04-22 21:13:12'),
(7, 'aallykat', '$2y$10$BrCIZp1VpRXISi31ZUmisOPEKVyYE3zus4eDP.pZa0L.KR9p6HalW', '2019-04-22 22:56:36'),
(8, 'viviank', '$2y$10$X1hM34xDFPg0ls48x/xe8eHyj0zKsG/WtBWLhrwAl1EjvBVRUz74y', '2019-04-23 09:39:46'),
(9, 'User12345', '$2y$10$xshq0nK1Yd4c80mJnivTmeQ1bbd/c5o1Kd9o./8Xxf/EHj.qpYxWG', '2019-04-23 09:46:46'),
(10, 'test123', '$2y$10$zfN81MtWmD9BcRWP8hOSe.In..bJvk.nbQaO.F.64FoyNnfN4s0vO', '2019-04-23 13:16:28'),
(11, 'Becca', '$2y$10$x5b.Z7uyXw/Ds8kKc1zk1u7Gx8FKyk5ruSp26JQ8QoQ5Tqo7Y9W5m', '2019-04-23 16:33:26'),
(12, 'usertest123', '$2y$10$Ml..GGQYs.3Z5j5eWdz9Yev2O3eQLnl.Z2A/9KTa.jzRxTFpufcby', '2019-04-27 18:05:54'),
(13, 'AnimalLover', '$2y$10$jnz2nLDd04sQPtY.euQ5qufhJIfxf79.E8SucWHbSlLDaAWbiUVAG', '2019-04-30 14:20:37'),
(14, 'Chloe', '$2y$10$M8yi3p4GDJaPdyEab0Cnv.HRckRGREqvJUpq1bxXeFOrbBa23ZTnK', '2019-04-30 16:01:14'),
(15, 'faggit', '$2y$10$r8yH.Lr5XZQhwsUZeqxsUOlC7XwruQfdPM0RIAlOf5NVP96I3Ag9q', '2019-04-30 16:58:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_animalid` (`animalid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`animalid`);

--
-- Indexes for table `animal_images`
--
ALTER TABLE `animal_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animalid` (`animalid`);

--
-- Indexes for table `animal_owners`
--
ALTER TABLE `animal_owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animalid` (`animalid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `animalid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `animal_images`
--
ALTER TABLE `animal_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `animal_owners`
--
ALTER TABLE `animal_owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD CONSTRAINT `FK_animalid` FOREIGN KEY (`animalid`) REFERENCES `animal` (`animalid`),
  ADD CONSTRAINT `adoption_requests_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `animal_images`
--
ALTER TABLE `animal_images`
  ADD CONSTRAINT `animal_images_ibfk_1` FOREIGN KEY (`animalid`) REFERENCES `animal` (`animalid`);

--
-- Constraints for table `animal_owners`
--
ALTER TABLE `animal_owners`
  ADD CONSTRAINT `animal_owners_ibfk_1` FOREIGN KEY (`animalid`) REFERENCES `animal` (`animalid`),
  ADD CONSTRAINT `animal_owners_ibfk_2` FOREIGN KEY (`animalid`) REFERENCES `animal` (`animalid`),
  ADD CONSTRAINT `animal_owners_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
