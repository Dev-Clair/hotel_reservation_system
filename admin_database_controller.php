<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'hotel_database.php';

function rescheduledBookingTable()
{
    /**
     * require resource: Connection Object
     * to create rescheduledBookings table in database
     * close resource: Connection Object
     */
    $connection = connection();
    // Construct query to create table in database
    $sql_query = "CREATE TABLE IF NOT EXISTS rescheduledbookings (bookingID INT(10) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, mobileNo VARCHAR(20) NOT NULL, roomType VARCHAR(50) NOT NULL, checkInDate VARCHAR(10) NOT NULL, checkInTime VARCHAR(10) NOT NULL, stayType VARCHAR(20) NOT NULL, stayDuration VARCHAR(20) NOT NULL, pickUpLocation VARCHAR(150) NOT NULL, 'count' INT NOT NULL DEFAULT 0)";

    $status = $connection->query($sql_query);
    if ($status === false) {
        echo ($connection->error . PHP_EOL);
    }

    $connection->close(); // Close Connection Object
}

function addRescheduledBooking(array $newRecord): bool
{
    /**
     * require resource: Connection Object
     * to add a record to table in database
     * @param array $newRecord
     * close resource: Connection Object
     */
    $connection = connection();
    // Construct query to insert records into Database
    $sql_query = "INSERT INTO rescheduledbookings (bookingID, name, email, mobileNo, roomType, checkInDate, checkInTime, stayType, stayDuration, pickUpLocation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("isssssssss", $newRecord['bookingID'], $newRecord['name'], $newRecord['email'], $newRecord['mobileNo'], $newRecord['roomType'], $newRecord['checkInDate'], $newRecord['checkInTime'], $newRecord['stayType'], $newRecord['stayDuration'], $newRecord['pickUpLocation']);
    $result = $stmt->execute();

    $stmt->close(); // Close Statement Object
    $connection->close(); // Close Connection Object

    return $result;
}

function readRescheduledBookings(): array
{
    /**
     * require resource: Connection Object
     * to read records from table in database
     * close resource: Connection Object
     */
    $connection = connection();
    // Construct query to read table records from database
    $sql_query = "SELECT * FROM rescheduledbookings";
    $result = $connection->query($sql_query);
    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC); // Returns an associative array
        $result->close(); // Close Result Object
        $connection->close(); // Close Connection Object
        return $rows;
    } else {
        $connection->close(); // Close Connection Object
        return []; // Returns an empty array if no rows are found
    }
}

function adminValidate_bookingID(int $bookingID): bool
{
    /**
     * require resource: Connection Object
     * to validate bookingID in table in database
     * @param string $bookingID
     * @return bool true if valid else false
     * close resource: Connection Object
     */
    $connection = connection();
    $sql_query = "SELECT * FROM rescheduledbookings WHERE bookingID = ?";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("i", $bookingID);
    $validBookingID = false;
    if ($stmt->execute()) {
        $validBookingID = ($stmt->fetch() !== null); // Check if a row is fetched
    }

    $stmt->close(); // Close Statement Object
    $connection->close(); // Close Connection Object

    return $validBookingID;
}

function updateRescheduledBooking(int $bookingID, array $updatedRecord): bool
{
    /**
     * require resource: Connection Object
     * to update one or many records in the database
     * @param int $bookingID
     * @param array $updatedRecord
     * close resource: Connection Object
     */
    $connection = connection();
    $sql_query = "UPDATE rescheduledbookings SET roomType = ?, checkInDate = ?, checkInTime = ?, stayType = ?, stayDuration = ?, pickUpLocation = ? WHERE bookingID = ?";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("ssssssi", $updatedRecord['roomType'], $updatedRecord['checkInDate'], $updatedRecord['checkInTime'], $updatedRecord['stayType'], $updatedRecord['stayDuration'], $updatedRecord['pickUpLocation'], $bookingID);

    $status = $stmt->execute();

    $stmt->close(); // Close Statement Object
    $connection->close(); // Close Connection Object

    return $status;
}

function deleteRescheduledBooking(int $bookingID): bool
{
    /**
     * require resource: Connection Object
     * to delete a record in the database
     * @param int $bookingID
     * close resource: Connection Object
     */
    $connection = connection();
    // Construct query to delete table record in database
    $sql_query = "DELETE FROM rescheduledbookings WHERE bookingID = ?";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("i", $bookingID);

    $status = $stmt->execute();

    $stmt->close(); // Close Statement Object
    $connection->close(); // Close Connection Object

    return $status;
}

// rescheduledBookingTable();


/** Rescheduling Handlers */

function retrieveRescheduleCount($bookingID): int|null
{
    // require resource: Connection Object
    // to retrieve the number of reschedules in table in database
    // @param int $bookingID
    // close resource: Connection Object
    $connection = connection();
    // Construct query to check count value in table in database
    $sql_query = "SELECT `count` FROM rescheduledbookings WHERE bookingID = ?";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("i", $bookingID);

    $status = $stmt->execute();
    if ($status) {
        $stmt->bind_result($count); // Bind the result to a variable
        $stmt->fetch(); // Fetch the value
        $stmt->close(); // Close Statement Object
        $connection->close(); // Close Connection Object
        return $count; // Return the value stored in the count column
    } else {
        $stmt->close(); // Close Statement Object
        $connection->close(); // Close Connection Object
        return null; // Returns null if the query execution fails
    }
}

function updateRescheduleCount(int $updatedCount, int $bookingID): bool
{
    /**
     * require resource: Connection Object
     * to update count value for bookingID in table in the database
     * @param int $updatedCount
     * @param int $bookingID
     * close resource: Connection Object
     */
    $connection = connection();
    $sql_query = "UPDATE rescheduledbookings SET `count` = ? WHERE bookingID = ?";
    $stmt = $connection->prepare($sql_query);
    $stmt->bind_param("ii", $updatedCount, $bookingID);

    $status = $stmt->execute();

    $stmt->close(); // Close Statement Object
    $connection->close(); // Close Connection Object

    return $status;
}
