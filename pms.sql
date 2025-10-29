-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2025 at 11:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `announcement_title` varchar(255) NOT NULL,
  `announcement_content` mediumtext NOT NULL,
  `announcement_date` datetime NOT NULL DEFAULT current_timestamp(),
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `announcement_title`, `announcement_content`, `announcement_date`, `Company_id`) VALUES
(11, 'Office Rules and Regulations', '<p>Dear Team,<br />\r\n<br />\r\nI hope this message finds you well.<br />\r\n<br />\r\nWe want to bring to your attention of leave policy regarding absences around weekends and government holidays.The following guidelines will be in place:<br />\r\n<br />\r\nIf an employee takes continuous leave that spans over a weekend or a government holiday, and this leave includes either the preceding Friday or the following Monday, it will be considered as loss of pay for the additional days outside of their approved leave period.<br />\r\nFor example, if you take leave starting on [Friday] and return on [monday], the days that are weekends or government holidays and not officially covered by your leave will be treated as unpaid leave.<br />\r\n<br />\r\nPlease make sure to plan your leave accordingly.<br />\r\n<br />\r\nThank you for your attention to this matter.<br />\r\n<br />\r\nBest&nbsp;regards,<br />\r\n<br />\r\nT. Hamsavani</p>\r\n', '2024-09-04 11:15:09', '5'),
(13, 'Happy Birthday', '<p>hhhhh</p>\r\n', '2024-09-04 11:21:20', '2');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(55) NOT NULL,
  `date` varchar(233) DEFAULT NULL,
  `time_in` time NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `time_out` varchar(233) DEFAULT NULL,
  `num_hr` varchar(255) DEFAULT NULL,
  `send` varchar(255) NOT NULL,
  `year_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`, `send`, `year_time`, `Company_id`) VALUES
(2, 'ashwinkumar@mineit.tech', '08-10-2025', '10:55:43', '1', '2025:10:08 15:00:00', '4.4', '3', '2025-10-08 05:25:43', '1'),
(3, 'anand@mineit.tech', '08-10-2025', '15:01:14', '1', NULL, NULL, '3', '2025-10-08 09:31:14', '1'),
(4, 'nishar.mine@gmail.com', '09-10-2025', '16:21:52', '1', NULL, NULL, '3', '2025-10-09 10:51:52', '1'),
(5, 'ashwinkumar@mineit.tech', '09-10-2025', '16:23:30', '1', '2025:10:09 16:24:07', '0.0', '3', '2025-10-09 10:53:30', '1'),
(6, 'director.development@mineit.tech', '09-10-2025', '16:26:52', '1', '2025:10:09 16:27:26', '0.0', '3', '2025-10-09 10:56:52', '1'),
(7, 'yashaswini.mineit@gmail.com', '09-10-2025', '16:29:09', '1', NULL, NULL, '3', '2025-10-09 10:59:09', '2'),
(8, 'latika@mineit.tech', '09-10-2025', '16:30:14', '1', '2025:10:09 16:30:45', '-1.-1', '3', '2025-10-09 11:00:14', '1'),
(9, 'jhasuman.1503@gmail.com', '09-10-2025', '16:31:49', '1', '2025:10:09 16:38:17', '0.6', '3', '2025-10-09 11:01:49', '1'),
(10, 'muthammakajal@mineit.tech', '09-10-2025', '16:34:15', '1', '2025:10:09 16:35:04', '0.0', '3', '2025-10-09 11:04:15', '1'),
(11, 'jayamani@mineit.tech', '09-10-2025', '16:44:47', '1', '2025:10:09 18:01:46', '1.16', '3', '2025-10-09 11:14:47', '1'),
(12, 'jayamani@mineit.tech', '10-10-2025', '11:06:55', '1', '2025:10:10 15:32:17', '4.25', '3', '2025-10-10 05:36:55', '1'),
(13, 'tarunkumardubey@swifterz.co', '10-10-2025', '15:33:30', '1', NULL, NULL, '3', '2025-10-10 10:03:30', '2'),
(14, 'nishar.mine@gmail.com', '10-10-2025', '15:35:13', '1', NULL, NULL, '3', '2025-10-10 10:05:13', '1'),
(15, 'tangevva.swifterz@gmail.com', '10-10-2025', '15:36:18', '1', NULL, NULL, '3', '2025-10-10 10:06:18', '2'),
(16, 'director.development@mineit.tech', '10-10-2025', '15:38:23', '1', '2025:10:10 15:38:32', '-1.-1', '3', '2025-10-10 10:08:23', '1'),
(17, 'karan@jiffy.com', '10-10-2025', '15:40:30', '1', '2025:10:10 16:12:38', '0.31', '3', '2025-10-10 10:10:30', '1');

-- --------------------------------------------------------

--
-- Table structure for table `clientinformation`
--

CREATE TABLE `clientinformation` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `GSTNumber` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `projectName` varchar(255) NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `totalHours` int(11) DEFAULT NULL,
  `resourceInvolved` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `cliendid` varchar(255) DEFAULT NULL,
  `uploaderid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientinformation`
--

INSERT INTO `clientinformation` (`id`, `fullName`, `phoneNumber`, `email`, `GSTNumber`, `password`, `projectName`, `budget`, `startDate`, `endDate`, `totalHours`, `resourceInvolved`, `address`, `Company_id`, `cliendid`, `uploaderid`) VALUES
(1, 'MINE', '6382341074', 'mineit.tech@gmail.com', '6382341074', '', 'Virtual dressing system', 500000.00, NULL, NULL, NULL, NULL, '#53,1st Main Road, Maruthi layout,RMV 2nd Stage, Sanjay Nagar, Bangalore , Karnataka 560094, India', '1', 'MINE967806', '7'),
(3, 'RSP Design Consultants', '9845336816', 'geetha@rspindia.net', '2900011', '', 'Prestige Park Groove', 5500000.00, NULL, NULL, NULL, NULL, 'RSP House, 30, Museum Rd, Shanthala Nagar, Ashok Nagar, Bengaluru, Karnataka 560001.', '5', 'RSP Design Consultants951594', '103'),
(4, '                   ', '1234567890', 'dhaddevaibhavi@gmail.com', '12', '', '                    ', 123.00, NULL, NULL, NULL, NULL, '                                             ', '1', '                   827475', '59'),
(5, '                                            ', '9972080917', 'abc@example.com', '12', '', '                           ', 1212.00, NULL, NULL, NULL, NULL, 'Banashankari galli basavakalyan', '1', '                                            301531', '59'),
(6, 'name', '1234567890', '.@e.com', '12', '', 'dsf', 13.00, NULL, NULL, NULL, NULL, 'address', '1', 'name848515', '59');

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `text` text DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `emojis` int(11) NOT NULL DEFAULT 0,
  `employeeid` varchar(255) DEFAULT '0',
  `type` varchar(255) DEFAULT '0',
  `ring` varchar(255) NOT NULL DEFAULT '0',
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companylist`
--

CREATE TABLE `companylist` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `database_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `companylist`
--

