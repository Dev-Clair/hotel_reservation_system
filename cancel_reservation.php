<?php
// require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

// Retrieve BookingID from Query String
$bookingID = isset($_GET['bookingID']) ? (int)$_GET['bookingID'] : null;

// Validate BookingID
if ($operation->validateFieldValue("bookings", "bookingID", $bookingID)) {
    // If Valid: Retrieve record from bookings table and Add to cancelledBookings table in database
    $assignStatus = $operation->createRecords("cancelledbookings", $operation->retrieveSingleRecord("bookings", "bookingID", $bookingID));

    // Delete Record from bookings table in database
    $deleteStatus = $operation->deleteSingleRecord("bookings", "bookingID", $bookingID);

    if ($cancelStatus === true && $deleteStatus === true) {
        // Redirect to admin.php with success message
        $successMessage = "Booking Cancelled Successfully .";
        $address = 'admin.php?cancelSuccessMessage=' . urlencode($successMessage);
        header("Location: $address");
        exit();
    } else {
        // Redirect to admin.php with error message
        $errorMessage = "Error! Cannot Cancel Booking";
        $address = 'admin.php?cancelErrorMessage=' . urlencode($errorMessage);
        header("Location: $address");
        exit();
    }
}
