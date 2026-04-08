-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 03:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_ticket`
--

CREATE TABLE `booking_ticket` (
  `id` int(40) NOT NULL,
  `user_id` int(40) NOT NULL,
  `movie_id` int(40) NOT NULL,
  `holder_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `booking_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_ticket`
--

INSERT INTO `booking_ticket` (`id`, `user_id`, `movie_id`, `holder_id`, `total_amount`, `booking_added`) VALUES
(9, 24, 7, 38, 86.6, '2025-01-25 00:36:39'),
(10, 24, 3, 39, 78.3, '2025-01-25 00:52:25'),
(11, 24, 3, 40, 78.3, '2025-01-25 00:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `cinema_seats`
--

CREATE TABLE `cinema_seats` (
  `id` int(11) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `row` varchar(5) NOT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `screening_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinema_seats`
--

INSERT INTO `cinema_seats` (`id`, `seat_number`, `row`, `status`, `screening_id`, `created_at`, `updated_at`) VALUES
(1, 'A1', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(2, 'A2', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(3, 'A3', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(4, 'A4', 'A', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(5, 'A5', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(6, 'A6', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(7, 'A7', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(8, 'A8', 'A', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(9, 'A9', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(10, 'A10', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(11, 'A11', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(12, 'A12', 'A', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(13, 'A13', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(14, 'A14', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(15, 'A15', 'A', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(16, 'A16', 'A', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(21, 'B1', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(22, 'B2', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(23, 'B3', 'B', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(24, 'B4', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(25, 'B5', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(26, 'B6', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(27, 'B7', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(28, 'B8', 'B', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(29, 'B9', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(30, 'B10', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(31, 'B11', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(32, 'B12', 'B', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(33, 'B13', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(34, 'B14', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(35, 'B15', 'B', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(36, 'B16', 'B', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(41, 'C1', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(42, 'C2', 'C', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(43, 'C3', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(44, 'C4', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(45, 'C5', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(46, 'C6', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(47, 'C7', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(48, 'C8', 'C', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(49, 'C9', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(50, 'C10', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(51, 'C11', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(52, 'C12', 'C', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(53, 'C13', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(54, 'C14', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(55, 'C15', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(56, 'C16', 'C', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(57, 'C17', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(58, 'C18', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(59, 'C19', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(60, 'C20', 'C', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(61, 'D1', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(62, 'D2', 'D', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(63, 'D3', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(64, 'D4', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(65, 'D5', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(66, 'D6', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(67, 'D7', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(68, 'D8', 'D', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(69, 'D9', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(70, 'D10', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(71, 'D11', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(72, 'D12', 'D', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(73, 'D13', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(74, 'D14', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(75, 'D15', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(76, 'D16', 'D', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(77, 'D17', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(78, 'D18', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(79, 'D19', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(80, 'D20', 'D', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(81, 'E1', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(82, 'E2', 'E', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(83, 'E3', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(84, 'E4', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(85, 'E5', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(86, 'E6', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(87, 'E7', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(88, 'E8', 'E', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(89, 'E9', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(90, 'E10', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(91, 'E11', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(92, 'E12', 'E', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(93, 'E13', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(94, 'E14', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(95, 'E15', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(96, 'E16', 'E', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(97, 'E17', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(98, 'E18', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(99, 'E19', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(100, 'E20', 'E', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(101, 'F1', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(102, 'F2', 'F', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(103, 'F3', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(104, 'F4', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(105, 'F5', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(106, 'F6', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(107, 'F7', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(108, 'F8', 'F', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(109, 'F9', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(110, 'F10', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(111, 'F11', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(112, 'F12', 'F', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(113, 'F13', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(114, 'F14', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(115, 'F15', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(116, 'F16', 'F', 'booked', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(117, 'F17', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(118, 'F18', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(119, 'F19', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57'),
(120, 'F20', 'F', 'available', 1, '2024-12-06 08:40:57', '2024-12-06 08:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(20) NOT NULL,
  `food_name` varchar(99) NOT NULL,
  `food_category` enum('Ala Carte','Drink','Snack','Other') NOT NULL,
  `food_quantity` int(11) NOT NULL,
  `food_price` double NOT NULL,
  `food_rating` int(50) NOT NULL,
  `food_image` varchar(255) NOT NULL,
  `food_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `food_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `food_name`, `food_category`, `food_quantity`, `food_price`, `food_rating`, `food_image`, `food_created`, `food_update`) VALUES
(1, 'Popcorn', 'Ala Carte', 100, 5.6, 5, 'popcorn.png', '2025-01-19 16:00:00', '2025-01-24 09:58:17'),
(2, 'Nachos with Cheese', 'Snack', 50, 6.7, 5, 'nachos-with-cheese.png', '2025-01-19 16:00:00', '2025-01-24 09:57:02'),
(3, 'Hotdog', 'Ala Carte', 75, 5.4, 5, 'hotdog.png', '2025-01-19 16:00:00', '2025-01-24 10:02:33'),
(4, 'Soft Drinks', 'Drink', 200, 0, 5, 'soft_drinks.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(5, 'Candy', 'Other', 150, 0, 4, 'candy.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(6, 'Pretzels', 'Snack', 80, 0, 4, 'pretzels.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(7, 'Ice Cream', 'Snack', 60, 0, 5, 'ice_cream.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(8, 'Bottled Water', 'Drink', 250, 0, 5, 'bottled_water.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(9, 'Burger', 'Ala Carte', 40, 0, 5, 'burger.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(10, 'Fruit Juice', 'Drink', 70, 0, 5, 'fruit_juice.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(11, 'Fries', 'Snack', 100, 0, 5, 'fries.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(12, 'Pizza Slices', 'Ala Carte', 50, 0, 5, 'pizza_slices.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(13, 'Milkshake', 'Drink', 40, 0, 5, 'milkshake.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(14, 'Chocolate Bars', 'Snack', 120, 0, 5, 'chocolate_bars.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00'),
(15, 'Chicken Nuggets', 'Snack', 65, 0, 4, 'chicken_nuggets.jpg', '2025-01-19 16:00:00', '2025-01-19 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `holder_booking`
--

CREATE TABLE `holder_booking` (
  `id` int(30) NOT NULL,
  `seat_no` varchar(40) NOT NULL,
  `seat_count` int(15) NOT NULL,
  `date_pick` date NOT NULL,
  `time_pick` time NOT NULL,
  `hall` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `foods` varchar(999) NOT NULL,
  `food_quantiy` varchar(999) NOT NULL,
  `checkout_status` enum('Yes','No') NOT NULL,
  `record_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holder_booking`
--

INSERT INTO `holder_booking` (`id`, `seat_no`, `seat_count`, `date_pick`, `time_pick`, `hall`, `user_id`, `movie_id`, `foods`, `food_quantiy`, `checkout_status`, `record_date`) VALUES
(38, 'A9, A10, A11', 3, '2025-01-08', '18:25:00', 'Hall 6', 24, 7, '1', '1', 'Yes', '2025-01-25 08:36:37'),
(39, 'A14,A15,A16', 3, '2024-12-10', '21:03:24', 'Hall 6', 24, 3, '1,2', '1,1', 'Yes', '2025-01-25 08:52:23'),
(40, 'B14,B15,B16', 3, '2024-12-10', '21:03:24', 'Hall 6', 24, 3, '1,2', '1,1', 'No', '2025-01-25 08:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `release_date` date NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `duration` int(11) NOT NULL,
  `type` varchar(4) NOT NULL,
  `language` varchar(40) NOT NULL,
  `director` varchar(40) NOT NULL,
  `cast` varchar(100) NOT NULL,
  `handler` varchar(40) NOT NULL,
  `image` varchar(255) NOT NULL,
  `imagetitle` varchar(255) NOT NULL,
  `imagebg` varchar(255) NOT NULL,
  `status` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `description`, `release_date`, `price`, `duration`, `type`, `language`, `director`, `cast`, `handler`, `image`, `imagetitle`, `imagebg`, `status`) VALUES
(1, '65', 'Action', '65 is a 2023 American science fiction film written and directed by Scott Beck and Bryan Woods, and starring Adam Driver. Driver plays an astronaut who crashes on an unknown planet with a challenging environment and attempts to help a young girl, played by Ariana Greenblatt, survive. Beck and Woods produced with Sam Raimi, Deborah Liebling, and Zainab Azizi.', '2023-03-23', 23, 93, 'IF', 'English', 'Scott Beck, Bryan Woods', 'Adam Driver, Ariana Greenblatt, Salvatore Totino, Jane Tones', '65', '65.jpg', 'title-65.png', 'bg-65.jpeg', 'yes'),
(2, 'Harry Potter', 'Fantasy', 'Harry Potter is a series of seven fantasy novels written by British author J. K. Rowling. The novels chronicle the lives of a young wizard, Harry Potter, and his friends, Hermione Granger and Ron Weasley, all of whom are students at Hogwarts School of Witchcraft and Wizardry. The main story arc concerns Harry\'s conflict with Lord Voldemort, a dark wizard who intends to become immortal, overthrow the wizard governing body known as the Ministry of Magic, and subjugate all wizards and Muggles (non-', '2014-12-09', 22, 97, 'IF', 'English', 'Alfonso Cuarón, Mike Newell, David Yates', 'Daniel Radcliffe, Rupert Grint, Matthew Lewis, Emma Watson', 'harry-potter', 'harry-potter.jpg', 'title-harry-potter.png', 'bg-harry-potter.jpeg', 'yes'),
(3, 'Kahar: Kapla High Council', 'Action', 'Kahar: Kapla High Council ialah sebuah filem aksi drama persekolahan Malaysia 2024 arahan Razaisyam Rashid terbitan bersama Astro Shaw dengan Pasal Productions dan Alpha 47 Films. Ia dibintangi oleh Amir Ahnaf, Aedy Ashraf, Sky Iskandar, Thompson Goh, Khenobu, Fadhli Masoot dan Fazziq Muqris. Filem ini merupakan filem prekuel kepada siri TV Projek: High Council (2023). Tayangan filem ini dijadualkan bermula pada 28 November 2024.', '2024-12-02', 22, 99, 'LF', 'Malay', 'Razaisyam Rashid', 'Amir Ahnaf, Aedy Ashraf, Sky Iskandar, Thompson Goh, Khenobu, Fazziq Muqris', 'kahar', 'kahar.jpg', 'title-kahar.png', 'bg-kahar.jpeg', 'yes'),
(4, 'Venom: Let There Be Carnage', 'Action', 'Venom: Let There Be Carnage is a 2021 American superhero film featuring the Marvel Comics character Venom. The sequel to Venom (2018) and the second film in Sony\'s Spider-Man Universe (SSU), it was directed by Andy Serkis from a screenplay by Kelly Marcel. Tom Hardy stars as Eddie Brock and Venom alongside Michelle Williams, Naomie Harris, Reid Scott, Stephen Graham, and Woody Harrelson. In the film, Eddie and the alien symbiote Venom must face serial killer Cletus Kasady (Harrelson) after he be', '2022-11-16', 21, 102, 'IF', 'English', 'Andy Serkis', 'Tom Hardy, Michelle Williams, Naomie Harris, Reid Scott, Stephen Graham', 'venom', 'venom.jpg', 'title-venom.png', 'bg-venom.jpeg', 'yes'),
(7, 'Demon Slayer Infinity Castle', 'Action', 'Demon Slayer: Kimetsu no Yaiba – The Movie: Infinity Castle (Japanese: 劇場版「鬼滅の刃」 無限城編 Hepburn: Gekijō-ban \"Kimetsu no Yaiba\" Mugen-jō-hen?), also known simply as Demon Slayer: Infinity Castle, is a 2025 Japanese anime dark fantasy action-horror film based on the \"Infinity Castle\" arc of the 2016–20 manga series Demon Slayer: Kimetsu no Yaiba by Koyoharu Gotouge. It is a direct sequel to the fourth season of the Demon Slayer: Kimetsu no Yaiba anime television series - Hashira Training - as well a', '2025-07-04', 27, 78, 'IF', 'Japanese', 'Haruto Sotozaki', 'Akifumi Fujio Masanori Miyake Yūma Takahashi', 'demon-slayer-infinity-castle', 'demon-slayer-infinity-castle.jpg', 'title-demon-slayer-infinity-castle.png', 'bg-demon-slayer-infinity-castle.jpg', 'yes'),
(8, 'Dongeng Sang Kancil', 'Action', 'Filem ini mengisahkan seekor anak kancil yang menyaksikan ibunya dibunuh oleh satu bayang hitam misteri.\r\n\r\nSetelah dewasa, Kancil bertekad mencari bayang hitam tersebut untuk membalas dendam atas kematian ibunya dan menyelamatkan Hutan Rimba daripada ancaman yang sama.\r\n\r\nDalam pengembaraannya, Kancil bertemu dengan tiga pemangsa utama yang menguasai langit, daratan, dan lautan, iaitu Helang Perkasa, Gajah Belukar, dan Raja Buaya.\r\n\r\nDengan kecerdikannya, Kancil berjaya mendapatkan sokongan daripada mereka serta penghuni hutan lain untuk menumpaskan bayang hitam tersebut.', '2024-12-26', 23, 76, 'LF', 'Malay', 'Ahmad Razuri Roseli,  Nik Ahmad Rasyidi ', 'Hjh. Ainon Ariff, Nur Naquyah Burhanuddin', 'dongeng-sang-kancil', 'dongeng-sang-kancil.jpg', 'title-dongeng-sang-kancil.jpg', 'bg-dongeng-sang-kancil.jpg', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `movie_screenings`
--

CREATE TABLE `movie_screenings` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `screen_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_screenings`
--

INSERT INTO `movie_screenings` (`id`, `movie_id`, `screen_id`, `show_date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2024-12-10', '21:03:24', '23:03:24', '2024-12-06 09:04:27', '2024-12-06 09:04:27'),
(2, 7, 1, '2025-01-08', '18:25:00', '09:25:00', '2025-01-07 04:25:27', '2025-01-07 04:25:27'),
(3, 7, 1, '2025-01-09', '06:30:00', '08:40:00', '2025-01-07 04:27:18', '2025-01-07 04:27:18'),
(4, 7, 1, '2025-01-09', '06:30:00', '08:30:00', '2025-01-07 04:27:46', '2025-01-07 04:27:46'),
(5, 7, 1, '2025-01-08', '17:58:00', '17:58:00', '2025-01-07 04:59:00', '2025-01-07 04:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screens`
--

INSERT INTO `screens` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hall 6', '2024-12-06 08:47:36', '2024-12-06 08:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(999) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`, `phone`, `address`, `role`) VALUES
(24, 'Naqid', '$2y$10$K6bdy79w5mr0EsZxBkw8Fefw3yh55r/DBB/Lm030qJr2wdi9ZTDqm', 'ahmadnaqiuddinmohamad@gmail.com', '01972956422', 'Kuala Telemong, Kuala Terengganu', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_ticket`
--
ALTER TABLE `booking_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cinema_seats`
--
ALTER TABLE `cinema_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seat_number` (`seat_number`,`screening_id`),
  ADD KEY `screening_id` (`screening_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holder_booking`
--
ALTER TABLE `holder_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User_Id` (`user_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_screenings`
--
ALTER TABLE `movie_screenings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `screend_id` (`screen_id`);

--
-- Indexes for table `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_ticket`
--
ALTER TABLE `booking_ticket`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cinema_seats`
--
ALTER TABLE `cinema_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `holder_booking`
--
ALTER TABLE `holder_booking`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movie_screenings`
--
ALTER TABLE `movie_screenings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `screens`
--
ALTER TABLE `screens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cinema_seats`
--
ALTER TABLE `cinema_seats`
  ADD CONSTRAINT `screening_id` FOREIGN KEY (`screening_id`) REFERENCES `screens` (`id`);

--
-- Constraints for table `holder_booking`
--
ALTER TABLE `holder_booking`
  ADD CONSTRAINT `User_Id` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `movie_screenings`
--
ALTER TABLE `movie_screenings`
  ADD CONSTRAINT `movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `screend_id` FOREIGN KEY (`screen_id`) REFERENCES `screens` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
