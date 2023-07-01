<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';
// import file for validating user input
require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

// Retrieve BookingData from Query String
$bookingData = isset($_GET['bookingData']) ? unserialize(urldecode($_GET['bookingData'])) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve Form Inputs
    $roomType = $_POST['roomType'];
    $checkInDate = $_POST['checkInDate'];
    $checkInTime = $_POST['checkInTime'];
    $stayType = $_POST['stayType'];
    $stayDuration = $_POST['stayDuration'];
    $pickUpLocation = $_POST['pickUpLocation'];

    $errors = []; // Declare an error array variable

    // Validate User Inputs
    if (!validate_roomType($roomType))
        $errors[] = "Invalid room type. Please select a valid room type.";
    if (!validate_stayType($stayType))
        $errors[] = "Invalid stay type. Please select a valid stay type.";
    if (!validate_stayDuration($stayDuration))
        $errors[] = "Invalid stay duration. Please select a valid stay duration.";
    if (!validate_pickUpLocation($pickUpLocation))
        $errors[] = "Invalid pick-up location. Please enter a valid pick-up location.";

    if (!empty($errors)) {
        $errorMessage = implode("", $errors);
        $address = 'admin.php?rescheduleErrorMessage=' . urlencode($errorMessage);
        header("Location: $address");
        exit();
    }

    // Check if $bookingID is not null
    if ($bookingData['bookingID'] !== null) {
        // If Valid: Retrieve and add record from bookings table  to rescheduledBookings table in database
        $rescheduleStatus = $operation->createRecords("rescheduledbookings", $bookingData);
        // Delete Record from bookings table in database
        $deleteStatus = $operation->deleteSingleRecord("bookings", "bookingID", $bookingData['bookingID']);

        if ($rescheduleStatus === true || $deleteStatus === true) {
            // Create an array of updated booking details
            $validEntries = array(
                'roomType' => $roomType,
                'checkInDate' => $checkInDate,
                'checkInTime' => $checkInTime,
                'stayType' => $stayType,
                'stayDuration' => $stayDuration,
                'pickUpLocation' => $pickUpLocation
            );

            // Update the record with the matching bookingID
            $updateCondition = "bookingID =" . $bookingData['bookingID'];
            $updatedRecord = $operation->updateRecordFields("rescheduledbookings", $validEntries, "bookingID", $bookingData['bookingID']);

            if ($updatedRecord) {
                // Redirect to index.php with success message
                $successMessage = "Booking Successfully Rescheduled. Kindly communicate the success of the operation with the customer.";
                $address = 'admin.php?rescheduleSuccessMessage=' . urlencode($successMessage);
                header("Location: $address");
                exit();
            }
        }
    }
    $errorMessage = "Error! Cannot reschedule booking";
    $address = 'admin_rescheduled_reservations.php?rescheduleErrorMessage=' . urlencode($errorMessage);
    header("Location: $address");
    exit();
}

