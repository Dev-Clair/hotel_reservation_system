<?php
// Require file for redirecting user
require_once __DIR__ . DIRECTORY_SEPARATOR . 'validate_userinput.php';

/**
 * Admin Log-in
 */

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the values from the form field
    $admin_id = $_POST['admin_id'];
    $passwd = $_POST['password'];

    // Clean user input
    $admin_id = trim(strip_tags($admin_id));
    $passwd = trim(strip_tags($passwd));
    if ($admin_id !== "practicegroup2" && $passwd !== "mygroup") {
        // Display error message and redirect to index.php with error message
        $errorMessage = "Status: Invalid log-in details";
        $address = 'index.php?loginErrorMessage=' . urlencode($errorMessage);
        redirect_to($address);
        exit();
    } else {
        header('Location: admin.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="indexstyles.css">
</head>

<body>
    <header>
        <div class="topleft-container">
            <img src="img/water.png" alt="">
            <!-- <a href=" https://www.flaticon.com/free-icons/architecture-and-city" - Flaticon></a>" -->
        </div>
        <div class="topright-container">
            <div>
                <form method="post" action="">
                    <input type="text" class="rounded" id="adminId" name="admin_id" placeholder="Enter adminID" autocomplete="off">
                    <input type="password" class="rounded" id="adminPassword" name="password" placeholder="Enter password">
                    <button type="submit" class="  btn btn-sm btn-primary rounded">Log in</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Booking Error Alert -->
    <?php
    if (isset($_GET['bookingErrorMessage'])) {
        $errorMessage = $_GET['bookingErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>
    <!-- Admin Log-in Error Alert -->
    <?php
    if (isset($_GET['loginErrorMessage'])) {
        $errorMessage = $_GET['loginErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>
    <!-- Check Reservation Success and Error Alert -->
    <?php
    if (isset($_GET['checkSuccessMessage'])) {
        $successMessage = $_GET['checkSuccessMessage'];
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <?php
    if (isset($_GET['checkErrorMessage'])) {
        $errorMessage = $_GET['checkErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>
    <!-- Reschedule Reservation Success Alert -->
    <?php
    if (isset($_GET['updateSuccessMessage'])) {
        $errorMessage = $_GET['updateSuccessMessage'];
        echo '<div class="alert alert-success">' . $errorMessage . '</div>';
    }
    ?>

    <div class="container">

        <h1>Select Reservation Service</h1>

        <div class="row mt-4">
            <div class="col">
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#roomReservationModal">
                    Room Reservation
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <button type="button" class="btn btn-secondary btn-lg btn-block" disabled data-toggle="modal" data-target="#eventHallReservationModal">
                    Event Hall Reservation
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <button type="button" class="btn btn-secondary btn-lg btn-block" disabled data-toggle="modal" data-target="#conferenceRoomReservationModal">
                    Conference Room Reservation
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <button type="button" class="btn btn-secondary btn-lg btn-block" disabled data-toggle="modal" data-target="#privatePoolReservationModal">
                    Private Pool Reservation
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#rescheduleReservationModal">
                    Reschedule Reservation
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#enquiriesReservationModal">
                    Reservation Enquiries
                </button>
            </div>
        </div>
    </div>

    <footer>
        <div class="bottomleft-container">
            <p class="copyright">
                &copy; jagaad_group_2 class 2023
            </p>
        </div>
    </footer>

    <!-- Room Reservation Modal -->
    <div class="modal fade" id="roomReservationModal" tabindex="-1" role="dialog" aria-labelledby="roomReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomReservationModalLabel">Room Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="roomReservationForm" method="post" action="reservation_handler.php">
                        <!-- Service Details -->
                        <div class="form-group">
                            <label for="roomType"><strong>Room Type:</strong></label>
                            <select class="form-control" id="roomType" name="roomType">
                                <option value="">--Click to Select--</option>
                                <option value="Regular">Regular NGN 12,500</option>
                                <option value="Twin">Twin NGN 15,500</option>
                                <option value="King">King NGN 19,000</option>
                                <option value="Queen">Queen NGN 21,000</option>
                                <option value="Deluxe">Deluxe NGN 26,500</option>
                                <option value="Standard Suite">Standard Suite NGN 45,000</option>
                                <option value="Presidential Suite">Presidential Suite NGN 65,000</option>
                                <option value="Cabana">Cabana NGN 72,500</option>
                                <option value="Pent Floor">Pent Floor NGN 92,000</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="checkInDate"><strong>Check-in Date:</strong></label>
                            <input type="date" class="form-control" id="checkInDate" name="checkInDate">
                        </div>
                        <div class="form-group">
                            <label for="checkInTime"><strong>Check-in Time:</strong></label>
                            <input type="time" class="form-control" id="checkInTime" name="checkInTime">
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
                            <input type="text" class="form-control" id="pickupLocation" name="pickUpLocation" placeholder="Enter pickup location" autocomplete="off">
                        </div>
                        <!-- Personal Details -->
                        <div class="form-group">
                            <label for="name"><strong>Name:</strong></label>
                            <input type="text" class=" form-control" id="name" name="name" placeholder="Enter name" autocomplete="off">
                        </div>
                        <div class=" form-group">
                            <label for="email"><strong>Email:</strong></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="mobile"><strong>Tel No.:</strong></label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="+00-000-000-0000" autocomplete="off">
                        </div>
                        <!-- Payment System -->
                        <div class="form-group">
                            <label for="payment"><strong>Select Payment Option:</strong></label>
                            <span>Kindly confirm your reservation by making payment</span>
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled>
                                        <img src="img/masterpayicon.png" alt="Mastercard" class="payment-image">
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled>
                                        <img src="img/paypalpayicon.png" alt="PayPal" class="payment-image">
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled>
                                        <img src="img/visapayicon.png" alt="Visa" class="payment-image">
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled>
                                        <img src="img/amexpayicon.png" alt="Amex" class="payment-image">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Check / Reschedule Reservation Modal -->
    <div class="modal fade" id="rescheduleReservationModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleReservationModalLabel">Check or Reschedule a Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rescheduleReservationForm" method="post" action="confirm_bookingID.php">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="check_reservation" name="reservation" value="check_reservation">
                            <label class="form-check-label" for="check_reservation"><strong>Check Reservation</strong></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="reschedule_reservation" name="reservation" value="reschedule_reservation">
                            <label class="form-check-label" for="reschedule_reservation"><strong>Reschedule Reservation</strong></label>
                        </div>
                        <div class="form-group my-2">
                            <input type="text" class="form-control" name="bookingID" placeholder="Enter Booking-ID to check or reschedule a reservation">
                        </div>
                        <div class=" modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Enquiries Modal -->
    <div class="modal fade" id="enquiriesReservationModal" tabindex="-1" role="dialog" aria-labelledby="enquiriesReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enquiriesReservationModalLabel">Reservation Enquiries</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Click to call link -->
                    <a href="tel:01211449">Kindly call our customer service at 01-211449</a>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>