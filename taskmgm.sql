-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 05:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmgm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_desc` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT NULL,
  `workgroup` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('team_leader','team_member') NOT NULL,
  `workgroup` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `workgroup`, `created_at`) VALUES
(1, 'Akshay', 'akshaykomade012345@gmail.com', '9099142433', '$2y$10$D/QbWEN8wA0V39efsXMS9uDt7NvQw8lJteQIV/pNtHmsegp55/tEO', 'team_leader', 0, '2024-09-20 07:47:55'),
(2, 'yash', 'yash@gmail.com', '9099142433', '$2y$10$EwEBOxYq.SEZJAOryaHK3.ZuYOT/eDCDzkWLEnS4UWloUSatWuuuO', 'team_leader', 0, '2024-09-20 07:54:38'),
(4, 'yash', 'test@gmail.com', '9099142433', '$2y$10$.vsmch38ZzOz.H4DDXq9VOIAC8S.2i8bKKFV.QSPK8KWXGTK8upta', 'team_leader', 0, '2024-09-20 07:57:50'),
(5, 'Member', 'member@gmail.com', '923533455', 'asdasd', 'team_member', 5, '2024-09-22 09:39:22'),
(18, 'akshay', 'akshay123@gmail.com', '9173910948', '$2y$10$m6zkwGzlM24sGkfH.FGAxOEsE3eloH7FA0Yb2Q0rbyHEggfQr.Zq.', 'team_member', 5, '2024-09-23 11:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `workgroups`
--

CREATE TABLE `workgroups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `invite_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workgroups`
--

INSERT INTO `workgroups` (`id`, `name`, `invite_code`, `created_at`) VALUES
(5, 'UnityZ', 'HR9CjwDC', '2024-09-22 09:20:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `fk_task_1` (`workgroup`),
  ADD KEY `fk_task_2` (`assigned_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workgroups`
--
ALTER TABLE `workgroups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `workgroups`
--
ALTER TABLE `workgroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_task_1` FOREIGN KEY (`workgroup`) REFERENCES `workgroups` (`id`),
  ADD CONSTRAINT `fk_task_2` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
