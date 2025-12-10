-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 12, 2025 at 01:58 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petstridedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Device`
--

CREATE TABLE `Device` (
  `id` int NOT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Device`
--

INSERT INTO `Device` (`id`, `type`) VALUES
(1, 'GPS Tracker Pro'),
(2, 'GPS Tracker Pro'),
(3, 'Activity Monitor Plus'),
(4, 'GPS Tracker Pro'),
(5, 'Activity Monitor Plus'),
(6, 'GPS Tracker Pro'),
(7, 'GPS Tracker Elite'),
(8, 'Activity Monitor Plus'),
(9, 'GPS Tracker Pro'),
(10, 'Smart Collar GPS'),
(11, 'GPS Tracker Elite'),
(12, 'Activity Monitor Plus'),
(13, 'GPS Tracker'),
(14, 'GPS Tracker'),
(15, 'Activity Monitor'),
(16, 'GPS Tracker'),
(17, 'Activity Monitor'),
(18, 'GPS Tracker'),
(19, 'GPS Tracker'),
(20, 'Activity Monitor'),
(21, 'GPS Tracker'),
(22, 'Activity Monitor'),
(23, 'GPS Tracker'),
(24, 'GPS Tracker'),
(25, 'GPS Tracker'),
(26, 'GPS Tracker'),
(27, 'Activity Monitor'),
(28, 'GPS Tracker'),
(29, 'Activity Monitor'),
(30, 'GPS Tracker'),
(31, 'GPS Tracker'),
(32, 'Activity Monitor'),
(33, 'GPS Tracker'),
(34, 'Activity Monitor'),
(35, 'GPS Tracker'),
(36, 'GPS Tracker'),
(37, 'GPS Tracker'),
(38, 'GPS Tracker'),
(39, 'Activity Monitor'),
(40, 'GPS Tracker'),
(41, 'Activity Monitor'),
(42, 'GPS Tracker'),
(43, 'GPS Tracker'),
(44, 'Activity Monitor'),
(45, 'GPS Tracker'),
(46, 'Activity Monitor'),
(47, 'GPS Tracker'),
(48, 'GPS Tracker'),
(49, 'GPS Tracker'),
(50, 'GPS Tracker'),
(51, 'Activity Monitor'),
(52, 'GPS Tracker'),
(53, 'Activity Monitor'),
(54, 'GPS Tracker'),
(55, 'GPS Tracker'),
(56, 'Activity Monitor'),
(57, 'GPS Tracker'),
(58, 'Activity Monitor'),
(59, 'GPS Tracker'),
(60, 'GPS Tracker'),
(61, 'GPS Tracker'),
(62, 'GPS Tracker'),
(63, 'Activity Monitor'),
(64, 'GPS Tracker'),
(65, 'Activity Monitor'),
(66, 'GPS Tracker'),
(67, 'GPS Tracker'),
(68, 'Activity Monitor'),
(69, 'GPS Tracker'),
(70, 'Activity Monitor'),
(71, 'GPS Tracker'),
(72, 'GPS Tracker'),
(73, 'GPS Tracker'),
(74, 'GPS Tracker'),
(75, 'Activity Monitor'),
(76, 'GPS Tracker'),
(77, 'Activity Monitor'),
(78, 'GPS Tracker'),
(79, 'GPS Tracker'),
(80, 'Activity Monitor'),
(81, 'GPS Tracker'),
(82, 'Activity Monitor'),
(83, 'GPS Tracker'),
(84, 'GPS Tracker');

-- --------------------------------------------------------

--
-- Table structure for table `device_distribution`
--

CREATE TABLE `device_distribution` (
  `id` int NOT NULL,
  `Pet_id` int NOT NULL,
  `Device_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `device_distribution`
--

INSERT INTO `device_distribution` (`id`, `Pet_id`, `Device_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 11, 10),
(11, 13, 11),
(12, 15, 12);

-- --------------------------------------------------------

--
-- Table structure for table `ForumComment`
--

