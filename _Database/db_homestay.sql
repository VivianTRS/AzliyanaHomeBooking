-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2024 at 10:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_homestay`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookings`
--

CREATE TABLE `tbl_bookings` (
  `booking_id` int NOT NULL,
  `homestay_id` int NOT NULL,
  `guest_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nric_number` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_number` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `month` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) DEFAULT NULL,
  `bank` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bank_account_number` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_status` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`booking_id`, `homestay_id`, `guest_name`, `nric_number`, `contact_number`, `email`, `check_in_date`, `check_out_date`, `month`, `total_amount`, `deposit`, `bank`, `bank_account_number`, `payment_status`) VALUES
(3, 3, 'Zalihar', '040121011066', '0193313778', 'viviantanroushan@gmail.com', '2024-09-30', '2024-10-01', 9, 500.00, 100.00, 'bankislam', '-', 'paid'),
(7, 1, 'Deanna Sorfina Binti Md Shamsul', '040223010430', '011-11265383', 'dynashmsul@gmail.com', '2025-02-23', '2025-02-24', 2, 2.00, 1.00, 'cimb', '-', 'paid'),
(15, 1, 'Evon Tan Rou Min', '040121011088', '01135601088', 'viviantanroushan@gmail.com', '2024-12-01', '2024-12-02', 12, 2.00, 1.00, 'hongleong', '-', 'paid'),
(18, 1, 'Crystal ', '040121011033', '01135601088', 'viviantanroushan@gmail.com', '2024-11-15', '2024-11-16', 11, 2.00, 1.00, 'hongleong', '---', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_homestays`
--

CREATE TABLE `tbl_homestays` (
  `homestay_id` int NOT NULL,
  `name_homestay` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `max_guest` int DEFAULT NULL,
  `num_room` int DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `rules` text COLLATE utf8mb4_general_ci,
  `amenities` text COLLATE utf8mb4_general_ci,
  `contact_person` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_number` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `alternate_contact_person` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alternate_contact_number` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_homestays`
--

INSERT INTO `tbl_homestays` (`homestay_id`, `name_homestay`, `max_guest`, `num_room`, `price`, `deposit`, `check_in_time`, `check_out_time`, `location`, `description`, `rules`, `amenities`, `contact_person`, `contact_number`, `alternate_contact_person`, `alternate_contact_number`, `image`) VALUES
(1, 'Azhar', 4, 2, 1.00, 1.00, '14:00:00', '12:00:00', 'No 40 Jln Saujana Impian 3, Taman Saujana, 86000 Kluang, Johor', '', 'No smoking inside the house.\r\nKeep the house clean.\r\nDo not throw or hide trash in corners or under furniture.\r\nHandle equipment carefully. If damaged, you must replace it.\r\nNo BBQ on the floor (tiles may break).\r\nDo not steal or take any items from the house.', 'Air conditioning in Bedrooms 1, 2, and 3\r\n300 Mbps Wi-Fi\r\nCoway Ice Maker (provides cold water and ice)\r\n55-inch 4K HDR TV\r\nNetflix\r\nRefrigerator\r\nWashing Machine + laundry detergent\r\nBathroom equipped with body soap and shampoo\r\nBath towels provided\r\nBedrooms 1, 2, and 3 fully furnished (Queen Bed, Wardrobe, and Dressing Table)\r\nHigh-quality mattress for a comfortable sleep\r\nPull-back Sofa with scratch-resistant and waterproof material\r\nPhillips Clothes Iron (easy to iron and time-saving)\r\nComplete Kitchen Cooking Equipment (basic cooking ingredients, spoons, forks, frying pan, knife set)\r\nModern Piano-Style Sink\r\nModern Design', 'Hairul Azhar Shahri', '019 - 4561507', 'Alice', '013 - 7288172', 'booking1.jpg'),
(2, 'Illiyana', 4, 3, 300.00, 100.00, '14:00:00', '12:00:00', 'Jalan Nuri, Bandar Putra, 81000 Kulai, Johor', NULL, NULL, 'Air conditioning in Rooms 1, 2, and 3\r\n300mbps WIFI\r\nCoway water dispenser with ice\r\n55-inch 4K HDR TV\r\nNETFLIX\r\nRefrigerator\r\nWashing machine with laundry detergent\r\nBathroom with body soap and shampoo\r\nBath towels provided\r\nRooms 1, 2, and 3 are fully furnished with a queen bed, wardrobe, and vanity table\r\nHigh-quality mattress for a comfortable sleep\r\nPull-back sofa that is scratch-resistant and waterproof\r\nPhillips iron for easy and quick ironing\r\nFully equipped kitchen with basic cooking ingredients, utensils, frying pan, and knife set\r\nModern piano-style sink\r\nContemporary design', 'Hairul Azhar Shahri', '019 - 4561507', '', '', 'booking2.jpg'),
(3, '7 Wonders', 6, 3, 500.00, 100.00, '12:30:00', '13:20:00', '12284, Jalan Terkukur 12, Bandar Putra, 81000 Kulai, Johor, Malaysia', NULL, 'Maximum Occupancy. Do not exceed the maximum number of guests allowed in the booking without prior permission.\r\nNo Pets Allowed.Pets are not permitted inside the house unless previously agreed upon.\r\nCheck-In and Check-Out Times. Please adhere to the check-in and check-out times to ensure smooth transitions for all guests.\r\nNo Unauthorized Events. Parties or gatherings without prior approval from the management are not permitted.\r\nEnergy Conservation. Please switch off lights, fans, and air-conditioning when not in use or when leaving the house.\r\nKey Responsibility. Keep the keys safe. Lost keys may result in an additional charge.\r\nParking Rules. Only park in designated parking areas to avoid disturbances to neighbors.\r\nRespect House Décor. Please do not move or rearrange furniture without permission.\r\nSecure Belongings. Guests are responsible for their personal belongings. Lock the doors when going out', NULL, 'Vivian Tan Rou Shan', '011 - 35601088', '', '', 'booking3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_homestay_images`
--

CREATE TABLE `tbl_homestay_images` (
  `image_id` int NOT NULL,
  `homestay_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_homestay_images`
--

INSERT INTO `tbl_homestay_images` (`image_id`, `homestay_id`, `image`) VALUES
(3, 1, 'Azhar_67242411881f4_IMG-20240506-WA0016.jpg'),
(4, 2, 'ILLIYANA_67242464d4e56_nuri-house2.jpg'),
(6, 2, 'ILLIYANA_6724249c236a7_kluang-house1.jpeg'),
(8, 2, 'ILLIYANA_672424b87a017_kluang-house2.jpeg'),
(9, 2, 'ILLIYANA_672424c6d7f81_kluang-house3.jpeg'),
(10, 2, 'ILLIYANA_672424ce20d00_kluang-house4.jpeg'),
(11, 2, 'ILLIYANA_672424da75291_kluang-house5.jpeg'),
(12, 2, 'ILLIYANA_672424e6da5c6_kluang-house6.jpeg'),
(13, 2, 'ILLIYANA_672424ee29821_kluang-house7.jpeg'),
(17, 1, 'Azhar_67242540695fd_IMG-20240506-WA0056.jpg'),
(18, 1, 'Azhar_67242546d8cfb_IMG-20240506-WA0055.jpg'),
(19, 1, 'Azhar_6724254eed385_IMG-20240506-WA0054.jpg'),
(20, 1, 'Azhar_672425555d41d_IMG-20240506-WA0052.jpg'),
(22, 1, 'Azhar_672425688f52a_IMG-20240506-WA0051.jpg'),
(23, 1, 'Azhar_67242583791ac_IMG-20240506-WA0051.jpg'),
(24, 1, 'Azhar_672425893a0d8_IMG-20240506-WA0050.jpg'),
(25, 1, 'Azhar_6724258e9c0b8_IMG-20240506-WA0049.jpg'),
(37, 3, '7 Wonders_67242ac5174c1_7sweet-house1.png'),
(39, 3, '7 Wonders_67242ad9a9426_7sweet-house2.png'),
(40, 3, '7 Wonders_67242ade46a80_7sweet-house3.png'),
(41, 3, '7 Wonders_67242ae4982f5_7sweet-house4.png'),
(42, 3, '7 Wonders_67242ae9aa194_7sweet-house5.png'),
(43, 3, '7 Wonders_67242afda034d_7sweet-house6.png'),
(44, 3, '7 Wonders_67242b1ed0485_7sweet-house7.png'),
(45, 3, '7 Wonders_67242b261de57_7sweet-house8.png'),
(46, 3, '7 Wonders_67242b325931b_7sweet-house9.png'),
(47, 3, '7 Wonders_67242b388b439_7sweet-house10.png'),
(48, 3, '7 Wonders_67242b4886951_7sweet-house10.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_password_resets`
--

CREATE TABLE `tbl_password_resets` (
  `id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_type` enum('Admin','Guest') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$6dixF4XqlGkSXypd2FLQGutYB9MLWV37yC25JYHIlhOazpyiAuGnq', 'Admin', '2024-09-09 03:23:49'),
(2, 'Vivian', 'vivian@gmail.com', '$2y$10$9c0AI6hqiwooBPOu4FNqTe91LqWmzioy/e7kWZ0mP2LIIAU6POXYC', 'Admin', '2024-08-10 03:26:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `homestay_id` (`homestay_id`);

--
-- Indexes for table `tbl_homestays`
--
ALTER TABLE `tbl_homestays`
  ADD PRIMARY KEY (`homestay_id`);

--
-- Indexes for table `tbl_homestay_images`
--
ALTER TABLE `tbl_homestay_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `homestay_id` (`homestay_id`);

--
-- Indexes for table `tbl_password_resets`
--
ALTER TABLE `tbl_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_homestays`
--
ALTER TABLE `tbl_homestays`
  MODIFY `homestay_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_homestay_images`
--
ALTER TABLE `tbl_homestay_images`
  MODIFY `image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_password_resets`
--
ALTER TABLE `tbl_password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD CONSTRAINT `tbl_bookings_ibfk_1` FOREIGN KEY (`homestay_id`) REFERENCES `tbl_homestays` (`homestay_id`);

--
-- Constraints for table `tbl_homestay_images`
--
ALTER TABLE `tbl_homestay_images`
  ADD CONSTRAINT `tbl_homestay_images_ibfk_1` FOREIGN KEY (`homestay_id`) REFERENCES `tbl_homestays` (`homestay_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
