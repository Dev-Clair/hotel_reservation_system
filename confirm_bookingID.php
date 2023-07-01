<?php
ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for user action: Check Reservation
    if (isset($_POST['reservation']) && $_POST['reservation'] === 'check_reservation') {
        // Retrieve and Clean User Input: Booking-ID
        $bookingID = (int)trim(htmlspecialchars($_POST['bookingID']));

        // Search for bookingData in bookings table and Redirect to index.php with success message
        if ($operation->validateFieldValue("bookings",  "bookingID", $bookingID)) {
            $successMessage = "Reservation Status: Valid";
            $address = 'index.php?checkSuccessMessage=' . urlencode($successMessage);
            ob_end_flush();
            redirect_to($address);
            exit();
        }
        // Search for bookingData in rescheduledbookings table and Redirect to index.php with success message
        if ($operation->validateFieldValue("rescheduledbookings", "bookingID", $bookingID)) {
            $successMessage = "Reservation Status: Valid";
            $address = 'index.php?checkSuccessMessage=' . urlencode($successMessage);
            ob_end_flush();
            redirect_to($address);
            exit();
        }
        $errorMessage = "Reservation Status: Invalid";
        $address = 'index.php?checkErrorMessage=' . urlencode($errorMessage);
        redirect_to($address);
        exit();
    }

    // Check for user action: Reschedule Reservation
    if (isset($_POST['reservation']) && $_POST['reservation'] === 'reschedule_reservation') {
        // Retrieve and Clean User Input: Booking-ID
        $bookingID = (int)trim(htmlspecialchars($_POST['bookingID']));

        // Search for bookingData in bookings table and redirect to customer_rescheduled_reservations.php
        if ($operation->validateFieldValue("bookings", "bookingID", $bookingID)) {
            // Retrieve data from database
            $retrievedRecord = $operation->retrieveSingleRecord("bookings", "bookingID", $bookingID);
            // Redirect to customer_rescheduled_reservations.php with bookingData
            $address = 'customer_rescheduled_reservations.php?bookingData=' . urlencode(serialize($retrievedRecord));
            ob_end_flush();
            redirect_to($address);
            exit();
        }
        // Search for bookingData in rescheduledbookings table and redirect to customer_rescheduled_reservations.php
        if ($operation->validateFieldValue("rescheduledbookings", "bookingID", $bookingID)) {
            // Retrieve data from database
            $retrievedRecord = $operation->retrieveSingleRecord("rescheduledbookings", "bookingID", $bookingID);
            // Redirect to customer_rescheduled_reservations.php with bookingData
            $address = 'customer_rescheduled_reservations.php?bookingData=' . urlencode(serialize($retrievedRecord));
            ob_end_flush();
            redirect_to($address);
            exit();
        }
        // Redirect to index.php with error message
        $errorMessage = "Reservation Status: Invalid";
        $address = 'index.php?rescheduleErrorMessage=' . urlencode($errorMessage);
        ob_end_flush();
        redirect_to($address);
        exit();
    }
    // Redirect to index.php with error message
    $errorMessage = "Error! Try Again";
    $address = 'index.php?checkErrorMessage=' . urlencode($errorMessage);
    ob_end_flush();
    redirect_to($address);
    exit();
}
