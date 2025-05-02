Sustain Energy

**Sustain Energy** is a sustainability-focused web platform designed as part of a Graded Unit 2 project for the HND in Software Development. The site encourages businesses to evaluate and improve their environmental impact through features like a green calculator, certification, voucher redemption, and user management.

Features

**User Registration & Login**
**Green Calculator** – Assess company sustainability and receive a Bronze, Silver, or Gold certificate.
**Card Registration** – Securely store cardholder details (not used for real transactions).
**Voucher Shop** – Offset green shortfalls by purchasing eco vouchers.
**Certificate Generator** – Download personalized sustainability certificates as PDFs.
**User Dashboard** – View past scores, voucher purchases, and subscription info.
**Feedback Form** – Users can provide input to help improve the platform.

---

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP (Procedural)
- **Database**: MySQL (via phpMyAdmin)
- **Local Server**: XAMPP
- **PDF Generation**: FPDF (PHP library)

---

## File Structure Overview

/images		//for any images loaded onto the website
-logo.png
/includes
-footer.php
/libs		//contains the pdf generator file as well as available fonts
-/font
--courier.php
-fpdf.php
/requires
-connect_db.php		//connection to the database
-nav.php
/uploads		//stores the profile pictures a user uploads
-user_logo.php
about.png
calculator.png
contact.png
endorsements.php
forgot_password.php
generate_certificate.php
index.php
login.php
logout.php
manage_card.php
privacy.php
register_card.php
register.php
shop.php
style.css
subscribe.php
sustainability.php
template.php
terms.php
update_user.php
upload_logo.php
user_account.php

---

## Setup Instructions

1. **Clone or download the repository**  
   You can run it locally inside your XAMPP environment:
git clone https://github.com/yourusername/sustain-energy.git

2. **Move the project folder to your XAMPP directory**  
Typically:
C:\xampp\htdocs\sustain-energy

3. **Start Apache and MySQL using XAMPP Control Panel**

4. **Import the MySQL database**
- Open phpMyAdmin
- Create a new database (e.g., `sustainenergydb`)
- Copy this database prompt in sql
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 11:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sustainenergydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `calculator_results`
--

CREATE TABLE `calculator_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `certificate_level` enum('Gold','Silver','Bronze') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calculator_results`
--

INSERT INTO `calculator_results` (`id`, `user_id`, `year`, `total_score`, `certificate_level`, `created_at`) VALUES
(28, 1, '2025', 0, 'Bronze', '2025-04-22 22:33:41'),
(29, 2, '2025', 70, 'Gold', '2025-04-30 23:19:15'),
(31, 7, '2025', 30, 'Bronze', '2025-05-02 19:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cardholder_name` varchar(100) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `expiry_date` varchar(7) DEFAULT NULL,
  `cvv` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `cardholder_name`, `card_number`, `expiry_date`, `cvv`) VALUES
(13, 1, 'test', '2222222222222222', '12/27', '123'),
(14, 2, 'test2', '1111111111111111', '12/27', '123'),
(15, 7, 'jg', '1111111111111111', '12/27', '333');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `phone`, `message`, `submitted_at`, `user_id`) VALUES
(1, 'test', 'test@test.com', 'test', 'test', '2025-04-23 00:03:13', NULL),
(2, 'test', 'test@test.com', '1234', 'test', '2025-04-23 00:07:19', NULL),
(3, 'test', 'test@test.com', '1234', 'test', '2025-04-23 00:09:10', NULL),
(4, 'test2', 'test2@test2.com', '0131', 'hello', '2025-05-01 17:37:15', NULL),
(5, 'test2', 'test2@test2.com', '0131', 'hello 2', '2025-05-01 17:42:16', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL DEFAULT curdate(),
  `end_date` date GENERATED ALWAYS AS (`start_date` + interval 1 year) STORED,
  `price` decimal(6,2) NOT NULL DEFAULT 99.00,
  `status` enum('active','expired','cancelled') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `start_date`, `price`, `status`) VALUES
