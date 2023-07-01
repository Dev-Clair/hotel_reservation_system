<?php
ob_start();
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';
// import file for validating user input
require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve submitted form values
    $roomType = $_POST['roomType'];
    $checkInDate = $_POST['checkInDate'];
    $checkInTime = $_POST['checkInTime'];
    $stayType = $_POST['stayType'];
    $stayDuration = $_POST['stayDuration'];
    $pickUpLocation = $_POST['pickUpLocation'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile'];

    // Validate Userinputs
    $errors = []; // Declare an error array variable

    if (!validate_roomType($roomType))
        $errors[] = "Invalid room type. Please select a valid room type.";
    // if (!validate_checkInDate($checkInDate))
    //     $errors[] = "Invalid check-in date. Please enter a valid date in the format dd/mm/yyyy.";
    if (!validate_stayType($stayType))
        $errors[] = "Invalid stay type. Please select a valid stay type.";
    if (!validate_stayDuration($stayDuration))
        $errors[] = "Invalid stay duration. Please select a valid stay duration.";
    if (!validate_pickUpLocation($pickUpLocation))
        $errors[] = "Invalid pick-up location. Please enter a valid pick-up location.";
    if (!validate_name($name))
        $errors[] = "Invalid name. Please enter a valid name.";
    if (!validate_email($email))
        $errors[] = "Invalid email address. Please enter a valid email address.";
    // if (!validate_mobileNo($mobile_no))
    //     $errors[] = "Invalid mobile number. Please enter a valid mobile number.";

    if (!empty($errors)) {
        $errorMessage = implode("", $errors);
        $address = 'index.php?bookingErrorMessage=' . urlencode($errorMessage);
        ob_end_flush();
        redirect_to($address);
        exit();
    }

    // Generate booking-ID for customer usign the time() function
    $bookingID = time();

    // Create an array of the booking details to be entered into the database
    $newRecord = array(
        'bookingID' => $bookingID,
        'name' => $name,
        'email' => $email,
        'mobileNo' => $mobile_no,
        'roomType' => $roomType,
        'checkInDate' => $checkInDate,
        'checkInTime' => $checkInTime,
        'stayType' => $stayType,
        'stayDuration' => $stayDuration,
        'pickUpLocation' => $pickUpLocation
    );

    // Add new record to database
    $addRecord = $operation->createRecords("bookings", $newRecord);

    if ($addRecord) {
        // Redirect to booking_details.php with bookingID
        $address = "booking_ticket.php?bookingID=$bookingID";
        ob_end_flush();
        redirect_to($address);
        exit();
    }
    $errorMessage = "Error! Please try again";
    $address = 'index.php?bookingErrorMessage=' . urlencode($errorMessage);
    ob_end_flush();
    redirect_to($address);
    exit();
}