CREATE TABLE `ForumComment` (
  `id` int NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `likes` int DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `Users_id` int NOT NULL,
  `ForumPost_id` int NOT NULL,
  `ForumPost_Users_idUsers` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ForumPost`
--

CREATE TABLE `ForumPost` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `timestamp` timestamp NULL DEFAULT NULL,
  `likes` int DEFAULT NULL,
  `is_locked` varchar(45) DEFAULT NULL,
  `Users_idUsers` int NOT NULL,
  `Users_id` int NOT NULL,
  `ForumTopic_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `forumTopic`
--

CREATE TABLE `forumTopic` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `users_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `forumTopic`
--

INSERT INTO `forumTopic` (`id`, `title`, `description`, `users_id`) VALUES
(1, 'Dog Training Tips', 'Share your best dog training advice and techniques for common behavioral issues', 1),
(2, 'Healthy Pet Diets', 'Discuss the best food options for dogs and cats of all breeds', 3),
(3, 'Pet Adoption Stories', 'Share your heartwarming adoption journeys', 5),
(4, 'Best Walking Routes', 'Favorite parks and walking spots in your area', 7),
(5, 'Vet Recommendations', 'Looking for trustworthy vets in different cities', 9),
(6, 'Grooming Hacks', 'How to keep your pets clean, shiny, and happy', 11),
(7, 'Pet Safety at Home', 'Tips on keeping your pets safe indoors and outdoors', 13),
(8, 'Pet Travel Advice', 'Best ways to travel with your pets safely and comfortably', 15),
(9, 'Pet Tech Gadgets', 'Share reviews and discussions about smart collars and trackers', 2),
(10, 'Training Puppies', 'Dealing with chewing, potty training, and obedience basics', 4),
(11, 'Cat Behavior Explained', 'Understanding feline habits and moods', 6),
(12, 'Emergency Pet Care', 'How to act fast when your pet has an accident', 8);

-- --------------------------------------------------------

--
-- Table structure for table `Job`
--

CREATE TABLE `Job` (
  `id` int NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `pet_id` int DEFAULT NULL,
  `payment_status` int DEFAULT NULL,
  `price` float DEFAULT NULL,
  `caregiver_id` int DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `service_type` varchar(45) DEFAULT NULL,
  `message_id` int DEFAULT NULL,
  `Payment_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Job`
--

INSERT INTO `Job` (`id`, `location`, `user_id`, `pet_id`, `payment_status`, `price`, `caregiver_id`, `status`, `start_time`, `end_time`, `service_type`, `message_id`, `Payment_id`) VALUES
(1, 'New York, NY', 1, 1, 1, 50, 2, 'completed', '2024-11-01 08:00:00', '2024-11-01 11:00:00', 'Dog Walking', 1, 1),
(2, 'New York, NY', 1, 2, 1, 75, 4, 'completed', '2024-11-02 13:00:00', '2024-11-02 17:00:00', 'Pet Sitting', 2, 2),
(3, 'Chicago, IL', 3, 3, 1, 60, 2, 'completed', '2024-11-03 07:00:00', '2024-11-03 11:00:00', 'Pet Sitting', 3, 3),
(4, 'Phoenix, AZ', 5, 4, 1, 45, 6, 'completed', '2024-11-05 09:00:00', '2024-11-05 10:30:00', 'Dog Walking', 4, 4),
(5, 'San Antonio, TX', 7, 5, 1, 80, 8, 'in_progress', '2024-11-12 08:00:00', '2024-11-12 16:00:00', 'Pet Sitting', 5, 5),
(6, 'Dallas, TX', 9, 7, 1, 55, 10, 'completed', '2024-11-07 07:00:00', '2024-11-07 09:00:00', 'Dog Walking', 6, 6),
(7, 'Austin, TX', 11, 8, 1, 65, 12, 'completed', '2024-11-08 09:00:00', '2024-11-08 13:00:00', 'Pet Sitting', 7, 7),
(8, 'Phoenix, AZ', 5, 9, 1, 40, 6, 'completed', '2024-11-09 12:00:00', '2024-11-09 13:30:00', 'Dog Walking', 8, 8),
(9, 'Dallas, TX', 9, 11, 1, 70, 10, 'completed', '2024-11-10 14:00:00', '2024-11-10 18:00:00', 'Pet Sitting', 9, 9),
(10, 'San Jose, CA', 11, 13, 1, 85, 12, 'completed', '2024-11-11 08:00:00', '2024-11-11 12:00:00', 'Dog Walking', 10, 10),
(11, 'New York, NY', 1, 1, 1, 50, 2, 'scheduled', '2024-11-15 07:00:00', '2024-11-15 10:00:00', 'Dog Walking', 11, 11),
(12, 'Fort Worth, TX', 13, 10, 1, 95, 14, 'completed', '2024-11-12 11:00:00', '2024-11-12 17:00:00', 'Pet Sitting', 12, 12),
(13, 'Charlotte, NC', 15, 12, 1, 42, 14, 'completed', '2024-11-12 13:00:00', '2024-11-12 14:30:00', 'Dog Walking', 13, 13),
(14, 'Fort Worth, TX', 13, 15, 1, 58, 12, 'in_progress', '2024-11-12 15:00:00', '2024-11-12 18:00:00', 'Pet Sitting', 14, 14),
(15, 'San Antonio, TX', 7, 14, 1, 72, 8, 'scheduled', '2024-11-14 09:00:00', '2024-11-14 13:00:00', 'Pet Sitting', 15, 15);

-- --------------------------------------------------------

--
-- Table structure for table `Job_Agreement`
--

CREATE TABLE `Job_Agreement` (
  `id` int NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL,
  `Users_id` int NOT NULL,
  `Job_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Job_Agreement`
--

INSERT INTO `Job_Agreement` (`id`, `title`, `content`, `created_at`, `last_updated`, `Users_id`, `Job_id`) VALUES
(1, 'Walk Agreement - Max', 'Agreement for walking Max for 3 hours in Central Park', '2024-10-30 09:00:00', '2024-10-30 09:00:00', 1, 1),
(2, 'Sitting Agreement - Bella', 'Agreement for sitting Bella for 4 hours at owner home', '2024-10-31 11:00:00', '2024-10-31 11:00:00', 1, 2),
(3, 'Sitting Agreement - Luna', 'Agreement for sitting Luna for 4 hours with feeding', '2024-11-01 08:00:00', '2024-11-01 08:00:00', 3, 3),
(4, 'Walk Agreement - Rocky', 'Agreement for walking Rocky for 1.5 hours at park', '2024-11-03 07:00:00', '2024-11-03 07:00:00', 5, 4),
(5, 'Sitting Agreement - Daisy', 'Agreement for sitting Daisy for 8 hours with meals', '2024-11-10 06:00:00', '2024-11-10 06:00:00', 7, 5),
(6, 'Walk Agreement - Charlie', 'Agreement for walking Charlie for 2 hours morning', '2024-11-05 06:00:00', '2024-11-05 06:00:00', 9, 6),
(7, 'Sitting Agreement - Mittens', 'Agreement for sitting Mittens for 4 hours with play', '2024-11-06 08:00:00', '2024-11-06 08:00:00', 11, 7),
(8, 'Walk Agreement - Duke', 'Agreement for walking Duke for 1.5 hours afternoon', '2024-11-07 11:00:00', '2024-11-07 11:00:00', 5, 8),
(9, 'Sitting Agreement - Sadie', 'Agreement for sitting Sadie for 4 hours with training', '2024-11-08 13:00:00', '2024-11-08 13:00:00', 9, 9),
(10, 'Walk Agreement - Molly', 'Agreement for walking Molly for 4 hours with activities', '2024-11-09 07:00:00', '2024-11-09 07:00:00', 11, 10),
(11, 'Walk Agreement - Max #2', 'Agreement for walking Max for 3 hours next week', '2024-11-12 08:00:00', '2024-11-12 08:00:00', 1, 11),
(12, 'Sitting Agreement - Peanut', 'Agreement for sitting Peanut for 6 hours with care', '2024-11-11 10:00:00', '2024-11-11 10:00:00', 13, 12),
(13, 'Walk Agreement - Shadow', 'Agreement for walking Shadow for 1.5 hours evening', '2024-11-11 12:00:00', '2024-11-11 12:00:00', 15, 13),
(14, 'Sitting Agreement - Buddy', 'Agreement for sitting Buddy for 3 hours with medication', '2024-11-12 14:00:00', '2024-11-12 14:00:00', 13, 14),
(15, 'Sitting Agreement - Oliver', 'Agreement for sitting Oliver for 4 hours with grooming', '2024-11-13 08:00:00', '2024-11-13 08:00:00', 7, 15);

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE `Message` (
  `id` int NOT NULL,
  `sender_id` int DEFAULT NULL,
  `reciever_id` int DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `is_read` varchar(45) DEFAULT NULL,
  `Users_id` int NOT NULL,
  `Job_Agreement_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Message`
--

INSERT INTO `Message` (`id`, `sender_id`, `reciever_id`, `content`, `timestamp`, `is_read`, `Users_id`, `Job_Agreement_id`) VALUES
(1, 1, 2, 'Hi Sarah, can you walk Max tomorrow morning?', '2024-10-30 08:00:00', 'yes', 1, 1),
(2, 2, 1, 'Sure! I am available at 9 AM. See you then!', '2024-10-30 08:15:00', 'yes', 2, 1),
(3, 1, 4, 'Need pet sitting for Bella this weekend', '2024-10-31 10:00:00', 'yes', 1, 2),
(4, 4, 1, 'I can help! What time works best for you?', '2024-10-31 10:30:00', 'yes', 4, 2),
(5, 3, 2, 'Can you watch Luna on Friday afternoon?', '2024-11-01 07:00:00', 'yes', 3, 3),
(6, 2, 3, 'Yes, I would love to! Luna is adorable.', '2024-11-01 07:20:00', 'yes', 2, 3),
(7, 5, 6, 'Rocky needs a walk on Tuesday morning', '2024-11-03 06:30:00', 'yes', 5, 4),
(8, 6, 5, 'Perfect! I will be there at 10 AM sharp.', '2024-11-03 06:45:00', 'yes', 6, 4),
(9, 7, 8, 'Daisy needs sitting all day Saturday', '2024-11-10 05:30:00', 'yes', 7, 5),
(10, 8, 7, 'Sounds great! I will bring some treats for her.', '2024-11-10 05:50:00', 'yes', 8, 5),
(11, 9, 10, 'Charlie needs his morning walk on Thursday', '2024-11-05 05:00:00', 'yes', 9, 6),
(12, 10, 9, 'I can do that! See you at 8 AM.', '2024-11-05 05:15:00', 'yes', 10, 6),
(13, 11, 12, 'Mittens needs care while I am at work', '2024-11-06 07:00:00', 'yes', 11, 7),
(14, 12, 11, 'No problem! I will make sure she is comfortable.', '2024-11-06 07:20:00', 'yes', 12, 7),
(15, 5, 6, 'Duke needs an afternoon walk tomorrow', '2024-11-07 10:00:00', 'yes', 5, 8),
(16, 13, 14, 'Peanut needs full day care on Tuesday', '2024-11-11 09:00:00', 'yes', 13, 12),
(17, 14, 13, 'I will take excellent care of Peanut!', '2024-11-11 09:20:00', 'yes', 14, 12),
(18, 15, 14, 'Shadow needs an evening walk tonight', '2024-11-11 11:00:00', 'yes', 15, 13),
(19, 1, 2, 'Max loved his walk today! Thank you so much!', '2024-11-01 11:30:00', 'yes', 1, 1),
(20, 13, 12, 'Can you give Buddy his medication at 4 PM?', '2024-11-12 14:30:00', 'no', 13, 14);

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `id` int NOT NULL,
  `amount` float DEFAULT NULL,
  `method` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Payment`
--

INSERT INTO `Payment` (`id`, `amount`, `method`, `timestamp`) VALUES
(1, 50, 'Credit Card', '2024-11-01 13:30:00'),
(2, 75, 'PayPal', '2024-11-02 15:45:00'),
(3, 60, 'Credit Card', '2024-11-03 09:20:00'),
(4, 45, 'Debit Card', '2024-11-05 12:15:00'),
(5, 80, 'Credit Card', '2024-11-06 14:00:00'),
(6, 55, 'PayPal', '2024-11-07 08:30:00'),
(7, 65, 'Credit Card', '2024-11-08 10:45:00'),
(8, 40, 'Debit Card', '2024-11-09 13:00:00'),
(9, 70, 'Credit Card', '2024-11-10 15:30:00'),
(10, 85, 'PayPal', '2024-11-11 09:15:00'),
(11, 50, 'Credit Card', '2024-11-12 07:45:00'),
(12, 95, 'Credit Card', '2024-11-12 12:00:00'),
(13, 42, 'Debit Card', '2024-11-12 14:30:00'),
(14, 58, 'PayPal', '2024-11-12 16:00:00'),
(15, 72, 'Credit Card', '2024-11-12 17:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `Pet`
--

CREATE TABLE `Pet` (
  `id` int NOT NULL,
  `weight` float DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `photo_url` text,
  `is_active` varchar(45) DEFAULT NULL,
  `owner_id` int DEFAULT NULL,
  `vaccintation_status` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `Users_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Pet`
--

INSERT INTO `Pet` (`id`, `weight`, `name`, `age`, `breed`, `gender`, `height`, `photo_url`, `is_active`, `owner_id`, `vaccintation_status`, `color`, `Users_id`) VALUES
(1, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://cdn.example.com/pets/max.jpg', 'yes', 1, 'Up to date - Rabies, DHPP, Bordetella', 'Golden', 1),
(2, 15, 'Bella', 2, 'Beagle', 'Female', 15, 'https://cdn.example.com/pets/bella.jpg', 'yes', 1, 'Up to date - Rabies, DHPP', 'Tri-color', 1),
(3, 8.5, 'Luna', 1, 'Persian Cat', 'Female', 10, 'https://cdn.example.com/pets/luna.jpg', 'yes', 3, 'Up to date - FVRCP, Rabies', 'White', 3),
(4, 30, 'Rocky', 5, 'Labrador Retriever', 'Male', 22, 'https://cdn.example.com/pets/rocky.jpg', 'yes', 5, 'Up to date - Rabies, DHPP, Leptospirosis', 'Black', 5),
(5, 12, 'Daisy', 4, 'Cocker Spaniel', 'Female', 14, 'https://cdn.example.com/pets/daisy.jpg', 'yes', 7, 'Up to date - Rabies, DHPP', 'Brown and White', 7),
(6, 7, 'Whiskers', 2, 'Siamese Cat', 'Male', 9, 'https://cdn.example.com/pets/whiskers.jpg', 'yes', 3, 'Up to date - FVRCP, Rabies, FeLV', 'Seal Point', 3),
(7, 18.5, 'Charlie', 3, 'Australian Shepherd', 'Male', 20, 'https://cdn.example.com/pets/charlie.jpg', 'yes', 9, 'Up to date - Rabies, DHPP, Bordetella', 'Blue Merle', 9),
(8, 9.5, 'Mittens', 6, 'Maine Coon', 'Female', 11, 'https://cdn.example.com/pets/mittens.jpg', 'yes', 11, 'Up to date - FVRCP, Rabies', 'Tabby', 11),
(9, 22, 'Duke', 4, 'Boxer', 'Male', 21, 'https://cdn.example.com/pets/duke.jpg', 'yes', 5, 'Up to date - Rabies, DHPP', 'Fawn', 5),
(10, 5.5, 'Peanut', 1, 'Chihuahua', 'Male', 8, 'https://cdn.example.com/pets/peanut.jpg', 'yes', 13, 'Up to date - Rabies, DHPP', 'Tan', 13),
(11, 28, 'Sadie', 2, 'German Shepherd', 'Female', 23, 'https://cdn.example.com/pets/sadie.jpg', 'yes', 9, 'Up to date - Rabies, DHPP, Bordetella', 'Black and Tan', 9),
(12, 6, 'Shadow', 3, 'Domestic Shorthair', 'Male', 9, 'https://cdn.example.com/pets/shadow.jpg', 'yes', 15, 'Up to date - FVRCP, Rabies', 'Black', 15),
(13, 16, 'Molly', 5, 'Border Collie', 'Female', 19, 'https://cdn.example.com/pets/molly.jpg', 'yes', 11, 'Up to date - Rabies, DHPP', 'Black and White', 11),
(14, 10.5, 'Oliver', 2, 'British Shorthair', 'Male', 10.5, 'https://cdn.example.com/pets/oliver.jpg', 'yes', 7, 'Up to date - FVRCP, Rabies', 'Gray', 7),
(15, 20.5, 'Buddy', 6, 'English Bulldog', 'Male', 16, 'https://cdn.example.com/pets/buddy.jpg', 'yes', 13, 'Up to date - Rabies, DHPP', 'White and Brindle', 13),
(16, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg', 'yes', 1, 'up-to-date', 'Golden', 1),
(17, 12.3, 'Luna', 2, 'Beagle', 'Female', 15, 'https://images.dog.ceo/breeds/beagle/n02088364_100.jpg', 'yes', 3, 'up-to-date', 'Tri-color', 3),
(18, 45, 'Charlie', 5, 'Labrador', 'Male', 22.5, 'https://images.dog.ceo/breeds/labrador/n02099712_100.jpg', 'yes', 5, 'up-to-date', 'Black', 5),
(19, 8.5, 'Bella', 1, 'Chihuahua', 'Female', 8, 'https://images.dog.ceo/breeds/chihuahua/n02085620_100.jpg', 'yes', 7, 'due-soon', 'Fawn', 7),
(20, 32, 'Rocky', 4, 'German Shepherd', 'Male', 26, 'https://images.dog.ceo/breeds/germanshepherd/n02106662_100.jpg', 'yes', 9, 'up-to-date', 'Black and Tan', 9),
(21, 18.5, 'Daisy', 3, 'Cocker Spaniel', 'Female', 16, 'https://images.dog.ceo/breeds/spaniel-cocker/n02102318_100.jpg', 'yes', 11, 'up-to-date', 'Golden', 11),
(22, 55, 'Duke', 6, 'Rottweiler', 'Male', 27, 'https://images.dog.ceo/breeds/rottweiler/n02106550_100.jpg', 'yes', 13, 'up-to-date', 'Black and Tan', 13),
(23, 6.2, 'Molly', 2, 'Pomeranian', 'Female', 7, 'https://images.dog.ceo/breeds/pomeranian/n02112018_100.jpg', 'yes', 15, 'up-to-date', 'Orange', 15),
(24, 28, 'Cooper', 3, 'Border Collie', 'Male', 21, 'https://images.dog.ceo/breeds/collie-border/n02106166_100.jpg', 'yes', 1, 'up-to-date', 'Black and White', 1),
(25, 15.5, 'Sadie', 4, 'Shih Tzu', 'Female', 10.5, 'https://images.dog.ceo/breeds/shihtzu/n02086240_100.jpg', 'yes', 3, 'up-to-date', 'White and Gold', 3),
(26, 38, 'Bear', 5, 'Husky', 'Male', 23.5, 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg', 'yes', 5, 'up-to-date', 'Grey and White', 5),
(27, 20.5, 'Zoe', 2, 'Poodle', 'Female', 18, 'https://images.dog.ceo/breeds/poodle-standard/n02113799_100.jpg', 'yes', 7, 'up-to-date', 'White', 7),
(28, 42, 'Zeus', 4, 'Boxer', 'Male', 25, 'https://images.dog.ceo/breeds/boxer/n02108089_100.jpg', 'yes', 9, 'up-to-date', 'Brindle', 9),
(29, 10, 'Ruby', 1, 'Yorkshire Terrier', 'Female', 9, 'https://images.dog.ceo/breeds/terrier-yorkshire/n02094433_100.jpg', 'yes', 11, 'due-soon', 'Brown and Tan', 11),
(30, 30, 'Buddy', 3, 'Bulldog', 'Male', 16, 'https://images.dog.ceo/breeds/bulldog-english/n02109047_100.jpg', 'yes', 13, 'up-to-date', 'White and Brown', 13),
(31, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg', 'yes', 1, 'up-to-date', 'Golden', 1),
(32, 12.3, 'Luna', 2, 'Beagle', 'Female', 15, 'https://images.dog.ceo/breeds/beagle/n02088364_100.jpg', 'yes', 3, 'up-to-date', 'Tri-color', 3),
(33, 45, 'Charlie', 5, 'Labrador', 'Male', 22.5, 'https://images.dog.ceo/breeds/labrador/n02099712_100.jpg', 'yes', 5, 'up-to-date', 'Black', 5),
(34, 8.5, 'Bella', 1, 'Chihuahua', 'Female', 8, 'https://images.dog.ceo/breeds/chihuahua/n02085620_100.jpg', 'yes', 7, 'due-soon', 'Fawn', 7),
(35, 32, 'Rocky', 4, 'German Shepherd', 'Male', 26, 'https://images.dog.ceo/breeds/germanshepherd/n02106662_100.jpg', 'yes', 9, 'up-to-date', 'Black and Tan', 9),
(36, 18.5, 'Daisy', 3, 'Cocker Spaniel', 'Female', 16, 'https://images.dog.ceo/breeds/spaniel-cocker/n02102318_100.jpg', 'yes', 11, 'up-to-date', 'Golden', 11),
(37, 55, 'Duke', 6, 'Rottweiler', 'Male', 27, 'https://images.dog.ceo/breeds/rottweiler/n02106550_100.jpg', 'yes', 13, 'up-to-date', 'Black and Tan', 13),
(38, 6.2, 'Molly', 2, 'Pomeranian', 'Female', 7, 'https://images.dog.ceo/breeds/pomeranian/n02112018_100.jpg', 'yes', 15, 'up-to-date', 'Orange', 15),
(39, 28, 'Cooper', 3, 'Border Collie', 'Male', 21, 'https://images.dog.ceo/breeds/collie-border/n02106166_100.jpg', 'yes', 1, 'up-to-date', 'Black and White', 1),
(40, 15.5, 'Sadie', 4, 'Shih Tzu', 'Female', 10.5, 'https://images.dog.ceo/breeds/shihtzu/n02086240_100.jpg', 'yes', 3, 'up-to-date', 'White and Gold', 3),
(41, 38, 'Bear', 5, 'Husky', 'Male', 23.5, 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg', 'yes', 5, 'up-to-date', 'Grey and White', 5),
(42, 20.5, 'Zoe', 2, 'Poodle', 'Female', 18, 'https://images.dog.ceo/breeds/poodle-standard/n02113799_100.jpg', 'yes', 7, 'up-to-date', 'White', 7),
(43, 42, 'Zeus', 4, 'Boxer', 'Male', 25, 'https://images.dog.ceo/breeds/boxer/n02108089_100.jpg', 'yes', 9, 'up-to-date', 'Brindle', 9),
(44, 10, 'Ruby', 1, 'Yorkshire Terrier', 'Female', 9, 'https://images.dog.ceo/breeds/terrier-yorkshire/n02094433_100.jpg', 'yes', 11, 'due-soon', 'Brown and Tan', 11),
(45, 30, 'Buddy', 3, 'Bulldog', 'Male', 16, 'https://images.dog.ceo/breeds/bulldog-english/n02109047_100.jpg', 'yes', 13, 'up-to-date', 'White and Brown', 13),
(46, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg', 'yes', 1, 'up-to-date', 'Golden', 1),
(47, 12.3, 'Luna', 2, 'Beagle', 'Female', 15, 'https://images.dog.ceo/breeds/beagle/n02088364_100.jpg', 'yes', 3, 'up-to-date', 'Tri-color', 3),
(48, 45, 'Charlie', 5, 'Labrador', 'Male', 22.5, 'https://images.dog.ceo/breeds/labrador/n02099712_100.jpg', 'yes', 5, 'up-to-date', 'Black', 5),
(49, 8.5, 'Bella', 1, 'Chihuahua', 'Female', 8, 'https://images.dog.ceo/breeds/chihuahua/n02085620_100.jpg', 'yes', 7, 'due-soon', 'Fawn', 7),
(50, 32, 'Rocky', 4, 'German Shepherd', 'Male', 26, 'https://images.dog.ceo/breeds/germanshepherd/n02106662_100.jpg', 'yes', 9, 'up-to-date', 'Black and Tan', 9),
(51, 18.5, 'Daisy', 3, 'Cocker Spaniel', 'Female', 16, 'https://images.dog.ceo/breeds/spaniel-cocker/n02102318_100.jpg', 'yes', 11, 'up-to-date', 'Golden', 11),
(52, 55, 'Duke', 6, 'Rottweiler', 'Male', 27, 'https://images.dog.ceo/breeds/rottweiler/n02106550_100.jpg', 'yes', 13, 'up-to-date', 'Black and Tan', 13),
(53, 6.2, 'Molly', 2, 'Pomeranian', 'Female', 7, 'https://images.dog.ceo/breeds/pomeranian/n02112018_100.jpg', 'yes', 15, 'up-to-date', 'Orange', 15),
(54, 28, 'Cooper', 3, 'Border Collie', 'Male', 21, 'https://images.dog.ceo/breeds/collie-border/n02106166_100.jpg', 'yes', 1, 'up-to-date', 'Black and White', 1),
(55, 15.5, 'Sadie', 4, 'Shih Tzu', 'Female', 10.5, 'https://images.dog.ceo/breeds/shihtzu/n02086240_100.jpg', 'yes', 3, 'up-to-date', 'White and Gold', 3),
(56, 38, 'Bear', 5, 'Husky', 'Male', 23.5, 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg', 'yes', 5, 'up-to-date', 'Grey and White', 5),
(57, 20.5, 'Zoe', 2, 'Poodle', 'Female', 18, 'https://images.dog.ceo/breeds/poodle-standard/n02113799_100.jpg', 'yes', 7, 'up-to-date', 'White', 7),
(58, 42, 'Zeus', 4, 'Boxer', 'Male', 25, 'https://images.dog.ceo/breeds/boxer/n02108089_100.jpg', 'yes', 9, 'up-to-date', 'Brindle', 9),
(59, 10, 'Ruby', 1, 'Yorkshire Terrier', 'Female', 9, 'https://images.dog.ceo/breeds/terrier-yorkshire/n02094433_100.jpg', 'yes', 11, 'due-soon', 'Brown and Tan', 11),
(60, 30, 'Buddy', 3, 'Bulldog', 'Male', 16, 'https://images.dog.ceo/breeds/bulldog-english/n02109047_100.jpg', 'yes', 13, 'up-to-date', 'White and Brown', 13),
(61, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg', 'yes', 1, 'up-to-date', 'Golden', 1),
(62, 12.3, 'Luna', 2, 'Beagle', 'Female', 15, 'https://images.dog.ceo/breeds/beagle/n02088364_100.jpg', 'yes', 3, 'up-to-date', 'Tri-color', 3),
(63, 45, 'Charlie', 5, 'Labrador', 'Male', 22.5, 'https://images.dog.ceo/breeds/labrador/n02099712_100.jpg', 'yes', 5, 'up-to-date', 'Black', 5),
(64, 8.5, 'Bella', 1, 'Chihuahua', 'Female', 8, 'https://images.dog.ceo/breeds/chihuahua/n02085620_100.jpg', 'yes', 7, 'due-soon', 'Fawn', 7),
(65, 32, 'Rocky', 4, 'German Shepherd', 'Male', 26, 'https://images.dog.ceo/breeds/germanshepherd/n02106662_100.jpg', 'yes', 9, 'up-to-date', 'Black and Tan', 9),
(66, 18.5, 'Daisy', 3, 'Cocker Spaniel', 'Female', 16, 'https://images.dog.ceo/breeds/spaniel-cocker/n02102318_100.jpg', 'yes', 11, 'up-to-date', 'Golden', 11),
(67, 55, 'Duke', 6, 'Rottweiler', 'Male', 27, 'https://images.dog.ceo/breeds/rottweiler/n02106550_100.jpg', 'yes', 13, 'up-to-date', 'Black and Tan', 13),
(68, 6.2, 'Molly', 2, 'Pomeranian', 'Female', 7, 'https://images.dog.ceo/breeds/pomeranian/n02112018_100.jpg', 'yes', 15, 'up-to-date', 'Orange', 15),
(69, 28, 'Cooper', 3, 'Border Collie', 'Male', 21, 'https://images.dog.ceo/breeds/collie-border/n02106166_100.jpg', 'yes', 1, 'up-to-date', 'Black and White', 1),
(70, 15.5, 'Sadie', 4, 'Shih Tzu', 'Female', 10.5, 'https://images.dog.ceo/breeds/shihtzu/n02086240_100.jpg', 'yes', 3, 'up-to-date', 'White and Gold', 3),
(71, 38, 'Bear', 5, 'Husky', 'Male', 23.5, 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg', 'yes', 5, 'up-to-date', 'Grey and White', 5),
(72, 20.5, 'Zoe', 2, 'Poodle', 'Female', 18, 'https://images.dog.ceo/breeds/poodle-standard/n02113799_100.jpg', 'yes', 7, 'up-to-date', 'White', 7),
(73, 42, 'Zeus', 4, 'Boxer', 'Male', 25, 'https://images.dog.ceo/breeds/boxer/n02108089_100.jpg', 'yes', 9, 'up-to-date', 'Brindle', 9),
(74, 10, 'Ruby', 1, 'Yorkshire Terrier', 'Female', 9, 'https://images.dog.ceo/breeds/terrier-yorkshire/n02094433_100.jpg', 'yes', 11, 'due-soon', 'Brown and Tan', 11),
(75, 30, 'Buddy', 3, 'Bulldog', 'Male', 16, 'https://images.dog.ceo/breeds/bulldog-english/n02109047_100.jpg', 'yes', 13, 'up-to-date', 'White and Brown', 13),
(76, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg', 'yes', 1, 'up-to-date', 'Golden', 1),
(77, 12.3, 'Luna', 2, 'Beagle', 'Female', 15, 'https://images.dog.ceo/breeds/beagle/n02088364_100.jpg', 'yes', 3, 'up-to-date', 'Tri-color', 3),
(78, 45, 'Charlie', 5, 'Labrador', 'Male', 22.5, 'https://images.dog.ceo/breeds/labrador/n02099712_100.jpg', 'yes', 5, 'up-to-date', 'Black', 5),
(79, 8.5, 'Bella', 1, 'Chihuahua', 'Female', 8, 'https://images.dog.ceo/breeds/chihuahua/n02085620_100.jpg', 'yes', 7, 'due-soon', 'Fawn', 7),
(80, 32, 'Rocky', 4, 'German Shepherd', 'Male', 26, 'https://images.dog.ceo/breeds/germanshepherd/n02106662_100.jpg', 'yes', 9, 'up-to-date', 'Black and Tan', 9),
(81, 18.5, 'Daisy', 3, 'Cocker Spaniel', 'Female', 16, 'https://images.dog.ceo/breeds/spaniel-cocker/n02102318_100.jpg', 'yes', 11, 'up-to-date', 'Golden', 11),
(82, 55, 'Duke', 6, 'Rottweiler', 'Male', 27, 'https://images.dog.ceo/breeds/rottweiler/n02106550_100.jpg', 'yes', 13, 'up-to-date', 'Black and Tan', 13),
(83, 6.2, 'Molly', 2, 'Pomeranian', 'Female', 7, 'https://images.dog.ceo/breeds/pomeranian/n02112018_100.jpg', 'yes', 15, 'up-to-date', 'Orange', 15),
(84, 28, 'Cooper', 3, 'Border Collie', 'Male', 21, 'https://images.dog.ceo/breeds/collie-border/n02106166_100.jpg', 'yes', 1, 'up-to-date', 'Black and White', 1),
(85, 15.5, 'Sadie', 4, 'Shih Tzu', 'Female', 10.5, 'https://images.dog.ceo/breeds/shihtzu/n02086240_100.jpg', 'yes', 3, 'up-to-date', 'White and Gold', 3),
(86, 38, 'Bear', 5, 'Husky', 'Male', 23.5, 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg', 'yes', 5, 'up-to-date', 'Grey and White', 5),
(87, 20.5, 'Zoe', 2, 'Poodle', 'Female', 18, 'https://images.dog.ceo/breeds/poodle-standard/n02113799_100.jpg', 'yes', 7, 'up-to-date', 'White', 7),
(88, 42, 'Zeus', 4, 'Boxer', 'Male', 25, 'https://images.dog.ceo/breeds/boxer/n02108089_100.jpg', 'yes', 9, 'up-to-date', 'Brindle', 9),
(89, 10, 'Ruby', 1, 'Yorkshire Terrier', 'Female', 9, 'https://images.dog.ceo/breeds/terrier-yorkshire/n02094433_100.jpg', 'yes', 11, 'due-soon', 'Brown and Tan', 11),
(90, 30, 'Buddy', 3, 'Bulldog', 'Male', 16, 'https://images.dog.ceo/breeds/bulldog-english/n02109047_100.jpg', 'yes', 13, 'up-to-date', 'White and Brown', 13),
(91, 25.5, 'Max', 3, 'Golden Retriever', 'Male', 24, 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg', 'yes', 1, 'up-to-date', 'Golden', 1),
(92, 12.3, 'Luna', 2, 'Beagle', 'Female', 15, 'https://images.dog.ceo/breeds/beagle/n02088364_100.jpg', 'yes', 3, 'up-to-date', 'Tri-color', 3),
(93, 45, 'Charlie', 5, 'Labrador', 'Male', 22.5, 'https://images.dog.ceo/breeds/labrador/n02099712_100.jpg', 'yes', 5, 'up-to-date', 'Black', 5),
(94, 8.5, 'Bella', 1, 'Chihuahua', 'Female', 8, 'https://images.dog.ceo/breeds/chihuahua/n02085620_100.jpg', 'yes', 7, 'due-soon', 'Fawn', 7),
(95, 32, 'Rocky', 4, 'German Shepherd', 'Male', 26, 'https://images.dog.ceo/breeds/germanshepherd/n02106662_100.jpg', 'yes', 9, 'up-to-date', 'Black and Tan', 9),
(96, 18.5, 'Daisy', 3, 'Cocker Spaniel', 'Female', 16, 'https://images.dog.ceo/breeds/spaniel-cocker/n02102318_100.jpg', 'yes', 11, 'up-to-date', 'Golden', 11),
(97, 55, 'Duke', 6, 'Rottweiler', 'Male', 27, 'https://images.dog.ceo/breeds/rottweiler/n02106550_100.jpg', 'yes', 13, 'up-to-date', 'Black and Tan', 13),
(98, 6.2, 'Molly', 2, 'Pomeranian', 'Female', 7, 'https://images.dog.ceo/breeds/pomeranian/n02112018_100.jpg', 'yes', 15, 'up-to-date', 'Orange', 15),
(99, 28, 'Cooper', 3, 'Border Collie', 'Male', 21, 'https://images.dog.ceo/breeds/collie-border/n02106166_100.jpg', 'yes', 1, 'up-to-date', 'Black and White', 1),
(100, 15.5, 'Sadie', 4, 'Shih Tzu', 'Female', 10.5, 'https://images.dog.ceo/breeds/shihtzu/n02086240_100.jpg', 'yes', 3, 'up-to-date', 'White and Gold', 3),
(101, 38, 'Bear', 5, 'Husky', 'Male', 23.5, 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg', 'yes', 5, 'up-to-date', 'Grey and White', 5),
(102, 20.5, 'Zoe', 2, 'Poodle', 'Female', 18, 'https://images.dog.ceo/breeds/poodle-standard/n02113799_100.jpg', 'yes', 7, 'up-to-date', 'White', 7),
(103, 42, 'Zeus', 4, 'Boxer', 'Male', 25, 'https://images.dog.ceo/breeds/boxer/n02108089_100.jpg', 'yes', 9, 'up-to-date', 'Brindle', 9),
(104, 10, 'Ruby', 1, 'Yorkshire Terrier', 'Female', 9, 'https://images.dog.ceo/breeds/terrier-yorkshire/n02094433_100.jpg', 'yes', 11, 'due-soon', 'Brown and Tan', 11),
(105, 30, 'Buddy', 3, 'Bulldog', 'Male', 16, 'https://images.dog.ceo/breeds/bulldog-english/n02109047_100.jpg', 'yes', 13, 'up-to-date', 'White and Brown', 13);

-- --------------------------------------------------------

--
-- Table structure for table `Pet_tracking_data`
--

CREATE TABLE `Pet_tracking_data` (
  `id` int NOT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Pet_tracking_data`
--

INSERT INTO `Pet_tracking_data` (`id`, `latitude`, `longitude`, `timestamp`) VALUES
(1, '40.7128', '-74.0060', '2024-11-12 07:30:00'),
(2, '40.7138', '-74.0070', '2024-11-12 08:00:00'),
(3, '34.0522', '-118.2437', '2024-11-12 07:45:00'),
(4, '41.8781', '-87.6298', '2024-11-12 09:15:00'),
(5, '29.7604', '-95.3698', '2024-11-12 10:00:00'),
(6, '33.4484', '-112.0740', '2024-11-12 08:30:00'),
(7, '40.7148', '-74.0080', '2024-11-12 08:30:00'),
(8, '40.7158', '-74.0090', '2024-11-12 09:00:00'),
(9, '34.0532', '-118.2447', '2024-11-12 08:15:00'),
(10, '41.8791', '-87.6308', '2024-11-12 09:45:00'),
(11, '29.7614', '-95.3708', '2024-11-12 10:30:00'),
(12, '33.4494', '-112.0750', '2024-11-12 09:00:00'),
(13, '32.7767', '-96.7970', '2024-11-12 07:00:00'),
(14, '37.3382', '-121.8863', '2024-11-12 08:00:00'),
(15, '30.2672', '-97.7431', '2024-11-12 09:30:00'),
(16, '32.7777', '-96.7980', '2024-11-12 07:30:00'),
(17, '30.2682', '-97.7441', '2024-11-12 10:00:00'),
(18, '35.2271', '-80.8431', '2024-11-12 08:45:00'),
(19, '35.2281', '-80.8441', '2024-11-12 09:15:00'),
(20, '40.7168', '-74.0100', '2024-11-12 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE `Rating` (
  `id` int NOT NULL,
  `Feedback` text,
  `Stars` int DEFAULT NULL,
  `Users_id` int NOT NULL,
  `Job_Agreement_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`id`, `Feedback`, `Stars`, `Users_id`, `Job_Agreement_id`) VALUES
(1, 'Sarah was amazing with Max! Very professional and caring. Max came home happy and tired from all the exercise.', 5, 1, 1),
(2, 'Emily did a great job with Bella. Highly recommend! She sent updates throughout the day which was wonderful.', 5, 1, 2),
(3, 'Sarah took great care of Luna. Very happy with the service. Luna was calm and well-fed when I returned.', 5, 3, 3),
(4, 'Lisa was punctual and Rocky seemed very happy after the walk. Will definitely book again!', 4, 5, 4),
(5, 'Amanda is fantastic! Daisy loves her and the service was excellent. Very reliable and trustworthy.', 5, 7, 5),
(6, 'Jennifer was wonderful with Charlie. He got plenty of exercise and came home exhausted in the best way!', 5, 9, 6),
(7, 'Jessica provided excellent care for Mittens. Very attentive and sent lots of photos. Highly recommend!', 5, 11, 7),
(8, 'Lisa did a great job with Duke. He was well-exercised and happy. Professional service throughout.', 4, 5, 8),
(9, 'Jennifer was amazing with Sadie! She even worked on some training commands. Will book again for sure.', 5, 9, 9),
(10, 'Jessica was fantastic with Molly. Great communication and Molly had a wonderful time. Thank you!', 5, 11, 10),
(11, 'Ashley provided exceptional care for Peanut. Very gentle and understanding of his small size. Perfect!', 5, 13, 12),
(12, 'Ashley was great with Shadow. Quick walk but very thorough. Would definitely recommend to others!', 4, 15, 13);

-- --------------------------------------------------------

--
-- Table structure for table `Tracking`
--

CREATE TABLE `Tracking` (
  `id` int NOT NULL,
  `Pet_tracking_data_id` int NOT NULL,
  `Device_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Tracking`
--

INSERT INTO `Tracking` (`id`, `Pet_tracking_data_id`, `Device_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 1),
(8, 8, 2),
(9, 9, 3),
(10, 10, 4),
(11, 11, 5),
(12, 12, 6),
(13, 13, 7),
(14, 14, 10),
(15, 15, 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_picture` text,
  `postal_code` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `created_at`, `phone`, `password`, `city`, `role`, `email`, `profile_picture`, `postal_code`, `address`) VALUES
(1, 'John', 'Doe', '2024-01-15 09:30:00', '555-123-4567', '$2y$10$hash1234567890', 'New York', 'pet_owner', 'john.doe@email.com', 'https://cdn.example.com/profiles/user1.jpg', '10001', '123 Main St'),
(2, 'Sarah', 'Smith', '2024-01-20 13:45:00', '555-987-6543', '$2y$10$hash2345678901', 'Los Angeles', 'caregiver', 'sarah.smith@email.com', 'https://cdn.example.com/profiles/user2.jpg', '90001', '456 Oak Ave'),
(3, 'Mike', 'Johnson', '2024-02-01 08:15:00', '555-555-1234', '$2y$10$hash3456789012', 'Chicago', 'pet_owner', 'mike.j@email.com', 'https://cdn.example.com/profiles/user3.jpg', '60601', '789 Pine Rd'),
(4, 'Emily', 'Brown', '2024-02-10 15:20:00', '555-444-3333', '$2y$10$hash4567890123', 'Houston', 'caregiver', 'emily.b@email.com', 'https://cdn.example.com/profiles/user4.jpg', '77001', '321 Elm St'),
(5, 'David', 'Wilson', '2024-02-15 10:00:00', '555-666-7777', '$2y$10$hash5678901234', 'Phoenix', 'pet_owner', 'david.w@email.com', 'https://cdn.example.com/profiles/user5.jpg', '85001', '654 Maple Dr'),
(6, 'Lisa', 'Martinez', '2024-03-01 12:30:00', '555-888-9999', '$2y$10$hash6789012345', 'Philadelphia', 'caregiver', 'lisa.m@email.com', 'https://cdn.example.com/profiles/user6.jpg', '19019', '987 Cedar Ln'),
(7, 'James', 'Garcia', '2024-03-05 07:45:00', '555-222-3333', '$2y$10$hash7890123456', 'San Antonio', 'pet_owner', 'james.g@email.com', 'https://cdn.example.com/profiles/user7.jpg', '78201', '147 Birch Way'),
(8, 'Amanda', 'Lee', '2024-03-10 14:00:00', '555-777-8888', '$2y$10$hash8901234567', 'San Diego', 'caregiver', 'amanda.l@email.com', 'https://cdn.example.com/profiles/user8.jpg', '92101', '258 Willow Ct'),
(9, 'Robert', 'Taylor', '2024-03-15 11:00:00', '555-111-2222', '$2y$10$hash9012345678', 'Dallas', 'pet_owner', 'robert.t@email.com', 'https://cdn.example.com/profiles/user9.jpg', '75201', '369 Ash Blvd'),
(10, 'Jennifer', 'Anderson', '2024-03-20 09:30:00', '555-333-4444', '$2y$10$hash0123456789', 'San Jose', 'caregiver', 'jennifer.a@email.com', 'https://cdn.example.com/profiles/user10.jpg', '95101', '741 Spruce Ave'),
(11, 'Michael', 'Thomas', '2024-04-01 12:15:00', '555-555-6666', '$2y$10$hash1122334455', 'Austin', 'pet_owner', 'michael.t@email.com', 'https://cdn.example.com/profiles/user11.jpg', '73301', '852 Oak Park'),
(12, 'Jessica', 'White', '2024-04-05 07:00:00', '555-777-9999', '$2y$10$hash2233445566', 'Jacksonville', 'caregiver', 'jessica.w@email.com', 'https://cdn.example.com/profiles/user12.jpg', '32099', '963 Pine Circle'),
(13, 'Christopher', 'Harris', '2024-04-10 14:45:00', '555-999-1111', '$2y$10$hash3344556677', 'Fort Worth', 'pet_owner', 'chris.h@email.com', 'https://cdn.example.com/profiles/user13.jpg', '76101', '159 Maple Lane'),
(14, 'Ashley', 'Martin', '2024-04-15 09:30:00', '555-222-5555', '$2y$10$hash4455667788', 'Columbus', 'caregiver', 'ashley.m@email.com', 'https://cdn.example.com/profiles/user14.jpg', '43004', '357 Cedar Point'),
(15, 'Matthew', 'Thompson', '2024-04-20 11:00:00', '555-444-7777', '$2y$10$hash5566778899', 'Charlotte', 'pet_owner', 'matthew.t@email.com', 'https://cdn.example.com/profiles/user15.jpg', '28201', '486 Birch Street'),
(16, 'John', 'Smith', '2024-01-15 09:30:00', '555-0101', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'New York', 'owner', 'john.smith@email.com', 'https://i.pravatar.cc/150?img=1', '10001', '123 Main St'),
(17, 'Emma', 'Johnson', '2024-01-20 13:20:00', '555-0102', '$2y$10$bcdefghijklmnopqrstuvwxyza', 'Los Angeles', 'caregiver', 'emma.johnson@email.com', 'https://i.pravatar.cc/150?img=2', '90001', '456 Oak Ave'),
(18, 'Michael', 'Williams', '2024-02-01 08:15:00', '555-0103', '$2y$10$cdefghijklmnopqrstuvwxyzab', 'Chicago', 'owner', 'michael.w@email.com', 'https://i.pravatar.cc/150?img=3', '60601', '789 Pine Rd'),
(19, 'Sophia', 'Brown', '2024-02-10 10:45:00', '555-0104', '$2y$10$defghijklmnopqrstuvwxyzabc', 'Houston', 'caregiver', 'sophia.brown@email.com', 'https://i.pravatar.cc/150?img=4', '77001', '321 Elm St'),
(20, 'James', 'Davis', '2024-02-15 15:30:00', '555-0105', '$2y$10$efghijklmnopqrstuvwxyzabcd', 'Phoenix', 'owner', 'james.davis@email.com', 'https://i.pravatar.cc/150?img=5', '85001', '654 Maple Dr'),
(21, 'Olivia', 'Miller', '2024-03-01 07:00:00', '555-0106', '$2y$10$fghijklmnopqrstuvwxyzabcde', 'Philadelphia', 'caregiver', 'olivia.miller@email.com', 'https://i.pravatar.cc/150?img=6', '19101', '987 Cedar Ln'),
(22, 'William', 'Wilson', '2024-03-05 12:20:00', '555-0107', '$2y$10$ghijklmnopqrstuvwxyzabcdef', 'San Antonio', 'owner', 'william.wilson@email.com', 'https://i.pravatar.cc/150?img=7', '78201', '147 Birch Blvd'),
(23, 'Ava', 'Moore', '2024-03-10 09:10:00', '555-0108', '$2y$10$hijklmnopqrstuvwxyzabcdefg', 'San Diego', 'caregiver', 'ava.moore@email.com', 'https://i.pravatar.cc/150?img=8', '92101', '258 Spruce Way'),
(24, 'Benjamin', 'Taylor', '2024-03-20 14:45:00', '555-0109', '$2y$10$ijklmnopqrstuvwxyzabcdefgh', 'Dallas', 'owner', 'benjamin.t@email.com', 'https://i.pravatar.cc/150?img=9', '75201', '369 Willow Ct'),
(25, 'Isabella', 'Anderson', '2024-04-01 10:30:00', '555-0110', '$2y$10$jklmnopqrstuvwxyzabcdefghi', 'San Jose', 'caregiver', 'isabella.a@email.com', 'https://i.pravatar.cc/150?img=10', '95101', '741 Ash St'),
(26, 'Lucas', 'Thomas', '2024-04-10 07:00:00', '555-0111', '$2y$10$klmnopqrstuvwxyzabcdefghij', 'Austin', 'owner', 'lucas.thomas@email.com', 'https://i.pravatar.cc/150?img=11', '73301', '852 Poplar Ave'),
(27, 'Mia', 'Jackson', '2024-04-15 12:15:00', '555-0112', '$2y$10$lmnopqrstuvwxyzabcdefghijk', 'Jacksonville', 'caregiver', 'mia.jackson@email.com', 'https://i.pravatar.cc/150?img=12', '32099', '963 Cherry Rd'),
(28, 'Henry', 'White', '2024-05-01 09:00:00', '555-0113', '$2y$10$mnopqrstuvwxyzabcdefghijkl', 'Fort Worth', 'owner', 'henry.white@email.com', 'https://i.pravatar.cc/150?img=13', '76101', '159 Beech Dr'),
(29, 'Charlotte', 'Harris', '2024-05-10 14:20:00', '555-0114', '$2y$10$nopqrstuvwxyzabcdefghijklm', 'Columbus', 'caregiver', 'charlotte.h@email.com', 'https://i.pravatar.cc/150?img=14', '43004', '357 Hickory Ln'),
(30, 'Alexander', 'Martin', '2024-05-20 08:40:00', '555-0115', '$2y$10$opqrstuvwxyzabcdefghijklmn', 'Charlotte', 'owner', 'alex.martin@email.com', 'https://i.pravatar.cc/150?img=15', '28201', '486 Walnut Blvd'),
(31, 'John', 'Smith', '2024-01-15 09:30:00', '555-0101', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'New York', 'owner', 'john.smith@email.com', 'https://i.pravatar.cc/150?img=1', '10001', '123 Main St'),
(32, 'Emma', 'Johnson', '2024-01-20 13:20:00', '555-0102', '$2y$10$bcdefghijklmnopqrstuvwxyza', 'Los Angeles', 'caregiver', 'emma.johnson@email.com', 'https://i.pravatar.cc/150?img=2', '90001', '456 Oak Ave'),
(33, 'Michael', 'Williams', '2024-02-01 08:15:00', '555-0103', '$2y$10$cdefghijklmnopqrstuvwxyzab', 'Chicago', 'owner', 'michael.w@email.com', 'https://i.pravatar.cc/150?img=3', '60601', '789 Pine Rd'),
(34, 'Sophia', 'Brown', '2024-02-10 10:45:00', '555-0104', '$2y$10$defghijklmnopqrstuvwxyzabc', 'Houston', 'caregiver', 'sophia.brown@email.com', 'https://i.pravatar.cc/150?img=4', '77001', '321 Elm St'),
(35, 'James', 'Davis', '2024-02-15 15:30:00', '555-0105', '$2y$10$efghijklmnopqrstuvwxyzabcd', 'Phoenix', 'owner', 'james.davis@email.com', 'https://i.pravatar.cc/150?img=5', '85001', '654 Maple Dr'),
(36, 'Olivia', 'Miller', '2024-03-01 07:00:00', '555-0106', '$2y$10$fghijklmnopqrstuvwxyzabcde', 'Philadelphia', 'caregiver', 'olivia.miller@email.com', 'https://i.pravatar.cc/150?img=6', '19101', '987 Cedar Ln'),
(37, 'William', 'Wilson', '2024-03-05 12:20:00', '555-0107', '$2y$10$ghijklmnopqrstuvwxyzabcdef', 'San Antonio', 'owner', 'william.wilson@email.com', 'https://i.pravatar.cc/150?img=7', '78201', '147 Birch Blvd'),
(38, 'Ava', 'Moore', '2024-03-10 09:10:00', '555-0108', '$2y$10$hijklmnopqrstuvwxyzabcdefg', 'San Diego', 'caregiver', 'ava.moore@email.com', 'https://i.pravatar.cc/150?img=8', '92101', '258 Spruce Way'),
(39, 'Benjamin', 'Taylor', '2024-03-20 14:45:00', '555-0109', '$2y$10$ijklmnopqrstuvwxyzabcdefgh', 'Dallas', 'owner', 'benjamin.t@email.com', 'https://i.pravatar.cc/150?img=9', '75201', '369 Willow Ct'),
(40, 'Isabella', 'Anderson', '2024-04-01 10:30:00', '555-0110', '$2y$10$jklmnopqrstuvwxyzabcdefghi', 'San Jose', 'caregiver', 'isabella.a@email.com', 'https://i.pravatar.cc/150?img=10', '95101', '741 Ash St'),
(41, 'Lucas', 'Thomas', '2024-04-10 07:00:00', '555-0111', '$2y$10$klmnopqrstuvwxyzabcdefghij', 'Austin', 'owner', 'lucas.thomas@email.com', 'https://i.pravatar.cc/150?img=11', '73301', '852 Poplar Ave'),
(42, 'Mia', 'Jackson', '2024-04-15 12:15:00', '555-0112', '$2y$10$lmnopqrstuvwxyzabcdefghijk', 'Jacksonville', 'caregiver', 'mia.jackson@email.com', 'https://i.pravatar.cc/150?img=12', '32099', '963 Cherry Rd'),
(43, 'Henry', 'White', '2024-05-01 09:00:00', '555-0113', '$2y$10$mnopqrstuvwxyzabcdefghijkl', 'Fort Worth', 'owner', 'henry.white@email.com', 'https://i.pravatar.cc/150?img=13', '76101', '159 Beech Dr'),
(44, 'Charlotte', 'Harris', '2024-05-10 14:20:00', '555-0114', '$2y$10$nopqrstuvwxyzabcdefghijklm', 'Columbus', 'caregiver', 'charlotte.h@email.com', 'https://i.pravatar.cc/150?img=14', '43004', '357 Hickory Ln'),
(45, 'Alexander', 'Martin', '2024-05-20 08:40:00', '555-0115', '$2y$10$opqrstuvwxyzabcdefghijklmn', 'Charlotte', 'owner', 'alex.martin@email.com', 'https://i.pravatar.cc/150?img=15', '28201', '486 Walnut Blvd'),
(46, 'John', 'Smith', '2024-01-15 09:30:00', '555-0101', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'New York', 'owner', 'john.smith@email.com', 'https://i.pravatar.cc/150?img=1', '10001', '123 Main St'),
(47, 'Emma', 'Johnson', '2024-01-20 13:20:00', '555-0102', '$2y$10$bcdefghijklmnopqrstuvwxyza', 'Los Angeles', 'caregiver', 'emma.johnson@email.com', 'https://i.pravatar.cc/150?img=2', '90001', '456 Oak Ave'),
(48, 'Michael', 'Williams', '2024-02-01 08:15:00', '555-0103', '$2y$10$cdefghijklmnopqrstuvwxyzab', 'Chicago', 'owner', 'michael.w@email.com', 'https://i.pravatar.cc/150?img=3', '60601', '789 Pine Rd'),
(49, 'Sophia', 'Brown', '2024-02-10 10:45:00', '555-0104', '$2y$10$defghijklmnopqrstuvwxyzabc', 'Houston', 'caregiver', 'sophia.brown@email.com', 'https://i.pravatar.cc/150?img=4', '77001', '321 Elm St'),
(50, 'James', 'Davis', '2024-02-15 15:30:00', '555-0105', '$2y$10$efghijklmnopqrstuvwxyzabcd', 'Phoenix', 'owner', 'james.davis@email.com', 'https://i.pravatar.cc/150?img=5', '85001', '654 Maple Dr'),
(51, 'Olivia', 'Miller', '2024-03-01 07:00:00', '555-0106', '$2y$10$fghijklmnopqrstuvwxyzabcde', 'Philadelphia', 'caregiver', 'olivia.miller@email.com', 'https://i.pravatar.cc/150?img=6', '19101', '987 Cedar Ln'),
(52, 'William', 'Wilson', '2024-03-05 12:20:00', '555-0107', '$2y$10$ghijklmnopqrstuvwxyzabcdef', 'San Antonio', 'owner', 'william.wilson@email.com', 'https://i.pravatar.cc/150?img=7', '78201', '147 Birch Blvd'),
(53, 'Ava', 'Moore', '2024-03-10 09:10:00', '555-0108', '$2y$10$hijklmnopqrstuvwxyzabcdefg', 'San Diego', 'caregiver', 'ava.moore@email.com', 'https://i.pravatar.cc/150?img=8', '92101', '258 Spruce Way'),
(54, 'Benjamin', 'Taylor', '2024-03-20 14:45:00', '555-0109', '$2y$10$ijklmnopqrstuvwxyzabcdefgh', 'Dallas', 'owner', 'benjamin.t@email.com', 'https://i.pravatar.cc/150?img=9', '75201', '369 Willow Ct'),
(55, 'Isabella', 'Anderson', '2024-04-01 10:30:00', '555-0110', '$2y$10$jklmnopqrstuvwxyzabcdefghi', 'San Jose', 'caregiver', 'isabella.a@email.com', 'https://i.pravatar.cc/150?img=10', '95101', '741 Ash St'),
(56, 'Lucas', 'Thomas', '2024-04-10 07:00:00', '555-0111', '$2y$10$klmnopqrstuvwxyzabcdefghij', 'Austin', 'owner', 'lucas.thomas@email.com', 'https://i.pravatar.cc/150?img=11', '73301', '852 Poplar Ave'),
(57, 'Mia', 'Jackson', '2024-04-15 12:15:00', '555-0112', '$2y$10$lmnopqrstuvwxyzabcdefghijk', 'Jacksonville', 'caregiver', 'mia.jackson@email.com', 'https://i.pravatar.cc/150?img=12', '32099', '963 Cherry Rd'),
(58, 'Henry', 'White', '2024-05-01 09:00:00', '555-0113', '$2y$10$mnopqrstuvwxyzabcdefghijkl', 'Fort Worth', 'owner', 'henry.white@email.com', 'https://i.pravatar.cc/150?img=13', '76101', '159 Beech Dr'),
(59, 'Charlotte', 'Harris', '2024-05-10 14:20:00', '555-0114', '$2y$10$nopqrstuvwxyzabcdefghijklm', 'Columbus', 'caregiver', 'charlotte.h@email.com', 'https://i.pravatar.cc/150?img=14', '43004', '357 Hickory Ln'),
(60, 'Alexander', 'Martin', '2024-05-20 08:40:00', '555-0115', '$2y$10$opqrstuvwxyzabcdefghijklmn', 'Charlotte', 'owner', 'alex.martin@email.com', 'https://i.pravatar.cc/150?img=15', '28201', '486 Walnut Blvd'),
(61, 'John', 'Smith', '2024-01-15 09:30:00', '555-0101', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'New York', 'owner', 'john.smith@email.com', 'https://i.pravatar.cc/150?img=1', '10001', '123 Main St'),
(62, 'Emma', 'Johnson', '2024-01-20 13:20:00', '555-0102', '$2y$10$bcdefghijklmnopqrstuvwxyza', 'Los Angeles', 'caregiver', 'emma.johnson@email.com', 'https://i.pravatar.cc/150?img=2', '90001', '456 Oak Ave'),
(63, 'Michael', 'Williams', '2024-02-01 08:15:00', '555-0103', '$2y$10$cdefghijklmnopqrstuvwxyzab', 'Chicago', 'owner', 'michael.w@email.com', 'https://i.pravatar.cc/150?img=3', '60601', '789 Pine Rd'),
(64, 'Sophia', 'Brown', '2024-02-10 10:45:00', '555-0104', '$2y$10$defghijklmnopqrstuvwxyzabc', 'Houston', 'caregiver', 'sophia.brown@email.com', 'https://i.pravatar.cc/150?img=4', '77001', '321 Elm St'),
(65, 'James', 'Davis', '2024-02-15 15:30:00', '555-0105', '$2y$10$efghijklmnopqrstuvwxyzabcd', 'Phoenix', 'owner', 'james.davis@email.com', 'https://i.pravatar.cc/150?img=5', '85001', '654 Maple Dr'),
(66, 'Olivia', 'Miller', '2024-03-01 07:00:00', '555-0106', '$2y$10$fghijklmnopqrstuvwxyzabcde', 'Philadelphia', 'caregiver', 'olivia.miller@email.com', 'https://i.pravatar.cc/150?img=6', '19101', '987 Cedar Ln'),
(67, 'William', 'Wilson', '2024-03-05 12:20:00', '555-0107', '$2y$10$ghijklmnopqrstuvwxyzabcdef', 'San Antonio', 'owner', 'william.wilson@email.com', 'https://i.pravatar.cc/150?img=7', '78201', '147 Birch Blvd'),
(68, 'Ava', 'Moore', '2024-03-10 09:10:00', '555-0108', '$2y$10$hijklmnopqrstuvwxyzabcdefg', 'San Diego', 'caregiver', 'ava.moore@email.com', 'https://i.pravatar.cc/150?img=8', '92101', '258 Spruce Way'),
(69, 'Benjamin', 'Taylor', '2024-03-20 14:45:00', '555-0109', '$2y$10$ijklmnopqrstuvwxyzabcdefgh', 'Dallas', 'owner', 'benjamin.t@email.com', 'https://i.pravatar.cc/150?img=9', '75201', '369 Willow Ct'),
(70, 'Isabella', 'Anderson', '2024-04-01 10:30:00', '555-0110', '$2y$10$jklmnopqrstuvwxyzabcdefghi', 'San Jose', 'caregiver', 'isabella.a@email.com', 'https://i.pravatar.cc/150?img=10', '95101', '741 Ash St'),
(71, 'Lucas', 'Thomas', '2024-04-10 07:00:00', '555-0111', '$2y$10$klmnopqrstuvwxyzabcdefghij', 'Austin', 'owner', 'lucas.thomas@email.com', 'https://i.pravatar.cc/150?img=11', '73301', '852 Poplar Ave'),
(72, 'Mia', 'Jackson', '2024-04-15 12:15:00', '555-0112', '$2y$10$lmnopqrstuvwxyzabcdefghijk', 'Jacksonville', 'caregiver', 'mia.jackson@email.com', 'https://i.pravatar.cc/150?img=12', '32099', '963 Cherry Rd'),
(73, 'Henry', 'White', '2024-05-01 09:00:00', '555-0113', '$2y$10$mnopqrstuvwxyzabcdefghijkl', 'Fort Worth', 'owner', 'henry.white@email.com', 'https://i.pravatar.cc/150?img=13', '76101', '159 Beech Dr'),
(74, 'Charlotte', 'Harris', '2024-05-10 14:20:00', '555-0114', '$2y$10$nopqrstuvwxyzabcdefghijklm', 'Columbus', 'caregiver', 'charlotte.h@email.com', 'https://i.pravatar.cc/150?img=14', '43004', '357 Hickory Ln'),
(75, 'Alexander', 'Martin', '2024-05-20 08:40:00', '555-0115', '$2y$10$opqrstuvwxyzabcdefghijklmn', 'Charlotte', 'owner', 'alex.martin@email.com', 'https://i.pravatar.cc/150?img=15', '28201', '486 Walnut Blvd'),
(76, 'John', 'Smith', '2024-01-15 09:30:00', '555-0101', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'New York', 'owner', 'john.smith@email.com', 'https://i.pravatar.cc/150?img=1', '10001', '123 Main St'),
(77, 'Emma', 'Johnson', '2024-01-20 13:20:00', '555-0102', '$2y$10$bcdefghijklmnopqrstuvwxyza', 'Los Angeles', 'caregiver', 'emma.johnson@email.com', 'https://i.pravatar.cc/150?img=2', '90001', '456 Oak Ave'),
(78, 'Michael', 'Williams', '2024-02-01 08:15:00', '555-0103', '$2y$10$cdefghijklmnopqrstuvwxyzab', 'Chicago', 'owner', 'michael.w@email.com', 'https://i.pravatar.cc/150?img=3', '60601', '789 Pine Rd'),
(79, 'Sophia', 'Brown', '2024-02-10 10:45:00', '555-0104', '$2y$10$defghijklmnopqrstuvwxyzabc', 'Houston', 'caregiver', 'sophia.brown@email.com', 'https://i.pravatar.cc/150?img=4', '77001', '321 Elm St'),
(80, 'James', 'Davis', '2024-02-15 15:30:00', '555-0105', '$2y$10$efghijklmnopqrstuvwxyzabcd', 'Phoenix', 'owner', 'james.davis@email.com', 'https://i.pravatar.cc/150?img=5', '85001', '654 Maple Dr'),
(81, 'Olivia', 'Miller', '2024-03-01 07:00:00', '555-0106', '$2y$10$fghijklmnopqrstuvwxyzabcde', 'Philadelphia', 'caregiver', 'olivia.miller@email.com', 'https://i.pravatar.cc/150?img=6', '19101', '987 Cedar Ln'),
(82, 'William', 'Wilson', '2024-03-05 12:20:00', '555-0107', '$2y$10$ghijklmnopqrstuvwxyzabcdef', 'San Antonio', 'owner', 'william.wilson@email.com', 'https://i.pravatar.cc/150?img=7', '78201', '147 Birch Blvd'),
(83, 'Ava', 'Moore', '2024-03-10 09:10:00', '555-0108', '$2y$10$hijklmnopqrstuvwxyzabcdefg', 'San Diego', 'caregiver', 'ava.moore@email.com', 'https://i.pravatar.cc/150?img=8', '92101', '258 Spruce Way'),
(84, 'Benjamin', 'Taylor', '2024-03-20 14:45:00', '555-0109', '$2y$10$ijklmnopqrstuvwxyzabcdefgh', 'Dallas', 'owner', 'benjamin.t@email.com', 'https://i.pravatar.cc/150?img=9', '75201', '369 Willow Ct'),
(85, 'Isabella', 'Anderson', '2024-04-01 10:30:00', '555-0110', '$2y$10$jklmnopqrstuvwxyzabcdefghi', 'San Jose', 'caregiver', 'isabella.a@email.com', 'https://i.pravatar.cc/150?img=10', '95101', '741 Ash St'),
(86, 'Lucas', 'Thomas', '2024-04-10 07:00:00', '555-0111', '$2y$10$klmnopqrstuvwxyzabcdefghij', 'Austin', 'owner', 'lucas.thomas@email.com', 'https://i.pravatar.cc/150?img=11', '73301', '852 Poplar Ave'),
(87, 'Mia', 'Jackson', '2024-04-15 12:15:00', '555-0112', '$2y$10$lmnopqrstuvwxyzabcdefghijk', 'Jacksonville', 'caregiver', 'mia.jackson@email.com', 'https://i.pravatar.cc/150?img=12', '32099', '963 Cherry Rd'),
(88, 'Henry', 'White', '2024-05-01 09:00:00', '555-0113', '$2y$10$mnopqrstuvwxyzabcdefghijkl', 'Fort Worth', 'owner', 'henry.white@email.com', 'https://i.pravatar.cc/150?img=13', '76101', '159 Beech Dr'),
(89, 'Charlotte', 'Harris', '2024-05-10 14:20:00', '555-0114', '$2y$10$nopqrstuvwxyzabcdefghijklm', 'Columbus', 'caregiver', 'charlotte.h@email.com', 'https://i.pravatar.cc/150?img=14', '43004', '357 Hickory Ln'),
(90, 'Alexander', 'Martin', '2024-05-20 08:40:00', '555-0115', '$2y$10$opqrstuvwxyzabcdefghijklmn', 'Charlotte', 'owner', 'alex.martin@email.com', 'https://i.pravatar.cc/150?img=15', '28201', '486 Walnut Blvd'),
(91, 'John', 'Smith', '2024-01-15 09:30:00', '555-0101', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'New York', 'owner', 'john.smith@email.com', 'https://i.pravatar.cc/150?img=1', '10001', '123 Main St'),
(92, 'Emma', 'Johnson', '2024-01-20 13:20:00', '555-0102', '$2y$10$bcdefghijklmnopqrstuvwxyza', 'Los Angeles', 'caregiver', 'emma.johnson@email.com', 'https://i.pravatar.cc/150?img=2', '90001', '456 Oak Ave'),
(93, 'Michael', 'Williams', '2024-02-01 08:15:00', '555-0103', '$2y$10$cdefghijklmnopqrstuvwxyzab', 'Chicago', 'owner', 'michael.w@email.com', 'https://i.pravatar.cc/150?img=3', '60601', '789 Pine Rd'),
(94, 'Sophia', 'Brown', '2024-02-10 10:45:00', '555-0104', '$2y$10$defghijklmnopqrstuvwxyzabc', 'Houston', 'caregiver', 'sophia.brown@email.com', 'https://i.pravatar.cc/150?img=4', '77001', '321 Elm St'),
(95, 'James', 'Davis', '2024-02-15 15:30:00', '555-0105', '$2y$10$efghijklmnopqrstuvwxyzabcd', 'Phoenix', 'owner', 'james.davis@email.com', 'https://i.pravatar.cc/150?img=5', '85001', '654 Maple Dr'),
(96, 'Olivia', 'Miller', '2024-03-01 07:00:00', '555-0106', '$2y$10$fghijklmnopqrstuvwxyzabcde', 'Philadelphia', 'caregiver', 'olivia.miller@email.com', 'https://i.pravatar.cc/150?img=6', '19101', '987 Cedar Ln'),
(97, 'William', 'Wilson', '2024-03-05 12:20:00', '555-0107', '$2y$10$ghijklmnopqrstuvwxyzabcdef', 'San Antonio', 'owner', 'william.wilson@email.com', 'https://i.pravatar.cc/150?img=7', '78201', '147 Birch Blvd'),
(98, 'Ava', 'Moore', '2024-03-10 09:10:00', '555-0108', '$2y$10$hijklmnopqrstuvwxyzabcdefg', 'San Diego', 'caregiver', 'ava.moore@email.com', 'https://i.pravatar.cc/150?img=8', '92101', '258 Spruce Way'),
(99, 'Benjamin', 'Taylor', '2024-03-20 14:45:00', '555-0109', '$2y$10$ijklmnopqrstuvwxyzabcdefgh', 'Dallas', 'owner', 'benjamin.t@email.com', 'https://i.pravatar.cc/150?img=9', '75201', '369 Willow Ct'),
(100, 'Isabella', 'Anderson', '2024-04-01 10:30:00', '555-0110', '$2y$10$jklmnopqrstuvwxyzabcdefghi', 'San Jose', 'caregiver', 'isabella.a@email.com', 'https://i.pravatar.cc/150?img=10', '95101', '741 Ash St'),
(101, 'Lucas', 'Thomas', '2024-04-10 07:00:00', '555-0111', '$2y$10$klmnopqrstuvwxyzabcdefghij', 'Austin', 'owner', 'lucas.thomas@email.com', 'https://i.pravatar.cc/150?img=11', '73301', '852 Poplar Ave'),
(102, 'Mia', 'Jackson', '2024-04-15 12:15:00', '555-0112', '$2y$10$lmnopqrstuvwxyzabcdefghijk', 'Jacksonville', 'caregiver', 'mia.jackson@email.com', 'https://i.pravatar.cc/150?img=12', '32099', '963 Cherry Rd'),
(103, 'Henry', 'White', '2024-05-01 09:00:00', '555-0113', '$2y$10$mnopqrstuvwxyzabcdefghijkl', 'Fort Worth', 'owner', 'henry.white@email.com', 'https://i.pravatar.cc/150?img=13', '76101', '159 Beech Dr'),
(104, 'Charlotte', 'Harris', '2024-05-10 14:20:00', '555-0114', '$2y$10$nopqrstuvwxyzabcdefghijklm', 'Columbus', 'caregiver', 'charlotte.h@email.com', 'https://i.pravatar.cc/150?img=14', '43004', '357 Hickory Ln'),
(105, 'Alexander', 'Martin', '2024-05-20 08:40:00', '555-0115', '$2y$10$opqrstuvwxyzabcdefghijklmn', 'Charlotte', 'owner', 'alex.martin@email.com', 'https://i.pravatar.cc/150?img=15', '28201', '486 Walnut Blvd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Device`
--
ALTER TABLE `Device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_distribution`
--
ALTER TABLE `device_distribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_device_distribution_Pet1_idx` (`Pet_id`),
  ADD KEY `fk_device_distribution_Device1_idx` (`Device_id`);

--
-- Indexes for table `ForumComment`
--
ALTER TABLE `ForumComment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ForumComment_Users1_idx` (`Users_id`),
  ADD KEY `fk_ForumComment_ForumPost1_idx` (`ForumPost_id`,`ForumPost_Users_idUsers`);

--
-- Indexes for table `ForumPost`
--
ALTER TABLE `ForumPost`
  ADD PRIMARY KEY (`id`,`Users_idUsers`),
  ADD KEY `fk_ForumPost_Users1_idx` (`Users_id`),
  ADD KEY `fk_ForumPost_ForumTopic1_idx` (`ForumTopic_id`);

--
-- Indexes for table `forumTopic`
--
ALTER TABLE `forumTopic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_forumTopic_users1_idx` (`users_id`);

--
-- Indexes for table `Job`
--
ALTER TABLE `Job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Job_Payment1_idx` (`Payment_id`);

--
-- Indexes for table `Job_Agreement`
--
ALTER TABLE `Job_Agreement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Job_Agreement_Users1_idx` (`Users_id`),
  ADD KEY `fk_Job_Agreement_Job1_idx` (`Job_id`);

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Message_Users1_idx` (`Users_id`),
  ADD KEY `fk_Message_Job_Agreement1_idx` (`Job_Agreement_id`);

--
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Pet`
--
ALTER TABLE `Pet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Pet_Users1_idx` (`Users_id`);

--
-- Indexes for table `Pet_tracking_data`
--
ALTER TABLE `Pet_tracking_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Rating_Users1_idx` (`Users_id`),
  ADD KEY `fk_Rating_Job_Agreement1_idx` (`Job_Agreement_id`);

--
-- Indexes for table `Tracking`
--
ALTER TABLE `Tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Tracking_Pet_tracking_data1_idx` (`Pet_tracking_data_id`),
  ADD KEY `fk_Tracking_Device1_idx` (`Device_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Device`
--
ALTER TABLE `Device`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `ForumComment`
--
ALTER TABLE `ForumComment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumPost`
--
ALTER TABLE `ForumPost`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumTopic`
--
ALTER TABLE `forumTopic`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Job`
--
ALTER TABLE `Job`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Job_Agreement`
--
ALTER TABLE `Job_Agreement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Message`
--
ALTER TABLE `Message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Pet`
--
ALTER TABLE `Pet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `Rating`
--
ALTER TABLE `Rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Tracking`
--
ALTER TABLE `Tracking`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `device_distribution`
--
ALTER TABLE `device_distribution`
  ADD CONSTRAINT `fk_device_distribution_Device1` FOREIGN KEY (`Device_id`) REFERENCES `Device` (`id`),
  ADD CONSTRAINT `fk_device_distribution_Pet1` FOREIGN KEY (`Pet_id`) REFERENCES `Pet` (`id`);

--
-- Constraints for table `ForumComment`
--
ALTER TABLE `ForumComment`
  ADD CONSTRAINT `fk_ForumComment_ForumPost1` FOREIGN KEY (`ForumPost_id`,`ForumPost_Users_idUsers`) REFERENCES `ForumPost` (`id`, `Users_idUsers`),
  ADD CONSTRAINT `fk_ForumComment_Users1` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ForumPost`
--
ALTER TABLE `ForumPost`
  ADD CONSTRAINT `fk_ForumPost_ForumTopic1` FOREIGN KEY (`ForumTopic_id`) REFERENCES `forumTopic` (`id`),
  ADD CONSTRAINT `fk_ForumPost_Users1` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `forumTopic`
--
ALTER TABLE `forumTopic`
  ADD CONSTRAINT `fk_forumTopic_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `Job`
--
ALTER TABLE `Job`
  ADD CONSTRAINT `fk_Job_Payment1` FOREIGN KEY (`Payment_id`) REFERENCES `Payment` (`id`);

--
-- Constraints for table `Job_Agreement`
--
ALTER TABLE `Job_Agreement`
  ADD CONSTRAINT `fk_Job_Agreement_Job1` FOREIGN KEY (`Job_id`) REFERENCES `Job` (`id`),
  ADD CONSTRAINT `fk_Job_Agreement_Users1` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `fk_Message_Job_Agreement1` FOREIGN KEY (`Job_Agreement_id`) REFERENCES `Job_Agreement` (`id`),
  ADD CONSTRAINT `fk_Message_Users1` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `Pet`
--
ALTER TABLE `Pet`
  ADD CONSTRAINT `fk_Pet_Users1` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
  ADD CONSTRAINT `fk_Rating_Job_Agreement1` FOREIGN KEY (`Job_Agreement_id`) REFERENCES `Job_Agreement` (`id`),
  ADD CONSTRAINT `fk_Rating_Users1` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `Tracking`
--
ALTER TABLE `Tracking`
  ADD CONSTRAINT `fk_Tracking_Device1` FOREIGN KEY (`Device_id`) REFERENCES `Device` (`id`),
  ADD CONSTRAINT `fk_Tracking_Pet_tracking_data1` FOREIGN KEY (`Pet_tracking_data_id`) REFERENCES `Pet_tracking_data` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