(5, 2, '2025-05-01', 99.00, 'active'),
(6, 7, '2025-05-02', 99.00, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `join_date` date DEFAULT curdate(),
  `status` enum('active','inactive','deactivated') DEFAULT 'active',
  `company_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_name`, `contact_name`, `email`, `password_hash`, `phone`, `join_date`, `status`, `company_logo`) VALUES
(1, 'test', 'test', 'test@test.com', '$2y$10$TxGABBYV5y6wImtQnuuavuV4q0ueVD5kxLHnnllxej7inQ7uh/cEO', '1234', '2025-04-15', 'active', '5.png'),
(2, 'test2', 'test2', 'test2@test2.com', '$2y$10$.xTu6GE3Ip9YcEWkwfhuve5AY47MggOe7AapoQF3WHv1SmBZWxI66', '1234', '2025-05-01', 'active', '5.png'),
(4, 'ValidTest', 'ValidTest', 'Validtest@ValidTest.com', '$2y$10$EmZ4CTOeWeSc3JC.9qACvu/6P2NCxZpuL6SVPbNUelfqxaxBe2yre', '', '2025-05-02', 'active', NULL),
(5, 'ValidTest2', 'ValidTest2', 'Validtest2@ValidTest.com', '$2y$10$dItadkc.ZF8WJRbYORdnpOsOpmZ49aIV3oMU2m0mIOxuM3h6XhLIq', '', '2025-05-02', 'active', NULL),
(6, 'ValidTest3', 'ValidTest3', 'Validtest3@ValidTest.com', '$2y$10$McgxWFvl5xgNZ.LeTCcDbuogsZWw1.zjtaxtaxoflrPJZQvgDS7zK', '011111', '2025-05-02', 'active', NULL),
(7, 'SingleCharPass', 'SingleCharPass', 'SingleCharPass@SingleCharPass.com', '$2y$10$rAOEaE2sGmPCTqar9M0xt.BdByi81XlFAD//GEU8kFupLS6YoLKXy', '123', '2025-05-02', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `points_purchased` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `user_id`, `year`, `points_purchased`, `amount_paid`, `created_at`) VALUES
(1, 1, '2025', 70, 700.00, '2025-04-22 21:48:44'),
(2, 1, '2025', 35, 350.00, '2025-04-22 21:49:40'),
(3, 1, '2025', 100, 1000.00, '2025-04-22 21:50:26'),
(4, 1, '2025', 70, 700.00, '2025-04-22 22:04:26'),
(5, 1, '2025', 85, 850.00, '2025-04-22 22:05:01'),
(6, 1, '2025', 100, 1000.00, '2025-04-22 22:05:33'),
(7, 1, '2025', 10, 100.00, '2025-04-22 22:47:05'),
(8, 1, '2025', 85, 850.00, '2025-04-23 10:54:34'),
(9, 2, '2025', 10, 100.00, '2025-05-01 00:31:22'),
(10, 2, '2025', 70, 700.00, '2025-05-02 13:34:16'),
(11, 2, '2025', 20, 200.00, '2025-05-02 13:46:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calculator_results`
--
ALTER TABLE `calculator_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feedback_user` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_voucher_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calculator_results`
--
ALTER TABLE `calculator_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calculator_results`
--
ALTER TABLE `calculator_results`
  ADD CONSTRAINT `fk_calculator_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `fk_voucher_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

5. **Adjust Database Connection**
- In `requires/connect_db.php`, confirm your MySQL credentials match:
  ```php

	
$servername = "localhost";
$username = "EC2248699";
$password = "GradedUnit2"; 
$dbname = "sustainenergydb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

---
## Security Notes

- Passwords should be hashed (not shown in current code).
- All user input is escaped using `htmlspecialchars()` to prevent XSS.

---

## License

This project was developed for educational purposes and is not intended for commercial use. All images and resources used are either original or sourced under fair use for academic demonstration.

---

## Author

**Jamie Hyndman**  
HND Software Development Student  
Graded Unit 2 – H48W35/029 (2025)
