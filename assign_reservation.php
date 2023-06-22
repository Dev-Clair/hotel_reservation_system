<?php
// Import Database Files
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bookings_database_controller.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'assign_reservation_database_controller.php';

// Retrieve BookingID from Query String
$bookingID = isset($_GET['bookingID']) ? (int)$_GET['bookingID'] : null;

// Validate BookingID
if (validate_bookingID($bookingID)) {
    // If Valid: Retrieve and add record from bookings table  to customerservice table in database
    $assignStatus = assignBooking(readSingleBooking($bookingID));

    // Delete Record from bookings table in database
    $deleteStatus = deleteSingleBooking($bookingID);

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
