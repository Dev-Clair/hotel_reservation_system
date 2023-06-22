<?php
ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bookings_database_controller.php'; // Import Database File
require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php'; // Import file for validating userinput

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for user action: Check Reservation
    if (isset($_POST['reservation']) && $_POST['reservation'] === 'check_reservation') {
        // Retrieve and Clean User Input: Booking-ID
        $bookingID = (int)trim(htmlspecialchars($_POST['bookingID']));

        // Redirect to index.php with appropriate message
        if (!validate_bookingID($bookingID)) {
            $errorMessage = "Reservation Status: Invalid for $bookingID";
            $address = 'index.php?checkErrorMessage=' . urlencode($errorMessage);
            redirect_to($address);
            exit();
        }
        $successMessage = "Reservation Status: Valid for $bookingID";
        $address = 'index.php?checkSuccessMessage=' . urlencode($successMessage);
        ob_end_flush();
        redirect_to($address);
        exit();
    }

    // Check for user action: Reschedule Reservation
    if (isset($_POST['reservation']) && $_POST['reservation'] === 'reschedule_reservation') {
        // Retrieve and Clean User Input: Booking-ID
        $bookingID = (int)trim(htmlspecialchars($_POST['bookingID']));

        // Redirect to appropriate page
        if (!validate_bookingID($bookingID)) {
            // Redirect to index.php with error message
            $errorMessage = "Reservation Status: Invalid for $bookingID";
            $address = 'index.php?checkErrorMessage=' . urlencode($errorMessage);
            ob_end_flush();
            redirect_to($address);
            exit();
        }
        // Redirect to customer_rescheduled_reservations.php with Booking-ID
        $address = 'customer_rescheduled_reservations.php?bookingID=' . urlencode($bookingID);
        ob_end_flush();
        redirect_to($address);
        exit();
    }
}
