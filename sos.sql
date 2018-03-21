-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2018 at 12:28 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `username`, `password`) VALUES
(1, 'Juan Fernandez', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `offenses`
--

CREATE TABLE `offenses` (
  `offense_id` int(11) NOT NULL,
  `student_no` varchar(50) DEFAULT NULL,
  `recom_no` int(11) DEFAULT NULL,
  `inc_uniform` tinyint(4) NOT NULL DEFAULT '0',
  `late_tardy` tinyint(4) NOT NULL DEFAULT '0',
  `absent` tinyint(4) NOT NULL DEFAULT '0',
  `no_id` tinyint(4) NOT NULL DEFAULT '0',
  `cutting_classes` tinyint(4) NOT NULL DEFAULT '0',
  `check_others` tinyint(4) NOT NULL DEFAULT '0',
  `others` varchar(550) DEFAULT NULL,
  `offs_date` date DEFAULT NULL,
  `admitted_excuse` varchar(550) DEFAULT NULL,
  `admitted_notexcuse` varchar(550) DEFAULT NULL,
  `academic_loses` varchar(550) DEFAULT NULL,
  `completion_required` varchar(550) DEFAULT NULL,
  `dropped` varchar(550) DEFAULT NULL,
  `parent_notification` varchar(550) DEFAULT NULL,
  `recom_others_cb` tinyint(4) NOT NULL DEFAULT '0',
  `recom_others` varchar(550) DEFAULT NULL,
  `recom_date` date DEFAULT NULL,
  `com_service` varchar(200) DEFAULT NULL,
  `done` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offenses`
--

INSERT INTO `offenses` (`offense_id`, `student_no`, `recom_no`, `inc_uniform`, `late_tardy`, `absent`, `no_id`, `cutting_classes`, `check_others`, `others`, `offs_date`, `admitted_excuse`, `admitted_notexcuse`, `academic_loses`, `completion_required`, `dropped`, `parent_notification`, `recom_others_cb`, `recom_others`, `recom_date`, `com_service`, `done`) VALUES
(1, '1', NULL, 1, 0, 1, 0, 0, 0, NULL, '2018-03-19', '1', '0', '0', '0', '0', '0', 0, NULL, '2018-03-20', '30', 0),
(2, '3', NULL, 0, 0, 0, 1, 0, 0, NULL, '2018-03-19', '1', '0', '0', '0', '0', '0', 0, NULL, '1970-01-01', '50', 0),
(3, '1', NULL, 1, 0, 0, 0, 0, 0, NULL, '2018-03-19', '1', '0', '0', '0', '0', '0', 0, NULL, '2018-03-20', '50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `id_number` int(30) DEFAULT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `middlename` varchar(200) DEFAULT NULL,
  `educational_level` varchar(100) DEFAULT NULL,
  `strand` varchar(200) DEFAULT NULL,
  `grade` varchar(11) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `senior_grade` varchar(200) DEFAULT NULL,
  `senior_section` varchar(200) DEFAULT NULL,
  `year` varchar(500) DEFAULT NULL,
  `course` varchar(150) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `id_number`, `firstname`, `lastname`, `middlename`, `educational_level`, `strand`, `grade`, `section`, `senior_grade`, `senior_section`, `year`, `course`, `date`) VALUES
(1, 111, 'asd', 'asd', 'asd', 'Senior High School', 'ABM', NULL, NULL, '11', 'Artemis', NULL, NULL, '2018-03-19'),
(2, 333, 'asd', 'asd', 'dasd', 'Junior High School', NULL, '7', 'Aphrodite', NULL, NULL, NULL, NULL, '2018-03-19'),
(3, 123, 'afas', 'asd', 'gasd', 'College', NULL, NULL, NULL, NULL, NULL, '1st', 'BSIT', '2018-03-19'),
(4, 667, 'gadfds', 'asd', 'fdgf', 'Junior High School', NULL, '8', 'Venus', NULL, NULL, NULL, NULL, '2018-03-06'),
(5, 88, 'hrtf', 'asdgdfg', 'rtg', 'Junior High School', NULL, '8', 'Aphrodite', NULL, NULL, NULL, NULL, '2018-03-19'),
(6, 9, 'ga', 'agafg', 'asdv', 'Senior High School', 'ABM', NULL, NULL, '11', 'Nyx', NULL, NULL, '2018-03-19'),
(7, 445, 'ahef', 'Jsaf', 'sdferf', 'Junior High School', NULL, '7', 'Aphrodite', NULL, NULL, NULL, NULL, '2018-03-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offenses`
--
ALTER TABLE `offenses`
  ADD PRIMARY KEY (`offense_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `offenses`
--
ALTER TABLE `offenses`
  MODIFY `offense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
