<?php
// Import Database Files
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bookings_database_controller.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'cancel_reservation_database_controller.php';

// Retrieve BookingID from Query String
$bookingID = isset($_GET['bookingID']) ? (int)$_GET['bookingID'] : null;


// Validate BookingID
if (validate_bookingID($bookingID)) {
    // If Valid: Retrieve record from bookings table and Add to cancelledBookings table in database
    $cancelStatus = cancelBooking(readSingleBooking($bookingID));

    // Delete record from bookings table in database
    $deleteStatus = deleteSingleBooking($bookingID);

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
