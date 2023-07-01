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
    // If Valid: Retrieve and add record from bookings table  to customerservice table in database
    $assignStatus = $operation->createRecords("customerservice", $operation->retrieveSingleRecord("bookings", "bookingID", $bookingID));

    // Delete Record from bookings table in database
    $deleteStatus = $operation->deleteSingleRecord("bookings", "bookingID", $bookingID);

    if ($assignStatus === true && $deleteStatus === true) {
        // Redirect to admin.php with success message
        $successMessage = "Booking Successfully Assigned.";
        $address = 'admin.php?assignSuccessMessage=' . urlencode($successMessage);
        header("Location: $address");
        exit();
    } else {
        // Redirect to admin.php with error message
        $errorMessage = "Error! Cannot Assign Booking";
        $address = 'admin.php?assignErrorMessage=' . urlencode($errorMessage);
        header("Location: $address");
        exit();
    }
}
