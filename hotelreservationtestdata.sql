-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2023 at 02:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelreservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `roomType` varchar(50) NOT NULL,
  `checkInDate` varchar(10) NOT NULL,
  `checkInTime` varchar(10) NOT NULL,
  `stayType` varchar(20) NOT NULL,
  `stayDuration` varchar(20) NOT NULL,
  `pickUpLocation` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingID`, `name`, `email`, `mobileNo`, `roomType`, `checkInDate`, `checkInTime`, `stayType`, `stayDuration`, `pickUpLocation`) VALUES
(1686130902, 'Samuel Aniogbu', 'aniogbu.samuel@yahoo.com', '+2348133893441', 'Deluxe', '2023-06-09', '20:00', 'shortStay', '6 days', '50, Alexander Road, Ikoyi Lagos'),
(1686137540, 'Wendy Uche', 'wendyuche@gmail.com', '+4470304556875', 'Presidential Suite', '2023-06-10', '10:00', 'shortStay', '6 days', '2, Ligali Ayorinde Street, Victoria Island Lagos'),
(1686140601, 'Seyi Chinedu', 'seyichinedu@yahoo.com', '+2338069412280', 'Regular', '2023-06-08', '17:00', 'shortStay', '4 days', ''),
(1686140755, 'Chukwu Loveth', 'chukwuloveth@gmail.com', '+448714458797', 'King', '2023-06-21', '13:00', 'extendedStay', '1-2 months', '5b, Mumuni Street Lady-lak, Bariga Lagos'),
(1686211089, 'Jonathan Audu', 'jonathanaudu@yahoo.com', '+2238136785426', 'Standard Suite', '2023-06-10', '11:00', 'shortStay', '5 days', '225 Igbosere Mccarthy Drive, Obalende Lagos'),
(1686211616, 'John Nezerwa', 'nezerwa.john@gmail.com', '+441254687745', 'King', '2023-06-17', '08:00', 'shortStay', '3 days', '17, Peter\'s Drive Elelenwo GRA Phase-2 PH'),
(1686387451, 'Amy Vivian', 'amyvivy@yahoo.com', '+2236078945789', 'Deluxe', '2023-06-13', '', 'shortStay', '5 days', '2, Aduragbemi Street off Agberin, Oworonshoki Lagos'),
(1686389465, 'Jonathan Wick', 'johnwick@yahoo.com', '+478597859987', 'Presidential Suite', '2023-06-12', '13:25', 'shortStay', '3 days', '28, Kenneth Drive Off Mike Jones, NY'),
(1686944245, 'Funmi Jones', 'funmi.jones@gmail.com', '+2218031359935', 'Pent Floor', '2023-06-20', '14:25', 'extendedStay', '1-2 months', 'Muritala Mohammed Airport MM1, Ikeja Lagos'),
(1686944970, 'Joe Nwobodo', 'joe.nwobodo@gmail.com', '+2347035678827', 'King', '2023-06-20', '16:30', 'shortStay', '6 days', 'Ojodu Berger B/Stop Lagos');

-- --------------------------------------------------------

--
-- Table structure for table `cancelledbookings`
--

CREATE TABLE `cancelledbookings` (
  `bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `roomType` varchar(50) NOT NULL,
  `checkInDate` varchar(10) NOT NULL,
  `checkInTime` varchar(10) NOT NULL,
  `stayType` varchar(20) NOT NULL,
  `stayDuration` varchar(20) NOT NULL,
  `pickUpLocation` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cancelledbookings`
--

INSERT INTO `cancelledbookings` (`bookingID`, `name`, `email`, `mobileNo`, `roomType`, `checkInDate`, `checkInTime`, `stayType`, `stayDuration`, `pickUpLocation`) VALUES
(1686144094, 'Sheriff Quadri', 'quadrisheriff@yahoo.com', '+2347066321764', 'Regular', '2023-06-08', '12:00', 'shortStay', '2 days', '7, Hughes Avenue Alagomeji, Yaba Lagos'),
(1686147390, 'Jane Doe', 'janedoe@yahoo.com', '+2349147534755', 'Cabana', '2023-06-14', '10:00', 'shortStay', '5 days', '75, Trabzonspor Drive off Ozumba Mbadiwe, Victoria Island, Lagos'),
(1686211398, 'Sunidhi Chauhan', 'sunichau@yahoo.com', '+2238136788895', 'Pent Floor', '2023-06-19', '21:00', 'extendedStay', '1 month', '5, Oloto Street Off Bourdillon, Ikoyi Lagos'),
(1687339096, 'sunday oyetola', 'oyetolasunday@outlook.com', '+314578458956', 'Regular', '2023-06-24', '14:00', 'shortStay', '2 days', ''),
(1688202926, 'Jean McConough', 'jeanmcconough@gmail.com', '+414576320540', 'Cabana', '2023-07-02', '13:15', 'shortStay', '5 days', '');

-- --------------------------------------------------------

--
-- Table structure for table `customerservice`
--

CREATE TABLE `customerservice` (
  `bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `roomType` varchar(50) NOT NULL,
  `checkInDate` varchar(10) NOT NULL,
  `checkInTime` varchar(10) NOT NULL,
  `stayType` varchar(20) NOT NULL,
  `stayDuration` varchar(20) NOT NULL,
  `pickUpLocation` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customerservice`
--

INSERT INTO `customerservice` (`bookingID`, `name`, `email`, `mobileNo`, `roomType`, `checkInDate`, `checkInTime`, `stayType`, `stayDuration`, `pickUpLocation`) VALUES
(1686211471, 'Didier Sheriff', 'didysheriff225@gmail.com', '+458125689947', 'Standard Suite', '2023-06-16', '17:00', 'shortStay', '4 days', ''),
(1686211843, 'Hennadii Shvedko', 'hennadii.shvedko@yahoo.com', '+157486352253', 'Twin', '2023-06-23', '14:00', 'extendedStay', '1 month', '12, Queens Drive off McCole, New Alabama'),
(1688199106, 'Sam Carl', 'samcarl@yahoo.com', '+234587854658', 'Twin', '2023-07-05', '10:25', 'extendedStay', '1 month', '45, Elelenwo GRA ph-2, Rivers');

-- --------------------------------------------------------

--
-- Table structure for table `rescheduledbookings`
--

CREATE TABLE `rescheduledbookings` (
  `bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `roomType` varchar(50) NOT NULL,
  `checkInDate` varchar(10) NOT NULL,
  `checkInTime` varchar(10) NOT NULL,
  `stayType` varchar(20) NOT NULL,
  `stayDuration` varchar(20) NOT NULL,
  `pickUpLocation` varchar(150) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rescheduledbookings`
--

INSERT INTO `rescheduledbookings` (`bookingID`, `name`, `email`, `mobileNo`, `roomType`, `checkInDate`, `checkInTime`, `stayType`, `stayDuration`, `pickUpLocation`, `count`) VALUES
(1686131696, 'Jenny Stiles', 'jennystiles@gmail.com', '+4750515435', 'Queen', '2023-06-20', '16:00', 'extendedStay', '2-3 weeks', '27a, Olawale Cole Onitiri Street Off Admiralty Road, Lekki Phase-1 Lagos', 0),
(1686388912, 'Corey Schafer', 'coreyschafer245@gmail.com', '+417894587796', 'Standard Suite', '2023-06-13', '13:00', 'shortStay', '6 days', '27, Jones Drive Alberta, NJ', 0),
(1686573784, 'Andrea Giovanelli', 'andrea.giovanelli@gmail.com', '+478085891266', 'Cabana', '2023-06-26', '09:20', 'extendedStay', '2-3 weeks', '1, Oba Oniru Palace Road, Palace Estate Oniru VI, Lagos', 0),
(1686943628, 'Dele Michael', 'dele.michael@yahoo.com', '+2349153456788', 'King', '2023-06-23', '20:30', 'extendedStay', '1-2 months', '1, Walter Carrignton Street Off Ozumba Mbadiwe, Victoria Island Lagos', 0),
(1687182002, 'Monkey Luffy', 'mugiwara19@gmail.com', '+2347589857845', '', '2023-06-28', '17:45', 'extendedStay', '1-2 months', '', 0),
(1688129203, 'Charles Kalu', 'charlesmillicent@gmail.com', ' 2334584785621', 'Deluxe', '2023-07-03', '11:00', 'extendedStay', '1-2 weeks', '2nd Avenue Estate, Ikoyi Lagos', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) PRIMARY KEY NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `serviceID` varchar(10) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `reviews` varchar(150) NOT NULL,
  `dateCreated` varchar(10) NOT NULL DEFAULT curdate(),
  `dateUpdated` varchar(10) NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `serviceID`, `rating`, `reviews`, `dateCreated`, `dateUpdated`) VALUES
(1, 'Samuel Aniogbu', 'aniogbu.samuel@yahoo.com', 'RM', 5, 'It was very lovely experience for me. Great hotel! Great personnel!! Thrilling experience!!!', '2023-06-18', '0000-00-00'),
(2, 'Wendy Uche', 'wendyuche@gmail.com', 'RM', 4, 'The service quality exceeds expectation. Fantastic Place', '2023-06-18', '0000-00-00'),
(3, 'Jane Doe', 'janedoe@yahoo.com', 'RM', 4, 'Cool! I cannot wait for next time I will be in Lagos.', '2023-06-18', '0000-00-00'),
(4, 'Corey Schafer', 'coreyschafer245@gmail.com', 'RM', 5, 'Great Hotel. Loved the view from my hotel room', '2023-06-18', '0000-00-00'),
(5, 'Jenny Stiles', 'jennystiles@gmail.com', 'RM', 3, 'Lovely Place!', '2023-06-18', '0000-00-00'),
(6, 'Jonathan Audu', 'jonathanaudu@yahoo.com', 'RM', 5, 'I had a great time. The hotel is properly situated within the city metropolis.', '2023-06-18', '0000-00-00'),
(7, 'John Nezerwa', 'nezerwa.john@gmail.com', 'RM', 3, 'I had an awesome time', '2023-06-18', '0000-00-00'),
(9, 'Hennadii Shvedko', 'hennadii.shvedko@yahoo.com', 'RM', 4, 'I had a great time.', '2023-06-18', '0000-00-00'),
(10, 'Joe Nwobodo', 'joe.nwobodo@gmail.com', 'RM', 5, 'Great Place. I loved and enjoyed every bit of my stay.', '2023-06-18', '0000-00-00'),
(11, 'Seyi chinedu', 'seyichinedu@yahoo.com', 'RM', 4, 'I cannot wait to be back.', '2023-06-19', '0000-00-00'),
(12, 'Monkey Luffy', 'mugiwara19@gmail.com', 'RM', 5, 'Yaaahuuuu!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!', '2023-06-19', '0000-00-00'),
(13, 'Sam Smith', 'sammysmith@yahoo.com', 'RM', 4, 'Lovely spaces, lovely people. A bouquet of experience', '2023-06-19', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) PRIMARY KEY NOT NULL,
  `serviceID` varchar(10) NOT NULL,
  `serviceName` varchar(50) NOT NULL,
  `serviceDescription` varchar(150) NOT NULL,
  `servicePrice` int(10) NOT NULL,
  `serviceStatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `serviceID`, `serviceName`, `serviceDescription`, `servicePrice`, `serviceStatus`) VALUES
(1, 'RM', 'Room Reservation', 'Room reservation covers for temporary living spaces where customers can select short or extended stay duration.', 28500, 'available'),
(2, 'EH', 'Event Hall', 'Event hall reservation covers for large indoor spaces where customers can host open or private gatherings.', 58000, 'unavailable'),
(3, 'CR', 'Conference Rooms', 'Conference room reservation covers for indoor spaces where customers can host private meetings.', 40000, 'unavailable'),
(4, 'PP', 'Private Pools', 'Private pool reservation is strictly for private pool events for  customers.', 30000, 'unavailable');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `cancelledbookings`
--
ALTER TABLE `cancelledbookings`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `customerservice`
--
ALTER TABLE `customerservice`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `rescheduledbookings`
--
ALTER TABLE `rescheduledbookings`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
