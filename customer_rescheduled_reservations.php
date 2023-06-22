<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bookings_database_controller.php'; // Import Database File
require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php'; // Import file for validating user input

// Retrieve BookingID from Query String
$bookingID = isset($_GET['bookingID']) ? (int)$_GET['bookingID'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve Form Inputs
    $checkInDate = $_POST['checkInDate'];
    $checkInTime = $_POST['checkInTime'];
    $stayType = $_POST['stayType'];
    $stayDuration = $_POST['stayDuration'];
    $pickUpLocation = $_POST['pickUpLocation'];

    $errors = []; // Declare an error array variable

    // Validate User Inputs
    if (!validate_stayType($stayType))
        $errors[] = "Invalid stay type. Please select a valid stay type.";
    if (!validate_stayDuration($stayDuration))
        $errors[] = "Invalid stay duration. Please select a valid stay duration.";
    if (!validate_pickUpLocation($pickUpLocation))
        $errors[] = "Invalid pick-up location. Please enter a valid pick-up location.";

    if (!empty($errors)) {
        $errorMessage = implode("", $errors);
        $address = 'customer_rescheduled_reservations.php?updateErrorMessage=' . urlencode($errorMessage);
        header("Location: $address");
        exit();
    }

    // Check if $bookingID is set and not null
    if ($bookingID) {
        // Create an array of updated booking details
        $updatedRecord = array(
            'checkInDate' => $checkInDate,
            'checkInTime' => $checkInTime,
            'stayType' => $stayType,
            'stayDuration' => $stayDuration,
            'pickUpLocation' => $pickUpLocation
        );

        // Search and update the record with the matching bookingID
        $updateRecord = updateSingleBooking($bookingID, $updatedRecord);

        if ($updateRecord) {
            // Redirect to index.php with success message
            $successMessage = "Booking Successfully Rescheduled. The reception will call 3 hours before the check-in time to confirm availability status.";
            $address = 'index.php?updateSuccessMessage=' . urlencode($successMessage);
            header("Location: $address");
            exit();
        }
    }

    $errorMessage = "Error! Cannot update record";
    $address = 'customer_rescheduled_reservations.php?updateErrorMessage=' . urlencode($errorMessage);
    header("Location: $address");
    exit();
}

// Retrieve booking information from database
if ($bookingID) {
    $bookingData = readSingleBooking($bookingID);
} else {
    $errorMessage = "Error! Invalid booking ID.";
    $address = 'customer_rescheduled_reservations.php?updateErrorMessage=' . urlencode($errorMessage);
    header("Location: $address");
    exit();
}

// Check if booking data is found
if ($bookingData) {
    $checkInDate = $bookingData['checkInDate'];
    $checkInTime = $bookingData['checkInTime'];
    $stayType = $bookingData['stayType'];
    $stayDuration = $bookingData['stayDuration'];
    $pickUpLocation = $bookingData['pickUpLocation'];
} else {
    $errorMessage = "Error! Booking data not found.";
    $address = 'customer_rescheduled_reservations.php?updateErrorMessage=' . urlencode($errorMessage);
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
            <h4>Update Booking Reservation Details: <?php echo $bookingID; ?></h4>
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
                        <input type="radio" class="form-check-input" id="shortStay" name="stayType" value="shortStay">
                        <label class="form-check-label" for="shortStay"><strong>Short Stay</strong></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="extendedStay" name="stayType" value="extendedStay">
                        <label class="form-check-label" for="extendedStay"><strong>Extended Stay</strong></label>
                    </div>
                    <select class="form-control my-2" id="stayDuration" name="stayDuration">
                        <option value="">--Click to Select--</option>
                        <optgroup label="Short Stay">
                            <option value="1 day">1 day</option>
                            <option value="2 days">2 days</option>
                            <option value="3 days">3 days</option>
                            <option value="4 days">4 days</option>
                            <option value="5 days">5 days</option>
                            <option value="6 days">6 days</option>
                        </optgroup>
                        <optgroup label="Extended Stay">
                            <option value="1-2 weeks">1-2 weeks</option>
                            <option value="2-3 weeks">2-3 weeks</option>
                            <option value="1 month">1 month</option>
                            <option value="1-2 months">1-2 months</option>
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