// Check if booking data is found
if (is_array($bookingData)) {
    $roomType = $bookingData['roomType'];
    $checkInDate = $bookingData['checkInDate'];
    $checkInTime = $bookingData['checkInTime'];
    $stayType = $bookingData['stayType'];
    $stayDuration = $bookingData['stayDuration'];
    $pickUpLocation = $bookingData['pickUpLocation'];
} else {
    $errorMessage = "Error! Booking data not found.";
    $address = 'admin.php?rescheduleErrorMessage=' . urlencode($errorMessage);
    header("Location: $address");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="indexstyles.css">
</head>

<body>
    <header>
        <div class="topleft-container">
            <img src="img/water.png" alt="">
            <!-- <a href=" https://www.flaticon.com/free-icons/architecture-and-city" - Flaticon></a>" -->
        </div>
    </header>

    <!-- Reschedule Reservation Error Alert -->
    <?php
    if (isset($_GET['updateErrorMessage'])) {
        $errorMessage = $_GET['updateErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>
    <div class="container">
        <form method="post" action="">
            <h4>Update Booking Reservation Details: <?php echo $bookingData['bookingID']; ?></h4>
            <div class="form-group">
                <label for="roomType"><strong>Room Type:</strong></label>
                <select class="form-control" id="roomType" name="roomType">
                    <option value="">--Click to Select--</option>
                    <option value="Regular" <?php if ($roomType == 'Regular') echo 'selected'; ?>>Regular NGN 12,500</option>
                    <option value="Twin" <?php if ($roomType == 'Twin') echo 'selected'; ?>>Twin NGN 15,500</option>
                    <option value="King" <?php if ($roomType == 'King') echo 'selected'; ?>>King NGN 19,000</option>
                    <option value="Queen" <?php if ($roomType == 'Queen') echo 'selected'; ?>>Queen NGN 21,000</option>
                    <option value="Deluxe" <?php if ($roomType == 'Deluxe') echo 'selected'; ?>>Deluxe NGN 26,500</option>
                    <option value="Standard Suite" <?php if ($roomType == 'Standard Suite') echo 'selected'; ?>>Standard Suite NGN 45,000</option>
                    <option value="Presidential Suite" <?php if ($roomType == 'Presidential Suite') echo 'selected'; ?>>Presidential Suite NGN 65,000</option>
                    <option value="Cabana" <?php if ($roomType == 'Cabana') echo 'selected'; ?>>Cabana NGN 72,500</option>
                    <option value="Pent Floor" <?php if ($roomType == 'Pent Floor') echo 'selected'; ?>>Pent Floor NGN 92,000</option>
                </select>
            </div>
            <div class="form-group">
                <label for="checkInDate"><strong>Check-in Date:</strong></label>
                <input type="date" class="form-control" id="checkInDate" name="checkInDate" value="<?php echo $checkInDate; ?>">
            </div>
            <div class="form-group">
                <label for="checkInTime"><strong>Check-in Time:</strong></label>
                <input type="time" class="form-control" id="checkInTime" name="checkInTime" value="<?php echo $checkInTime; ?>">
            </div>
            <div class="form-group">
                <label for="durationOfStay"><strong>Check-in Duration:</strong></label>
                <div class="form-check">
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="shortStay" name="stayType" value="shortStay" <?php if ($stayType === 'shortStay') echo 'checked'; ?>>
                        <label class="form-check-label" for="shortStay"><strong>Short Stay</strong></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="extendedStay" name="stayType" value="extendedStay" <?php if ($stayType === 'extendedStay') echo 'checked'; ?>>
                        <label class="form-check-label" for="extendedStay"><strong>Extended Stay</strong></label>
                    </div>
                    <select class="form-control my-2" id="stayDuration" name="stayDuration">
                        <option value="">--Click to Select--</option>
                        <optgroup label="Short Stay">
                            <option value="1 day" <?php if ($stayDuration == '1 day') echo 'selected'; ?>>1 day</option>
                            <option value="2 days" <?php if ($stayDuration == '2 days') echo 'selected'; ?>>2 days</option>
                            <option value="3 days" <?php if ($stayDuration == '3 days') echo 'selected'; ?>>3 days</option>
                            <option value="4 days" <?php if ($stayDuration == '4 days') echo 'selected'; ?>>4 days</option>
                            <option value="5 days" <?php if ($stayDuration == '5 days') echo 'selected'; ?>>5 days</option>
                            <option value="6 days" <?php if ($stayDuration == '6 days') echo 'selected'; ?>>6 days</option>
                        </optgroup>
                        <optgroup label="Extended Stay">
                            <option value="1-2 weeks" <?php if ($stayDuration == '1-2 weeks') echo 'selected'; ?>>1-2 weeks</option>
                            <option value="2-3 weeks" <?php if ($stayDuration == '2-3 weeks') echo 'selected'; ?>>2-3 weeks</option>
                            <option value="1 month" <?php if ($stayDuration == '1 month') echo 'selected'; ?>>1 month</option>
                            <option value="1-2 months" <?php if ($stayDuration == '1-2 months') echo 'selected'; ?>>1-2 months</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="pickupLocation"><strong>Chauffeur Service:</strong></label>
                <input type="text" class="form-control" id="pickupLocation" name="pickUpLocation" value="<?php echo $pickUpLocation; ?>" autocomplete="off">
            </div>
            <div class="topright-container">
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                <a href="index.php" class="btn btn-sm btn-danger" role="button">Cancel</a>
            </div>
        </form>
    </div>

    <footer>
        <div class="bottomleft-container">
            <p class="copyright">
                &copy; jagaad_group_2 class 2023
            </p>
        </div>
    </footer>

</body>

</html>