INSERT INTO `companylist` (`id`, `company_name`, `database_name`, `created_at`) VALUES
(1, 'Merry\'s Info-Tech & New-Gen Educare', 'snh6_jiffy2', '2024-04-22 10:06:31'),
(3, 'Ghate Solution', 'snh6_jiffy2', '2024-06-21 12:49:20'),
(5, 'SWIFTERZ', 'snh6_jiffy2', '2024-07-09 16:04:11'),
(6, 'AECEARTH', 'snh6_jiffy2', '2024-08-08 06:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `logo`, `Company_id`) VALUES
(3, 'Accounts', './../uploads/department/download _.webp', '1'),
(5, 'TestingEngineering', './../uploads/department/Test-engineering-pic.webp', '1'),
(6, 'Designer', './../uploads/department/Designers-_[_].webp', '1'),
(7, 'Cyber Security', './../uploads/department/Cyber-_.webp', '1'),
(8, 'Digital Marketing', './../uploads/department/Dgial Market-_.webp', '1'),
(10, 'Human Resource', './../uploads/department/human-resources-concept-with-hand-_-_-_.webp', '2'),
(11, 'System Administration', './../uploads/department/download.webp', '2'),
(12, 'Technical ', './../uploads/department/SWIFTERZ logo OG-_.webp', '5'),
(13, 'Sales', './../uploads/department/SWIFTERZ logo OG-_.webp', '5'),
(14, 'Operations', './../uploads/department/SWIFTERZ logo OG-_.webp', '5'),
(15, 'Human Resources', './../uploads/department/SWIFTERZ logo OG-_.webp', '5'),
(16, 'Accounts', './../uploads/department/SWIFTERZ logo OG-_.webp', '5'),
(17, 'Sales', './../uploads/department/Sales.webp', '6'),
(18, ' CEO', './../uploads/department/Sales.webp', '6'),
(19, 'Lead Coordinator', './../uploads/department/Sales.webp', '6'),
(20, 'Sales Director', './../uploads/department/Sales.webp', '6'),
(21, 'Coordinator for Institution', './../uploads/department/Sales.webp', '6'),
(22, 'Admin', './../uploads/department/Sales.webp', '6'),
(23, 'HR', './../uploads/department/Sales.webp', '6'),
(24, 'Business Development Manager', './../uploads/department/Sales.webp', '6'),
(25, ' Digital Marketing', './../uploads/department/Sales.webp', '6'),
(26, 'Coordinator for HUB', './../uploads/department/Sales.webp', '6'),
(27, 'Management', './../uploads/department/AECearth logo.webp', '6'),
(28, 'Accounts', './../uploads/department/Sales.webp', '6'),
(29, 'Designing', './../uploads/department/Swifterz TM Crop _.webp', '5'),
(32, 'Sales & Marketing', './../uploads/department/Screenshot _-_-_ _.webp', '1'),
(35, 'HumanResource', './../uploads/department/HR IMAGE.webp', '1');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `empid` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `doj` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `department` int(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` varchar(10000) NOT NULL,
  `salary` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(55) DEFAULT NULL,
  `send` int(11) DEFAULT NULL,
  `call` int(11) NOT NULL DEFAULT 0,
  `callerid` int(11) NOT NULL DEFAULT 0,
  `active` varchar(255) NOT NULL DEFAULT 'active',
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `OTP` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `accountnumber` varchar(255) DEFAULT NULL,
  `Allpannel` varchar(255) DEFAULT 'Employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `empid`, `full_name`, `dob`, `phone_number`, `doj`, `email`, `password`, `user_type`, `user_role`, `department`, `profile_picture`, `address`, `salary`, `status`, `send`, `call`, `callerid`, `active`, `created_date`, `OTP`, `Company_id`, `accountnumber`, `Allpannel`) VALUES
(1, 'EMP-0001', 'Nisha C R', '2001-02-21', '7397718515', '2022-03-05', 'nishar.mine@gmail.com', '7a2119fb84ee5896bf4a0a0ec3962628', 'Employee', 'admin', 1, 'WhatsApp Image 2024-06-24 at 3.15.30 PM.jpeg', '                                                                                                                                bangalore                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ', '0', 'Online', NULL, 0, 476, 'active', '2023-11-27 11:57:25', NULL, '1', '123456784', 'Admin'),
(2, 'EMP-0002', 'Anusiya M ', '2001-10-15', '8754891839', '2023-06-19', 'anusiyam@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'FrontEnd Developer', 1, 'anu.jpg', 'Tamil Nadu                                                                                                                                ', '25000', 'Online', NULL, 0, 7, 'deactive', '2024-05-28 12:01:17', NULL, '1', '12345678', 'Employee'),
(4, 'EMP-0004', 'SANJANA H NADIG', '2002-05-30', '7899725664', '2024-03-06', 'sanjana@mineit.tech', 'a31d254b7558a05009491a60b47d0103', 'Trainee', 'FrontEnd Developer', 0, 'pic.jpg', 'santhrupti lig 66 khb colony chitradurga', '0', NULL, NULL, 0, 0, 'deactive', '2024-05-28 12:25:22', '32692', '1', NULL, 'Employee'),
(5, 'EMP-0005', 'L PAVITHRA', '1999-12-13', '9380283947', '2024-03-04', 'pavithra@mineit.tech', '69ea35d46fcfe61630876d88659dac5f', 'Trainee', 'FrontEnd Developer', 0, '20221212_160218.jpg', '#62, RBI COLONY MAIN ROAD PAPPANNA BLOCK GANGANAGAR BENGALURU-24', '0', NULL, NULL, 0, 0, 'deactive', '2024-05-28 12:27:02', NULL, '1', NULL, 'Employee'),
(6, 'EMP-0006', 'suman kumar jha', '2003-09-15', '8789648459', '2024-03-04', 'jhasuman.1503@gmail.com', 'de2dff113465469b988b0240a9d549b9', 'Trainee', 'Backend Developer', 0, 'suman photo.jpg', 'chalapathi raju layout ,Bethal nagar\r\nKR puram, Bangalore -560049', '0', 'Offline', NULL, 0, 0, 'active', '2024-05-28 12:30:46', '35072', '1', NULL, 'Employee'),
(7, 'EMP-0007', 'Jayamani M', '2001-02-21', '6385855002', '2023-06-19', 'jayamani@mineit.tech', '158943d0cec351ea3dd3c7f1d4260bda', 'Employee', 'Management', 1, 'jayamani.jpg', '                                                                                                                                                                                                                                            447 , chinnasalem,                                                                                                                                                                                                                                                                                                                                 ', '40000', 'Offline', NULL, 0, 25, 'active', '2024-05-28 12:34:19', NULL, '1', '123456784', 'Management,Accounts,Sales,Admin,Project Manager,Employee,Client,All'),
(8, 'EMP-0008', 'RUTHALA AVINASH', '2000-05-07', '6302498946', '2024-03-06', 'Avinash@mineit.tech', '559cf726753328daedf67c82f92e6e3e', 'Trainee', 'FrontEnd Developer', 0, 'IMG-20231210-WA0025.jpg', '                                                                Sairam PG,near presidency College,Hebbal,kempapura, Bangalore                                                                 ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-05-28 12:44:20', '62115', '1', '6060247817881', 'Employee'),
(9, 'EMP-0009', 'Joud Sammani', '1999-02-06', '555911392', '2024-11-21', 'joud@swifterz.ae', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Project Manager', 1, 'joud_profile.jpg', 'Dubai, UAE', '100000', 'Online', NULL, 0, 0, 'active', '2024-11-21 12:44:56', NULL, '5', '1234567890', 'All'),
(10, 'EMP-0010', 'Prateek Choudhary ', '2024-03-25', ' 6363450742 ', '2024-03-04', 'prateek@mineit.tech', 'a6662d732518a5107c88418168e6cf25', 'Trainee', 'FrontEnd Developer', 0, 'My Image.jpg', '                                                                #5,Gowthampura,Ulsoor, Bangalore-08                                                                 ', '0', 'Online', NULL, 0, 0, 'active', '2024-05-28 13:07:59', NULL, '1', '561156518989', 'Employee'),
(11, 'EMP-0011', 'Shabaz Pasha ', '2003-05-31', '93531 14993', '2024-03-04', 'shabazsahza.mine@gmail.com', '84836b4d0cec166b071419f0a3634019', 'Trainee', 'FrontEnd Developer', 0, '1000088698.jpg', '#321 Near Ayesha Masjid Madeena Nagar Mangammanapalya Bommanahalli Bangalore ', '0', 'Online', NULL, 0, 0, 'active', '2024-05-28 13:09:06', '87112', '1', NULL, 'Employee'),
(12, 'EMP-0012', 'Ayush Kumar ', '2003-09-04', '+91 78926 82726', '2024-03-04', 'ayushkumar8511@gmail.com', '0746e65cbb84329869fed007803caaa4', 'Trainee', 'FrontEnd Developer', 0, '1000155256.jpg', 'No. 16 Durga maheswari Nilaya and cross, manjunatha Layout Near Amar Jyothi Public school, Devasandra, K.R Pura, Bangalore-560036.', '0', 'Online', NULL, 0, 0, 'deactive', '2024-05-28 13:11:01', NULL, '1', NULL, 'Employee'),
(13, 'EMP-0013', 'Kailash Prasad ', '2001-07-25', '8957902281', '2024-03-04', 'kp350722@gmail.com', '715da37a9ec01ced13fd49bde24fc373', 'Trainee', 'FrontEnd Developer', 0, 'SAVE_20240409_154934.jpg', 'Kr puram Baswanapura Main road Gayatri layout 15 cross ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-05-28 13:12:00', NULL, '1', NULL, 'Employee'),
(15, 'EMP-0014', 'Divya MN', '2001-09-08', '9108292351', '2023-11-02', 'divya@mineit.tech', '9d6c49d026bbb5de9b7b6e4faa208520', 'Employee', 'Backend Developer', 0, '1000153420.jpg', 'Bangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-05-28 13:33:38', NULL, '1', NULL, 'Employee'),
(16, 'EMP-0015', 'Sabari Raj S R', '2001-05-19', '9789469166', '2023-11-16', 'sabariraj@mineit.tech', 'f649d8df8d49af97ffcaf713fb524703', 'Employee', 'FrontEnd Developer', 0, 'sabariraj.jpg', 'No .11/85 Thadagam Road,\r\nKovilmedu Privu, Near Kiruba Hospital , Velandipalayam Post, Coimbatore -641025', '0', 'Offline', NULL, 0, 0, 'active', '2024-05-28 13:34:16', '14187', '1', NULL, 'Employee'),
(17, 'EMP-0016', 'Vijay M', '2001-04-26', '6360611485', '2024-03-06', 'vijay@mineit.tech', '23590df197efc8beb7f6078ffb84a4e9', 'Trainee', 'Backend Developer', 0, 'WhatsApp Image 2024-05-22 at 9.42.30 AM.jpeg', 'JC Nagar', '0', 'Online', NULL, 0, 0, 'deactive', '2024-05-28 13:43:19', NULL, '1', NULL, 'Employee'),
(18, 'EMP-0017', 'Deepthi S', '2000-11-01', '8317339167', '2024-03-06', 'deepthi@mineit.tech', 'b59cd9608154255fc88b32d53930795c', 'Trainee', 'Backend Developer', 0, 'phototcs.jpeg', '8th main,basaveshwaranagar bangalore', '0', NULL, NULL, 0, 0, 'deactive', '2024-05-28 13:49:52', NULL, '1', NULL, 'Employee'),
(19, 'EMP-0018', 'Nayana Motagi ', '2000-09-05', '9945516910', '2024-03-08', 'nayanamotagi24@gmail.com', 'ae9993fa41002253c6eb8744500eb8bc', 'Trainee', 'FrontEnd Developer', 0, 'IMG_20240418_095747.png', 'Kempapura hebbal Bangalore ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-05-28 15:00:05', NULL, '1', NULL, 'Employee'),
(20, 'EMP-0019', 'Jeethu Pathak', '2002-04-02', '7760320371', '2024-03-04', 'jeethu@mineit.tech', '23a7f12cd152ecc805a747640410241f', 'Trainee', 'FrontEnd Developer', 0, 'Jeethu Pathak.jpg', 'Seetharama palya,Mahadeva pura post,Bangalore-560048', '0', 'Online', NULL, 0, 59, 'active', '2024-05-28 19:49:37', '13033', '1', NULL, 'Employee'),
(21, 'EMP-0020', 'Vaibhavi Khiranand Dhadde', '2002-12-14', '9972080917', '2024-05-01', 'vaibhavi@mineit.tech', '252ce5808b0e032921a3bd50830f0cc8', 'Employee', 'Testing Engineer', 5, 'vai1.jpg', '53, 1st Main Road, Maruthi layout, RMV 2nd Stage, Sanjay Nagar, Bangalore - 560094, Karnataka, India', '12000', 'Online', NULL, 0, 0, 'active', '2024-05-29 06:24:31', '39276', '1', '11', 'Employee'),
(22, 'EMP-0021', 'Shashi Bhavan C K', '2002-01-19', '7483984655', '2023-11-02', 'shashibhavan@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Backend Developer', 0, '1000041860.jpg', 'K R puram, Bangalore - 560036', '0', 'Online', NULL, 0, 0, 'active', '2024-05-29 08:32:26', NULL, '1', NULL, 'Employee'),
(24, 'EMP-0023', 'Dilip P', '1999-03-06', '9743591277', '2023-11-01', 'dilip@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Backend Developer', 0, 'WhatsApp Image 2023-12-22 at 12.41.42 PM.jpeg', '                                                                                                                                                                                                Nagashettyhalli Bangalore                                                                                                                                                                                                 ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-04 05:51:19', NULL, '1', '0', 'Employee'),
(25, 'EMP-0024', 'Jyothsna ', '2001-04-15', '94912 15409', '2023-12-01', 'jyothsna@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'FrontEnd Developer', 0, 'IMG_20240516_182232.jpg', '                                                                Banglore                                                                 ', '0', 'Online', NULL, 0, 26, 'active', '2024-06-04 06:01:44', NULL, '1', '923010050685409', 'Employee'),
(26, 'EMP-0025', 'Ajith Kumar', '2001-04-30', '6382712217', '2024-01-08', 'ajith@mineit.tech', '89b644724244532adc17d74afc18b9c0', 'Employee', 'FrontEnd Developer', 1, 'me.jpeg', '2/147 A, Mela street, Thiranipalayam, Lalgudi (tk), Trichy - 621 109', '15000', 'Online', NULL, 0, 7, 'active', '2024-06-04 06:28:01', NULL, '1', '923010050640956', 'Employee'),
(27, 'EMP-0026', 'BHAVYA SREE M', '2002-05-29', '9491207140', '2023-11-01', 'bhavyasreem@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Backend Developer', 1, '1000004705.jpg', 'Bangalore', '15000', 'Online', NULL, 0, 0, 'active', '2024-06-04 06:33:21', NULL, '1', '923010048327601', 'Employee'),
(28, 'EMP-0027', 'Abdul Ahad', '2001-10-03', '9113979679', '2024-02-14', 'abdulahad@mineit.tech', '13d469fdf44444b621d19f23ecb891d4', 'Employee', 'FrontEnd Developer', 1, 'Abdul Ahad Photo.jpg', 'Bangalore                                                                ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-04 06:39:48', NULL, '1', '12345678', 'Sales,Employee'),
(29, 'EMP-0028', 'K SUMANTH KUMAR RAJU', '2001-10-21', '9100896317', '2023-11-02', 'sumanth@mineit.tech', '470e9b1c51fa4cb3bda3557fb7e9d749', 'Employee', 'Backend Developer', 0, 'photo.jpg', 'Kshatriya Nagar 1st cross, Tirupati, Andhra Pradesh.', '30000000', 'Online', NULL, 0, 26, 'active', '2024-06-04 06:42:08', NULL, '1', '923010050618164', 'Employee'),
(30, 'EMP-0029', 'Bhanuprasadyadav P ', '2001-06-24', '0', '2023-11-02', 'bhanuprasad@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Backend Developer', 0, 'bhanuprasad.jpg', '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Bengaluru                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ', '0', 'Online', NULL, 0, 35, 'active', '2024-06-04 06:43:38', NULL, '1', '0', 'Employee'),
(31, 'EMP-0030', 'Nithyashree N Bannur ', '1999-07-23', '7337703618', '2023-11-06', 'nithyashree@mineit.tech', 'a3e37db79e07bece99ae5d36999b7618', 'Employee', 'Backend Developer', 0, '1000038910.jpg', '#3390 A/1 5th main 2nd cross RPC layout Vijaynagar Bangalore ', '0', 'Online', NULL, 0, 21, 'active', '2024-06-04 06:46:18', NULL, '1', NULL, 'Employee'),
(32, 'EMP-0031', 'saranya', '1991-05-17', '9739001516', '2023-04-24', 'saranyaelangovan@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'FrontEnd Developer', 0, 'WhatsApp Image 2024-06-04 at 10.21.28.jpeg', '#10 Anjanadhari layout Rachenahalli thanisandra Bengaluru- 560077', '0', 'Online', NULL, 0, 0, 'active', '2024-06-04 06:52:02', '86777', '1', NULL, 'Employee'),
(33, 'EMP-0032', 'Meena Mani', '1999-08-12', '9751862387', '2024-10-30', 'meena@mineit.tech', '04227da7c059aac68cc1e17471aa0508', 'Employee', 'Project Manager', 0, 'WhatsApp Image 2024-05-15 at 1.13.12 PM.jpeg', 'Kotagiri, Nilgiris - 643217', '35000', 'Online', NULL, 0, 30, 'active', '2024-06-04 07:06:44', NULL, '1', '67678684567', 'Employee'),
(34, 'EMP-0033', 'Sunil Gowda S', '2000-06-29', '9945212556', '2023-08-21', 'sunil@mineit.tech', 'c5aafd632a50d6cc450f8601a48bae5e', 'Employee', 'FrontEnd Developer', 0, 'Sunil.jpeg', 'Seegehalli Whitefield bengaluru 560067', '0', 'Offline', NULL, 0, 27, 'active', '2024-06-04 07:15:09', '78312', '1', '60345678212', 'Employee'),
(35, 'EMP-0034', 'Ashwini satti', '2002-06-03', '7204343744', '2023-12-01', 'ashwini@mineit.tech', 'd1788c93aa6089d958a0c63fba6a4c08', 'Employee', 'Backend Developer', 0, '1000231384.jpg', 'Bedarahatti,Ta:athani,Dist: belgaum, Karnataka', '15000', 'Offline', NULL, 0, 25, 'active', '2024-06-04 07:18:46', '19766', '1', '64197051588', 'Employee'),
(36, 'EMP-0035', 'Santhosh M', '2001-01-03', '9789516159', '2024-06-03', 'santhosh@mineit.tech', '7917490ade79c2b277e14298d14a85dc', 'Employee', 'Testing Engineer', 0, 'Linkedin Profile Pic.jpeg', '81-A, MM Street, Kodaikanal, Tamil Nadu', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-07 10:43:51', NULL, '1', NULL, 'Employee'),
(37, 'EMP-0036', 'Dhiwakaran M', '2001-04-23', '0', '2023-09-04', 'dhiwakaran@mineit.tech', 'f93c8e585ffd0822ac885c0db977bd2b', 'Employee', 'Designer', 0, 'Green Gradient Minimalist Simple Instagram Profile Picture.png', '                                                                                                                                Hosur                                                                                                                                 ', '0', 'Online', NULL, 0, 38, 'active', '2024-06-07 10:53:51', NULL, '1', '923010048364765', 'Employee'),
(38, 'EMP-0037', 'sharathchandra B R', '2000-06-25', '8296595546', '2023-11-02', 'sharath@mineit.tech', 'd09b0b8e999b1ed96b125652b89d8185', 'Employee', 'FrontEnd Developer', 0, 'WhatsApp Image 2024-05-16 at 6.23.23 PM.jpeg', 'Bangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-06-07 10:58:29', NULL, '1', NULL, 'Employee'),
(39, 'EMP-0038', 'Harish R', '2002-10-01', '8792680188', '2023-11-01', 'harish.ramakrishna1@gmail.com', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'FrontEnd Developer', 0, 'Harish_R.jpg', '#24 Best country 1main road near sumbhram institution of technology vidyaranyapura Bangalore 560097', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-07 11:00:05', NULL, '1', NULL, 'Employee'),
(40, 'EMP-0039', 'Paranthaman G', '1997-12-24', '9445409521', '2024-06-03', 'paranthaman@mineit.tech', '16cbf7880d723910a1ceec73532965a3', 'Employee', 'UI/UX', 0, 'IMG_20240225_201116.jpg', '                                                                                                                                3/52 chidambaram nagar,kamaraj street,mangadu,chennai-600122                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-06-07 11:11:10', NULL, '1', '924010027740684', 'Employee'),
(41, 'EMP-0040', 'SHAIK JAVED', '2001-10-09', '7997665161', '2024-04-08', 'shaikjaved.mine@gmail.com', 'b02331e23a5d2e2890c58d3f3925ed5a', 'Employee', 'Digital Marketing Executive', 0, 'JAVED PASSPHOTO.JPG', '4/156 Badullavari Street, Kanigir, Andhrapradesh  523230', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-07 12:07:20', NULL, '1', NULL, 'Employee'),
(42, 'EMP-0041', 'Rahul Sahoo', '2001-03-23', '07835850829', '2024-03-04', 'rahuls@mineit.tech', 'e183eae2879d9b25e1614fae33b2d489', 'Trainee', 'Defence and Security', 0, '1000038874.jpg', '#30, 5th main,\r\nKR puram, ayyapa nagar ', '0', 'Online', NULL, 0, 44, 'deactive', '2024-06-07 12:07:49', NULL, '1', NULL, 'Employee'),
(43, 'EMP-0042', 'Manaswita Goswami', '1999-05-23', '7086043838', '2024-05-02', 'manaswitagoswami@mineit.tech', 'c762e029e1f5ea7eba9baab3b06354ea', 'Employee', 'Content Writer', 0, 'Passport Photo.jpg', '160, 4th Cross Rd, RMV 2nd Stage, Sachidananda Nagar, Raj Mahal Vilas 2nd Stage, Sanjayanagara, Bengaluru, Karnataka 560094', '0', NULL, NULL, 0, 0, 'deactive', '2024-06-07 12:08:33', NULL, '1', NULL, 'Employee'),
(44, 'EMP-0043', 'NEELKAMAL PATEL', '2000-12-23', '9285454214', '2024-03-06', 'neelkamal@mineit.tech', 'faa7c960194b1ebef2d078b163af0127', 'Trainee', 'Defence and Security', 0, 'IMG_0285 _Neel.jpeg', 'BENGALURU', '0', 'Online', NULL, 0, 0, 'active', '2024-06-07 12:13:02', '14922', '1', NULL, 'Employee'),
(45, 'EMP-0044', 'Kishore N ', '1999-07-17', '9606255977', '2024-03-09', 'kishorekn0056@gmail.com', '9ea3131b1d9a8a346d28ed19561524b5', 'Trainee', 'Defence and Security', 0, '1000051764.jpg', 'Nandini layout, Bangalore ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-07 12:13:15', NULL, '1', NULL, 'Employee'),
(46, 'EMP-0045', 'Chandan Kumar V K ', '2000-09-18', '8151037033', '2024-06-06', 'ck18vk@gmail.com', 'bd35027b12b39ecfc0a8daae907715c4', 'Trainee', 'Defence and Security', 0, 'IMG_20220713_172858_copy_911x1191.jpg', 'Yelanka,Banglore ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-07 12:15:06', NULL, '1', NULL, 'Employee'),
(47, 'EMP-0046', 'SaiSabarish', '2003-12-03', '9659395553', '2024-03-06', 'saisabarish@mineit.tech', '49bb558128e6423e75108c97dd3e4e25', 'Trainee', 'Defence and Security', 0, 'WhatsApp Image 2024-06-06 at 3.55.41 PM.jpeg', '422/1,v.s.illam,kamarjar 2nd street,b.b.kulam,madurai', '0', 'Online', NULL, 0, 0, 'active', '2024-06-07 15:26:01', NULL, '1', NULL, 'Employee'),
(48, 'EMP-0047', 'M.S.Purnima', '2000-12-04', '+91 9652836098', '2024-06-06', 'purnima@mineit.tech', '17ae4741e0c8be5fa97a87bc0bb79535', 'Trainee', 'Testing Engineer', 0, 'WhatsApp Image 2024-06-10 at 2.33.29 PM.jpeg', 'K.R. Puram Bangalore', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-10 11:11:32', '92917', '1', NULL, 'Employee'),
(49, 'EMP-0048', 'Bipin Chavan', '1999-05-13', '805571827', '2024-06-06', 'bipinchavan@mineit.tech', '45a2a8b13e2846a5ecf5a5c4bc29aafe', 'Trainee', 'Testing Engineer', 0, 'WhatsApp Image 2024-06-10 at 2.41.41 PM.jpeg', 'SLN Gents PG, Rajagopal Road, Sanjaya Nagar,Bangalore', '0', 'Offline', NULL, 0, 0, 'active', '2024-06-10 11:12:30', NULL, '1', NULL, 'Employee'),
(50, 'EMP-0049', 'Turab Hussain', '2001-10-16', '7204449351', '2024-02-01', 'hussain@mineit.tech', '1c643fd3907f92f9076ad81ba4836016', 'Employee', 'FrontEnd Developer', 0, 'WhatsApp Image 2024-06-10 at 22.00.31_e1f01a8f.jpg', 'RT Nagar,Bangalore-560032                                                             ', '0', 'Online', NULL, 0, 26, 'deactive', '2024-06-10 15:01:02', NULL, '1', '0000000000000', 'Employee'),
(51, 'EMP-0050', 'Rahul hosmani', '2000-04-18', '7760682155', '2024-06-06', 'rahulh@mineit.tech', '9e535fee0d340ad904152749df1cb3e0', 'Trainee', 'Backend Developer', 0, 'Screenshot 2024-06-11 155846.png', '                                                                                                                                BANGLORE                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-06-11 12:12:40', '66954', '1', '123', 'Employee'),
(52, 'EMP-0051', 'Ashutosh Prajapati ', '2001-07-17', '7338537351', '2024-03-04', 'ashutosh@mineit.tech', 'c442e808532f2e5053cad0916edb9f45', 'Trainee', 'FrontEnd Developer', 0, 'IMG-20240506-WA0110.jpg', 'Vibuthipura mutta road Marathahalli ', '0', 'Online', NULL, 0, 33, 'active', '2024-06-11 13:37:44', NULL, '1', NULL, 'Employee'),
(53, 'EMP-0052', 'Ashwinkumar', '2001-06-20', '8870230720', '2024-04-01', 'ashwinkumar@mineit.tech', 'b2469b949484294a76231528e15f109c', 'Employee', 'Graphic Designer', 6, 'WhatsApp Image 2023-12-13 at 16.27.35_e01806ed.jpg', 'Silk Board, Bengaluru, Karnataka, INDIA', '0', 'Offline', NULL, 0, 60, 'active', '2024-06-12 12:03:47', NULL, '1', '897987', 'Admin,Project Manager,Employee'),
(54, 'EMP-0053', 'prasanth', '2003-08-08', '0978909600', '2024-02-12', 'prasanthb.mine@gmail.com', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Graphic/UI', 0, 'my.jpg', '                                                                                                                                                                                                                                                                                                                                madurai                                                                                                                                                                                                                                                                                                                                ', '0', 'Online', NULL, 0, 41, 'active', '2024-06-18 07:00:24', NULL, '1', '9789096005', 'Employee'),
(55, 'EMP-0054', 'CHANDAN YADAV K S', '2002-10-21', '7022591217', '2024-03-04', 'chandan@mineit.tech', '9b574fbb149516fa80638510c1f77026', 'Trainee', 'FrontEnd Developer', 0, 'PICTURE CONVACATION.jpg', 'Near post office Karahalli Village,Bangarpet (t),Kolar(d)', '0', 'Online', NULL, 0, 0, 'active', '2024-06-18 07:33:56', NULL, '1', NULL, 'Employee'),
(56, 'EMP-0055', 'Hema B', '2003-12-13', '0', '2024-06-06', 'hhemaaa013@gmail.com', '5ba9abfbe1cb7c478ffb9777d11e0845', 'Trainee', 'Backend Developer', 0, 'IMG_5025.jpeg', '                                                                                                                                                                                                                                                                                                                                Saish Living Spaces, New bels road. Bengaluru.                                                                                                                                                                                                                                                                                                                                 ', '0', 'Online', NULL, 0, 0, 'deactive', '2024-06-18 10:42:58', NULL, '1', '89789', 'Employee'),
(57, 'EMP-0056', 'Raghu raj pratap singh', '2002-04-01', '06206099589', '2024-05-22', 'raghurajpratapsingh6165@gmail.com', '9ac9249ebe7a7923a7e214fd39695253', 'Trainee', 'Defence and Security', 0, 'WhatsApp Image 2024-06-19 at 09.59.15_22295cac.jpg', '                                                                K.R. Puram bangalore                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-06-19 06:31:58', NULL, '1', '36533840834', 'Employee'),
(58, 'EMP-0057', 'Daniel C', '1986-06-24', '6382341074', '2021-10-27', 'cdaniel.mine@gmail.com', '13d469fdf44444b621d19f23ecb891d4', 'Employee', 'CTO', 0, 'WhatsApp Image 2024-04-22 at 17.00.00_85b77df9.jpg', '# 87, Kandal Main Road Ooty. - 643006.', '0', 'Online', NULL, 0, 7, 'active', '2024-06-19 07:00:17', NULL, '1', NULL, 'Employee'),
(59, 'EMP-0058', 'Anand T', '1979-08-21', '8220333544', '2012-08-19', 'anand@mineit.tech', '44961fba6242d6fc80b276473eed2e24', 'Employee', 'Management', 4, 'WhatsApp Image 2024-04-22 at 17.00.00_85b77df9.jpg', '                                                                  Bangalore                                                                                                                                                                                                                                                                                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-06-19 07:07:51', '49980', '1', 'bug', 'Management,Accounts,Sales,Admin,Project Manager,Employee,Client,All'),
(60, 'EMP-0059', 'Latika Pandit', '1998-12-29', '7989556983', '2024-06-06', 'latika@mineit.tech', 'a1dbd2d90a8ff78df97b2a464225d75f', 'Trainee', 'UI/UX', 6, 'Profile picture_latika pandit .JPG', 'Sri sai luxurious ladies pg, 4th cross, Sanjay Nagar, Hebbal, Karnataka, 560094', '0', 'Offline', NULL, 0, 0, 'active', '2024-06-19 07:08:22', NULL, '1', '8686876', 'Admin,Project Manager,Employee'),
(61, 'EMP-0060', 'Jai Ranpara', '2004-01-21', '8657432101', '2024-06-06', 'rjai@mineit.tech', 'c406cf676fd92219a1c6bf7a6c4279d1', 'Trainee', 'Backend Developer', 0, 'Jai.JPG', 'B 1501 Eternia Hiranandani Gardens Powai Mumbai 400076', '0', 'Online', NULL, 0, 0, 'active', '2024-06-20 12:54:06', NULL, '1', NULL, 'Employee'),
(62, 'EMP-001', 'Yeshna Jerold Masih', '1999-08-27', '8770917677', '2024-03-13', 'hr@ghate.solutions', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'admin', 0, 'WhatsApp Image 2024-06-21 at 2.56.22 PM.jpeg', 'bengaluru', '0', 'Online', NULL, 0, 0, 'active', '2024-06-21 11:26:32', NULL, '2', NULL, 'Employee'),
(64, 'EMP-0002', 'Tarun Dubey', '1999-11-08', '9755559901', '2024-05-01', 'tarunkumardubey@swifterz.co', 'a412c990fef411aee2396fb42707c32e', 'Employee', 'HR Exceutive', 10, 'IMG_4928.jpeg', 'Kalyan Nagar Bengaluru', '0', 'Online', NULL, 0, 0, 'active', '2024-06-25 07:45:30', NULL, '2', '922010032273353', 'Admin'),
(65, 'EMP-0002', 'Tangevva Satti', '2000-06-03', '7625017522', '2023-06-03', 'tangevva.swifterz@gmail.com', 'ad94320259309e89d4cc1124e80a962a', 'Employee', 'HR Exceutive', 10, 'WhatsApp Image 2024-06-25 at 11.23.57 AM.jpeg', 'Bengluru', '0', 'Online', NULL, 0, 0, 'active', '2024-06-25 07:54:36', '17211', '2', '923010048363775', 'Admin'),
(66, 'EMP-0002', 'SaiSabarish', '2003-12-03', '9659395553', '2024-06-01', 'saisabarish@ghate.solutions', 'b2e03cb45bbfa9e57f351b54ef9a7a56', 'Employee', 'System Administration', 0, 'WhatsApp Image 2024-06-06 at 3.55.41 PM.jpeg', 'Bangalore,India', '0', NULL, NULL, 0, 0, 'active', '2024-06-25 11:49:31', NULL, '2', NULL, 'Employee'),
(67, 'EMP-0062', 'Dr Karthikeyan Saminathan', '1989-05-16', '9791306877', '2024-05-06', 'director.development@mineit.tech', 'e9b26d0811e1a2e36704bb8a797c7ad4', 'Employee', 'Project Manager', 1, 'Dr.Karthikeyan.jpg', '                                                                1/5-68E , Annai Ganga Naayar Township,\r\nAnna Nagar, Neelambur,Coimbatore-062                                                                ', '175000', 'Offline', NULL, 0, 7, 'active', '2024-06-25 14:38:37', NULL, '1', '922010040242633', 'Management,Accounts,Sales,Admin,Project Manager,Employee,Client,All'),
(68, 'EMP-0063', 'Punitha.S', '1991-03-11', '6374559883', '2022-04-12', 'punitha.ghate@gmail.com', 'b2e03cb45bbfa9e57f351b54ef9a7a56', 'Employee', 'Management', 0, '20240614_145921.jpg', '24,Allurinilayam, Amarjyothi Layout, Sanjaynagar,Bangalore 560094', '0', NULL, NULL, 0, 0, 'active', '2024-06-26 07:19:54', NULL, '1', NULL, 'Employee'),
(69, 'EMP-0064', 'Hamsavani', '1986-04-17', '7708022116', '2022-02-02', 'hamsavani.ghate@gmail.com', 'e700abbe22ebc14f26ba5cfbe5c40da6', 'Employee', 'Accountent', 3, 'hamsa photo.jpg', '18c Rajaji st, om sakthi nagar ambatturch 53', '0', NULL, NULL, 0, 0, 'active', '2024-06-26 14:02:26', NULL, '1', '12345678', 'Accounts,Employee'),
(70, 'EMP-0065', 'Ajith N', '2000-08-05', '8248373129', '2024-07-01', 'ajith.n@mineit.tech', 'c3ca08c36c5e4251ad1f41126ba024ad', 'Employee', 'Defence and Security', 0, '1000067001.jpg', '                                                                Bangalore India                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-02 09:36:35', NULL, '1', '8248373129', 'Employee'),
(71, 'EMP-0066', 'Maheen N', '1999-10-10', '8220333514', '2022-03-05', 'maheen@swifterz.co', 'dc2580c1f34db92149637493704e109e', 'Employee', '', 14, 'WhatsApp Image 2024-06-24 at 4.51.49 PM (1).jpeg', 'Bangalore', '30000', 'Online', NULL, 0, 0, 'active', '2024-07-10 06:35:18', NULL, '5', '1152500102712101', 'Admin'),
(72, 'EMP-0002', 'Yashaswini  P G', '1999-05-03', '8618490736', '2024-03-25', 'yashaswini.mineit@gmail.com', '6de3bb80cc76782b7ee4c5bd89aafde2', 'Trainee', 'HR Exceutive', 10, 'WhatsApp Image 2024-07-11 at 4.39.10 PM (1).jpeg', 'Bengaluru', '0', 'Online', NULL, 0, 0, 'active', '2024-07-11 13:11:06', '30996', '2', '39556169005', 'Admin'),
(73, 'EMP-0067', 'Nagindrarao', '1973-08-01', '8892145203', '2024-06-10', 'nmalkhed73@gmail.com', '1278910e60db273ed8e618c54e7d6da9', 'Employee', 'Vice President Projects', 0, 'Screenshot_20240627_231612.jpg', '126NE nisarga layout bannerghatta road bengaluru 560083', '0', 'Online', NULL, 0, 97, 'active', '2024-07-18 07:41:03', NULL, '5', NULL, 'Employee'),
(74, 'EMP-0068', 'Vandana. S', '1999-07-08', '9148758724', '2024-05-13', 'vandanas@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, 'IMG-20240513-WA0003.jpg', '                                                                                                                                                                                                                                                                                                                                Rg layout 2nd cross kolar 563101                                                                                                                                                                                                                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-18 09:48:34', NULL, '5', '4242500103812601', 'Employee'),
(75, 'EMP-0069', 'Guru charan R shetty ', '1997-03-30', '8660245294', '2024-05-06', 'gurucharan.r.shetty@swifterz.co', 'dc2580c1f34db92149637493704e109e', 'Employee', 'Tekla Modeler', 0, 'IMG_20200918_092745~2.jpg', 'Muthyala Nagar, BNS Layout, Mathikere, Bengaluru, Karnataka 560054', '0', NULL, NULL, 0, 0, 'active', '2024-07-19 06:04:26', NULL, '5', NULL, 'Employee'),
(76, 'EMP-0070', 'Anshu Amar', '1995-02-02', '9811139713', '2024-06-20', 'anshuamar@swifterz.co', '15265f06957af1415821ec0b902c4f75', 'Employee', 'Project Manager', 0, 'BIM.PNG', 'SriVinayak PG', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 09:06:48', '10116', '5', NULL, 'Employee'),
(77, 'EMP-0071', 'Vishal ', '1994-04-16', '8296783569', '2024-02-05', 'vishalitagi@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler- MEP', 0, 'Vishal Whie Backround.jpg', '                                                                                                                                                                                                Bazar road hire bagewadi BELAGAVI 591109                                                                                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 10:24:16', NULL, '5', '8296783569', 'Employee'),
(78, 'EMP-0072', 'Dharani M K', '2001-07-22', '07338273473', '2024-05-13', 'dharanimk.swifterz@gmail.com', '9b9b28b6fed2f044608b648bfef7e79a', 'Employee', 'BIM Modeler', 0, 'IMG_20240719_135717.jpg', '                                                                                                                                Bengaluru                                                                                                                              ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 10:27:44', NULL, '5', '4456', 'Employee'),
(79, 'EMP-0073', 'Padmavati H Budihal', '2001-07-23', '9353722624', '2024-02-19', 'padmavati@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, '20231030_000001.jpg', 'Bangalore ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 11:00:17', NULL, '5', NULL, 'Employee'),
(80, 'EMP-0074', 'Shaikh Shahebaz', '1995-10-07', '7847837944', '2024-05-13', 'shahebaz.s@swifterz.co', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'BIM Modeler', 0, 'IMG_20240713_154103_793.jpg', 'Bangalore', '0', NULL, NULL, 0, 0, 'deactive', '2024-07-19 11:11:03', NULL, '5', NULL, 'Employee'),
(81, 'EMP-0075', 'Yogesh S', '2001-08-12', '8310837308', '2024-04-01', 'yogesh@swifterz.co', 'f2258de99689f272ac7bd62b17db61bb', 'Employee', 'BIM Modeler', 0, 'IMG_20240408_175036.jpg', 'T Dasarahalli,Bangaluru', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 12:44:26', NULL, '5', NULL, 'Employee'),
(82, 'EMP-0076', 'Mohammed Samir V', '2001-09-21', '8943440841', '2024-02-05', 'samir@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler- MEP', 0, 'IMG-20230905-WA0041.jpg', 'Mathikere,star pg', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 12:46:39', NULL, '5', NULL, 'Employee'),
(83, 'EMP-0077', 'Netravati', '2001-05-20', '9353609178', '2024-02-19', 'netravati@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, 'IMG_20220413_192753.jpg', 'Banglore', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 12:59:10', NULL, '5', NULL, 'Employee'),
(84, 'EMP-0078', 'Manoj ', '1997-08-02', '7338571279', '2024-04-01', 'manoj@swifterz.com', '42938ad666db10ec36f2fee69e62b293', 'Employee', 'BIM Modeler', 0, 'IMG_20230107_213351_573.jpg', '                                                                                                                                Manoj s/o Mahadevegowda Hullahalli, Agasanapura post, Malavalli tq, Mandya di, Karnataka 571340                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-19 18:40:04', NULL, '5', '39979456440', 'Employee'),
(85, 'EMP-0079', 'Chandrasekar H', '1998-12-27', '6381176377', '2024-02-05', 'chandrasekarh@swifterz.co', '5235ce9e54a0d86dbe535d4b0f2dd615', 'Employee', 'BIM Modeler', 0, 'IMG_20240410_104027.jpg', '2nd stage,2nd cross Street,KR garden,Jeevanahalli,Cox Town, Bangalore 560005', '0', 'Online', NULL, 0, 0, 'active', '2024-07-20 05:52:54', NULL, '5', NULL, 'Employee'),
(86, 'EMP-0080', 'Vishwa J Y', '2000-01-20', '9916130141', '2024-02-05', 'vishwa@swifterz.co', '58542b4fe783f4d0d805315f25d36a79', 'Employee', 'BIM Modeler', 0, 'IMG_20240720_092322.jpg', 'BTM 1st stage, Bangaluru', '0', 'Online', NULL, 0, 0, 'active', '2024-07-20 05:54:08', '68894', '5', NULL, 'Employee'),
(87, 'EMP-0081', 'Sanjay B R ', '2001-02-11', '63615 43671', '2024-04-01', 'sanjaybr.swifterz15@gmail.com', '6c90bce104e555ef5acc46b0e162dd76', 'Employee', 'BIM Modeler', 0, 'IMG_20240720_093727.jpg', 'Yelchanahalli, Bengaluru ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-20 06:11:26', NULL, '5', NULL, 'Employee'),
(88, 'EMP-0082', 'Ravikiran', '2000-02-05', '09538383652', '2024-05-06', 'ravikirantalwar@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, 'Screenshot_20240425-101156.jpg', 'Bangalore\r\nBangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-07-20 06:30:56', NULL, '5', NULL, 'Employee'),
(89, 'EMP-0083', 'Karthigeyan B', '1997-11-17', '+918610046560', '2024-07-01', 'bkarthigeyan1@gmail.com', 'f882cbb2484f527fb5332288652812d4', 'Employee', 'BIM Architect Lead', 0, 'IMG_20230122_221626_812.jpg', 'MIN NAGAR PALLAVAN SALAI Kancheepuram\r\nKanchipuram', '0', 'Online', NULL, 0, 0, 'active', '2024-07-20 06:33:35', NULL, '5', NULL, 'Employee'),
(90, 'EMP-0084', 'PURRU GIRI SAI PRASAD ', '2002-03-21', '7075215225', '2024-02-05', 'purrugirisaiprasad@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, '1000029299.jpg', 'Nagashettihalli ', '0', 'Offline', NULL, 0, 0, 'active', '2024-07-22 18:26:22', NULL, '5', NULL, 'Employee'),
(91, 'EMP-0085', 'Deepan mohanraj', '1998-03-18', '8248438214', '2024-02-05', 'deepanmohanraj@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, 'DSC_8779.JPG', 'Bangalore ', '0', 'Online', NULL, 0, 0, 'active', '2024-07-23 06:35:52', NULL, '5', NULL, 'Employee'),
(92, 'EMP-0086', 'SaiSabarish', '2003-12-03', '9659395553', '2024-03-06', 'saran@swifterz.co', '49bb558128e6423e75108c97dd3e4e25', 'Employee', 'BIM Modeler- MEP', 0, 'WhatsApp Image 2024-06-06 at 3.55.41 PM.jpeg', 'Bangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-07-24 11:07:06', NULL, '5', NULL, 'Employee'),
(93, 'EMP-0087', 'Tanu satti', '2000-06-03', '7892416823', '2023-04-17', 'tangevvasatti@aecearth.in', '57fdd29e54d828758e62c84751326096', 'Employee', 'Business Development Manager', 15, 'Swifterz TM Crop (1).jpg', 'Banglore', '0', NULL, NULL, 0, 0, 'deactive', '2024-08-05 12:59:14', '80113', '5', '1413543', 'Employee'),
(94, 'EMP-0066', 'Punitha.S', '1991-03-11', '6374559883', '2022-04-05', 'punitha@ghate.solutions', 'a37d4a0a3b53e12d98b066866f592ab0', 'Employee', 'Management', 3, 'WhatsApp Image 2024-08-08 at 9.28.48 AM.jpeg', 'Sanjayanagar , Bangalore', '10000', 'Offline', NULL, 0, 0, 'active', '2024-08-08 06:15:03', NULL, '6', '12345678', 'Employee,All'),
(95, 'EMP-0067', 'sateesh sreenivas', '1962-01-18', '9880564152', '2024-08-08', 'sateesh.s1@assetsociety.org', 'e72eb9b334aa00cef141d621aeb4930d', 'Employee', 'CEO', 0, 'IMG-20200212-WA0030.jpg', '2777,14t A main ,8th E cross ,near Attiguppe,Vijaynagar 2nd stage ,Bangalore -560040', '0', 'Online', NULL, 0, 0, 'active', '2024-08-08 09:32:06', NULL, '6', NULL, 'Employee'),
(96, 'EMP-0068', 'Maheen N', '1999-10-10', '8220333514', '2022-03-05', 'maheen@aecearth.in', '68568fa322905a2528a8f311b1faaa32', 'Employee', 'Admin', 0, 'WhatsApp Image 2024-06-24 at 4.51.49 PM (1).jpeg', 'Bangalore', '0', NULL, NULL, 0, 0, 'active', '2024-08-08 11:32:28', NULL, '6', NULL, 'Employee'),
(97, 'EMP-0088', 'Manoj Kumar', '1980-02-07', '9845590739', '2024-06-10', 'manojkumar@swifterz.co', 'd737533dae15c83068e9cbbcb7272ecf', 'Employee', 'Business Development Manager', 0, 'WhatsApp Image 2024-08-08 at 4.53.30 PM.jpeg', '!02, A-4 , Ghataprabha block, NGV ,Kormangala bangalore -47', '0', 'Online', NULL, 0, 98, 'active', '2024-08-08 13:24:06', NULL, '5', NULL, 'Employee'),
(98, 'EMP-0089', 'G Gopal krishna', '1984-02-03', '8095530760', '2023-11-01', 'gopal@swifterz.co', '57919265d0b52f06fd5af2588612d527', 'Employee', 'Technical Director', 0, '5437dfc2-4f56-477b-a975-8b54f0eb5254.jfif', '#F15,second floor ,pyramid watsonia appartment,jakkur,Yalanka', '0', 'Online', NULL, 0, 0, 'active', '2024-08-08 13:25:00', NULL, '5', NULL, 'Employee'),
(99, 'EMP-0090', 'NAGINDRARAO MALKHED', '1973-08-01', '8892145203', '2024-06-10', 'nagendra@swifterz.co', '1278910e60db273ed8e618c54e7d6da9', 'Employee', 'Vice President Projects', 0, 'IMG20161210133551.jpg', '126NE NISARGA LAYOUT JIGANI HOBALI ', '0', 'Online', NULL, 0, 0, 'active', '2024-08-08 13:47:49', NULL, '5', NULL, 'Employee'),
(100, 'EMP-0069', 'Abhishek', '2024-02-12', '9611734459', '2024-02-12', 'Abhishek.aecearth@gmail.com', 'a4ff05eb0115390e2de5dcce50f745bc', 'Employee', 'BDM', 17, 'Sales.jpg', 'bangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-08-09 12:53:49', '98145', '6', 'ooo2', 'Employee'),
(101, 'EMP-0070', 'Dilraj', '1989-01-01', '9606051007', '2024-03-27', 'dilrajkv.aecearth@gmail.com', '569506e51e1eb311a26f93e27bf46502', 'Employee', 'Sales  ', 20, 'Sales.jpg', 'Bangalore', '0', NULL, NULL, 0, 0, 'active', '2024-08-09 13:07:53', NULL, '6', NULL, 'Employee'),
(102, 'EMP-0091', 'Tanu Satti', '2000-06-03', 'Tanu Satti', '2022-04-17', 'thanusatti@gmail.com', '1a9100a2ceb0d616ba414851cbc31c40', 'Employee', 'HR Executive', 0, 'WhatsApp Image 2024-08-05 at 4.17.54 PM (2).jpeg', 'Benglore', '0', 'Online', NULL, 0, 0, 'active', '2024-08-12 06:23:31', NULL, '5', NULL, 'Employee'),
(103, 'EMP-0092', 'Subash S', '2000-01-01', '07397718590', '2018-03-01', 'subash.swifterz@gmail.com', '2c04e409ff11c1861c534dd27d4a93a8', 'Employee', 'Project Manager', 0, 'DP.jpg', 'No. 24, Second floor, Corner Woods, D. Rajgopal Road, Sanjay Nagar, Bangalore??560094.', '0', 'Online', NULL, 0, 0, 'active', '2024-08-12 08:15:36', '22914', '5', '0', 'Employee'),
(104, 'EMP-0093', 'Bharath H.J ', '2002-01-17', '6364053247', '2024-08-01', 'bharathhj@swifterz.co', 'e612dc8483abe31609c245d2f7b91485', 'Employee', 'BIM Modeler', 0, 'IMG_20230627_223718_482.jpg', '                                                                Haravu, Pandavapura(tq), Mandya(district), Karnataka.                                                                ', '0', 'Offline', NULL, 0, 0, 'active', '2024-08-12 09:52:53', '68969', '5', '40092378781', 'Employee'),
(105, 'EMP-0066', 'shanker', '1980-09-09', '9894055835', '2023-01-12', 'shankkerkumar@swifterz.co', '5cf52ad626168727663e25e93868a78a', 'Employee', 'Project Manager', 4, 'WhatsApp Image 2024-06-22 at 12.06.10 PM (2).jpeg', 'bangalore', '0', NULL, NULL, 0, 0, 'active', '2024-08-12 13:41:46', NULL, '1', NULL, 'Employee'),
(106, 'EMP-0094', 'Pavan Kumar N ', '2000-07-05', '8431688648', '2024-08-01', 'pavankumarn@swifterz.co', 'bed96579f1d7246d3e4e093c2fe5ee06', 'Employee', 'BIM Modeler', 0, 'IMG_20230908_052443_326.jpg', '                                                                                                                                Yelahanka,pallanahalli ,Banglore                                                                                                                                 ', '0', 'Online', NULL, 0, 0, 'active', '2024-08-12 13:58:33', NULL, '5', '8431688648', 'Employee'),
(107, 'EMP-0095', 'Shankker Kumar', '2024-07-31', '8220333514', '2024-08-13', 'sk.swifterz@gmail.com', 'dc2580c1f34db92149637493704e109e', 'Employee', 'CEO', 14, 'Swifterz TM Crop (1).jpg', 'Bangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-08-13 09:00:11', NULL, '5', 'nnnkm', 'All'),
(108, 'EMP-0096', 'Tarun Debey', '2024-08-06', '8220333514', '2024-08-30', 'tarundubey.swifterz@gmail.com', 'dc2580c1f34db92149637493704e109e', 'Employee', 'HR Executive', 14, 'Swifterz TM Crop (1).jpg', 'Bangalore', '0', NULL, NULL, 0, 0, 'active', '2024-08-13 09:48:15', NULL, '5', NULL, 'Employee'),
(109, 'EMP-0097', 'Ashwin Kumar', '2024-08-05', '8220333514', '2024-08-20', 'ashwingd.mine@gmail.com', 'dc2580c1f34db92149637493704e109e', 'Employee', 'Graphic Designer', 29, 'Swifterz TM Crop (1).jpg', 'Bangalore', '0', 'Online', NULL, 0, 0, 'active', '2024-08-13 10:01:21', NULL, '5', 'sdfsd', 'Employee'),
(110, 'EMP-0098', 'Sharath Kumar H N ', '2000-01-07', '9480202919', '2024-08-05', 'sharath7swifterz@gmail.com', 'd79c373da2c20c0fe580bd48f8398ca1', 'Employee', 'BIM Modeler', 0, '1000082661.jpg', 'Mandya ', '0', 'Offline', NULL, 0, 0, 'active', '2024-08-16 13:22:10', '63471', '5', NULL, 'Employee'),
(111, 'EMP-0099', 'Anjana Aj', '1998-08-06', '8147847648', '2024-07-01', 'anjana@swiifterz.co', '6d573f70af9736c6b5a7f727254908e9', 'Employee', 'BIM Modeler', 0, 'Screenshot_20240628-134447_Gallery.jpg', 'Babusapalya Sk Clothes General store MmM garden hennur karnataka Bengaluru 560043', '0', NULL, NULL, 0, 0, 'active', '2024-08-19 08:00:45', NULL, '5', NULL, 'Employee'),
(112, 'EMP-0100', 'Shyamala MP', '2000-09-14', '7022892860', '2024-08-01', 'shyamalamp@swifterz.co', 'b2ec2d95c293a49e8b69b60a4ceb9a9f', 'Employee', 'BIM Modeler', 0, 'Document from SHYAMALA   M.P', '                                                                                                                                                                                                Madihalli, Tiptur taluk , Tumkur district, Karnataka                                                                                                                                                                                                 ', '0', 'Online', NULL, 0, 0, 'active', '2024-08-20 06:25:56', '94090', '5', '64174093751', 'Employee'),
(113, 'EMP-0101', 'Anand Thayalaguru', '1984-08-19', '8220333544', '2012-08-12', 'anand.swifterz@gmail.com', '44961fba6242d6fc80b276473eed2e24', 'Employee', 'Management', 14, 'Swifterz TM Crop (1).jpg', 'Bangalore', '0', 'Offline', NULL, 0, 0, 'active', '2024-08-20 14:14:34', '30405', '5', '5656', 'Management'),
(114, 'EMP-0102', 'NAVEENRAJ KS', '1997-02-25', '9791823173', '2024-08-01', 'naveen@swifterz.co', '8b5c6ebe47a577a84047ab223ee9d628', 'Employee', 'BIM Modeler', 0, '1000056836.jpg', 'Indiranagar, tamilnadu ', '0', 'Online', NULL, 0, 0, 'active', '2024-08-21 07:03:13', NULL, '5', NULL, 'Employee'),
(115, 'EMP-0103', 'Sharath Kumar H N', '2000-01-07', '9480202919', '2024-08-05', 'sharathkumarhn@swifterz.co', 'd79c373da2c20c0fe580bd48f8398ca1', 'Employee', 'BIM Modeler', 0, '1000082661.jpg', 'Mandya', '0', 'Online', NULL, 0, 0, 'active', '2024-08-21 07:38:11', NULL, '5', NULL, 'Employee'),
(116, 'EMP-0104', 'Anjana', '1998-08-06', '8147847648', '2024-07-01', 'anjana@swifterz.co', 'dc2580c1f34db92149637493704e109e', 'Employee', 'BIM Modeler', 0, 'Square Fit_2023122403440926.jpg', '                                                                                                                                Kalayan nagar,babusapalya Bengaluru karnataka 560043                                                                                                                                ', '0', 'Online', NULL, 0, 0, 'active', '2024-08-21 13:14:56', NULL, '5', '1234567890', 'Employee'),
(117, 'EMP-0105', 'Ajith Three', '2024-09-10', '1234567890', '2024-09-10', 'ajithkumars.mine@gmail.com', '0f1ba603c1a843a3d02d6c5038d8e959', 'Employee', 'Project Manager', 0, 'swift_jiffy_favicon.jpeg', '#53, 1st Main Road, Maruthi Layout, RMV 2nd Stage, Sanjay Nagar, Bangalore.', '0', NULL, NULL, 0, 0, 'deactive', '2024-09-10 12:06:39', NULL, '5', NULL, 'Employee'),
(118, 'EMP-0106', 'Sabari Raj S R', '2001-05-19', '9789469166', '2024-09-11', 'sabariraj.mine@gmail.com', '60f76e7abd89a15ae5906c6881c7589f', 'Employee', 'Project Manager', 0, 'IMG_7426.png', 'BLR', '0', NULL, NULL, 0, 0, 'active', '2024-09-11 06:58:57', NULL, '5', NULL, 'Employee'),
(119, 'EMP-0067', 'test', '2024-09-11', '997208017', '2024-09-11', 'dhaddevaibhavi@gmail.com', '17ae4741e0c8be5fa97a87bc0bb79535', 'Employee', 'Testing Engineer', 5, 'rad.jpg', 'blaaaa', '0', NULL, NULL, 0, 0, 'deactive', '2024-09-11 12:19:33', NULL, '1', '5421', ''),
(120, 'EMP-0068', 'kushi', '2003-11-06', '9988667788', '2024-06-20', 'shar.mine@gmail.com', '17ae4741e0c8be5fa97a87bc0bb79535', 'Trainee', 'FrontEnd Developer', 1, 'WhatsApp Image 2024-06-28 at 3.25.28 PM.jpeg', 'Bangalore', '0', NULL, NULL, 0, 0, 'deactive', '2024-09-23 10:16:26', NULL, '1', '1234567', 'Employee'),
(121, 'EMP-0069', 'Muthamma ', '1995-12-13', '8105743999', '2024-09-17', 'muthammakajal@mineit.tech', '0167496d5fbf612404bcc5597718f820', 'Employee', 'Hr', 35, 'a3b6b1c6-2474-4db6-a870-8b3f4c22389a.jpg', 'Bangalore ', '0', 'Offline', NULL, 0, 0, 'active', '2024-10-10 08:11:10', NULL, '1', '79173971937198371983718', 'Admin'),
(123, 'EMP-0070', 'Abhimanyu', '1980-06-23', '9600698542', '2025-04-23', 'abhimnayu.mine@gmail.com', '9812bf4702b22e597904949152d3b9f6', 'Employee', 'Management', 3, 'image.jpg', 'Bengaluru', '0', 'Online', NULL, 0, 0, 'active', '2025-04-23 09:48:40', NULL, '1', '1234567890', 'Management,Employee,All'),
(124, 'EMP-0071', 'kavita', '2025-06-19', '7760302371', '2025-06-20', 'kavya@gmail.com', '67e59c9b132fbed35a5b235dfa0877c8', 'Trainee', 'Testing Engineer', 6, 'download.jpg', 'sindhur road,totad mane', '0', NULL, NULL, 0, 0, 'active', '2025-06-16 16:19:09', NULL, '1', '574637687', 'Employee'),
(125, 'EMP-KAR-145209', 'Karan', '1990-01-01', '7448907020', '2025-10-09', 'mlkaran2004@gmail.com', '619ffea8fedf1e8a2d81e04658dab747', 'Employee', 'hr', 2, 'user.png', 'Default Address', '0', 'Offline', NULL, 0, 0, 'active', '2025-10-09 18:22:09', NULL, '1', NULL, 'Management,Project Manager,Employee'),
(126, 'EMP-KAR-150001', 'Karan ', '1990-01-01', '9876543210', '2025-10-09', 'karan@jiffy.com', '6bd9d12f9af2d0569a6cf8639299cd0e', 'Employee', 'Senior Manager', 1, 'Gemini_Generated_Image_1ewyof1ewyof1ewy.png', 'Default Address', '0', 'Online', NULL, 0, 0, 'active', '2025-10-09 18:30:01', NULL, '1', '695849542655', 'Management,Project Manager,Employee');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `detials` varchar(10000) NOT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `event_mode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `date`, `start_time`, `end_time`, `location`, `detials`, `Company_id`, `event_mode`) VALUES
(13, 'tgb', '2025-04-09', '14:38:00', '14:34:00', 'bangalore', '<p>cvc</p>\r\n', '1', 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `leave_type` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `leave_range` varchar(50) NOT NULL DEFAULT '0',
  `days_count` int(11) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hours_per_duration` varchar(255) DEFAULT NULL,
  `time_range` varchar(255) DEFAULT NULL,
  `permission_time` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `title`, `leave_type`, `start_date`, `end_date`, `leave_range`, `days_count`, `company_id`, `created_at`, `hours_per_duration`, `time_range`, `permission_time`) VALUES
(2, 'Casual Leave', 2, '2024-06-18', '0000-00-00', 'Monthly', 2, 1, '2024-06-18 07:02:31', NULL, NULL, NULL),
(5, 'Permission', 2, NULL, NULL, 'Monthly', 0, 1, '2024-06-25 05:02:38', '1', '06:00-07:00', NULL),
(15, 'Makara Sankranti', 1, '2024-01-15', '2024-01-15', '', 0, 2, '2024-06-28 05:11:38', NULL, NULL, NULL),
(14, 'New Year', 1, '2024-01-01', '2024-01-01', '1', 1, 2, '2024-06-28 05:10:59', NULL, NULL, NULL),
(16, 'Rebulic Day', 1, '2024-01-26', '2024-01-26', '', 0, 2, '2024-06-28 05:12:06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `interviewmeeting`
--

CREATE TABLE `interviewmeeting` (
  `ID` int(11) NOT NULL,
  `InterviewerName` varchar(255) NOT NULL,
  `Roles` varchar(255) NOT NULL,
  `MeetingDateTime` datetime NOT NULL,
  `MeetingLink` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_type` varchar(50) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_number` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `tax` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_type`, `project_name`, `customer_name`, `address`, `email`, `date`, `due_date`, `created_at`, `invoice_number`, `Company_id`, `status`, `tax`) VALUES
(9, 'Project', '5', '1', 'salem', 'jayam4413@gmail.com', '2024-06-18', '2024-06-20', '2024-06-18 09:52:16', 'INV-79213', '1', 'Pending', '24'),
(10, 'Project', '10', '1', 'madagsdsdsaskar1', 'jayamani@mineit.tech', '2024-08-25', '2024-08-31', '2024-08-25 08:04:14', 'INV-51945', '1', 'Paid', '3');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_services`
--

CREATE TABLE `invoice_services` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_services`
--

INSERT INTO `invoice_services` (`id`, `invoice_id`, `service_name`, `description`, `unit_cost`, `quantity`, `created_at`) VALUES
(1, 9, 'dashboard', 'dscsdasda', 2000.00, 3, '2024-06-18 09:52:16'),
(2, 10, 'login', 'asdasd', 4.00, 200, '2024-08-25 08:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `assign_to` varchar(50) DEFAULT NULL,
  `issue` varchar(50) DEFAULT NULL,
  `Ticketid` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `work_experience` enum('entryLevel','midLevel','seniorLevel') NOT NULL,
  `source` enum('jobPortal','socialMedia','referral','ourportal') NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `jobid` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `submission_date` timestamp NULL DEFAULT current_timestamp(),
  `interviewdate` varchar(255) NOT NULL DEFAULT '0',
  `interviewlink` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `status1` varchar(255) NOT NULL DEFAULT 'Pending',
  `offer_letter` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `full_name`, `email`, `phone`, `address`, `work_experience`, `source`, `resume_path`, `jobid`, `status`, `submission_date`, `interviewdate`, `interviewlink`, `Company_id`, `cost`, `status1`, `offer_letter`) VALUES
(2, 'Meena', 'meena@gmail.com', '8765431526', 'xyz', 'midLevel', 'socialMedia', './resume_directory/TELEsuite logo brief.pdf', 72, 'shortlist', '2024-10-03 09:37:36', '', 'jkhjad', '1', NULL, 'Pending', NULL),
(3, 'Nehru Jarvis', 'jaxynijuri@mailinator.com', '6876 123-7071', 'Quisquam sint labori', 'midLevel', 'jobPortal', './resume_directory/TELEsuite logo brief.pdf', 72, 'shortlist', '2024-10-03 09:40:04', '', 'jakdjkadhkadh', '1', NULL, 'Pending', NULL),
(4, 'Ashwini', 'ashwini@mineit.tech', '8909876567', 'bengalore', 'entryLevel', 'jobPortal', './resume_directory/Human Resource.pdf', 42, '0', '2024-10-04 09:29:47', '0', NULL, '1', NULL, 'Pending', NULL),
(5, 'Ashwini', 'ashwini@mineit.tech', '8909876567', 'bengalore', 'entryLevel', 'referral', './resume_directory/Human Resource.pdf', 42, '0', '2024-10-05 07:21:41', '0', NULL, '1', NULL, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaveemail`
--

CREATE TABLE `leaveemail` (
  `id` int(11) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `Company_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_data`
--

CREATE TABLE `login_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login_time` varchar(255) NOT NULL,
  `logout_time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `login_data`
--

INSERT INTO `login_data` (`id`, `name`, `email`, `login_time`, `logout_time`) VALUES
(6, 'Jayamani M', 'jayamani@mineit.tech', '2024-05-30 15:21:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meetingaction`
--

CREATE TABLE `meetingaction` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `response` varchar(255) NOT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetingaction`
--

INSERT INTO `meetingaction` (`id`, `meeting_id`, `response`, `remark`, `created_at`, `user_id`) VALUES
(1, 15, 'accept', 'i will come', '2024-06-19 06:12:38', '7'),
(2, 13, 'accept', '', '2024-06-19 10:22:31', '29'),
(3, 24, 'accept', '', '2024-07-01 12:51:21', '58');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messages_id` int(11) NOT NULL,
  `outgoing` varchar(20) NOT NULL,
  `incoming` varchar(20) NOT NULL,
  `messages` varchar(5000) NOT NULL,
  `file_path` mediumtext DEFAULT NULL,
  `message_status` int(11) DEFAULT 0,
  `date` varchar(255) DEFAULT NULL,
  `ring` varchar(255) NOT NULL DEFAULT '0',
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messages_id`, `outgoing`, `incoming`, `messages`, `file_path`, `message_status`, `date`, `ring`, `Company_id`) VALUES
(1, '476', '495', 'Screenshot_2022-08-30-19-01-19-06_1c337646f29875672b5a61192b9010f9.jpg', './../uploads/chat/Screenshot_2022-08-30-19-01-19-06_1c337646f29875672b5a61192b9010f9.jpg', 0, '24-05:2024 11:08:AM', '1', NULL),
(2, '495', '483', 'good morning  ????????', NULL, 1, '27-05:2024 09:59:AM', '1', NULL),
(3, '495', '483', '????????????????????', NULL, 1, '27-05:2024 10:00:AM', '1', NULL),
(4, '483', '495', 'Happy morn PM', NULL, 1, '27-05:2024 10:01:AM', '1', NULL),
(5, '495', '483', 'ok ma ????????????????????????', NULL, 1, '27-05:2024 02:26:PM', '1', NULL),
(6, '1', '2', 'HAI ANUSIYA ', NULL, 1, '03-06:2024 12:10:PM', '1', NULL),
(7, '2', '1', 'hai mam good morning ????????????', NULL, 1, '04-06:2024 07:49:AM', '1', NULL),
(8, '7', '2', 'hai good morning', NULL, 1, '08-06:2024 08:06:AM', '1', NULL),
(9, '2', '7', 'hai jai', NULL, 1, '10-06:2024 06:42:PM', '1', NULL),
(10, '49', '21', 'hii good morning', NULL, 1, '11-06:2024 10:10:AM', '0', NULL),
(11, '21', '49', 'hlo....happy morn', NULL, 1, '11-06:2024 10:19:AM', '1', NULL),
(12, '49', '36', 'hii', NULL, 1, '12-06:2024 05:39:PM', '1', NULL),
(13, '49', '36', 'you are the best <3', NULL, 1, '12-06:2024 05:39:PM', '1', NULL),
(14, '36', '49', 'I know :)', NULL, 1, '12-06:2024 05:40:PM', '1', NULL),
(15, '36', '21', 'hi', NULL, 1, '12-06:2024 05:40:PM', '1', NULL),
(16, '36', '33', 'Hi TL :)', NULL, 1, '12-06:2024 05:41:PM', '1', NULL),
(17, '21', '36', 'hlo', NULL, 1, '13-06:2024 09:25:AM', '1', NULL),
(18, '26', '7', 'Hi', NULL, 1, '18-06:2024 10:12:AM', '1', NULL),
(19, '26', '7', 'Good Morning Jai', NULL, 1, '18-06:2024 10:12:AM', '1', NULL),
(20, '26', '7', 'How are you?', NULL, 1, '18-06:2024 10:12:AM', '1', NULL),
(21, '7', '26', 'fine you ', NULL, 1, '18-06:2024 10:34:AM', '1', NULL),
(22, '26', '7', 'I\'m good jai', NULL, 1, '18-06:2024 10:35:AM', '1', NULL),
(23, '7', '26', 'ok da', NULL, 1, '18-06:2024 10:35:AM', '1', NULL),
(24, '7', '26', 'do work', NULL, 1, '18-06:2024 10:35:AM', '1', NULL),
(25, '26', '7', 'Ok sir', NULL, 1, '18-06:2024 10:35:AM', '1', NULL),
(26, '56', '12', 'hii', NULL, 1, '18-06:2024 02:23:PM', '1', NULL),
(27, '33', '36', 'Hey Santhosh', NULL, 1, '18-06:2024 03:20:PM', '1', NULL),
(28, '13', '6', 'Hii', NULL, 1, '18-06:2024 03:47:PM', '1', NULL),
(29, '12', '13', 'hii', NULL, 0, '18-06:2024 04:51:PM', '1', NULL),
(30, '7', '26', 'hai da ', NULL, 1, '18-06:2024 06:23:PM', '1', NULL),
(31, '26', '7', 'Hi jai', NULL, 1, '18-06:2024 06:24:PM', '1', NULL),
(32, '37', '7', 'HI da macha ', NULL, 1, '18-06:2024 06:29:PM', '1', NULL),
(33, '7', '26', 'variya illaya', NULL, 1, '18-06:2024 06:44:PM', '1', NULL),
(34, '7', '37', 'sollu macha', NULL, 0, '18-06:2024 06:44:PM', '1', NULL),
(35, '26', '7', 'Varanuma jai?', NULL, 1, '18-06:2024 06:45:PM', '1', NULL),
(36, '41', '37', 'HII', NULL, 0, '18-06:2024 06:50:PM', '1', NULL),
(37, '41', '7', 'HII', NULL, 1, '18-06:2024 06:51:PM', '1', NULL),
(38, '7', '26', 'yes', NULL, 1, '19-06:2024 08:56:AM', '1', NULL),
(39, '7', '41', 'hai Good morning ????????????', NULL, 1, '19-06:2024 08:56:AM', '1', NULL),
(40, '26', '7', 'Good Morning Jai', NULL, 1, '19-06:2024 10:05:AM', '1', NULL),
(41, '26', '33', 'Hi Dora', NULL, 1, '19-06:2024 10:05:AM', '1', NULL),
(42, '26', '33', 'Good Morning', NULL, 1, '19-06:2024 10:05:AM', '1', NULL),
(43, '33', '26', 'Hi Da Bujji', NULL, 1, '19-06:2024 10:07:AM', '1', NULL),
(44, '29', '33', 'Hi????', NULL, 1, '19-06:2024 10:08:AM', '1', NULL),
(45, '33', '29', 'Hi ????', NULL, 1, '19-06:2024 10:12:AM', '1', NULL),
(46, '49', '21', 'Screenshot 2024-06-19 103014.png', './../uploads/chat/Screenshot 2024-06-19 103014.png', 1, '19-06:2024 10:31:AM', '1', NULL),
(47, '7', '26', 'do work da ', NULL, 1, '19-06:2024 10:47:AM', '1', NULL),
(48, '26', '7', 'Ok jai', NULL, 1, '19-06:2024 10:48:AM', '1', NULL),
(49, '10', '49', 'u r the best', NULL, 1, '19-06:2024 03:32:PM', '1', NULL),
(50, '36', '21', ':)', NULL, 1, '19-06:2024 03:36:PM', '1', NULL),
(51, '21', '36', ':)', NULL, 1, '19-06:2024 03:42:PM', '1', NULL),
(52, '7', '26', 'hai come to caben', NULL, 1, '19-06:2024 03:43:PM', '1', NULL),
(53, '26', '7', 'ok', NULL, 1, '19-06:2024 03:43:PM', '1', NULL),
(54, '7', '2', 'Good morning ', NULL, 1, '20-06:2024 09:37:AM', '1', NULL),
(55, '2', '7', 'Very good morning', NULL, 1, '20-06:2024 09:55:AM', '1', NULL),
(56, '7', '2', 'Why U Login Today', NULL, 1, '20-06:2024 10:11:AM', '1', NULL),
(57, '6', '13', 'Hii Mr. kailash', NULL, 0, '20-06:2024 10:21:AM', '1', NULL),
(58, '7', '26', 'come to me ', NULL, 1, '20-06:2024 10:22:AM', '1', NULL),
(59, '26', '7', 'ok', NULL, 1, '20-06:2024 10:23:AM', '1', NULL),
(60, '22', '28', 'hi', NULL, 1, '20-06:2024 10:30:AM', '1', NULL),
(61, '22', '28', 'sdhgdfh', NULL, 1, '20-06:2024 10:31:AM', '1', NULL),
(62, '22', '28', 'cvnb', NULL, 1, '20-06:2024 10:31:AM', '1', NULL),
(63, '22', '28', 'sv bdv', NULL, 1, '20-06:2024 10:31:AM', '1', NULL),
(64, '2', '7', 'this is vaibhavi bro ..... i am testing team lead panel', NULL, 1, '20-06:2024 10:31:AM', '1', NULL),
(65, '21', '31', 'Send a message-Observe the message in the chat window, Check the timestamp  displayed next to the message The message should appear with the correct  formatting and The correct timestamp should be displayed', NULL, 1, '20-06:2024 12:09:PM', '1', NULL),
(66, '21', '31', 'You Send a message-Observe the message in the chat window, Check the timestamp displayed next to the message The message should appear with the correct formatting and The correct timestamp should be displayedThe message displayed in correct format and The correct timestamp is displayed.Login as user A -Navigate to chat-Search or  a friend-Type a text-Click on send-Verify that text appears in the chat window and check whether that friend receives text                                                                                                                                                Login as user A -Navigate to chat-Search or  a friend-Type a text-Click on send-Verify that text appears in the chat window and check whether that friend receives text                                                                                               Login as user A -Navigate to chat-Search or  a friend-Type a text-Click on send-Verify that text appears in the chat window and check whether that friend receives text ', NULL, 1, '20-06:2024 12:11:PM', '1', NULL),
(67, '21', '31', 'Login as user A -Navigate to chat-Search or  a friend-Type a text-Click on send-Verify that text appears in the chat window and check whether that friend receives text                                                                                                       Login as user A -Navigate to chat-Search or  a friend-Type a text-Click on send-Verify that text appears in the chat window and check whether that friend receives text ', NULL, 1, '20-06:2024 12:13:PM', '1', NULL),
(68, '49', '21', 'testing        hiii', NULL, 1, '20-06:2024 12:13:PM', '1', NULL),
(69, '21', '49', 'tested     hello :)', NULL, 1, '20-06:2024 12:15:PM', '1', NULL),
(70, '49', '21', 'thanks', NULL, 1, '20-06:2024 12:15:PM', '1', NULL),
(71, '49', '10', 'thanks', NULL, 1, '20-06:2024 12:16:PM', '1', NULL),
(72, '49', '6', 'suman hii', NULL, 1, '20-06:2024 12:16:PM', '1', NULL),
(73, '10', '56', 'hii', NULL, 1, '20-06:2024 12:19:PM', '1', NULL),
(74, '21', '31', 'hihiiii', NULL, 1, '20-06:2024 12:23:PM', '1', NULL),
(75, '6', '49', 'Hello Mr.Bipin', NULL, 1, '20-06:2024 02:12:PM', '1', NULL),
(76, '7', '2', 'okok ', NULL, 1, '20-06:2024 04:48:PM', '1', NULL),
(77, '7', '26', 'ok da sathudo', NULL, 1, '20-06:2024 04:48:PM', '1', NULL),
(78, '26', '7', 'Ok Jai', NULL, 1, '20-06:2024 04:49:PM', '1', NULL),
(79, '26', '50', 'https://jiffy.mineit.tech/jiffy/video/index.php?roomID=9475', NULL, 1, '20-06:2024 04:52:PM', '1', NULL),
(80, '22', '28', 'ahsvb', NULL, 1, '24-06:2024 03:48:PM', '1', NULL),
(81, '22', '28', 'ascvasv', NULL, 1, '24-06:2024 03:48:PM', '1', NULL),
(82, '22', '28', 'jhsabvcjhasb', NULL, 1, '24-06:2024 03:48:PM', '1', NULL),
(83, '22', '28', 'jkasbvcjhsab', NULL, 1, '24-06:2024 03:48:PM', '1', NULL),
(84, '22', '28', 'kxjbvb', NULL, 1, '24-06:2024 03:48:PM', '1', NULL),
(85, '22', '28', 'jhgbvjhcb', NULL, 1, '24-06:2024 03:48:PM', '1', NULL),
(86, '28', '22', 'hi', NULL, 1, '24-06:2024 03:50:PM', '1', NULL),
(87, '28', '22', 'bar.png', './../uploads/chat/bar.png', 1, '24-06:2024 03:50:PM', '1', NULL),
(88, '7', '26', 'good morning', NULL, 1, '25-06:2024 08:13:AM', '1', NULL),
(89, '26', '7', 'Good Morning Jai', NULL, 1, '25-06:2024 10:45:AM', '1', NULL),
(90, '62', '64', 'hi', NULL, 1, '25-06:2024 11:16:AM', '0', NULL),
(91, '7', '26', 'Good Morning', NULL, 1, '26-06:2024 09:02:AM', '1', NULL),
(92, '26', '7', 'Good Morning Jai', NULL, 1, '26-06:2024 10:06:AM', '1', NULL),
(93, '1', '7', 'hai', NULL, 1, '26-06:2024 10:06:AM', '1', NULL),
(94, '26', '7', 'Have a great day!!', NULL, 1, '26-06:2024 10:06:AM', '1', NULL),
(95, '29', '33', 'Hello', NULL, 1, '26-06:2024 10:27:AM', '1', NULL),
(96, '29', '33', 'Hi', NULL, 1, '26-06:2024 10:27:AM', '1', NULL),
(97, '1', '7', 'ok', NULL, 1, '26-06:2024 11:05:AM', '1', NULL),
(98, '1', '7', 'hai', NULL, 1, '26-06:2024 11:07:AM', '1', NULL),
(99, '1', '7', 'hai', NULL, 1, '26-06:2024 11:13:AM', '1', NULL),
(100, '50', '26', 'Minutes_of_Meeting - 24th June - AECearth.pdf', './../uploads/chat/Minutes_of_Meeting - 24th June - AECearth.pdf', 1, '27-06:2024 10:14:AM', '1', NULL),
(101, '7', '25', 'hai mam ', NULL, 1, '27-06:2024 10:15:AM', '1', NULL),
(102, '7', '25', 'you apply for leave ', NULL, 1, '27-06:2024 10:16:AM', '1', NULL),
(103, '48', '21', 'https://bluechipservicesinternational.org/BLUECHIP/index.jsp', NULL, 1, '27-06:2024 05:13:PM', '1', NULL),
(104, '34', '15', 'hi divya morning', NULL, 1, '01-07:2024 12:03:PM', '1', NULL),
(105, '34', '15', 'i hv one error in the backend not getting that error weather its code error or database error', NULL, 1, '01-07:2024 12:04:PM', '1', NULL),
(106, '34', '25', 'What\'s ur doubt ', NULL, 1, '01-07:2024 12:05:PM', '1', NULL),
(107, '48', '21', ' Actions builder = new Actions(driver);   Action myAction = builder.click(driver.findElement(My Element))        .release()        .build();      myAction.perform();      Robot robot = new Robot();     robot.keyPress(KeyEvent.VK_CONTROL);     robot.keyPress(KeyEvent.VK_V);     robot.keyRelease(KeyEvent.VK_V);     robot.keyRelease(KeyEvent.VK_CONTROL);     robot.keyPress(KeyEvent.VK_ENTER);     robot.keyRelease(KeyEvent.VK_ENTER);', NULL, 1, '01-07:2024 12:41:PM', '1', NULL),
(108, '50', '7', 'Hello Jay, Good Afternoon Could you please send me the document of \"PyMySql\"  Thanks & Regards Turab Hussain React Developer MINE, Bangalore', NULL, 1, '01-07:2024 02:10:PM', '1', NULL),
(109, '26', '33', 'Hi Dora', NULL, 1, '01-07:2024 03:50:PM', '1', NULL),
(110, '26', '33', 'How are you?', NULL, 1, '01-07:2024 03:50:PM', '1', NULL),
(111, '48', '15', 'https://bluechipservicesinternational.org/BLUECHIP/student/users-profile.jsp    once i submit all details in edit profile and saving changes page is navigated to HTTP Status 500 ??? Internal Server Error', NULL, 1, '01-07:2024 05:19:PM', '1', NULL),
(112, '7', '50', 'ok da', NULL, 1, '01-07:2024 05:37:PM', '1', NULL),
(113, '25', '7', 'Screenshot 2024-07-02 at 10.10.51???AM.png', './../uploads/chat/Screenshot 2024-07-02 at 10.10.51???AM.png', 1, '02-07:2024 10:12:AM', '1', NULL),
(114, '25', '7', 'jai i kept holiday at 28-06-2024 (friday) only jai', './../uploads/chat/Screenshot 2024-07-02 at 10.10.51???AM.png', 1, '02-07:2024 10:13:AM', '1', NULL),
(115, '25', '34', 'ntg le busy person', NULL, 1, '02-07:2024 10:14:AM', '1', NULL),
(116, '48', '21', 'Environment:?? Os: winows Device: DESKTOP-NAFHVHF Browser: Chrome processor: Intel(R) Core(TM) i3 CPU ????????????????550 ??@ 3.20GHz ????3.20 GHz RAM: 4.00 GB (3.80 GB usable)', NULL, 1, '02-07:2024 10:17:AM', '1', NULL),
(117, '21', '26', 'Good morning bro', NULL, 1, '02-07:2024 10:21:AM', '1', NULL),
(118, '21', '26', '???', NULL, 1, '02-07:2024 10:21:AM', '1', NULL),
(119, '26', '21', '????', NULL, 1, '02-07:2024 10:22:AM', '1', NULL),
(120, '26', '21', 'Good morning thangi', NULL, 1, '02-07:2024 10:22:AM', '1', NULL),
(121, '26', '27', 'IF(b.bid_status = 1, true, false) AS applied_for_bid', NULL, 1, '02-07:2024 12:25:PM', '1', NULL),
(122, '26', '7', 'Good Morning Jai', NULL, 1, '03-07:2024 10:01:AM', '1', NULL),
(123, '26', '7', 'Have a wonderful day!', NULL, 1, '03-07:2024 10:02:AM', '1', NULL),
(124, '47', '7', 'hi annen', NULL, 1, '03-07:2024 11:24:AM', '1', NULL),
(125, '47', '26', 'Hi annen', NULL, 1, '03-07:2024 11:25:AM', '1', NULL),
(126, '26', '47', 'Hi ', NULL, 1, '03-07:2024 11:26:AM', '1', NULL),
(127, '26', '47', 'Good Morning', NULL, 1, '03-07:2024 11:26:AM', '1', NULL),
(128, '47', '26', 'good morning nea', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(129, '47', '26', 'break varalaiya', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(130, '26', '47', 'Enga ', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(131, '47', '26', 'kudika povom', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(132, '47', '26', 'tea kudika nea ', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(133, '26', '47', 'Enga', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(134, '47', '26', 'ginger tea shop', NULL, 1, '03-07:2024 11:28:AM', '1', NULL),
(135, '26', '47', 'U go', NULL, 1, '03-07:2024 11:29:AM', '1', NULL),
(136, '47', '26', 'en nea neeyum va polam', NULL, 1, '03-07:2024 11:29:AM', '1', NULL),
(137, '26', '47', 'Neenga ponga ', NULL, 1, '03-07:2024 11:29:AM', '1', NULL),
(138, '26', '27', 'Hello', NULL, 1, '03-07:2024 11:29:AM', '1', NULL),
(139, '7', '25', 'ok ma', NULL, 1, '03-07:2024 11:56:AM', '1', NULL),
(140, '39', '7', 'https://docs.google.com/document/d/1iVryI_OwUeZ-YHWP9wgHOpboQ70dLL-jBwi3nuoySSs/edit', NULL, 1, '03-07:2024 05:21:PM', '1', NULL),
(141, '15', '34', 'can u please share the code', NULL, 1, '03-07:2024 05:55:PM', '1', NULL),
(142, '15', '34', 'i will check and inform', NULL, 1, '03-07:2024 05:55:PM', '1', NULL),
(143, '26', '7', 'Good morning jai', NULL, 1, '04-07:2024 09:58:AM', '1', NULL),
(144, '26', '7', 'How are you?', NULL, 1, '04-07:2024 09:58:AM', '1', NULL),
(145, '33', '26', 'Hi Bujji', NULL, 1, '04-07:2024 04:23:PM', '1', NULL),
(146, '33', '26', 'Im fine, thanks, how are you from?', NULL, 1, '04-07:2024 04:24:PM', '1', NULL),
(147, '34', '15', 'ok got it thank you', NULL, 1, '05-07:2024 10:23:AM', '1', NULL),
(148, '34', '25', 'ok ', NULL, 1, '05-07:2024 10:24:AM', '1', NULL),
(149, '25', '34', 'enu sunila.....', NULL, 1, '05-07:2024 11:30:AM', '1', NULL),
(150, '48', '26', 'once u updated hosted URL pls share to me', NULL, 1, '05-07:2024 12:23:PM', '1', NULL),
(151, '26', '48', 'Ok Purnima Got it', NULL, 1, '06-07:2024 10:25:AM', '1', NULL),
(152, '39', '7', 'https://codecanyon.net/item/hd-wallpaper-android-app-with-firebase-backend-and-admob-ads/26396506', NULL, 1, '06-07:2024 11:05:AM', '1', NULL),
(153, '39', '7', 'https://codecanyon.net/item/fire-wall-native-android-hd-wallpaper-app-with-firebase-backend/23871088', NULL, 1, '06-07:2024 11:06:AM', '1', NULL),
(154, '44', '42', 'Hello', NULL, 1, '08-07:2024 03:43:PM', '1', NULL),
(155, '44', '42', 'Rahul ????', NULL, 1, '08-07:2024 03:43:PM', '1', NULL),
(156, '44', '42', 'I need reply', NULL, 1, '08-07:2024 03:43:PM', '1', NULL),
(157, '44', '42', 'Ignore >>>>>>?????', NULL, 1, '08-07:2024 03:44:PM', '1', NULL),
(158, '27', '26', 'Hi', NULL, 1, '09-07:2024 10:11:AM', '1', NULL),
(159, '21', '48', '[RemoteTestNG] detected TestNG version 7.4.0 Opening Chrome browser as Default browser SLF4J: No SLF4J providers were found. SLF4J: Defaulting to no-operation (NOP) logger implementation SLF4J: See https://www.slf4j.org/codes.html#noProviders for further details. Jul 09, 2024 11:12:30 AM org.openqa.selenium.devtools.CdpVersionFinder findNearestMatch WARNING: Unable to find an exact match for CDP version 126, returning the closest version; found: 122; Please update to a Selenium version that supports CDP version 126 Opening Chrome browser as Default browser Jul 09, 2024 11:12:47 AM org.openqa.selenium.devtools.CdpVersionFinder findNearestMatch WARNING: Unable to find an exact match for CDP version 126, returning the closest version; found: 122; Please update to a Selenium version that supports CDP version 126 Opening Chrome browser as Default browser Jul 09, 2024 11:13:05 AM org.openqa.selenium.devtools.CdpVersionFinder findNearestMatch WARNING: Unable to find an exact match for CDP version 126, returning the closest version; found: 122; Please update to a Selenium version that supports CDP version 126 FAILED: login(\"vaibhavi@mineit.tech\", \"Vaibhu@1412\") org.openqa.selenium.NoSuchElementException: no such element: Unable to locate element: {\"method\":\"xpath\",\"selector\":\"//a[text()=\' IT Solution\']\"}   (Session info: chrome=126.0.6478.127) For documentation on this error, please visit: https://www.selenium.dev/documentation/webdriver/troubleshooting/errors#no-such-element-exception Build info: version: \'4.18.1\', revision: \'b1d3319b48\' System info: os.name: \'Windows 11\', os.arch: \'amd64\', os.version: \'10.0\', java.version: \'18.0.2\' Driver info: org.openqa.selenium.chrome.ChromeDriver Command: [35717d41563e8c7342744a14d4c6a2b1, findElement {using=xpath, value=//a[text()=\' IT Solution\']}] Capabilities {acceptInsecureCerts: false, browserName: chrome, browserVersion: 126.0.6478.127, chrome: {chromedriverVersion: 126.0.6478.126 (d36ace6122e..., userDataDir: C:\\Users\\Vaibhavi\\AppData\\L...}, fedcm:accounts: true, goog:chromeOptions: {debuggerAddress: localhost:60775}, networkConnectionEnabled: false, pageLoadStrategy: normal, platformName: windows, proxy: Proxy(), se:cdp: ws://localhost:60775/devtoo..., se:cdpVersion: 126.0.6478.127, setWindowRect: true, strictFileInteractability: false, timeouts: {implicit: 0, pageLoad: 300000, script: 30000}, unhandledPromptBehavior: dismiss and notify, webauthn:extension:credBlob: true, webauthn:extension:largeBlob: true, webauthn:extension:minPinLength: true, webauthn:extension:prf: true, webauthn:virtualAuthenticators: true} Session ID: 35717d41563e8c7342744a14d4c6a2b1 	at java.base/jdk.internal.reflect.DirectConstructorHandleAccessor.newInstance(DirectConstructorHandleAccessor.java:67) 	at java.base/java.lang.reflect.Constructor.newInstanceWithCaller(Constructor.java:499) 	at java.base/java.lang.reflect.Constructor.newInstance(Constructor.java:483) 	at org.openqa.selenium.remote.ErrorCodec.decode(ErrorCodec.java:167) 	at org.openqa.selenium.remote.codec.w3c.W3CHttpResponseCodec.decode(W3CHttpResponseCodec.java:138) 	at org.openqa.selenium.remote.codec.w3c.W3CHttpResponseCodec.decode(W3CHttpResponseCodec.java:50) 	at org.openqa.selenium.remote.HttpCommandExecutor.execute(HttpCommandExecutor.java:190) 	at org.openqa.selenium.remote.service.DriverCommandExecutor.invokeExecute(DriverCommandExecutor.java:216) 	at org.openqa.selenium.remote.service.DriverCommandExecutor.execute(DriverCommandExecutor.java:174) 	at org.openqa.selenium.remote.RemoteWebDriver.execute(RemoteWebDriver.java:519) 	at org.openqa.selenium.remote.ElementLocation$ElementFinder$2.findElement(ElementLocation.java:165) 	at org.openqa.selenium.remote.ElementLocation.findElement(ElementLocation.java:59) 	at org.openqa.selenium.remote.RemoteWebDriver.findElement(RemoteWebDriver.java:356) 	at org.openqa.selenium.remote.RemoteWebDriver.findElement(RemoteWebDriver.java:350) 	at org.openqa.selenium.support.pagefactory.DefaultElementLocator.findElement(DefaultElementLocator.java:68) 	at org.openqa.selenium.support.pagefactory.internal.LocatingElementHandler.invoke(LocatingElementHandler.java:38) 	at jdk.proxy2/jdk.proxy2.$Proxy17.submit(Unknown Source) 	at Pages.ModulesPage.clickOn_ITsolutions(ModulesPage.java:28) 	at test.Login.login(Login.java:23) 	at java.base/jdk.internal.reflect.DirectMethodHandleAccessor.invoke(DirectMethodHandleAccessor.java:104) 	at java.base/java.lang.reflect.Method.invoke(Method.java:577) 	at org.testng.internal.MethodInvocationHelper.invokeMethod(MethodInvocationHelper.java:133) 	at org.testng.internal.TestInvoker.invokeMethod(TestInvoker.java:598) 	at org.testng.internal.TestInvoker.invokeTestMethod(TestInvoker.java:173) 	at org.testng.internal.MethodRunner.runInSequence(MethodRunner.java:46) 	at org.testng.internal.TestInvoker$MethodInvocationAgent.invoke(TestInvoker.java:824) 	at org.testng.internal.TestInvoker.invokeTestMethods(TestInvoker.java:146) 	at org.testng.internal.TestMethodWorker.inv', NULL, 1, '09-07:2024 11:13:AM', '1', NULL),
(160, '48', '21', 'WebElement element = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath(\"//a[text()=\' IT Solution\']\")));', NULL, 1, '09-07:2024 11:19:AM', '1', NULL),
(161, '26', '27', 'Good Morning', NULL, 1, '10-07:2024 09:59:AM', '1', NULL),
(162, '48', '21', 'https://swifterz.co/', NULL, 1, '11-07:2024 12:27:PM', '1', NULL),
(163, '48', '21', 'https://www.digitalocean.com/community/tutorials/java-programming-interview-questions', NULL, 1, '12-07:2024 03:47:PM', '1', NULL),
(164, '48', '21', 'Hi', NULL, 1, '12-07:2024 03:47:PM', '1', NULL),
(165, '48', '21', 'hru', NULL, 1, '12-07:2024 03:47:PM', '1', NULL),
(166, '48', '21', 'good afternoon', NULL, 1, '12-07:2024 03:47:PM', '1', NULL),
(167, '21', '48', 'good night', NULL, 1, '12-07:2024 03:47:PM', '1', NULL),
(168, '49', '6', 'good morning broo', NULL, 1, '15-07:2024 10:14:AM', '1', NULL),
(169, '49', '21', 'gm tangi', NULL, 1, '15-07:2024 10:14:AM', '1', NULL),
(170, '48', '21', ':)', NULL, 1, '15-07:2024 03:11:PM', '1', NULL),
(171, '48', '26', 'ok', NULL, 1, '15-07:2024 04:56:PM', '1', NULL),
(172, '21', '49', 'Gm Anna', NULL, 1, '16-07:2024 10:00:AM', '1', NULL),
(173, '48', '52', 'Happy Birthday ????', NULL, 1, '17-07:2024 09:29:AM', '1', NULL),
(174, '49', '67', 'Subject: Clarification on Employment Status and Request for Laptop Provision  Dear Karthikeyan Sir,  I hope this message finds you well. I am grateful for the opportunity to intern at MINE INFOTECH and am excited about the possibility of a permanent role after my internship. To enhance my productivity, I kindly request the provision of a company laptop for the remaining month of my internship and beyond. This will significantly help me perform my tasks more effectively.  Additionally, thank you for permitting me to work from home permanently this flexibility is greatly appreciated. I would also appreciate clarification on the process and criteria for transitioning to a permanent role. I look forward to contributing further to the  MINE INFOTECH.  Best regards,   Bipin Chavan   8055718271', NULL, 1, '19-07:2024 12:52:PM', '1', NULL),
(175, '76', '75', 'HI', NULL, 0, '19-07:2024 02:28:PM', '0', NULL),
(176, '6', '49', 'hey bro ', NULL, 1, '22-07:2024 10:05:AM', '1', NULL),
(177, '76', '78', 'Happy Birthday', NULL, 0, '22-07:2024 02:13:PM', '0', NULL),
(178, '49', '6', 'working from offc?', NULL, 1, '22-07:2024 03:08:PM', '1', NULL),
(179, '48', '31', 'Happy Birthday :)', NULL, 1, '23-07:2024 12:15:PM', '1', NULL),
(180, '49', '6', 'zuiiiii', NULL, 1, '02-08:2024 10:39:AM', '1', NULL),
(181, '98', '97', 'hi', NULL, 0, '08-08:2024 05:22:PM', '1', NULL),
(182, '73', '71', 'hi from jiffy portal', NULL, 1, '08-08:2024 05:23:PM', '0', NULL),
(183, '73', '97', 'hi from jiffy portal', NULL, 1, '08-08:2024 05:24:PM', '1', NULL),
(184, '92', '85', 'hi', NULL, 1, '12-08:2024 06:13:PM', '1', NULL),
(185, '92', '106', 'hi', NULL, 0, '12-08:2024 06:13:PM', '1', NULL),
(186, '85', '92', 'hi', NULL, 1, '13-08:2024 06:26:PM', '1', NULL),
(187, '92', '85', 'bye', NULL, 1, '14-08:2024 02:52:PM', '1', NULL),
(188, '85', '92', 'GOOD', NULL, 1, '16-08:2024 03:14:PM', '1', NULL),
(189, '92', '85', 'so baddd......', NULL, 1, '16-08:2024 03:15:PM', '1', NULL),
(190, '85', '92', 'BREAK WE WILL GO . TIME IS AFTER 3:45PM', NULL, 1, '16-08:2024 03:15:PM', '1', NULL),
(191, '92', '85', 'no Sharply 3.30', NULL, 1, '16-08:2024 03:16:PM', '1', NULL),
(192, '85', '92', 'KK AGAIN WAIT  6 MINS ', NULL, 1, '16-08:2024 03:34:PM', '1', NULL),
(193, '30', '50', 'Hi', NULL, 0, '17-08:2024 05:06:PM', '0', NULL),
(194, '114', '106', 'Hi', NULL, 0, '21-08:2024 10:42:AM', '1', NULL),
(195, '114', '112', 'Hi', NULL, 0, '21-08:2024 10:53:AM', '1', NULL),
(196, '25', '35', 'hi', NULL, 1, '21-08:2024 12:40:PM', '1', NULL),
(197, '25', '35', '10.pdf', './../uploads/chat/10.pdf', 1, '21-08:2024 12:40:PM', '1', NULL),
(198, '31', '21', 'hiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii', NULL, 1, '21-08:2024 01:01:PM', '1', NULL),
(199, '21', '31', ':)', NULL, 1, '21-08:2024 01:01:PM', '1', NULL),
(200, '21', '31', '???', NULL, 0, '21-08:2024 01:04:PM', '1', NULL),
(201, '21', '31', '???????????????????????????', NULL, 0, '21-08:2024 01:05:PM', '1', NULL),
(202, '21', '48', '???', NULL, 0, '21-08:2024 01:44:PM', '0', NULL),
(203, '21', '6', 'Hi .... are u using earphones?????', NULL, 1, '21-08:2024 03:23:PM', '1', NULL),
(204, '38', '34', 'Sharathchandra Front End Developer (1) (1).pdf', './../uploads/chat/Sharathchandra Front End Developer (1) (1).pdf', 1, '21-08:2024 03:45:PM', '1', NULL),
(205, '116', '85', 'Hi', NULL, 1, '21-08:2024 04:50:PM', '1', NULL),
(206, '114', '106', 'hi ', NULL, 0, '22-08:2024 09:53:AM', '1', NULL),
(207, '35', '25', 'Hi', NULL, 1, '22-08:2024 12:15:PM', '1', NULL),
(208, '25', '35', 'hi', NULL, 1, '22-08:2024 12:15:PM', '0', NULL),
(209, '25', '26', 'hi', NULL, 1, '22-08:2024 12:17:PM', '1', NULL),
(210, '26', '25', 'Hello', NULL, 1, '22-08:2024 12:18:PM', '1', NULL),
(211, '26', '25', 'about1.jpg', './../uploads/chat/about1.jpg', 1, '22-08:2024 12:20:PM', '1', NULL),
(212, '21', '48', 'Testing chat function', NULL, 0, '22-08:2024 03:39:PM', '0', NULL),
(213, '21', '48', 'Testing chat function', NULL, 0, '22-08:2024 03:58:PM', '0', NULL),
(214, '21', '48', 'Testing chat function', NULL, 0, '22-08:2024 04:06:PM', '0', NULL),
(215, '21', '48', 'Testing chat function', NULL, 0, '22-08:2024 04:07:PM', '0', NULL),
(216, '60', '53', 'HELLO', NULL, 1, '23-08:2024 11:10:AM', '1', NULL),
(217, '60', '53', 'hello', NULL, 1, '23-08:2024 11:18:AM', '1', NULL),
(218, '60', '53', 'hi how are you ', NULL, 1, '23-08:2024 11:19:AM', '1', NULL),
(219, '60', '53', 'cudca asdcaiv avinaod aidniae vubebv vuweru vballach iauvie demo', NULL, 1, '23-08:2024 11:19:AM', '1', NULL),
(220, '60', '53', 'hello', NULL, 1, '23-08:2024 11:19:AM', '1', NULL),
(221, '53', '60', 'hello', NULL, 1, '23-08:2024 11:24:AM', '1', NULL),
(222, '53', '60', 'demo', NULL, 1, '23-08:2024 11:24:AM', '1', NULL),
(223, '53', '60', 'hi', NULL, 1, '23-08:2024 11:26:AM', '1', NULL),
(224, '35', '25', 'Hi..Hlo....', NULL, 1, '23-08:2024 03:01:PM', '1', NULL),
(225, '35', '25', 'hi', NULL, 1, '23-08:2024 03:01:PM', '1', NULL),
(226, '21', '38', 'username - anand@mineit.tech', NULL, 1, '26-08:2024 11:10:AM', '1', NULL),
(227, '21', '38', 'password - mine@123', NULL, 1, '26-08:2024 11:10:AM', '1', NULL),
(228, '38', '21', 'Thank u', NULL, 1, '26-08:2024 11:11:AM', '1', NULL),
(229, '21', '38', ':)', NULL, 1, '26-08:2024 11:11:AM', '1', NULL),
(230, '38', '21', 'nan complete kodla tast na', NULL, 1, '26-08:2024 12:20:PM', '1', NULL),
(231, '38', '21', 'delete madda tast naa', NULL, 1, '26-08:2024 12:22:PM', '1', NULL),
(232, '21', '38', 'nan edit madidini back end issue anta', NULL, 1, '26-08:2024 12:22:PM', '1', NULL),
(233, '38', '21', 'hwdaa okk ', NULL, 1, '26-08:2024 12:22:PM', '1', NULL),
(234, '38', '21', 'done', NULL, 1, '26-08:2024 12:22:PM', '1', NULL),
(235, '21', '38', '???Hm', NULL, 1, '26-08:2024 12:22:PM', '1', NULL),
(236, '38', '21', 'Screenshot (57).png', './../uploads/chat/Screenshot (57).png', 1, '26-08:2024 12:28:PM', '1', NULL),
(237, '38', '21', 'yav search bar need ella', './../uploads/chat/Screenshot (57).png', 1, '26-08:2024 12:28:PM', '1', NULL),
(238, '38', '21', 'hii', NULL, 1, '27-08:2024 12:16:PM', '1', NULL),
(239, '21', '38', 'Hlo sharath', NULL, 1, '27-08:2024 04:04:PM', '1', NULL),
(240, '60', '53', 'demo', NULL, 1, '28-08:2024 01:26:PM', '1', NULL),
(241, '53', '60', 'Ohayo', NULL, 1, '28-08:2024 02:51:PM', '1', NULL),
(242, '30', '33', 'Hii', NULL, 1, '29-08:2024 06:51:PM', '1', NULL),
(243, '30', '33', 'Bye', NULL, 1, '29-08:2024 06:52:PM', '1', NULL),
(244, '30', '33', 'Hello ', NULL, 1, '29-08:2024 06:52:PM', '1', NULL),
(245, '30', '33', 'Testing jiffy ', NULL, 1, '29-08:2024 06:53:PM', '1', NULL),
(246, '27', '33', 'Hi ', NULL, 1, '02-09:2024 12:10:PM', '1', NULL),
(247, '38', '21', 'hii', NULL, 1, '03-09:2024 03:57:PM', '1', NULL),
(248, '38', '21', 'http://localhost/mine_jiffy/project/employeetracking.php there no search bar only', NULL, 1, '03-09:2024 03:58:PM', '1', NULL),
(249, '38', '21', 'Screenshot (58).png', './../uploads/chat/Screenshot (58).png', 1, '03-09:2024 04:00:PM', '1', NULL),
(250, '21', '38', 'https://jiffy.mineit.tech/project/employeetracking.php  login with meena\'s credentials search bar is there.', NULL, 1, '05-09:2024 04:45:PM', '1', NULL),
(251, '53', '60', 'yo ', NULL, 1, '07-09:2024 09:05:PM', '1', NULL),
(252, '21', '31', 'Nithya test madakke task assign madidini', NULL, 0, '10-09:2024 10:47:AM', '1', NULL),
(253, '60', '33', 'hi', NULL, 1, '10-09:2024 12:26:PM', '1', NULL),
(254, '33', '60', 'Hi', NULL, 0, '10-09:2024 01:18:PM', '1', NULL),
(255, '38', '27', 'Project Management panel - My Task- Your Task - \'Employee, All Projects, All\' filters are not Required.', NULL, 1, '11-09:2024 12:39:PM', '1', NULL),
(256, '27', '26', 'Cyber security.docx', './../uploads/chat/Cyber security.docx', 1, '11-09:2024 05:40:PM', '1', NULL),
(257, '25', '30', 'hi bhanu', NULL, 1, '12-09:2024 10:28:AM', '1', NULL),
(258, '25', '30', 'en madthayidiya?', NULL, 1, '12-09:2024 10:28:AM', '1', NULL),
(259, '25', '30', 'tindha?', NULL, 1, '12-09:2024 10:28:AM', '1', NULL),
(260, '21', '27', 'hi', NULL, 1, '12-09:2024 10:37:AM', '1', NULL),
(261, '27', '21', 'hlo', NULL, 1, '12-09:2024 10:39:AM', '1', NULL),
(262, '27', '21', 'attach file.png', './../uploads/chat/attach file.png', 1, '12-09:2024 10:39:AM', '1', NULL),
(263, '33', '30', 'working on jiffy', NULL, 1, '23-09:2024 12:21:PM', '1', NULL),
(264, '16', '38', 'hii', NULL, 0, '23-09:2024 12:32:PM', '1', NULL),
(265, '33', '30', 'working on jiffy', NULL, 1, '23-09:2024 01:05:PM', '1', NULL),
(266, '1', '38', 'Hlo', NULL, 0, '23-09:2024 03:24:PM', '1', NULL),
(267, '53', '60', 'task assigned ', NULL, 1, '24-09:2024 12:17:PM', '1', NULL),
(268, '35', '30', 'hi', NULL, 1, '23-10:2024 06:37:PM', '1', NULL),
(269, '35', '30', 'bhavya shop-Dealers (7).pptx', './../uploads/chat/bhavya shop-Dealers (7).pptx', 1, '23-10:2024 06:42:PM', '1', NULL),
(270, '52', '20', 'hey', NULL, 0, '29-10:2024 10:21:AM', '1', NULL),
(271, '52', '20', '1616461406327.jpg', './../uploads/chat/1616461406327.jpg', 0, '29-10:2024 10:22:AM', '1', NULL),
(272, '1', '21', 'Hii tester', NULL, 1, '06-11:2024 01:40:PM', '1', NULL),
(273, '21', '1', 'hello', NULL, 1, '06-11:2024 01:41:PM', '0', NULL),
(274, '33', '21', 'hi', NULL, 1, '06-11:2024 02:43:PM', '1', NULL),
(275, '38', '21', 'closure call spelling is wrong.', NULL, 1, '15-11:2024 01:39:PM', '1', NULL),
(276, '38', '21', 'whats was the correct spelling', NULL, 1, '15-11:2024 01:39:PM', '1', NULL),
(277, '1', '26', 'hi', NULL, 1, '23-04:2025 01:29:PM', '1', NULL),
(278, '6', '21', 'yes', NULL, 1, '28-04:2025 03:09:PM', '1', NULL),
(279, '26', '1', 'Hi', NULL, 1, '30-05:2025 12:03:PM', '0', NULL),
(280, '35', '30', 'HI', NULL, 0, '17-06:2025 09:32:PM', '0', NULL),
(281, '35', '30', 'Hlo', NULL, 0, '07-07:2025 03:15:PM', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_expension`
--

CREATE TABLE `monthly_expension` (
  `id` int(11) NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `prize` varchar(255) NOT NULL,
  `month-year` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthly_expension`
--

INSERT INTO `monthly_expension` (`id`, `tittle`, `prize`, `month-year`, `created_at`, `updated_at`, `Company_id`) VALUES
(23, 'employeesalary', '400000', 'August 2024', '2024-08-25 08:08:02', '2024-08-25 08:08:02', '1'),
(24, 'Computer', '50000', 'August 2024', '2024-08-27 07:11:18', '2024-08-27 07:11:18', '1');

-- --------------------------------------------------------

--
-- Table structure for table `posters`
--

CREATE TABLE `posters` (
  `PosterId` int(11) NOT NULL,
  `QuestionType` varchar(255) NOT NULL,
  `QuestionDescription` text NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `answer` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posters`
--

INSERT INTO `posters` (`PosterId`, `QuestionType`, `QuestionDescription`, `Name`, `CreatedAt`, `status`, `answer`) VALUES
(21, '1', 'In distinctio Harum', 'Germaine Ashley', '2024-11-19 13:43:12', 0, NULL),
(22, '1', 'Hi', 'John Doe', '2025-06-16 13:32:55', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(254) NOT NULL,
  `message` text NOT NULL,
  `hashtags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `category` varchar(100) NOT NULL DEFAULT '0',
  `due_date` varchar(255) NOT NULL,
  `department` varchar(2555) DEFAULT NULL,
  `progress` varchar(12) DEFAULT NULL,
  `document_attachment` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `members` varchar(255) DEFAULT NULL,
  `budget` varchar(255) NOT NULL DEFAULT '0',
  `location` varchar(255) NOT NULL DEFAULT 'empty',
  `modules` varchar(2555) DEFAULT NULL,
  `no_resource` varchar(255) DEFAULT NULL,
  `no_resources_requried` varchar(255) DEFAULT NULL,
  `lead_id` varchar(2555) DEFAULT NULL,
  `project_manager_id` varchar(255) DEFAULT NULL,
  `totalhours` varchar(255) DEFAULT NULL,
  `perday` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `tasks` varchar(2555) DEFAULT NULL,
  `uploaderid` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `paid_date` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `client_id`, `description`, `category`, `due_date`, `department`, `progress`, `document_attachment`, `priority`, `start_date`, `members`, `budget`, `location`, `modules`, `no_resource`, `no_resources_requried`, `lead_id`, `project_manager_id`, `totalhours`, `perday`, `Company_id`, `tasks`, `uploaderid`, `payment_status`, `paid_date`) VALUES
(4, 'Virtual dressing system', '1', '<p>&bull; The virtual dress system allows users to try on clothes virtually using their digital avatars. &bull; This project combines computer vision and web development technologies to provide an interactive user experience. &bull; The project will use Python as the backend language, with Flask for user registration and login, and OpenCV for virtual try-on features.</p>\r\n', '0', '2024-07-31', '1,5,7', '100', 'Research for Virtual dress system-9384.pdf', 'Normal', '2024-06-10 00:00:00', '2,7,13,3,11,6', '60000', 'office', 'Shopkeeper,     virtual AI, Marketing and communication, UI & UX design', '6', '0', '7', '7', '450', '8.82', '1', 'shopkeeper Dashboard,    API Creation', '7', 'Pending', NULL),
(6, 'AECP', '1', '<p>The Architecture, Engineering &amp; Construction (AEC) Collection provides BIM and CAD software, including Revit, Civil 3D, and AutoCAD, as well as a cloud-based common data environment enabling designers, engineers, and contractors to efficiently deliver high-quality building and infrastructure projects. Powerful conceptual design tools help AEC professionals capture design intent, while model-based design solutions accelerate design processes and support integrated workflows for multi-discipline coordination. Analysis and optimization tools improve design quality and ensure constructability. Construction coordination and schedule simulation help reduce costs and minimize field coordination issues during construction. With the AEC Collection, teams can create with ease, explore what&rsquo;s possible, and build with confidence.</p>\r\n', '0', '2024-07-05', '1,5', '42.75862069', 'AECP-Product Document v-2-9782.docx', 'High', '2024-06-07 00:00:00', '28,2,15,39,7,25,22', '200000000', 'office', 'HR,       General Manager,       Project Manager,       Site Manager,       Store Manager,       Client,       Others,  Vice President,  Procurement Management, Marketing and communication, UI & UX design', '7', '0', '2', '7', '220', '7.86', '1', 'dashboard', '7', 'Pending', NULL),
(8, 'MINE', '1', '<p>The purpose of the platform is to streamline the process of assigning projects from clients to various hubs or collaborated providers. By centralizing project submission and assignment, the platform aims to improve efficiency, collaboration, and transparency in project management. &nbsp;</p>\r\n', '0', '2024-06-30', '1,5', '98.795180723', 'MINE Platform - Documentation-7512.pdf', 'High', '2024-06-10 00:00:00', '27,49,50', '2000000', 'Bangalore', 'Landing page,    Client interface,    Coordinators interface,    Partners interface,    Customer purchase interface,  Cyber Security,  Data Science,  UI/UX,  System Maintence, Marketing and communication', '4', '1', '33', '7', '400', '20.00', '1', '', '33', 'Pending', NULL),
(9, 'VMS', '1', '<p>A Vendor Management System (VMS) is a comprehensive software solution designed to streamline and optimize the process of procuring goods and services from vendors. It serves as a central hub for managing vendor-related activities, facilitating effective communication, improving vendor performance, and ensuring compliance with organizational policies. By leveraging a VMS, businesses can enhance their vendor relationships, reduce costs, and increase operational efficiency.</p>\r\n', '0', '2024-06-30', '1,5', '87.804878049', 'Vendor Management System - Final-7681.pdf', 'High', '2024-06-10 00:00:00', '52,30,20,29,33,50', '600000', 'Bangalore', 'Vendor dashboard,        Customer dashboard,        Material Upload,        Order management,        Invoice and payment,        Order tracking,  Marketing and communication,  UI & UX design', '5', '-1', '33', '7', '400', '20.00', '1', '', '33', 'Pending', NULL),
(10, 'Jiffy Digital Office', '1', '<p>Jiffy is the ultimate productivity and management solution, redefining the way organizations operate. With a relentless focus on efficiency and collaboration, Jiffy offers a unified platform that seamlessly integrates HR management, project tracking, task allocation, and employee communication. It simplifies the complexities of the modern workplace, allowing you to effortlessly monitor employee attendance, manage projects from start to finish, assign tasks with precision, and streamline leave requests. Jiffy&#39;s real-time notifications keep you informed, while its robust reporting tools provide invaluable insights into performance and attendance trends. Plus, its user-friendly interface, educational resources, and commitment to data security make it the ideal choice for businesses of all sizes. Jiffy isn&#39;t just a product; it&#39;s your partner in optimizing productivity and transforming the way work gets done. Join us on this journey to redefine efficiency and collaboration in your organization.</p>\r\n', '0', '2024-06-30', '1,5,6,8', '68.462757528', 'Jiffy-Product Document v-1-3552.docx', 'High', '2024-06-11 00:00:00', '2,7,21', '200000000', 'office', 'Employee,      Team Lead,      Project Manager,      Admin,      Accountent,      Management,      Client,  Business and SalesCRM, Marketing & communication, UI & UX', '3', '0', '2, 7', '7', '150', '7.89', '1', '', '7', 'Pending', NULL),
(12, 'Swifterz Creative Services LLP', '1', '', '0', '2024-06-30', '4', '50.49833887', 'Swifterz_bim-3108.docx', 'High', '2024-06-20 00:00:00', '26,25,29', '2000000', 'Bengaluru', 'HomePage,     Client Module,     Project Strategists,     Project Manager,     Co-ordinator,     Staffing,     Partners,     Verification team,    Marketing & Communication,    UI & UX design', '4', '1', '33', '33', '400', '8', '1', 'Website and admin page,     ', '7', 'Pending', NULL),
(13, 'Bluechip', '1', '', '0', '2024-07-21', '1', '71.851851852', 'Bluechip document-8929.pdf', 'High', '2024-06-21 00:00:00', '2,15,39,7,38,22', '500000', 'office', 'Landing Page,   Agent Panel,   Student Panel,   Admin Panel,  Others, Marketing and communication, UI & UX design', '6', '0', '2', '7', '200', '6.67', '1', '', '7', 'Pending', NULL),
(15, 'Prestige Park Groove', '3', '<p>Prestige Park Groove is an expansive residential development featuring 19 towers, a central clubhouse, an art &amp; performance center, a villa clubhouse, and approximately 100 luxury villas. Our team is tasked with delivering comprehensive CAD to BIM services for this project, working closely with RSP Design Consultants. The scope of work includes architectural modeling at LOD 300, ensuring precision and detail in the digital representation of the buildings. We are also responsible for coordinating effectively with the structural and MEP consultants to facilitate seamless project execution and integration across all disciplines.</p>\r\n', '0', '2024-08-31', '12', '0', 'Prestige Park Grove Layout-5716.pdf', 'High', '2024-08-21 00:00:00', '111,76,104,85,91,78,98,75,84,82,83,79,106,90,88,87,110,112,103,74,77,86,81', '5500000', 'Bangalore', 'Tower 1,  Tower 2,  Tower 3,  Tower 4,  Tower 5,  Tower 6,  Tower 7,  Tower 8,  Tower 9,  Tower 10,  Tower 11,  Tower 12,  Tower 13,  Tower 14,  Tower 15,  Tower 16,  Tower 17,  Tower 18,  Tower 19,  Villa Royal,  Villa Ultima,  Villa Club House,  Central Club House,  Art & Performance Cetre,  Stitching', '23', '0', '87', '76', '80', '8.00', '5', '', '103', 'Pending', NULL),
(29, 'GHATE', '1', '<p>cx&nbsp;</p>\r\n', '0', '2025-07-04', '4', '100', 'team_report-6430.pdf', 'High', '2025-06-26 00:00:00', '35, 30', '15000000', 'Bangalore, Karnataka', 'USER', '4', '2', '7', '33', '1234', 'rrr', '1', 'create api', '33', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questiontypes`
--

CREATE TABLE `questiontypes` (
  `QuestionTypeId` int(11) NOT NULL,
  `TypeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revenue_collected`
--

CREATE TABLE `revenue_collected` (
  `id` int(11) NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `received_amount` decimal(10,2) NOT NULL,
  `month` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revenue_collected`
--

INSERT INTO `revenue_collected` (`id`, `tittle`, `received_amount`, `month`, `created_at`, `updated_at`, `Company_id`) VALUES
(12, 'milk', 1000.00, 'August 2024', '2024-08-25 08:07:10', '2024-08-25 08:07:10', '1'),
(13, 'jiffy', 50000.00, 'August 2024', '2024-08-25 08:07:34', '2024-08-25 08:07:34', '1'),
(14, 'Projects', 5000000.00, 'September 2024', '2024-08-27 07:12:37', '2024-08-27 07:12:37', '1'),
(15, 'sugar', 1000.00, 'October 2024', '2024-10-23 12:19:47', '2024-10-23 12:19:47', '1');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `Company_id`) VALUES
(14, 'Project Manager', '1'),
(15, 'CEO', '1'),
(16, 'CTO', '1'),
(18, 'Testing Engineer', '1'),
(20, 'FrontEnd Developer', '1'),
(21, 'Backend Developer', '1'),
(23, 'admin', '1'),
(24, 'Hr', '1'),
(26, 'UI/UX', '1'),
(27, 'Graphic/UI', '1'),
(28, 'Digital Marketing Executive', '1'),
(29, 'Content Writer', '1'),
(30, 'Defence and Security', '1'),
(37, 'Management', '1'),
(38, 'HR Exceutive', '2'),
(39, 'Accountant', '2'),
(40, 'Director', '2'),
(41, 'System Administration', '2'),
(42, 'Project Manager', '5'),
(43, 'Technical Director', '5'),
(44, 'BIM Modeler', '5'),
(46, 'BIM Architect', '5'),
(47, 'BIM Architect Lead', '5'),
(48, 'Tekla Modeler', '5'),
(49, 'BIM Project Manager', '5'),
(50, 'Business Development Manager', '5'),
(51, 'Vice President Projects', '5'),
(52, 'Junior BIM Modeler', '5'),
(53, 'Architect Intern', '5'),
(54, 'BIM Modeler- MEP', '5'),
(55, 'Graphics Design', '1'),
(56, 'IT & Networking', '1'),
(57, 'Coordinator', '6'),
(58, 'HR', '6'),
(59, 'BDM', '6'),
(60, 'Inside Sales', '6'),
(61, 'Digital Marketing', '6'),
(62, 'HUB coordinator', '6'),
(63, 'Sales Manager', '6'),
(64, 'Zonal Sales Manager', '6'),
(65, 'Management', '6'),
(66, 'CEO', '6'),
(67, 'Accounts', '6'),
(68, 'Admin', '6'),
(69, 'Sales  ', '6'),
(70, 'Sales  ', '6'),
(71, 'Sales  ', '6'),
(72, 'Sales  ', '6'),
(73, 'Sales  ', '6'),
(74, 'HR Executive', '5'),
(75, 'CEO', '5'),
(76, 'Graphic Designer', '5'),
(77, 'Management', '5'),
(80, 'Developer', '1'),
(81, 'BOD', '5'),
(83, 'CTO', '5');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out1` time NOT NULL,
  `Company_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `permonth_days` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `perday_hours` varchar(255) DEFAULT NULL,
  `currect_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out1`, `Company_name`, `logo`, `Company_id`, `permonth_days`, `address`, `emailid`, `perday_hours`, `currect_date`) VALUES
(1, '10:00:00', '19:00:00', 'Merry\'s Info-Tech & New-Gen Educare LLP', './../uploads/6677c33d7e52a_mine.jpg', '1', '26', '#24 Corner Woods, Second Floor, Dr.Raja Gopal Road, Sanjay Nagar Main Road, Bengaluru 560094', 'mineit.tech@gmail.com', '9', '2024-05-15 17:35:23'),
(2, '10:00:00', '19:00:00', 'GHATE', './../uploads/667a52821a7f2_Ghate.jpg', '2', '26', 'Bangalore', 'hr@ghate.solutions ', '9', '2024-06-25 07:15:46'),
(3, '09:30:00', '18:30:00', 'Swifterz Creative Services LLP', './../uploads/6698a033afc65_swifterz.png', '5', '26', '#53, First Main Road, Maruthi Layout, RMV 2nd Stage, Sanjay Nagar, Bengaluru - 560 094.', 'bim@swifterz.co', '9', '2024-07-10 06:48:43'),
(4, '09:30:00', '06:30:00', 'AECearth ', './../uploads/66b4671d29dd6_AECearth logo.png', '6', '26', 'Sanjayanagar , Bangalore', 'punitha.ghate@gmail.com ', '3', '2024-08-08 08:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `projectid` int(11) DEFAULT NULL,
  `modules_name` varchar(255) DEFAULT NULL,
  `uploaderid` int(11) NOT NULL,
  `ticket` varchar(255) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `due_date` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `checklist` text DEFAULT NULL,
  `document_attachment` varchar(10000) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(12) DEFAULT NULL,
  `start_time` varchar(45) DEFAULT NULL,
  `end_time` varchar(45) DEFAULT NULL,
  `ring` int(11) NOT NULL DEFAULT 0,
  `Pause` varchar(255) DEFAULT '0',
  `restart` varchar(255) NOT NULL DEFAULT '0',
  `Actual_start_time` varchar(255) DEFAULT NULL,
  `Approval` varchar(255) DEFAULT NULL,
  `outputfilepath` varchar(1000) DEFAULT NULL,
  `perferstart_time` time DEFAULT NULL,
  `perferend_time` time DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `projectid`, `modules_name`, `uploaderid`, `ticket`, `task_name`, `assigned_to`, `due_date`, `category`, `description`, `checklist`, `document_attachment`, `created_at`, `updated_at`, `status`, `start_time`, `end_time`, `ring`, `Pause`, `restart`, `Actual_start_time`, `Approval`, `outputfilepath`, `perferstart_time`, `perferend_time`, `Company_id`) VALUES
(1602, 12, 'HomePage', 26, 'T-7031', 'Project Management Module Integration with SwiftBIM', 26, '2024-09-10', 'Task', '<p>Project Management Module Integration with SwiftBIM</p>\r\n', '', '', '2024-09-10 07:56:27', '2024-09-10 07:56:27', 'Completed', '2024-09-10 11:26:32', '2024-09-12 11:23:00', 0, '0', '0', '2024-09-10', NULL, NULL, '11:25:00', '19:00:00', '1'),
(2802, 4, '     virtual AI', 59, 'T-8752', 'karan', 123, '2025-10-29', 'Task', '', '', '', '2025-10-09 11:01:05', '2025-10-09 11:01:05', 'Todo', NULL, NULL, 0, '0', '0', '2025-10-09', 'Rejected', NULL, '12:00:00', '14:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `leave_type` varchar(110) NOT NULL,
  `to_date` varchar(120) NOT NULL,
  `from_date` varchar(120) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_remark` mediumtext DEFAULT NULL,
  `remark_date` varchar(120) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `is_read` varchar(1) DEFAULT NULL,
  `empid` int(11) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `leave_lop` varchar(255) NOT NULL DEFAULT 'Lop',
  `days_count` varchar(255) NOT NULL DEFAULT '0',
  `count` int(23) NOT NULL DEFAULT 0,
  `starttime` varchar(255) DEFAULT NULL,
  `endtime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `leave_type`, `to_date`, `from_date`, `description`, `posting_date`, `admin_remark`, `remark_date`, `status`, `is_read`, `empid`, `Company_id`, `leave_lop`, `days_count`, `count`, `starttime`, `endtime`) VALUES
(12, '5', '2024-06-10', '2024-06-10', '<p>Sick leave</p>\r\n', '2024-06-10 09:25:36', NULL, NULL, 1, '1', 36, '1', '0', '1', 0, NULL, NULL),
(24, '2', '2024-06-19', '2024-06-19', '<p>Subject: Request for One Day Leave Due to Hospital Visit</p>\r\n\r\n<p>Dear sir,</p>\r\n\r\n<p>I hope this message finds you well. I am writing to request a one-day leave on 19/06/2024&nbsp;as I need to visit the hospital to attend to a pressing health issue concerning a close relative.</p>\r\n\r\n<p>The nature of this visit requires my presence and I anticipate being away for the entire day. I have ensured that my current tasks are up to date, and I will make arrangements to complete any pending work before my leave. Additionally, I will be available via phone or email in case of any urgent matters that require my attention.I apologize for any inconvenience this may cause and appreciate your understanding and support. Please let me know if you need any further information or if there are any additional steps I need to take to formalize this request.</p>\r\n\r\n<p>Thank you for your consideration.</p>\r\n\r\n<p>Best regards,<br />\r\nBHANU PRASAD YADAV P<br />\r\nJr java developer<br />\r\n9632920686</p>\r\n', '2024-06-18 16:00:06', NULL, NULL, 1, '1', 30, '1', '0', '1', 0, NULL, NULL),
(26, '2', '2024-06-21', '2024-06-21', '<p>Due to some emergency&nbsp;</p>\r\n', '2024-06-21 01:47:55', NULL, NULL, 1, NULL, 13, '1', '0', '1', 0, NULL, NULL),
(27, '2', '2024-06-21', '2024-06-21', '<p>I have a fever today, hence I was unable to attend office.&nbsp;<br />\r\n<br />\r\nI will continue from tomorrow.&nbsp;</p>\r\n', '2024-06-21 05:38:00', NULL, NULL, 1, NULL, 61, '1', '0', '1', 0, NULL, NULL),
(28, '2', '2024-06-25', '2024-06-25', '<p>Subject: Request for One Day Personal Leave</p>\r\n\r\n<p>Dear Sir/Mam,</p>\r\n\r\n<p>I hope this message finds you well. I am writing to inform you that I need to take a personal leave on 25 june 2024.I will be unable to attend work on that day.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Thanks and regards<br />\r\nSharathchandra BR<br />\r\nFront-end Developer</p>\r\n', '2024-06-22 05:19:42', NULL, NULL, 1, NULL, 38, '1', '0', '1', 0, NULL, NULL),
(30, '2', '2024-06-24', '2024-06-24', '<p>Subject: Request for One Day Leave</p>\r\n\r\n<p>Hi sir,</p>\r\n\r\n<p>I need to address an urgent issue with my bank account and will need to take a day off tomorrow to visit the bank.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best,</p>\r\n\r\n<p>Bhanuprasadyadav P</p>\r\n\r\n<p>Jr Java developer&nbsp;</p>\r\n', '2024-06-23 15:02:39', NULL, NULL, 1, NULL, 30, '1', '0', '1', 0, NULL, NULL),
(31, '2', '2024-06-24', '2024-06-24', '<p>Good morning Meena,</p>\r\n\r\n<p>I need to take a leave today as my spectacles fell down &amp;they&nbsp; broken as I&#39;m in&nbsp; my way to the office, and I am unable to work without them. I apologize for any inconvenience caused.</p>\r\n\r\n<p>Regards,</p>\r\n\r\n<p>Purnima M.S</p>\r\n', '2024-06-24 04:55:01', NULL, NULL, 1, '1', 48, '1', '0', '1', 0, NULL, NULL),
(32, '2', '2024-06-25', '2024-06-24', '<p>Requesting for leave&nbsp;</p>\r\n\r\n<p>As above subject I met with an minor accident so,I request you to grant a leave from today afternoon 24/Jun to tomorrow afternoon 25/Jun and I have 2 casual now I&#39;m spending one for this reason,hope you understand the condition.</p>\r\n\r\n<p>Thank you&nbsp;</p>\r\n', '2024-06-24 09:02:48', NULL, NULL, 1, '1', 24, '1', '0', '2', 0, NULL, NULL),
(33, '2', '2024-06-25', '2024-06-25', '<p>Medical Treatment, Rejection of permission to work from home&nbsp;</p>\r\n', '2024-06-24 13:35:37', NULL, NULL, 1, NULL, 36, '1', '0', '1', 0, NULL, NULL),
(34, '2', '2024-06-25', '2024-06-25', '<p>I hope this message finds you well. I m feeling unwell today due to fever and cold. Consequently, I will be unable to perform my duties effectively. I&#39;ll keep you updated on my progress and ensure a smooth transition of my tasks during my absence.</p>\r\n\r\n<p>Therefore, I kindly request a one day leave.I appreciate your understanding and support in this matter.</p>\r\n\r\n<p>Appreciate your understanding.</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Nithyashree N Bannur</p>\r\n\r\n<p>Jr Java developer.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2024-06-25 03:31:08', NULL, NULL, 1, '1', 31, '1', '0', '1', 0, NULL, NULL),
(36, '2', '2024-06-28', '2024-06-27', '<p>Dear Sir/Ma&#39;am,</p>\r\n\r\n<p>Im going home&nbsp;after long time for a medical check up and I&#39;m requesting you to grant me leave for 27th and 28th of June 2024. I assure you that I&#39;ll complete all my task before going home&nbsp; and assigned work to my team members as well and make sure my absent will not affect the ongoing project. I&nbsp;will be available through phone in case of any emergency.</p>\r\n\r\n<p>Thanks &amp; Regards,</p>\r\n\r\n<p>Meena M</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2024-06-25 09:07:48', NULL, NULL, 1, NULL, 33, '1', '0', '2', 0, NULL, NULL),
(54, '2', '2024-06-26', '2024-06-26', '<p>Subject: Application for One Day Leave_ Bank Work</p>\r\n\r\n<p>Dear sir/mam,</p>\r\n\r\n<p>I am writing to request a one-day leave on 26-06-2024 to attend to some urgent bank-related work. This task requires my personal presence at the bank and cannot be completed outside of working hours.</p>\r\n\r\n<p><br />\r\nThank you for your understanding.</p>\r\n\r\n<p>Sincerely,<br />\r\nSharathchandra B R</p>\r\n', '2024-06-26 01:28:32', NULL, NULL, 1, NULL, 38, '1', '0', '1', 0, NULL, NULL),
(55, '2', '2024-06-28', '2024-06-27', '<p>&nbsp;</p>\r\n\r\n<p>I am writing to formally request a leave of absenc order to visit my hometown. This trip is important to me as it will allow me to reconnect with my family and attend to some personal matters.</p>\r\n\r\n<p>I have ensured that my current projects are up to date and I am willing to delegate my tasks to ensure a smooth workflow during my absence. I will be accessible by email should any questions arise during my leave.</p>\r\n\r\n<p>Thank you for considering my request. I look forward to your favorable response.</p>\r\n\r\n<p>Sincerely,</p>\r\n\r\n<p>Jayamani</p>\r\n\r\n<p>Mine</p>\r\n', '2024-06-26 03:32:06', NULL, NULL, 1, '1', 7, '1', '0', '2', 0, NULL, NULL),
(56, '2', '2024-06-26', '2024-06-26', '<p>Sick</p>\r\n', '2024-06-26 03:45:56', NULL, NULL, 1, NULL, 36, '1', '0', '1', 0, NULL, NULL),
(57, '2', '2024-07-01', '2024-07-01', '<p>Subject: Request for Leave on 01/07/2024.</p>\r\n\r\n<p>Dear Sir/Madam,</p>\r\n\r\n<p>I am Shashi Bhavan C K from Merry&#39;s Info Tech &amp; New-Gen Educare Company. I am writing to formally request a leave of absence on the 1st of july, 2024 to visit my home temple.</p>\r\n\r\n<p>I have ensured that all my current tasks and responsibilities are up to date, and I am confident that my absence will not affect ongoing projects. Additionally, my colleague, Abdul, has kindly agreed to take care of any tasks that may arise during my leave.</p>\r\n\r\n<p>Thank you for considering my request. I look forward to your approval.</p>\r\n\r\n<p>Sincerely,<br />\r\nShashi Bhavan C K<br />\r\nMerry&#39;s Info Tech &amp; New-Gen Educare Company</p>\r\n', '2024-06-26 08:58:16', NULL, NULL, 1, NULL, 22, '1', '0', '1', 0, NULL, NULL),
(58, '2', '2024-06-28', '2024-06-27', '<p>Subject: Leave Request for Health Checkup - 27th &amp; 28th June 2024</p>\r\n\r\n<p>Dear Jayamani,</p>\r\n\r\n<p>I hope this message finds you well.</p>\r\n\r\n<p>I am writing to inform you that I need to undergo a health checkup on the 27th and 28th of June, 2024. As such, I would like to request leave for these two days.</p>\r\n\r\n<p>I have ensured that all my current tasks and responsibilities are up to date and have handed over any pending work to Abdul. They have kindly agreed to manage any urgent issues during my absence. I will be available by phone or email for any critical matters.</p>\r\n\r\n<p>Please let me know if you need any additional information or if there are any specific procedures I need to follow to formalize this leave request.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Harish R<br />\r\nFront End Developer<br />\r\n8792680188</p>\r\n', '2024-06-26 09:13:26', NULL, NULL, 1, NULL, 39, '1', '0', '2', 0, NULL, NULL),
(59, '5', '', '', '<p>Need one hour permission,<br />\r\nNeed to go temple on account of&nbsp;wedding anniversary kindly grant</p>\r\n', '2024-06-26 09:22:05', NULL, NULL, 1, NULL, 32, '1', '0', '0', 0, '2024-06-26T18:00', '2024-06-26T19:00'),
(60, '5', '', '', '<p>I need to go home, and I kindly request you to give me permission for 1 hour, Since I have to pack my things and reach the boarding point on time.</p>\r\n\r\n<p>Thanks and Regards,</p>\r\n\r\n<p>Meena M</p>\r\n', '2024-06-26 12:31:11', NULL, NULL, 1, NULL, 33, '1', '0', '0', 0, '2024-06-26T18:00', '2024-06-26T19:00'),
(61, '5', '', '', '<p>Hello,</p>\r\n\r\n<p>I&#39;m going home so I&#39;m leaving 1 hour early.</p>\r\n\r\n<p>Thanks &amp; Regards,</p>\r\n\r\n<p>K Sumanth Kumar Raju.</p>\r\n', '2024-06-26 12:33:41', NULL, NULL, 1, NULL, 29, '1', '0', '0', 0, '2024-06-26T18:01', '2024-06-26T19:01'),
(62, '2', '2024-07-02', '2024-07-01', '<p>Dear Dr.Karthikeyan,</p>\r\n\r\n<p>I hope this message finds you well. I am writing to formally request two days of leave on 1st and 2nd July 2024. The purpose of this leave is to attend an appointment related to my passport.</p>\r\n\r\n<p>I have ensured that my current tasks are up to date and have informed my team about my absence to ensure minimal disruption. I will be accessible by phone and email during this period to address any urgent matters that may arise.</p>\r\n\r\n<p>Please let me know if there are any specific procedures or forms I need to complete for this leave request. I appreciate your consideration of my request and look forward to your approval.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nSabari Raj S R&nbsp;<br />\r\nFrontend Developer &amp; Web Administrator</p>\r\n', '2024-06-26 13:17:27', NULL, NULL, 1, NULL, 16, '1', '0', '2', 0, NULL, NULL),
(63, '2', '2024-06-28', '2024-06-28', '<p>Im&nbsp; going home on my personal reason so im taking leave on Friday.</p>\r\n\r\n<p>Warm Regrads,</p>\r\n\r\n<p>M.Jyothsna</p>\r\n\r\n<p>Frontend Developer</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2024-06-26 13:21:40', NULL, NULL, 1, NULL, 25, '1', '0', '1', 0, NULL, NULL),
(64, 'Others', '2024-06-28', '2024-06-28', '<p>Subject :- Requesting for one day leave due to going hometown&nbsp;<br />\r\nAs per the above subject i have some emergency at my home so i request you to grant me a leave for&nbsp; a day.<br />\r\n<br />\r\nthanks &amp; regards,<br />\r\nDilip P</p>\r\n', '2024-06-27 08:53:04', NULL, NULL, 1, NULL, 24, '1', '1', '1', 0, NULL, NULL),
(65, '2', '2024-06-28', '2024-06-28', '<p>I am writing to request leave on [28-06-2024] to attend my grandfather&#39;s Thithi ceremony, which is a significant family event. I will ensure all urgent tasks are handled before my leave and will be available via phone for any emergencies.</p>\r\n', '2024-06-27 11:53:54', NULL, NULL, 1, NULL, 37, '1', '0', '1', 0, NULL, NULL),
(66, 'Others', '2024-06-28', '2024-06-28', '<p>Due to health issue I want to go for hospital&nbsp;</p>\r\n', '2024-06-28 03:15:33', NULL, NULL, 1, NULL, 30, '1', '1', '1', 0, NULL, NULL),
(68, '2', '', '', '<p>Greetings maam,&nbsp;<br />\r\n<br />\r\nI would like to take a leave on monday and tuesday as i am travelling back to home to visit my grandfather who is in poor health.&nbsp;</p>\r\n', '2024-06-29 05:47:25', NULL, NULL, 1, NULL, 61, '1', '0', '0', 0, '2024-07-01T09:00', '2024-07-01T10:00'),
(69, '2', '2024-07-01', '2024-07-01', '<p>Hello, I am writing to inform you that I am unable to attend work due to high fever today i.e, 1st of July.</p>\r\n\r\n<p>I apologize for any inconvenience and my absence will not affect the on going projects and appreciate your understanding.</p>\r\n', '2024-07-01 01:36:35', NULL, NULL, 1, NULL, 29, '1', '0', '1', 0, NULL, NULL),
(70, '2', '2024-07-02', '2024-07-01', '<p>Dear Sir,&nbsp;</p>\r\n\r\n<p>Greetings of the day!&nbsp;</p>\r\n\r\n<p>I have done my medical check up but the reports are coming on Tuesday only and I have to consult the doctor and I will come back to office on Wednesday, I request you to extend my leave till Wednesday (Jul 7th).</p>\r\n\r\n<p>Thanks and Regards,&nbsp;</p>\r\n\r\n<p>Meena M</p>\r\n\r\n<p>Automation Test Engineer</p>\r\n', '2024-07-01 02:19:18', NULL, NULL, 1, NULL, 33, '1', '0', '2', 0, NULL, NULL),
(71, '2', '2024-07-01', '2024-07-01', '<p>I hope this message finds you well. I m feeling unwell today due to headache and cold. Consequently, I will be unable to perform my duties effectively. I&#39;ll keep you updated on my progress and ensure a smooth transition of my tasks during my absence.</p>\r\n\r\n<p>Therefore, I kindly request a one day leave.I appreciate your understanding and support in this matter.</p>\r\n\r\n<p>Appreciate your understanding.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Nithyashree N Bannur</p>\r\n\r\n<p>Jr Java developer.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2024-07-01 02:48:33', NULL, NULL, 1, NULL, 31, '1', '0', '1', 0, NULL, NULL),
(72, '2', '2024-07-02', '2024-07-02', '<p>Please excuse me as I am travelling back home due to my grandfather being sick.&nbsp;<br />\r\n<br />\r\nI will come to office from wednesday.&nbsp;</p>\r\n', '2024-07-01 06:05:20', NULL, NULL, 1, NULL, 61, '1', '0', '1', 0, NULL, NULL),
(77, '5', '', '', '<p>We have Payed the Rent for the PG for the New Employee of Our Company(Ajith N)</p>\r\n', '2024-07-02 04:44:32', NULL, NULL, 1, NULL, 47, '1', '0', '0', 0, '2024-07-02T09:00', '2024-07-02T10:00'),
(78, '5', '', '', '<p>Permission Due to heavy traffiv in hebbal&nbsp;</p>\r\n', '2024-07-02 04:55:18', NULL, NULL, 1, NULL, 32, '1', '0', '0', 0, '2024-07-02T10:01', '2024-07-02T11:01'),
(80, '2', '2024-07-03', '2024-07-03', '<p>My husband not feeling well need to take him to hospital.</p>\r\n\r\n<p>Kindly accept my request&nbsp;</p>\r\n', '2024-07-03 03:31:44', NULL, NULL, 1, NULL, 32, '1', '0', '1', 0, NULL, NULL),
(82, '2', '2024-07-06', '2024-07-06', '<p>I am Divya M N, a Backend Developer. I am requesting casual leave on 06-07-2024 (Saturday) as I have a dental appointment for a teeth clip placement. I assure you that my leave will not affect any ongoing projects, as I am completing my tasks on schedule. Kindly approve my leave request.</p>\r\n', '2024-07-03 12:15:16', NULL, NULL, 1, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(84, 'Others', '2024-07-04', '2024-07-04', '<p>Dear Sharanya,</p>\r\n\r\n<p>I hope this message finds you well. Due to some emergency , I need to request emergency leave 04-07-2024. I&#39;ve ensured tasks are handled appropriately. Please advise if any specific protocols need to be followed. Thank you for your understanding and support.</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Nithyashree N Bannur</p>\r\n', '2024-07-04 02:44:37', NULL, NULL, 1, NULL, 31, '1', '1', '1', 0, NULL, NULL),
(85, '5', '', '', '<p><strong>Subject</strong>: <strong>Request for Early Departure Approval,</strong></p>\r\n\r\n<p>I hope this message finds you well. I am writing to request your approval for leaving the office one hour earlier than usual today due to an emergency situation that requires my immediate attention outside of work.</p>\r\n\r\n<p>I apologize for any inconvenience this may cause and appreciate your understanding in this matter. Please let me know if you need any further information or if there are any specific protocols I should follow.</p>\r\n\r\n<p><strong>Thank you for your consideration.</strong></p>\r\n\r\n<p><strong>Best regards,</strong></p>\r\n\r\n<p><strong>Dilip P<br />\r\nPython Developer<br />\r\n+91 9743591277</strong></p>\r\n', '2024-07-04 11:38:04', NULL, NULL, 1, NULL, 24, '1', '0', '0', 0, '2024-07-04T18:00', '2024-07-04T19:00'),
(86, '2', '2024-07-05', '2024-07-05', '<p>I had a medical appointment tomorrow i need leave&nbsp;</p>\r\n', '2024-07-04 11:54:19', NULL, NULL, 2, NULL, 50, '1', '0', '1', 0, NULL, NULL),
(87, 'Others', '2024-07-06', '2024-07-05', '<p>Husband not feeling well - Taken to hospital.</p>\r\n', '2024-07-06 01:31:02', NULL, NULL, 1, NULL, 32, '1', '1', '2', 0, NULL, NULL),
(88, '2', '2024-07-08', '2024-07-08', '<p>Subject: Request for One Day Leave.</p>\r\n\r\n<p>Dear Sir/Ma&#39;am,</p>\r\n\r\n<p>I hope this message finds you well. I am writing to request one day&#39;s leave on 08-07-2024 to complete my Aadhar verification.</p>\r\n\r\n<p>Thank you&nbsp;</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Sharathchandra B R.</p>\r\n', '2024-07-06 20:12:30', NULL, NULL, 1, NULL, 38, '1', '0', '1', 0, NULL, NULL),
(91, '2', '2024-07-09', '2024-07-09', '<p>Experiencing a heavy cough and fever&nbsp;</p>\r\n', '2024-07-09 03:10:25', NULL, NULL, 1, NULL, 47, '1', '0', '1', 0, NULL, NULL),
(92, 'Others', '2024-07-12', '2024-07-08', '<p>Work from Home</p>\r\n', '2024-07-09 07:56:20', NULL, NULL, 1, NULL, 67, '1', '1', '5', 0, NULL, NULL),
(93, '5', '', '', '<p>Due to heavy traffic I couldn&#39;t be able to reach the office on time&nbsp;</p>\r\n', '2024-07-10 04:00:10', NULL, NULL, 1, NULL, 34, '1', '0', '0', 0, '2024-07-10T10:00', '2024-07-10T11:00'),
(94, '5', '', '', '<p>I am in need of one hour permission since my relatives came here to meet me, Kindly approve for the same. Thanks in advance</p>\r\n', '2024-07-10 09:05:23', NULL, NULL, 1, NULL, 33, '1', '0', '0', 0, '2024-07-10T15:00', '2024-07-10T16:00'),
(95, 'Others', '2024-07-13', '2024-07-08', '<p>I have been diagnosed with dengue fever and am currently feeling unwell.</p>\r\n', '2024-07-11 07:58:05', NULL, NULL, 1, NULL, 10, '1', '1', '6', 0, NULL, NULL),
(97, '2', '2024-07-16', '2024-07-15', '<p>Dear Sir/Mam,</p>\r\n\r\n<p>I hope this message finds you well.</p>\r\n\r\n<p>I am writing to request leave for two days, from 15/07/2024 to 16/07/2024. I have some personal matters that need my attention during this time.</p>\r\n\r\n<p>I will ensure that all my tasks are up to date before I leave and will be available for any urgent matters via email.</p>\r\n\r\n<p>Thank you for considering my request.</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>M.Jyothsna</p>\r\n', '2024-07-11 15:31:56', NULL, NULL, 1, NULL, 25, '1', '0', '2', 0, NULL, NULL),
(99, '2', '2024-07-12', '2024-07-12', '<p>Subject :- Requesting for a one day leave due to health issues&nbsp;</p>\r\n\r\n<p>As per the above subject I&#39;m not well so I request you to grant me a one day leave..</p>\r\n\r\n<p>Thanks and regards,</p>\r\n\r\n<p>Dilip P&nbsp;</p>\r\n', '2024-07-12 02:14:40', NULL, NULL, 1, NULL, 24, '1', '0', '1', 0, NULL, NULL),
(100, '2', '2024-07-12', '2024-07-12', '<p>I hope this message finds you well. I am writing to inform you that I am feeling unwell and will not be able to come to work today. I have seen a doctor and have been advised to rest.</p>\r\n\r\n<p>I will keep you updated on my condition and inform you when I am able to return to work. I apologize for any inconvenience this may cause and will ensure that all my pending tasks are covered.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nAbdul Ahad<br />\r\nFront End Developer<br />\r\nabdulahad@mineit.tech<br />\r\nMine</p>\r\n', '2024-07-12 02:38:37', NULL, NULL, 1, NULL, 28, '1', '0', '1', 0, NULL, NULL),
(102, '2', '2024-07-12', '2024-07-12', '<p>Subject: Request for Half Day Leave</p>\r\n\r\n<p>Dear sir/maam,</p>\r\n\r\n<p>I hope this email finds you well. I am writing to request a half-day leave on 12/07/24 due to travel plans to my native place. I will be available in the morning and will complete any urgent tasks before I leave.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n\r\n<p>Best regards,<br />\r\nBHANU PRASAD YADAV P<br />\r\nJr Java developer<br />\r\n9632920686</p>\r\n', '2024-07-12 05:08:20', NULL, NULL, 1, NULL, 30, '1', '0', '1', 0, NULL, NULL),
(103, '2', '2024-07-16', '2024-07-15', '<p>Dear sir,i hope this message&nbsp;finds you in good health.i am writing to request a leave to addent&nbsp;my uncle ceremony,which is family event on 15/7/24 to 16/7/24, so please consider my leave.</p>\r\n\r\n<p>Thanks &amp; regards</p>\r\n\r\n<p>G.paranthaman</p>\r\n', '2024-07-12 07:16:57', NULL, NULL, 1, NULL, 40, '1', '0', '2', 0, NULL, NULL),
(104, '5', '', '', '<p>I am writing to request permission to leave the office early today as I need to catch a bus to my hometown to ensure a timely arrival at my home. I will make sure to complete all my tasks before leaving.</p>\r\n', '2024-07-12 10:22:24', NULL, NULL, 1, NULL, 2, '1', '0', '0', 0, '2024-07-12T18:00', '2024-07-12T19:00'),
(106, '2', '2024-07-19', '2024-07-18', '<p>I am writing to request leave on 18th and 19th July 2024 in order to attend my practical exams scheduled for these dates. I kindly ask for your permission to be absent on these days so that I can focus on my exams. I assure you that I will complete all my pending work before my leave and will catch up on any missed tasks upon my return.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n', '2024-07-17 10:06:19', NULL, NULL, 1, NULL, 2, '1', '0', '2', 0, NULL, NULL),
(107, '2', '2024-07-21', '2024-07-21', '<p>I hope this message finds you well. I am writing to request leave from 21/07/2024&nbsp;to 21/07/2024&nbsp; due to [reason for leave].</p>\r\n\r\n<p>During my absence, I will ensure that all my responsibilities are covered. Please let me know if there are any specific tasks you would like me to address before I leave.</p>\r\n\r\n<p>Thank you for considering my request. I look forward to your approval.</p>\r\n', '2024-07-20 11:59:36', NULL, NULL, 1, NULL, 7, '1', '0', '1', 0, NULL, NULL),
(109, '2', '2024-08-20', '2024-08-19', '<p>Dear Dr.Karthikeyan,</p>\r\n\r\n<p>I hope this email finds you well.</p>\r\n\r\n<p>I am writing to inform you that I have been recovering from typhoid, and while my fever has reduced only two days ago, I am still not fully recovered. Upon my doctor&#39;s advice, I will need to take additional rest to ensure a complete recovery. Therefore, I would like to request sick leave for Monday, August 19th, and Tuesday, August 20th.</p>\r\n\r\n<p>If my health does not improve by then, I may need to extend my leave, and I will keep you updated on my condition. Please rest assured that I am committed to completing my project on time once I am fully recovered.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nSabari Raj S R</p>\r\n', '2024-08-18 13:15:42', NULL, NULL, 1, NULL, 16, '1', '0', '2', 0, NULL, NULL),
(110, '2', '2024-08-20', '2024-08-19', '<p>Good morning [Sir/Madam],</p>\r\n\r\n<p>I am Ashwini Satti, working at MINE. I would like to request&nbsp; casual leave for tomorrow, 19th August 2024, as we are celebrating a festival at our home for Raksha Bandhan.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nAshwini Satti</p>\r\n', '2024-08-18 16:32:47', NULL, NULL, 1, NULL, 35, '1', '0', '2', 0, NULL, NULL),
(111, '2', '2024-08-19', '2024-08-19', '<p>Due to an unexpected emergency, I will be return to the office tomorrow. I apologize for any inconvenience and will ensure that my tasks are completed.</p>\r\n', '2024-08-19 04:09:55', NULL, NULL, 1, NULL, 37, '1', '0', '1', 0, NULL, NULL),
(113, '2', '2024-08-19', '2024-08-19', '<p>I hope this message finds you well. I am writing to inform you that I am unable to make it to work today as the bus I was traveling on has broken down, and there is no immediate alternative transportation available.</p>\r\n\r\n<p>I sincerely apologize for the inconvenience this may cause and request leave for today, 19th August 2024.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p><strong>Best regards,</strong><br />\r\nLatika</p>\r\n', '2024-08-19 09:36:32', NULL, NULL, 1, NULL, 60, '1', '0', '1', 0, NULL, NULL),
(114, '2', '2024-08-21', '2024-08-21', '<p>Subject: Leave Application Due to Illness</p>\r\n\r\n<p>Dear Sir/Ma&#39;am,</p>\r\n\r\n<p>I am writing to inform you that I am unwell and will not be able to attend work on 21-8-2024. I will keep you updated on my recovery and will return to work as soon as I am able.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n', '2024-08-21 02:39:55', NULL, NULL, 1, NULL, 22, '1', '0', '1', 0, NULL, NULL),
(115, '2', '2024-08-23', '2024-08-23', '<p>Subject: Request for Leave on 23rd August 2024</p>\r\n\r\n<p>I hope this message finds you well. I am writing to inform you that I need to attend an important family function on the 23rd of August 2024.</p>\r\n\r\n<p>I kindly request approval for a day&#39;s leave on that date. I have ensured that all my current tasks are up-to-date, and I will make the necessary arrangements to manage any ongoing responsibilities during my absence.</p>\r\n\r\n<p>Please let me know if any further information is required. I appreciate your understanding and support.</p>\r\n\r\n<p>Thank you for considering&nbsp;my&nbsp;request.<br />\r\nSharathchandra B R<br />\r\nFrontend Developer</p>\r\n', '2024-08-21 09:33:22', NULL, NULL, 1, NULL, 38, '1', '0', '1', 0, NULL, NULL),
(116, '2', '2024-08-22', '2024-08-22', '<p>Subject: Request for Leave on 22rd August 2024</p>\r\n\r\n<p><br />\r\nI hope this message finds you well. I am writing to inform you that I need to attend an important family function on the 23rd of August 2024.</p>\r\n\r\n<p>I kindly request approval for a day&#39;s leave on that date. I have ensured that all my current tasks are up-to-date, and I will make the necessary arrangements to manage any ongoing responsibilities during my absence.</p>\r\n\r\n<p>Please let me know if any further information is required. I appreciate your understanding and support.</p>\r\n\r\n<p>Thank you for considering my request.<br />\r\nSharathchandra B R<br />\r\nFrontend developer</p>\r\n', '2024-08-21 15:08:14', NULL, NULL, 1, NULL, 38, '1', '0', '1', 0, NULL, NULL),
(117, '5', '', '', '<p>I need 1 hour permission for my personal work</p>\r\n', '2024-08-22 13:11:36', NULL, NULL, 1, NULL, 25, '1', '0', '0', 0, '2024-08-23T10:00', '2024-08-23T11:00'),
(118, '5', '', '', '<p>Some personal work I am taking permission&nbsp;</p>\r\n', '2024-08-23 02:48:55', NULL, NULL, 1, NULL, 27, '1', '0', '0', 0, '2024-08-23T10:00', '2024-08-23T11:00'),
(120, '2', '2024-08-26', '2024-08-26', '<p>I hope this message finds you well. I m feeling unwell today due to headache and cold. Consequently, I will be unable to perform my duties effectively. I&#39;ll keep you updated on my progress and ensure a smooth transition of my tasks during my absence.</p>\r\n\r\n<p>Therefore, I kindly request a one day leave.I appreciate your understanding and support in this matter.</p>\r\n\r\n<p>Appreciate your understanding.</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Nithyashree N Bannur&nbsp;</p>\r\n\r\n<p>Jr Java Developer.</p>\r\n', '2024-08-26 02:21:05', NULL, NULL, 1, NULL, 31, '1', '0', '1', 0, NULL, NULL),
(121, '2', '2024-08-29', '2024-08-28', '<p>Due to some emergency i need to go out of station</p>\r\n', '2024-08-26 07:44:32', NULL, NULL, 1, NULL, 34, '1', '0', '2', 0, NULL, NULL),
(122, '5', '', '', '<p>Due to health checkup&nbsp;</p>\r\n', '2024-08-26 08:58:00', NULL, NULL, 1, NULL, 30, '1', '0', '0', 0, '2024-08-26T17:30', '2024-08-26T18:30'),
(123, '2', '2024-08-27', '2024-08-27', '<p>Dear sir /mam</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>I am writing to inform you that I need to take a leave of absence from work due to some personal work that requires my immediate attention.</p>\r\n\r\n<p>Thank you for considering my request.</p>\r\n\r\n<p><strong>Sincerely,</strong></p>\r\n\r\n<p>Bhavya Sree&nbsp;</p>\r\n\r\n<p>Python developer&nbsp;</p>\r\n', '2024-08-26 15:29:24', NULL, NULL, 1, NULL, 27, '1', '0', '1', 0, NULL, NULL),
(124, '2', '2024-08-27', '2024-08-27', '<p>Dear sir/ma&#39;am,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Greetings of the day!</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>I&#39;m not feeling well as suffering from fever from yesterday. Hoping that you&#39;ll understand my situation and do the needful.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks &amp; Regards,</p>\r\n\r\n<p>K SUMANTH KUMAR RAJU,</p>\r\n\r\n<p>Backend Developer.</p>\r\n', '2024-08-26 22:56:17', NULL, NULL, 1, NULL, 29, '1', '0', '1', 0, NULL, NULL),
(125, '2', '2024-08-31', '2024-08-30', '<p><strong>Subject:</strong> Request for Leave Due to Health Check-Up</p>\r\n\r\n<p>Dear Mam,</p>\r\n\r\n<p>I hope this message finds you well. I am writing to inform you that I have a scheduled health check-up on 30-08-2024 to 31-08-2024&nbsp;and would like to request leave for the day.</p>\r\n\r\n<p>I apologize for any inconvenience this may cause and will ensure that all my pending work is completed before my absence. I will be available on email for any urgent matters.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nBhanu Prasad Yadav<br />\r\nJr Java Developer</p>\r\n', '2024-08-27 05:11:27', NULL, NULL, 1, NULL, 30, '1', '0', '2', 0, NULL, NULL),
(126, '2', '2024-08-31', '2024-08-31', '<p>I am Divya M N, a Backend Developer. I am requesting casual leave on 31-08-2024 (Saturday) as I have a dental appointment for a teeth clip placement. I assure you that my leave will not affect any ongoing projects, as I am completing my tasks on schedule. Kindly approve my leave request.</p>\r\n', '2024-08-27 05:16:24', NULL, NULL, 1, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(128, '2', '2024-08-28', '2024-08-28', '<p>Subject: Application for One Day Leave_ Bank Work</p>\r\n\r\n<p>Dear sir/mam,</p>\r\n\r\n<p>I am writing to request a one-day leave on 28-08-2024 to 28-08-2024 for&nbsp;attend to some urgent bank-related work. This task requires my personal presence at the bank and cannot be completed outside of working hours.</p>\r\n\r\n<p><br />\r\nThank you for your understanding.</p>\r\n\r\n<p>Sincerely,<br />\r\nJyothsna M</p>\r\n', '2024-08-27 07:08:11', NULL, NULL, 1, NULL, 25, '1', '0', '1', 0, NULL, NULL),
(129, '5', '', '', '<p>I hope this message finds you well. I am writing to request permission to leave the office for one hour&nbsp; from 2:45pm&nbsp;to 3:45pm, to update my Aadhaar card. The Aadhaar update center requires in-person verification, and I have been scheduled for an appointment at that time.</p>\r\n\r\n<p>I assure you that I will complete any pending tasks before I leave and make up for the time lost once I return. If there are any urgent matters that need my attention during my absence, please let me know, and I will make the necessary arrangements to address them promptly.</p>\r\n\r\n<p>Thank you for considering my request. I apologize for any inconvenience this may cause and appreciate your understanding and support.</p>\r\n\r\n<p>Best regards,<br />\r\nSharathchandra B R</p>\r\n', '2024-08-28 07:43:48', NULL, NULL, 1, NULL, 38, '1', '0', '0', 0, '2024-08-28T14:45', '2024-08-28T15:45'),
(130, '2', '2024-08-29', '2024-08-29', '<p>I am Divya MN,working as a Backend developer. I am requesting sick leave on 29-08-2024 (Thursday) because I am not feeling well and I&#39;m going for hospital so please kindly approve my leave .I assure that my work won&#39;t affect to any of my current ongoing projects.</p>\r\n', '2024-08-29 03:43:53', NULL, NULL, 1, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(131, '5', '', '', '<p>I am going out for emergency purpose.</p>\r\n', '2024-08-29 12:02:50', NULL, NULL, 1, NULL, 16, '1', '0', '0', 0, '2024-08-29T18:01', '2024-08-29T19:01'),
(132, '2', '2024-08-29', '2024-08-29', '<p>Subject: Request for Sick Leave on 29/08/2024</p>\r\n\r\n<p>Dear Sir/Ma&#39;am,</p>\r\n\r\n<p>I hope this message finds you well. I am writing to inform you that I am not feeling well and would like to request sick leave for today, 29th August 2024.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Shashi Bhavan C K</p>\r\n', '2024-08-29 13:09:56', NULL, NULL, 1, NULL, 22, '1', '0', '1', 0, NULL, NULL),
(138, '2', '2024-09-13', '2024-09-13', '<p>I hope this email finds you well. I would like to request a one-day leave on 13th September, as I need to accompany my brother to Chennai for his send-off as he is going abroad.</p>\r\n\r\n<p>Please let me know if any further details are required.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nSabari Raj</p>\r\n\r\n<p>Frontend Developer &amp; Web Administrator</p>\r\n', '2024-09-13 04:07:05', NULL, NULL, 1, NULL, 16, '1', '0', '1', 0, NULL, NULL),
(139, '2', '2024-09-18', '2024-09-18', '<p>&nbsp;</p>\r\n\r\n<p>I hope this message finds you well. I m feeling unwell today due to headache and cold. Consequently, I will be unable to perform my duties effectively. I&#39;ll keep you updated on my progress and ensure a smooth transition of my tasks during my absence.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Therefore, I kindly request a one day leave.I appreciate your understanding and support in this matter.</p>\r\n\r\n<p>Appreciate your understanding.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Best regards,</p>\r\n\r\n<p>Nithyashree N Bannur</p>\r\n\r\n<p>Jr Java developer</p>\r\n', '2024-09-18 03:03:57', NULL, NULL, 1, NULL, 31, '1', '0', '1', 0, NULL, NULL),
(140, '2', '2024-09-18', '2024-09-18', '<p>Subject: Request for Leave Due to Grandfather&rsquo;s Demise</p>\r\n\r\n<p>I am writing to inform you of the unfortunate passing of my grandfather. In light of this, I request to take a day off on 18-9-2024 to be with my family and attend the funeral.</p>\r\n\r\n<p>I hope for your understanding during this difficult time, and I will ensure that all my responsibilities are taken care of before my leave.</p>\r\n\r\n<p>Thank you for your support.</p>\r\n', '2024-09-18 05:54:34', NULL, NULL, 1, NULL, 22, '1', '0', '1', 0, NULL, NULL),
(143, '5', '', '', '<p>I hope this message finds you well. I would like to request your permission to take one hour off from work on 18-09-2024&nbsp;from 6pm&nbsp;to 7pm&nbsp;due toa personal appointment.</p>\r\n\r\n<p>I will ensure that all my tasks are up to date and that there is no disruption to ongoing work. If needed, I will also make up for the lost time after returning.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n\r\n<p>Sincerely,</p>\r\n', '2024-09-18 11:39:51', NULL, NULL, 1, NULL, 38, '1', '0', '0', 0, '2024-09-18T06:00', '2024-09-18T07:00'),
(144, '5', '', '', '<p><strong>Subject</strong>: Request for One Hour Leave Due to Personal Problem</p>\r\n\r\n<p>I hope this message finds you well. I would like to request one hour of leave today from [6:00] to [7:00] due to a personal matter that requires my immediate attention.</p>\r\n\r\n<p>I will ensure to make up for any work missed during this time. Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\n[Ashwini Satti]</p>\r\n', '2024-09-18 11:59:32', NULL, NULL, 1, NULL, 35, '1', '0', '0', 0, '2024-09-18T18:00', '2024-09-18T19:00'),
(145, '2', '2024-09-21', '2024-09-21', '<p><strong>Subject:</strong> Request for One Day Leave.</p>\r\n\r\n<p>I hope this message finds you well. I would like to request a day leave&nbsp;on [21-09-2024] as my parents are visiting, and I need to hospital for a medical appointment.</p>\r\n\r\n<p>I will ensure that all my ongoing tasks are up to date and hand over any necessary responsibilities to my colleagues during my absence.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n\r\n<p>Best regards,<br />\r\n[Ashwini Satti]</p>\r\n', '2024-09-19 13:01:36', NULL, NULL, 1, NULL, 35, '1', '0', '1', 0, NULL, NULL),
(146, '2', '2024-09-20', '2024-09-20', '<p>Dear Sir/Mam</p>\r\n\r\n<p>Im Jyothsna working as a frontend developer at MINE. Im unable to come office today because of my health. Im taking leave from 20/9/2024 to 20/9/2024. Hope u will Understand my situation.&nbsp;</p>\r\n\r\n<p>Thanking you,</p>\r\n\r\n<p>Your&#39;s Obediently,</p>\r\n\r\n<p>M</p>\r\n\r\n<p>Jyothsna.M</p>\r\n', '2024-09-20 03:05:31', NULL, NULL, 1, NULL, 25, '1', '0', '1', 0, NULL, NULL),
(151, '2', '2024-09-26', '2024-09-26', '<p>I am Divya MN, working as a Backend developer. I am requesting for sick leave on 26/09/2024 because of some health issues.so,kindly approve leave .</p>\r\n', '2024-09-26 02:05:37', NULL, NULL, 2, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(152, '2', '2024-09-27', '2024-09-27', '<p>I am Divya MN, working as a Backend developer at Merry&#39;s Infotech and new gen educare. I am requesting for sick leave because of some health issues, my work will be taken care by shahsi,so that progress won&#39;t be affected to any of project.so,kindly approve my leave.</p>\r\n', '2024-09-27 03:08:43', NULL, NULL, 1, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(153, '2', '2024-09-27', '2024-09-27', '<p>&nbsp;</p>\r\n\r\n<p>I hope this message finds you well. I am writing to inform you that I am unable to come to work today, 27-9-2024, as my right leg is swollen, making it difficult for me to walk properly. I will be taking a day of sick leave to rest and recover.</p>\r\n\r\n<p>Please let me know if there are any immediate tasks or updates that require my attention, and I will do my best to address them remotely if possible.</p>\r\n\r\n<p>Thank you for your understanding.</p>\r\n\r\n<p>Best regards,<br />\r\nSabari Raj S R</p>\r\n', '2024-09-27 03:22:36', NULL, NULL, 1, NULL, 16, '1', '0', '1', 0, NULL, NULL),
(155, '2', '2024-10-08', '2024-10-08', '<p>Due to some emergency problem am going out of station&nbsp;</p>\r\n', '2024-10-06 13:29:03', NULL, NULL, 1, NULL, 34, '1', '0', '1', 0, NULL, NULL),
(156, '2', '2024-10-08', '2024-10-08', '<p>I am Divya MN, working as a Backend developer at Merry&#39;s Infotech and new gen educare. I am requesting for half day sick leave because of some health issues, my work will be taken care by shahsi,so that progress won&#39;t be affected to any of project.so,kindly approve my leave.</p>\r\n', '2024-10-08 09:31:19', NULL, NULL, 1, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(157, '2', '2024-10-14', '2024-10-14', '<p>I am writing to formally request leave on Monday, October 14th, as I need to visit the bank to inquire about my education loan. I have been receiving calls from the bank regarding this matter, and it&rsquo;s important for me to clarify the details in person.</p>\r\n\r\n<p>Thank you for your understanding. Please let me know if you need any further information.</p>\r\n\r\n<p>Best regards,<br />\r\nDivya MN</p>\r\n', '2024-10-13 09:31:56', NULL, NULL, 1, NULL, 15, '1', '0', '1', 0, NULL, NULL),
(159, '5', '', '', '<p>Subject: Request for One Hour Permission to Send Documents</p>\r\n\r\n<p>Dear,</p>\r\n\r\n<p>I hope this message finds you well. I would like to request a one-hour permission to send some important documents related .</p>\r\n\r\n<p>Thank you for your understanding, and I appreciate your support.</p>\r\n\r\n<p>Best regards,<br />\r\n&nbsp;</p>\r\n', '2024-10-23 06:55:39', NULL, NULL, 0, NULL, 38, '1', '0', '0', 0, '2024-10-22T14:45', '2024-10-22T15:45'),
(161, '2', '2024-10-30', '2024-10-29', '<p>I am writing to confirm my leave and work arrangements for the upcoming days.</p>\r\n\r\n<p>I will be on leave on Tuesday, 28/10/24&nbsp; and Wednesday, 29/10/24 as I am traveling to my native place to celebrate the Diwali festival with my family. Additionally, I will be working from home on the 4th and 5th of November, as I will be accompanying my father to the hospital for his health checkup. I have already informed the CTO regarding my work-from-home arrangement.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n\r\n<p>Best regards,<br />\r\nSabari Raj S R<br />\r\nFull Stack Developer</p>\r\n', '2024-10-28 07:57:10', NULL, NULL, 1, NULL, 16, '1', '0', '2', 0, NULL, NULL),
(162, 'Others', '2024-11-04', '2024-11-04', '<p>I am writing to formally request leave on Monday, November 4th, as I need to visit the bank to inquire about my education loan. I have been receiving messages and calls from the bank regarding this matter and also they are keeping penalty charges due to overdue, and it&rsquo;s important for me to clarify the details in personal.</p>\r\n', '2024-10-29 07:11:24', NULL, NULL, 1, NULL, 15, '1', '1', '1', 0, NULL, NULL),
(163, '2', '2025-05-14', '2025-05-14', '<p>jubfvdzfhjh</p>\r\n', '2025-05-14 11:36:19', NULL, NULL, 1, NULL, 21, '1', '0', '1', 0, NULL, NULL),
(164, '2', '2025-05-14', '2025-05-14', '<p>ihgcvb</p>\r\n', '2025-05-14 11:38:27', NULL, NULL, 1, NULL, 21, '1', '0', '1', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`, `Company_id`) VALUES
(1, 'Casual Leave', 'Provided for urgent or unforeseen matters to the employees.', '2020-11-01 01:07:56', '1'),
(2, 'Medical Leave', 'Related to Health Problems of Employee', '2020-11-06 02:16:09', '1'),
(3, 'Restricted Holiday', 'Holiday that is optional', '2020-11-06 02:16:38', '1'),
(5, 'Paternity Leave', 'To take care of newborns', '2021-03-02 23:46:31', '1'),
(6, 'Bereavement Leave', 'Grieve their loss of losing loved ones', '2021-03-02 23:47:48', '1'),
(7, 'Compensatory Leave', 'For Overtime workers', '2021-03-02 23:48:37', '1'),
(8, 'Maternity Leave', 'Taking care of newborn ,recoveries', '2021-03-02 23:50:17', '1'),
(9, 'Religious Holidays', 'Based on employee\'s followed religion', '2021-03-02 23:51:26', '1'),
(10, 'Adverse Weather Leave', 'In terms of extreme weather conditions', '2021-03-03 02:18:26', '1'),
(11, 'Voting Leave', 'For official election day', '2021-03-03 02:19:06', '1'),
(12, 'Self-Quarantine Leave', 'Related to COVID-19 issues', '2021-03-03 02:19:48', '1'),
(13, 'Personal Time Off', 'To manage some private matters', '2021-03-03 02:21:10', '1');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `teamname` varchar(255) NOT NULL,
  `employee` varchar(255) NOT NULL,
  `leader` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `project_lead` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `teamname`, `employee`, `leader`, `created_at`, `project_lead`, `Company_id`) VALUES
(1, 'Algorithm Avengers', '28, 2, 30, 15, 39, 20, 22, 34', '2', '2024-06-04 01:59:03', '7', '1'),
(2, 'Code Crafters', '26, 27, 31, 10, 32, 6', '32', '2024-06-07 09:11:40', '7', '1'),
(3, 'Quality Seekers', '49, 48, 33, 36, 21', '33', '2024-06-07 09:12:46', '7', '1'),
(4, 'Black Squad Programmers', '35, 30, 7, 25, 38, 6', '7', '2024-06-07 09:17:37', '7', '1'),
(5, 'Designer Team', '53, 37, 60, 40, 54', '53', '2024-06-07 09:19:07', '7', '1'),
(6, 'Cyber Security', '16', '16', '2024-06-07 09:20:36', '7', '1'),
(7, 'Quality Checking', '104, 83, 110, 74', '87', '2024-08-20 04:44:28', '103', '5'),
(8, 'developers squad', '26, 30', '26', '2024-08-29 07:05:57', '33', '1'),
(9, '', '31, 21', '21', '2024-09-02 10:12:39', '33', '1'),
(10, ' ', '21', '21', '2024-09-02 10:20:04', '33', '1'),
(11, 'development team', '26, 35, 30, 34', '30', '2024-09-23 06:43:49', '33', '1'),
(12, 'developers', '30', '26', '2024-09-23 07:27:39', '33', '1'),
(13, 'Swifterz', '27, 49, 55', '27', '2024-09-30 10:29:13', '33', '1');

-- --------------------------------------------------------

--
-- Table structure for table `teamrequried`
--

CREATE TABLE `teamrequried` (
  `Id` int(11) NOT NULL,
  `TeamLead` varchar(255) DEFAULT NULL,
  `RequiredRole` varchar(255) DEFAULT NULL,
  `RequiredExperience` varchar(255) DEFAULT NULL,
  `TimeToHire` varchar(255) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Pending',
  `completed` varchar(255) NOT NULL DEFAULT '0',
  `teamtype` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `Subject` varchar(255) DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `Company_id` varchar(255) DEFAULT NULL,
  `currentdate` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` varchar(255) DEFAULT NULL,
  `forward` varchar(255) DEFAULT NULL,
  `view` varchar(255) NOT NULL DEFAULT '0',
  `ring` varchar(255) NOT NULL DEFAULT '0',
  `Ticket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `teamrequried`
--

INSERT INTO `teamrequried` (`Id`, `TeamLead`, `RequiredRole`, `RequiredExperience`, `TimeToHire`, `number`, `Status`, `completed`, `teamtype`, `type`, `Subject`, `Message`, `to`, `amount`, `Company_id`, `currentdate`, `remark`, `forward`, `view`, `ring`, `Ticket`) VALUES
(8, '53', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'other', 'Canva Subscription, Freepik', 'We need Canva Subscription to work and for other design works.', '7', NULL, '1', '2024-06-19 06:48:40', ' ', '', '1', '0', 'Ticket_9992'),
(12, '53', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'Hardware Issue', 'Need storage space to render Creatives', '<p>Due to usage my personal laptop I&#39;m running out of storage, please make a step to figure it out. Or make arrangements for new work system.</p>\r\n', '7', NULL, '1', '2024-06-21 07:29:10', '    ', '', '1', '0', 'Ticket_4043'),
(13, '33', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Software Issue', 'Not able to apply leave', '<p>Im trying apply leave but im not able to apply and getting below error code</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Warning</strong>: Undefined array key &quot;leaveType&quot; in&nbsp;<strong>/home/snh6/domains/jiffy.mineit.tech/public_html/jiffy/project/leave.php</strong>&nbsp;on line&nbsp;<strong>30</strong><br />\r\n<br />\r\n<strong>Warning</strong>: Undefined array key &quot;leaveNamePolicy&quot; in&nbsp;<strong>/home/snh6/domains/jiffy.mineit.tech/public_html/jiffy/project/leave.php</strong>&nbsp;on line&nbsp;<strong>31</strong><br />\r\n<br />\r\n<strong>Fatal error</strong>: Uncaught mysqli_sql_exception: Column &#39;title&#39; cannot be null in /home/snh6/domains/jiffy.mineit.tech/public_html/jiffy/project/leave.php:44 Stack trace: #0 /home/snh6/domains/jiffy.mineit.tech/public_html/jiffy/project/leave.php(44): mysqli_stmt-&gt;execute() #1 {main} thrown in&nbsp;<strong>/home/snh6/domains/jiffy.mineit.tech/public_html/jiffy/project/leave.php</strong>&nbsp;on line&nbsp;<strong>44</strong></p>\r\n', '7', NULL, '1', '2024-06-25 10:49:32', 'done', '', '1', '0', 'Ticket_3520'),
(14, '26', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'Hardware Issue', 'Requesting Replacement For Charger', '<p>My laptop charger got burnt and has not been working since the last 2 days, I request you to replace it with a new one as soon as possible.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks in advance,</p>\r\n', '1', NULL, '1', '2024-06-25 13:53:02', 'approved', '', '1', '0', 'Ticket_3018'),
(15, '25', NULL, NULL, NULL, NULL, 'Forword', '0', NULL, 'Software Issue', 'Need Lan connector for Macbook', '<p>I need Lan connect for macbook pro.Because of that im not able to connect my Lan to my laptop.</p>\r\n', '1', NULL, '1', '2024-06-25 13:54:17', 'I need lan connector for makbook', '1', '1', '0', 'Ticket_5889'),
(17, '39', NULL, NULL, NULL, NULL, 'Forword', '0', NULL, 'other', 'Hardware ', '<p>monitor,hdmi connector,keyboard,mouse<br />\r\nand emergency requiremenet for internet connection&nbsp;</p>\r\n', '1', NULL, '1', '2024-06-25 14:05:19', 'send message to maheen\r\n', '', '1', '0', 'Ticket_7599'),
(18, '28', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Hardware Issue', 'Replacement of Lenovo ThinkPad Laptop of System Name:DESKTOP-A9ILP8H', '<p>I am writing to request a replacement for my Lenovo ThinkPad laptop as it has become very slow and is affecting my productivity.</p>\r\n\r\n<p>Could you please assist with providing a new or upgraded laptop at your earliest convenience?</p>\r\n\r\n<p>Thank you.</p>\r\n\r\n<p>Best regards,<br />\r\nAbdul Ahad<br />\r\nabdul@mineit.tech<br />\r\nFront End Developer<br />\r\nMINE</p>\r\n', '1', NULL, '1', '2024-06-25 14:07:04', NULL, NULL, '1', '0', 'Ticket_3326'),
(20, '24', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'other', 'Requesting for the Lan connector ', '<p>As per the above subject i request you to provide me the LAN Connectoe because i cant able to access the high speed internet connectivity.&nbsp;<br />\r\n<br />\r\nThanks and Regards,&nbsp;<br />\r\nDILIP P</p>\r\n', '1', NULL, '1', '2024-06-27 13:52:36', ' ', '', '1', '0', 'Ticket_2425'),
(21, '30', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'other', 'Requesting for LAN connector', '<p>Requesting for LAN connector</p>\r\n', '1', NULL, '1', '2024-06-27 14:04:49', 'done', '', '1', '0', 'Ticket_9706'),
(22, '22', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'other', 'Requesting for the LAN connector', '<p>As per the subject I request you to provide me the LAN connector because I&#39;m facing the internet issue .</p>\r\n\r\n<p>Thanks and regards&nbsp;</p>\r\n\r\n<p>Shashi&nbsp;</p>\r\n', '1', NULL, '1', '2024-06-27 14:06:42', 'JBHB', '', '1', '0', 'Ticket_5698'),
(23, '26', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Hardware Issue', 'I need Mac Connector', '<p>I need 8 in 1 Mac connector and also a good&nbsp;monitor&nbsp;to&nbsp;work&nbsp;efficiently. Please give me as soon as possible.<br />\r\nThank you<br />\r\n<br />\r\nRegards,<br />\r\nAjith Kumar</p>\r\n', '1', NULL, '1', '2024-06-27 14:12:09', NULL, NULL, '0', '0', 'Ticket_8290'),
(24, '22', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'other', 'USB Extender ', '<p>The issue is I&#39;m not able to mouse, keyboard and LAN connector at a time so that I need the USB Extender&nbsp;</p>\r\n', '1', NULL, '1', '2024-06-27 14:17:56', NULL, NULL, '0', '0', 'Ticket_8731'),
(25, '21', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Network Issue', 'Request for Ethernet LAN port.', '<p>I am writing to request the&nbsp;Ethernet LAN port at my workstation. Due to the nature of my work, a stable and high-speed internet connection is essential for me to perform my tasks efficiently. Currently, I am experiencing some connectivity issues with the Wi-Fi, which is affecting my productivity.</p>\r\n', '1', NULL, '1', '2024-06-28 06:38:23', NULL, NULL, '1', '0', 'Ticket_9235'),
(26, '2', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Hardware Issue', 'Requesting Ethernet Port', '<p>My laptop doesn&#39;t support Ethernet cable. So I need Ethernet port to get a stable internet connection.&nbsp;</p>\r\n', '1', NULL, '1', '2024-07-01 10:37:36', NULL, NULL, '1', '0', 'Ticket_3766'),
(27, '39', NULL, NULL, NULL, NULL, 'Forword', '0', NULL, 'other', 'Hardware ', '<p>I Need to solve bugs in bluechip in my mac its not supporting to download workbench<br />\r\nso i need proper laptop with eclipes and workbench instillation&nbsp;<br />\r\nif i need dont reseve my work will get delay becouse of this i have deadline to submit project on this week friday (05/07/2024)<br />\r\nso kindly provid it tommorow<br />\r\n&nbsp;</p>\r\n', '7', NULL, '1', '2024-07-01 14:21:34', 'with in today i want is admin', '1', '1', '0', 'Ticket_9753'),
(28, '31', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'other', 'Ethernet Connector', '<p>I need a Ethernet Connector.</p>\r\n', '31', NULL, '1', '2024-07-02 07:49:25', NULL, NULL, '1', '0', 'Ticket_6596'),
(30, '53', NULL, NULL, NULL, NULL, 'Approve', '0', NULL, 'AC Issue', 'AC is not working', '<p>AC is not working Please check on this ASAP.</p>\r\n', '7', NULL, '1', '2024-07-02 08:34:58', '.', '', '1', '0', 'Ticket_5927'),
(31, '7', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'other', 'LMS BIM  Course Document', '<p>I hope this message finds you well. I am pleased to share the LMS BIM Course Document with you ahead of our scheduled demo today.</p>\r\n\r\n<p>Please find the document attached for your review. Your feedback will be invaluable during our demo session later.</p>\r\n\r\n<p>Looking forward to our discussion today.</p>\r\n', '58', NULL, '1', '2024-07-02 09:18:18', NULL, NULL, '1', '0', 'Ticket_8801'),
(32, '58', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'other', 'TASK REQUEST ', '<p>USER HAVE PAUSE THE CURRENT TASK AND TO RECEIVE NEW TASK , AS FOR THE ALLOTMENT OF MANAGEMENT FOR EMERGENY TAKS ALLOTMENT.&nbsp;</p>\r\n', '32', NULL, '1', '2024-07-02 11:42:32', NULL, NULL, '1', '0', 'Ticket_6572'),
(33, '2', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'other', 'Meeting', '<p>Good Evening Sir,</p>\r\n\r\n<p>Our AECP team has some doubts regarding the BOM and BOQ format and needs clarification on the architectural design structure extension. If you could arrange a meeting with the Swifterz team, it would be greatly helpful for our team.</p>\r\n\r\n<p>Best Regards,</p>\r\n\r\n<p>Anusiya M<br />\r\nTeam Lead<br />\r\nMerry&#39;s Info-Tech &amp; New-Gen Educare</p>\r\n', '7', NULL, '1', '2024-07-02 12:37:57', 'Take action', '67', '1', '0', 'Ticket_8118'),
(34, '27', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Hardware Issue', 'Urgent: System Malfunction Assistance Required', '<p>&nbsp; Dear mam/Sir,</p>\r\n\r\n<p>I am writing to inform you that my system is currently not working properly, which is affecting my ability to perform my tasks efficiently.</p>\r\n\r\n<p>Here are the specific issues I am encountering:</p>\r\n\r\n<ol>\r\n	<li>The taskbar is&nbsp; disabled and is not functioning correctly.</li>\r\n	<li>The system is running very slowly, significantly impacting my workflow.</li>\r\n	<li>The battery life is extremely short; the system only lasts about 20 minutes without charging.</li>\r\n	<li>The system unexpectedly shuts down at random times.</li>\r\n</ol>\r\n\r\n<p>I have attempted to troubleshoot the problem, but unfortunately, the issue persists. Given the impact on my work, I would appreciate it if the IT department could look into this matter as soon as possible.</p>\r\n\r\n<p>Please let me know the next steps or if any further information is required from my end. Your prompt assistance in resolving this issue would be greatly appreciated.</p>\r\n\r\n<p>Thank you for your understanding and support.</p>\r\n\r\n<p>Best regards,<br />\r\nBhavya Sree</p>\r\n\r\n<p>Python Developer&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1', NULL, '1', '2024-07-09 07:14:29', '  ', '', '1', '0', 'Ticket_5358'),
(35, '70', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Hardware Issue', 'Requesting to Change the laptop for Ramkumar Sir', '', '1', NULL, '1', '2024-07-11 11:16:51', NULL, NULL, '1', '0', 'Ticket_3540'),
(36, '70', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Hardware Issue', 'Requesting the laptop for Ajith.N', '', '1', NULL, '1', '2024-07-11 11:18:05', NULL, NULL, '0', '0', 'Ticket_3258'),
(37, '7', NULL, NULL, NULL, NULL, 'Decline', '0', NULL, 'other', 'Swifterz.ae', '<p>&nbsp; We have received updates on SwiftBim from Daniel Sir. To ensure we<br />\r\nproceed correctly, we need your confirmation on the necessary changes.<br />\r\n<br />\r\nKindly review the document attached, which details the updates and<br />\r\nproposed changes. Please provide your input and any additional changes<br />\r\nrequired. Based on your feedback, we will proceed as soon as possible.<br />\r\nDocument Link<br />\r\n<a href=\"https://docs.google.com/document/d/10EQ_QSabCOPQaQFnu4kvOqzCACyMlo-se437zoKgDIc/edit?usp=sharing\" target=\"_blank\">https://docs.google.com/document/d/10EQ_QSabCOPQaQFnu4kvOqzCACyMlo-se437zoKgDIc/edit?usp=sharing</a></p>\r\n', '59', NULL, '1', '2024-07-11 14:01:07', '  ', '', '1', '0', 'Ticket_4288'),
(38, '7', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'other', 'Request', '<p>I hope this message finds you well. I am writing to request the standard format for PowerPoint presentations used within our organization. As I prepare to create a presentation for [briefly mention the purpose or topic], having the approved template and guidelines would ensure consistency and adherence to our branding standards.</p>\r\n\r\n<p>Could you please provide me with the PowerPoint template and any specific formatting instructions that I should follow? Your assistance in this matter would be greatly appreciated.</p>\r\n', '58', NULL, '1', '2024-07-18 07:02:24', NULL, NULL, '0', '0', 'Ticket_8497'),
(42, '59', 'NODEJS', '2', '2024-07-21', 2, 'Ticket Closed', '0', 'IT', 'hiring', NULL, '* NODEJS TEST', '1', NULL, '1', '2024-07-21 08:25:57', 'gh', '', '1', '0', 'Ticket_9230'),
(51, '33', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Infrastructure', 'AC probel,', '', '47', NULL, '1', '2024-08-16 09:40:23', 'Just Go on the look for it ', '70', '1', '0', 'Ticket_6476'),
(54, '33', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Software Issue', 'Email configuration', '<p>One of our employees (Jeethu&#39;s ) email id is not working, please fix it as soon as possible</p>\r\n\r\n<p>name: Jeethu</p>\r\n\r\n<p>email: jeethu@mineit.tech</p>\r\n\r\n<p>password: mine@123#</p>\r\n', '47', NULL, '1', '2024-08-27 15:23:35', 'Yes I have Resolved it You can Check now', '', '1', '0', 'Ticket_4681'),
(55, '60', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'AC Issue', 'not working', '<p>demo</p>\r\n', '53', NULL, '1', '2024-08-28 11:46:30', NULL, NULL, '1', '0', 'Ticket_2226'),
(56, '60', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'AC Issue', 'not working', '<p>demo 2</p>\r\n', '53', NULL, '1', '2024-08-28 11:47:14', NULL, NULL, '1', '0', 'Ticket_5077'),
(59, '33', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Software Issue', 'Not able to apply leave', 'khdkahkdjha', '47', NULL, '1', '2024-09-02 07:11:29', 'Fix it', '16', '1', '0', 'Ticket_5858'),
(65, '16', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Network Issue', 'Network Issue', '<p>Make sure you know which internet or network provider is responsible for the issue.</p>\r\n', '70', NULL, '1', '2024-09-23 08:50:39', NULL, NULL, '1', '0', 'Ticket_5030'),
(67, '33', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Software Issue', 'network issue', '<p>network issue</p>\r\n', '30', NULL, '1', '2024-09-23 09:32:31', NULL, NULL, '1', '0', 'Ticket_4792'),
(68, '25', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Hardware Issue', 'Need a charger for Mac laptop', '<p>I need a Charger for Mac laptop. Coz my Charger pin came out and it is not working.</p>\r\n', '1', NULL, '1', '2024-09-23 09:58:46', NULL, NULL, '0', '0', 'Ticket_3014'),
(70, '1', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Network Issue', 'Network Issue', 'Network issue', '38', NULL, '1', '2024-09-23 11:50:31', NULL, NULL, '0', '0', 'Ticket_2641'),
(71, '21', NULL, NULL, NULL, NULL, 'Decline', '0', NULL, 'Hardware Issue', 'Request for Laptop allocation', '<p>Dear Nisha C R,&nbsp;</p>\r\n\r\n<p>I hope this mail&nbsp;finds you well. I am writing to request the allocation of a laptop for my work-related tasks. As my current duties involve writing testcases, finding bugs in a software, raising bugs and automating the testcases, having a dedicated laptop will significantly improve my productivity and efficiency.</p>\r\n\r\n<p>Kindly let me know the process and any further details required to proceed with this request. I would appreciate your support and guidance in this matter.</p>\r\n\r\n<p>Thank you for considering my request. I look forward to your response.</p>\r\n\r\n<p>Best regards,<br />\r\nVaibhavi Khiranand Dhadde<br />\r\nJr.Automation Engineer</p>\r\n', '1', NULL, '1', '2024-09-24 06:29:20', 'jgdb', '', '1', '0', 'Ticket_7962'),
(72, '33', 'Java developer', '3', '2024-11-09', 3, 'Ticket Closed', '0', 'IT', 'hiring', NULL, '<p>Description</p>\r\n', '1', NULL, '1', '2024-10-03 11:34:39', NULL, NULL, '1', '0', 'Ticket_4694'),
(73, '35', 'python', '1', '2024-10-09', 4, 'Ticket Closed', '0', 'IT', 'hiring', NULL, '<p>python developer</p>\r\n', '1', NULL, '1', '2024-10-07 10:07:17', 'dfgbd', '35', '1', '0', 'Ticket_1656'),
(74, '35', 'python', '1', '', 111, 'Pending', '0', 'IT', 'hiring', NULL, '<p>java</p>\r\n', '1', NULL, '1', '2024-10-07 10:08:40', NULL, NULL, '1', '0', 'Ticket_3050'),
(75, '35', 'php', '2', '2024-10-19', 78, 'Pending', '0', 'IT', 'hiring', NULL, '<p>php</p>\r\n', '1', NULL, '1', '2024-10-07 10:12:19', NULL, NULL, '0', '0', 'Ticket_6481'),
(76, '15', NULL, NULL, NULL, NULL, 'Forword', '0', NULL, 'Network Issue', 'test', '<p>asd</p>\r\n', '33', NULL, '1', '2024-10-07 12:48:46', 'demo', '33', '1', '0', 'Ticket_7872'),
(77, '33', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Software Issue', 'Jiffy 403 forbidden error', '<p>Test</p>\r\n', '16', NULL, '1', '2024-10-07 12:48:59', NULL, NULL, '1', '0', 'Ticket_6390'),
(78, '33', NULL, NULL, NULL, NULL, 'Ticket Closed', '0', NULL, 'Software Issue', 'Ex nesciunt quod do', '<p>test</p>\r\n', '15', NULL, '1', '2024-10-07 12:49:42', 'decline', '', '1', '0', 'Ticket_4164'),
(79, '35', 'Python', '1', '2025-06-16', 2, 'Approve', '0', 'IT', 'hiring', NULL, '<p>sdfgb</p>\r\n', '1', NULL, '1', '2025-06-17 15:48:40', 'gbcfvbfgb', '', '0', '0', 'Ticket_2797'),
(80, '35', NULL, NULL, NULL, NULL, 'Pending', '0', NULL, 'Infrastructure', 'Ic need', '<p>dfv</p>\r\n', '35', NULL, '1', '2025-06-17 16:18:39', NULL, NULL, '1', '0', 'Ticket_3145');

-- --------------------------------------------------------

--
-- Table structure for table `testing`
--

CREATE TABLE `testing` (
  `Testing_id` int(255) NOT NULL,
  `Project_id` int(255) DEFAULT NULL,
  `Bug_tittle` varchar(255) DEFAULT NULL,
  `Bug_dec` varchar(255) DEFAULT NULL,
  `testing_1` int(25) NOT NULL DEFAULT 0,
  `testing_2` int(255) NOT NULL DEFAULT 0,
  `remark_testing` varchar(255) DEFAULT NULL,
  `remark_dev` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `open_date` date NOT NULL DEFAULT current_timestamp(),
  `clode_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `id` int(11) NOT NULL,
  `start_time` varchar(2555) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `activity` varchar(20) DEFAULT NULL,
  `meeting_type` varchar(255) DEFAULT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `meeting_location` varchar(255) DEFAULT NULL,
  `task_description` varchar(255) DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `participate_id` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `start_t` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `Company_id` varchar(255) DEFAULT NULL,
  `momfile` varchar(2555) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `timeline`
--

INSERT INTO `timeline` (`id`, `start_time`, `end_time`, `project_id`, `activity`, `meeting_type`, `meeting_link`, `meeting_location`, `task_description`, `emp_id`, `participate_id`, `create_date`, `start_t`, `status`, `Company_id`, `momfile`) VALUES
(6, '18-06-2024 12:00 PM', '18-06-2024 12:30 PM', '0', 'meeting', 'offline', '', 'Meeting Room', 'Weekly Target ', '33', '49,48,33,36,21', '2024-06-18 08:29:42', '2024-06-18', 2, '1', 'outputimage/168e0b2ebff9a62b4d954f593f3bb2b9.pdf'),
(7, '18-06-2024 04:40 PM', '18-06-2024 05:40 PM', '0', 'meeting', 'offline', '', 'office', 'CRM planning', '7', '27,7', '2024-06-18 13:09:33', '2024-06-18', 2, '1', 'outputimage/f7720ca1d38098936c7bb7a8c2cfcb91.pdf'),
(13, '19-06-2024 19-06-2024 01:00 AM', '19-06-2024 03:45 PM', '4', 'meeting', 'offline', 'meeting', 'Meeting', 'Review For VDS', '7', '56,7,6', '2024-06-19 07:44:21', '2024-06-19', 2, '1', 'outputimage/cf9ce22fd3858f1650fe81a0ca81a151.pdf'),
(20, '20-06-2024 02:25 PM', '20-06-2024 03:00 PM', '0', 'meeting', 'online', 'https://meet.google.com/pmm-paxs-zkg', 'Enter Location', 'Client meeting with Client', '7', '7', '2024-06-20 10:44:34', '2024-06-20', 2, '1', 'outputimage/770beaab52bfe9257a41a77716818c8e.docx'),
(21, '24-06-2024 10:40 AM', '24-06-2024 11:30 AM', '7', 'meeting', 'offline', 'https://jiffy.mineit.tech/jiffy/project/timeline.php', 'Meeting Room ', 'Demo', '7', '26,7,29,33,32', '2024-06-24 04:09:22', '2024-06-24', 2, '1', 'outputimage/4c01280d565a5be28577a452dedf2cf7.pdf'),
(22, '24-06-2024 12:01 PM', '24-06-2024 01:00 PM', '0', 'meeting', 'offline', '', 'office', 'demo', '39', '37,24,39,7,25,38', '2024-06-24 08:37:02', '2024-06-24', 2, '1', 'outputimage/296a9dde646d9f78caf18e047a67b7d2.pdf'),
(23, '01-07-2024 01:51 PM', '01-07-2024 10:51 AM', '0', 'meeting', 'online', '', '                                        ', 'test', '21', '21', '2024-07-01 07:22:09', '2024-07-01', 2, '1', 'outputimage/1f8243fb22ce5b926cf6193407bebff5.pdf'),
(24, '01-07-2024 10:05 AM', '01-07-2024 01:00 PM', '8', 'meeting', 'offline', '', 'MINE Board Room', 'mine daily meeting', '67', '58,67', '2024-07-01 14:36:56', '2024-07-01', 2, '1', 'outputimage/46bc7f5a51c060b0a2b1294a6f7b3202.docx'),
(26, '12-07-2024 12:00 PM', '12-07-2024 01:00 PM', '13', 'meeting', 'online', 'https://meet.google.com/smm-sfwi-ofd', '', 'Bluechip Demo', '7', '2,15,39', '2024-07-12 07:51:44', '2024-07-12', 2, '1', 'outputimage/3a55b220a199d5d2ca00db5fac006dfb.pdf'),
(27, '03-08-2024 12:00 PM', '03-08-2024 01:00 PM', '13', 'meeting', 'online', 'https://meet.google.com/bjg-fuen-iec', '', 'Bluechip Demo', '7', '2,33,16,7', '2024-08-03 08:28:29', '2024-08-03', 2, '1', 'outputimage/a722da75613de23c2a9f30d98476bb3a.pdf'),
(28, '08-08-2024 12:00 PM', '08-08-2024 01:00 PM', '13', 'meeting', 'online', 'https://meet.google.com/pto-xhyf-huo', '', 'Regarding Bluechip Project Completion', '2', '2,15,39,7,22', '2024-08-08 07:52:41', '2024-08-08', 2, '1', 'outputimage/41cf9eb6209b3a039889516703d5afd3.pdf'),
(29, '14-08-2024 10:30 AM', '14-08-2024 11:30 AM', '0', 'meeting', 'online', 'https://meet.google.com/zgn-ivhq-zvx', '', 'Common meeting', '33', 'all,26,70,52,35,53,30,27,49,37,15,39,7,20,25,29,13,45,5,60,48,33,44,31,40,54,10,57,42,16,47,4,32,38,22,6,34,50,21', '2024-08-14 06:40:12', '2024-08-14', 2, '1', 'outputimage/d45ca734de59093d1e5dc05145ad362e.pdf'),
(33, '19-08-2024 02:30 AM', '19-08-2024 05:30 AM', '0', 'meeting', 'online', '', 'board room', 'DM project', '99', '73,99', '2024-08-19 06:45:18', '2024-08-19', 1, '5', NULL),
(34, '19-08-2024 11:30 AM', '19-08-2024 12:30 PM', '0', 'meeting', 'offline', '', 'online', 'business plan meeting with swifterz engg dubai', '99', '73', '2024-08-19 06:57:23', '2024-08-19', 0, '5', NULL),
(35, '19-08-2024 01:30 PM', '19-08-2024 02:30 PM', '0', 'meeting', 'offline', '', 'online', 'meeting with swifterz engg dubai for swift bim platform', '99', '99', '2024-08-19 06:59:05', '2024-08-19', 0, '5', NULL),
(36, '21-08-2024 11:15 AM', '21-08-2024 12:16 PM', '11', 'meeting', 'online', '', '', 'Testing meeting', '31', '21,17', '2024-08-21 07:53:25', '2024-08-21', 2, '1', 'outputimage/c2c411f18e7984bf4b2af8c8fb80ac3c.pdf'),
(37, '28-08-2024 01:10 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:17', '2024-08-28', 0, '1', NULL),
(38, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:21', '2024-08-28', 0, '1', NULL),
(39, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:24', '2024-08-28', 0, '1', NULL),
(40, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:28', '2024-08-28', 0, '1', NULL),
(41, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:31', '2024-08-28', 0, '1', NULL),
(42, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:35', '2024-08-28', 0, '1', NULL),
(43, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:39', '2024-08-28', 0, '1', NULL),
(44, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:42', '2024-08-28', 0, '1', NULL),
(45, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:46', '2024-08-28', 0, '1', NULL),
(46, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:49', '2024-08-28', 0, '1', NULL),
(47, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:52', '2024-08-28', 0, '1', NULL),
(48, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:56', '2024-08-28', 0, '1', NULL),
(49, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:15:59', '2024-08-28', 0, '1', NULL),
(50, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:03', '2024-08-28', 0, '1', NULL),
(51, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:07', '2024-08-28', 0, '1', NULL),
(52, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:11', '2024-08-28', 0, '1', NULL),
(53, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:14', '2024-08-28', 0, '1', NULL),
(54, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:18', '2024-08-28', 0, '1', NULL),
(55, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:21', '2024-08-28', 0, '1', NULL),
(56, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:25', '2024-08-28', 0, '1', NULL),
(57, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:28', '2024-08-28', 0, '1', NULL),
(58, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:32', '2024-08-28', 0, '1', NULL),
(59, '28-08-2024 01:00 PM', '28-08-2024 01:30 PM', '10', 'meeting', 'offline', '', 'office', 'demo', '60', '35,53,12,55', '2024-08-28 09:16:35', '2024-08-28', 0, '1', NULL),
(60, '28-08-2024 02:49 PM', '28-08-2024 03:49 PM', '10', 'meeting', 'offline', '', 'office', 'Demo', '53', '37,60,40', '2024-08-28 09:19:46', '2024-08-28', 0, '1', NULL),
(61, '30-08-2024 03:18 PM', '30-08-2024 03:19 PM', '10', 'meeting', 'online', 'https://meet.google.com/uho-xsxn-pjx', '', 'just for testing creating this', '33', '26,27', '2024-08-30 11:54:10', '2024-08-30', 1, '1', NULL),
(62, '30-08-2024 03:25 PM', '30-08-2024 03:26 PM', '0', 'meeting', 'online', 'https://meet.google.com/uho-xsxn-pjx', '', 'testing', '33', '26', '2024-08-30 11:55:35', '2024-08-30', 1, '1', NULL),
(63, '10-09-2024 12:40 PM', '10-09-2024 01:33 PM', '8', 'meeting', 'offline', '', 'Bangalore', 'ux report', '60', '15', '2024-09-10 09:03:32', '2024-09-10', 1, '1', NULL),
(64, '10-09-2024 01:28 PM', '10-09-2024 01:29 PM', '0', 'meeting', 'offline', '', '                       ', 'abcd test', '21', '21', '2024-09-10 09:57:50', '2024-09-10', 1, '1', NULL),
(65, '23-09-2024 12:30 PM', '23-09-2024 01:15 PM', '8', 'meeting', 'offline', '', 'bengaluru', 'meeting', '33', '30', '2024-09-23 08:45:35', '2024-09-23', 1, '1', NULL),
(66, '23-09-2024 03:25 PM', '23-09-2024 04:25 PM', '10', 'meeting', 'offline', '', 'bangalore', 'dshjkqhdj', '16', '22', '2024-09-23 09:00:33', '2024-09-23', 0, '1', NULL),
(67, '23-09-2024 03:25 PM', '23-09-2024 04:25 PM', '26', 'meeting', 'offline', '', 'bangalore', 'dshjkqhdj', '16', '22', '2024-09-23 09:01:18', '2024-09-23', 0, '1', NULL),
(68, '23-09-2024 01:35 PM', '23-09-2024 02:35 PM', '7', 'meeting', 'offline', '', 'banglore', 'Casual meeting', '15', '26,70,59,52,35,53,30,27,49,55,58,37,15,67,69,61,7,20,25,29,60,33,44,1,31,40,54,10,68,57,51,16,47,32,105,38,22,6,34,21', '2024-09-23 09:06:39', '2024-09-23', 0, '1', NULL),
(69, '23-09-2024 12:59 PM', '23-09-2024 01:59 PM', '10', 'meeting', 'offline', '', 'bengaluru', 'meetng', '33', '30', '2024-09-23 09:31:16', '2024-09-23', 0, '1', NULL),
(70, '22-10-2024 01:14 PM', '22-10-2024 01:14 PM', '11', 'meeting', 'offline', '', 'office', 'demo', '33', '29', '2024-10-22 09:43:05', '2024-10-22', 2, '1', 'outputimage/dd215b6277216c0b50e1d24b0918867c.pdf'),
(71, '18-06-2025 01:04 PM', '18-06-2025 02:04 PM', '7', 'meeting', 'online', 'https://google.meet', '', 'client meeting', '35', '26,35', '2025-06-17 06:32:42', '2025-06-18', 1, '1', NULL),
(72, '18-06-2025 02:05 PM', '18-06-2025 03:08 PM', '10', 'meeting', 'offline', '', 'Bangalore ', 'client meeting', '35', '26', '2025-06-17 06:33:35', '2025-06-18', 1, '1', NULL),
(73, '03-07-2025 10:02 PM', '03-07-2025 01:02 PM', '29', 'meeting', 'offline', '', 'Bangalore, Karnataka', 'client meeting', '33', '35', '2025-06-17 16:28:55', '2025-07-03', 0, '1', NULL),
(74, '10-10-2025 11:36 AM', '10-10-2025 11:41 AM', '13', 'meeting', 'online', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_dummy12345%40thread.v2/0?context=%7b%22Tid%22%3a%22dummy-tid%22%2c%22Oid%22%3a%22dummy-oid%22%7d', '', 'sdva', '59', '123,26,70,59', '2025-10-09 11:38:33', '2025-10-10', 1, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Company_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `userid`, `latitude`, `longitude`, `timestamp`, `Company_id`) VALUES
(7, '7', 13.0008584, 80.243273, '2025-08-20 07:15:51', '1'),
(8, '27', 13.041664, 77.5749632, '2025-08-11 06:51:55', '1'),
(9, '24', 13.0422212, 77.5733936, '2024-06-25 08:54:32', '1'),
(10, '50', 13.0453132, 77.5733936, '2024-07-11 04:48:13', '1'),
(11, '41', 13.0422212, 77.5733936, '2024-06-25 11:28:33', '1'),
(12, '29', 12.9728512, 77.6536064, '2024-10-29 05:42:40', '1'),
(13, '13', 13.0453132, 77.5733936, '2024-07-08 11:57:20', '1'),
(14, '12', 13.0315, 77.5757, '2024-06-20 11:39:48', '1'),
(15, '56', 13.035472328275, 77.575274590279, '2024-07-09 05:01:51', '1'),
(16, '49', 18.563072, 73.9606528, '2024-07-15 08:07:37', '1'),
(17, '22', 13.4222941, 78.0309844, '2024-11-25 04:31:19', '1'),
(18, '15', 8.6933504, 77.709312, '2025-07-07 18:12:03', '1'),
(19, '8', 13.044982, 77.5733936, '2024-06-21 04:24:34', '1'),
(20, '17', 13.0354507, 77.5753584, '2024-06-21 11:25:38', '1'),
(21, '39', 12.9653969, 77.5411622, '2024-08-13 06:57:22', '1'),
(22, '35', 13.0486402, 77.5727993, '2025-01-08 04:30:20', '1'),
(23, '40', 13.035523, 77.575209, '2024-10-09 06:35:20', '1'),
(24, '58', 13.0318336, 77.5749632, '2024-08-04 07:02:53', '1'),
(25, '30', 12.9119037, 77.5413899, '2025-06-11 08:14:21', '1'),
(26, '28', 12.899696719889, 77.591025448662, '2024-08-10 19:13:56', '1'),
(27, '48', 13.0354307, 77.5754067, '2024-06-24 13:33:04', '0'),
(28, '31', 12.9641271, 77.5373176, '2024-11-20 07:54:56', '1'),
(29, '10', 13.0318336, 77.5389184, '2024-06-24 12:11:55', '1'),
(30, '', 13.0354803, 77.5753663, '2025-07-24 06:44:46', '1'),
(31, '32', 13.0678784, 77.5716864, '2024-08-20 12:44:24', '1'),
(32, '1', 12.894208, 77.6306688, '2025-07-23 12:42:19', '1'),
(33, '47', 13.0354287, 77.5754085, '2024-07-24 12:48:05', '1'),
(34, '62', 13.0353366, 77.5754363, '2024-07-01 11:38:49', '2'),
(35, '2', 11.6602, 78.1532, '2024-08-09 13:00:33', '1'),
(36, '54', 13.0354376, 77.5753663, '2024-12-10 05:43:41', '1'),
(37, '20', 13.03421223237, 77.57524297808, '2024-08-20 04:59:11', '1'),
(38, '37', 13.0455537, 77.5761629, '2024-12-03 04:36:11', '1'),
(39, '23', 13.0355019, 77.575323, '2024-06-24 08:54:45', '1'),
(40, '21', 12.894208, 77.594624, '2025-07-28 12:32:12', '1'),
(41, '34', 13.0112482, 77.7639849, '2024-12-02 05:04:24', '1'),
(42, '64', 13.0383872, 77.5847936, '2024-06-26 13:07:52', '2'),
(43, '65', 13.0354207, 77.5753768, '2024-09-04 09:21:17', '2'),
(44, '38', 13.0387737, 77.6232977, '2024-11-07 16:24:46', '1'),
(45, '43', 13.0449157, 77.5733936, '2024-06-26 06:21:37', '1'),
(46, '67', 12.992512, 77.6077312, '2024-09-22 14:06:40', '1'),
(47, '33', 13.035589628, 77.575112481715, '2025-09-01 12:25:13', '1'),
(48, '53', 12.9466368, 77.6798208, '2024-07-02 07:09:26', '1'),
(49, '70', 13.0352288, 77.5753002, '2024-10-24 06:13:13', '1'),
(50, '46', 13.0355132, 77.575339, '2024-07-10 04:42:33', '1'),
(51, '44', 13.056846, 77.6016561, '2024-07-23 14:15:28', '1'),
(52, '71', 13.0453132, 77.5733936, '2024-09-10 10:22:06', '5'),
(53, '72', 13.0453132, 77.5733936, '2024-07-15 05:48:53', '2'),
(54, '77', 13.0354406, 77.5754008, '2024-08-31 05:48:40', '5'),
(55, '78', 13.0353687, 77.5754374, '2024-07-19 09:04:34', '5'),
(56, '76', 13.034616, 77.57563, '2024-08-17 05:52:24', '5'),
(57, '82', 13.0353953, 77.5753984, '2024-09-04 09:40:38', '5'),
(58, '86', 13.0353272, 77.5753748, '2024-10-24 08:03:35', '5'),
(59, '84', 12.4291709, 77.1508531, '2024-11-09 07:08:09', '5'),
(60, '81', 13.0354457, 77.5753995, '2024-07-26 03:50:33', '5'),
(61, '87', 12.8931026, 77.5733287, '2024-09-04 16:53:08', '5'),
(62, '59', 18.5574028, 73.9283005, '2024-11-06 10:28:14', '1'),
(63, '90', 13.0352601, 77.5753239, '2024-10-24 07:00:11', '5'),
(64, '79', 13.035428, 77.5753972, '2024-09-11 04:39:40', '5'),
(65, '91', 13.0422971, 77.5743381, '2024-08-22 04:13:02', '5'),
(66, '85', 13.0006996, 77.6150151, '2024-12-30 04:09:43', '5'),
(67, '92', 13.0353846, 77.5754159, '2024-09-13 11:53:28', '5'),
(68, '94', 13.037038375, 77.57379525, '2024-08-14 05:10:37', '6'),
(69, '97', 13.035152888487, 77.575929737685, '2024-08-20 05:21:02', '5'),
(70, '98', 13.0354055, 77.5753542, '2024-09-02 08:07:15', '5'),
(71, '73', 13.0353968, 77.5753542, '2024-08-08 13:44:31', '5'),
(72, '99', 12.788546, 77.6199173, '2024-11-14 05:05:01', '5'),
(73, '102', 13.0354417, 77.5753547, '2024-08-21 10:26:33', '5'),
(74, '74', 13.0353221, 77.5753497, '2024-10-24 07:37:45', '5'),
(75, '104', 13.035459, 77.5753794, '2024-08-29 03:40:15', '5'),
(76, '107', 13.0354394, 77.5753331, '2024-09-02 05:01:36', '5'),
(77, '114', 13.0547712, 77.5880704, '2024-08-21 05:14:44', '5'),
(78, '106', 13.0624378, 77.5913021, '2024-09-18 05:01:29', '5'),
(79, '16', 12.828672, 77.6896512, '2025-07-29 06:05:37', '1'),
(80, '88', 13.0354022, 77.5754004, '2024-09-04 09:42:00', '5'),
(81, '121', 13.0321488, 77.571395, '2024-12-20 05:24:00', '1'),
(82, '9', 13.0420953, 77.6222467, '2024-11-21 12:25:50', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientinformation`
--
ALTER TABLE `clientinformation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_ibfk_1` (`user_id`);

--
-- Indexes for table `companylist`
--
ALTER TABLE `companylist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interviewmeeting`
--
ALTER TABLE `interviewmeeting`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_services`
--
ALTER TABLE `invoice_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaveemail`
--
ALTER TABLE `leaveemail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_data`
--
ALTER TABLE `login_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetingaction`
--
ALTER TABLE `meetingaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messages_id`);

--
-- Indexes for table `monthly_expension`
--
ALTER TABLE `monthly_expension`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posters`
--
ALTER TABLE `posters`
  ADD PRIMARY KEY (`PosterId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questiontypes`
--
ALTER TABLE `questiontypes`
  ADD PRIMARY KEY (`QuestionTypeId`);

--
-- Indexes for table `revenue_collected`
--
ALTER TABLE `revenue_collected`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projectid` (`projectid`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `teamrequried`
--
ALTER TABLE `teamrequried`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `testing`
--
ALTER TABLE `testing`
  ADD PRIMARY KEY (`Testing_id`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `clientinformation`
--
ALTER TABLE `clientinformation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companylist`
--
ALTER TABLE `companylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `interviewmeeting`
--
ALTER TABLE `interviewmeeting`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice_services`
--
ALTER TABLE `invoice_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leaveemail`
--
ALTER TABLE `leaveemail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_data`
--
ALTER TABLE `login_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `meetingaction`
--
ALTER TABLE `meetingaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `monthly_expension`
--
ALTER TABLE `monthly_expension`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `posters`
--
ALTER TABLE `posters`
  MODIFY `PosterId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `questiontypes`
--
ALTER TABLE `questiontypes`
  MODIFY `QuestionTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `revenue_collected`
--
ALTER TABLE `revenue_collected`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2803;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `teamrequried`
--
ALTER TABLE `teamrequried`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `testing`
--
ALTER TABLE `testing`
  MODIFY `Testing_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community`
--
ALTER TABLE `community`
  ADD CONSTRAINT `community_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employee` (`id`);

--
-- Constraints for table `invoice_services`
--
ALTER TABLE `invoice_services`
  ADD CONSTRAINT `invoice_services_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
