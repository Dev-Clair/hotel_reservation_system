<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new CreateTable($conn);


/** *******************************************Create Tables***************************************** */
$fieldNames = "`bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
`name` varchar(50) NOT NULL,
`email` varchar(50) NOT NULL,
`mobileNo` varchar(20) NOT NULL,
`roomType` varchar(50) NOT NULL,
`checkInDate` varchar(10) NOT NULL,
`checkInTime` varchar(10) NOT NULL,
`stayType` varchar(20) NOT NULL,
`stayDuration` varchar(20) NOT NULL,
`pickUpLocation` varchar(150) NOT NULL,
`datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
// print_r($operation->createTable("bookings", $fieldNames));

$fieldNames = "`bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
`name` varchar(50) NOT NULL,
`email` varchar(50) NOT NULL,
`mobileNo` varchar(20) NOT NULL,
`roomType` varchar(50) NOT NULL,
`checkInDate` varchar(10) NOT NULL,
`checkInTime` varchar(10) NOT NULL,
`stayType` varchar(20) NOT NULL,
`stayDuration` varchar(20) NOT NULL,
`pickUpLocation` varchar(150) NOT NULL,
`count` int(11) NOT NULL DEFAULT 0";
// print_r($operation->createTable("rescheduledbookings", $fieldNames));

$fieldNames = "`bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
`name` varchar(50) NOT NULL,
`email` varchar(50) NOT NULL,
`mobileNo` varchar(20) NOT NULL,
`roomType` varchar(50) NOT NULL,
`checkInDate` varchar(10) NOT NULL,
`checkInTime` varchar(10) NOT NULL,
`stayType` varchar(20) NOT NULL,
`stayDuration` varchar(20) NOT NULL,
`pickUpLocation` varchar(150) NOT NULL";
// print_r($operation->createTable("cancelledbookings", $fieldNames));

$fieldNames = "`bookingID` int(10) UNSIGNED PRIMARY KEY NOT NULL,
`name` varchar(50) NOT NULL,
`email` varchar(50) NOT NULL,
`mobileNo` varchar(20) NOT NULL,
`roomType` varchar(50) NOT NULL,
`checkInDate` varchar(10) NOT NULL,
`checkInTime` varchar(10) NOT NULL,
`stayType` varchar(20) NOT NULL,
`stayDuration` varchar(20) NOT NULL,
`pickUpLocation` varchar(150) NOT NULL";
// print_r($operation->createTable("customerservice", $fieldNames));

$fieldNames = "`id` int(11) PRIMARY KEY NOT NULL,
`name` varchar(50) NOT NULL,
`email` varchar(50) NOT NULL,
`serviceID` varchar(10) NOT NULL,
`rating` int(11) NOT NULL DEFAULT 0,
`reviews` varchar(150) NOT NULL,
`datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
// print_r($operation->createTable("reviews", $fieldNames));

$fieldNames = "`id` int(11) PRIMARY KEY NOT NULL,
`serviceID` varchar(10) NOT NULL,
`serviceName` varchar(50) NOT NULL,
`serviceDescription` varchar(150) NOT NULL,
`servicePrice` int(10) NOT NULL,
`serviceStatus` varchar(20) NOT NULL";
// print_r($operation->createTable("services", $fieldNames));

/** *******************************************Alter Tables***************************************** */
$tableName = "";
$statement = "ADD COLUMN `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER" . "";
// print_r($operation->alterTable($tableName, $statement));

/** *******************************************Truncate Tables***************************************** */
$tableName = "";
// print_r($operation->truncateTable($tableName));

/** *******************************************Drop Tables***************************************** */
$tableName = "";
// print_r($operation->dropTable($tableName));
