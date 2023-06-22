<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'hotel_database.php';

function customerServiceTable()
{
    /**
     * require resource: Connection Object
     * to create customerService table in database
     * close resource: Connection Object
     */
    $connection = connection();
    // Construct query to create table in database
    $sql_query = "CREATE TABLE IF NOT EXISTS customerService (bookingID INT(10) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, mobileNo VARCHAR(20) NOT NULL, roomType VARCHAR(50) NOT NULL, checkInDate VARCHAR(10) NOT NULL, checkInTime VARCHAR(10) NOT NULL, stayType VARCHAR(20) NOT NULL, stayDuration VARCHAR(20) NOT NULL, pickUpLocation VARCHAR(150) NOT NULL)";

    $status = $connection->query($sql_query);
    if ($status === false) {
        echo ($connection->error . PHP_EOL);
    }

    $connection->close(); // Close Connection Object
}

function assignBooking(array $newRecord): bool
{
    /**
     * require resource: Connection Object
     * to add a record to table in database
     * @param array $newRecord
     * close resource: Connection Object
     */
    $connection = connection();
    // Construct query to insert records into Database
    $sql_query = "INSERT INTO customerService (bookingID, name, email, mobileNo, roomType, checkInDate, checkInTime, stayType, stayDuration, pickUpLocation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("isssssssss", $newRecord['bookingID'], $newRecord['name'], $newRecord['email'], $newRecord['mobileNo'], $newRecord['roomType'], $newRecord['checkInDate'], $newRecord['checkInTime'], $newRecord['stayType'], $newRecord['stayDuration'], $newRecord['pickUpLocation']);
    $result = $stmt->execute();

    $stmt->close(); // Close Statement Object
    $connection->close(); // Close Connection Object

    return $result;
}

// customerServiceTable();
