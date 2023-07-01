<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="adminstyles.css">
    <title>Booking Records</title>
</head>

<body>
    <header>
        <div class="topleft-container">
            <img src="img/water.png" alt="">
            <!-- <a href=" https://www.flaticon.com/free-icons/architecture-and-city" - Flaticon></a>" -->
        </div>
        <div class="topright-container">
            <div>
                <a href="index.php" class="btn btn-sm btn-danger" role="button">Log out</a>
            </div>
        </div>
    </header>
    <!-- Reschedule Reservation Success and Error Alert -->
    <?php
    if (isset($_GET['rescheduleSuccessMessage'])) {
        $errorMessage = $_GET['rescheduleSuccessMessage'];
        echo '<div class="alert alert-success">' . $errorMessage . '</div>';
    }
    ?>
    <?php
    if (isset($_GET['rescheduleErrorMessage'])) {
        $errorMessage = $_GET['rescheduleErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>

    <!-- Admin Assign Operation Success and Error Alert -->
    <?php
    if (isset($_GET['assignSuccessMessage'])) {
        $successMessage = $_GET['assignSuccessMessage'];
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <?php
    if (isset($_GET['assignErrorMessage'])) {
        $errorMessage = $_GET['assignErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>

    <!-- Admin Cancel Operation Success and Error Alert -->
    <?php
    if (isset($_GET['cancelSuccessMessage'])) {
        $successMessage = $_GET['cancelSuccessMessage'];
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <?php
    if (isset($_GET['cancelErrorMessage'])) {
        $errorMessage = $_GET['cancelErrorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>

    <div class="btn-grp">
        <!-- Create Reservation Modal -->
        <!-- <button type="button" class="btn-success rounded my-3 mb-3" data-toggle="modal" data-target="#roomReservationModal">
            Room Reservation
        </button> -->
        <!-- Bookings  trigger modal -->
        <button type="button" class="btn-primary rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showBookingsTableModal">Bookings
        </button>
        <!-- Assigned Bookings Button trigger modal -->
        <button type="button" class="btn-success rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showAssignedBookingsTableModal">Assigned
        </button>
        <!-- Rescheduled Bookings Button trigger modal -->
        <button type="button" class="btn-primary rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showRescheduledBookingsTableModal">Rescheduled
        </button>
        <!-- Cancelled Bookings Button trigger modal -->
        <button type="button" class="btn-danger rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showCancelledBookingsTableModal">Cancelled
        </button>
    </div>


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
    <!-- Bookings Table Modal -->
    <div class="modal fade" id="showBookingsTableModal" tabindex="-1" aria-labelledby="showBookingsTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showBookingsTableModalLabel"><strong>Bookings</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class=modal-body scrollable-container">
                    <section class="wrapper-main">
                        <!-- List Booking Record -->
                        <div class="container-fluid table-wrapper">
                            <table class="table table-striped table-bordered mt-4">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S/n</th>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Room-Type</th>
                                        <th>CID</th>
                                        <th>CIT</th>
                                        <th>Stay-Type</th>
                                        <th>Stay-Duration</th>
                                        <th>Pick-Up Location</th>
                                        <th colspan="3">Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $bookingRecords = $operation->retrieveAllRecords("bookings");
                                    if (!empty($bookingRecords)) {
                                        $count = 0;
                                        foreach ($bookingRecords as $row) {
                                            $count++;
                                    ?>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row["bookingID"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["mobileNo"]; ?></td>
                                            <td><?php echo $row["roomType"]; ?></td>
                                            <td><?php echo $row["checkInDate"]; ?></td>
                                            <td><?php echo $row["checkInTime"]; ?></td>
                                            <td><?php echo $row["stayType"]; ?></td>
                                            <td><?php echo $row["stayDuration"]; ?></td>
                                            <td><?php echo $row["pickUpLocation"]; ?></td>
                                            <td class="btn-group">
                                                <a href="assign_reservation.php?bookingID=<?php echo $row["bookingID"]; ?>" class="btn btn-success rounded btn-sm">Assign</a>
                                                <a href="admin_rescheduled_reservation.php?bookingData=<?php echo urlencode(serialize($row)); ?>" class="btn btn-primary rounded btn-sm">Reschedule</a>
                                                <a href="cancel_reservation.php?bookingID=<?php echo $row["bookingID"]; ?>" class="btn btn-danger rounded btn-sm">Cancel</a>
                                            </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="13">No records found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- Assigned Bookings Table Modal -->
    <div class="modal fade" id="showAssignedBookingsTableModal" tabindex="-1" aria-labelledby="showAssignedBookingsTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showAssignedBookingsTableModalLabel"><strong>Assigned Bookings</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class=modal-body scrollable-container">
                    <section class="wrapper-main">
                        <!-- List Booking Record -->
                        <div class="container-fluid table-wrapper">
                            <table class="table table-striped table-bordered mt-4">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S/n</th>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Room-Type</th>
                                        <th>CID</th>
                                        <th>CIT</th>
                                        <th>Stay-Type</th>
                                        <th>Stay-Duration</th>
                                        <th>Pick-Up Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $assignedBooking = $operation->retrieveAllRecords("customerservice");
                                    if (!empty($assignedBooking)) {
                                        $count = 0;
                                        foreach ($assignedBooking as $row) {
                                            $count++;
                                    ?>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row["bookingID"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["mobileNo"]; ?></td>
                                            <td><?php echo $row["roomType"]; ?></td>
                                            <td><?php echo $row["checkInDate"]; ?></td>
                                            <td><?php echo $row["checkInTime"]; ?></td>
                                            <td><?php echo $row["stayType"]; ?></td>
                                            <td><?php echo $row["stayDuration"]; ?></td>
                                            <td><?php echo $row["pickUpLocation"]; ?></td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="12">No records found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- Rescheduled Bookings Table Modal -->
    <div class="modal fade" id="showRescheduledBookingsTableModal" tabindex="-1" aria-labelledby="showRescheduledBookingsTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showRescheduledBookingsTableModalLabel"><strong>Rescheduled Bookings</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class=modal-body scrollable-container">
                    <section class="wrapper-main">
                        <!-- List Booking Record -->
                        <div class="container-fluid table-wrapper">
                            <table class="table table-striped table-bordered mt-4">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S/n</th>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Room-Type</th>
                                        <th>CID</th>
                                        <th>CIT</th>
                                        <th>Stay-Type</th>
                                        <th>Stay-Duration</th>
                                        <th>Pick-Up Location</th>
                                        <th>Count</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rescheduledBooking = $operation->retrieveAllRecords("rescheduledbookings");
                                    if (!empty($rescheduledBooking)) {
                                        $count = 0;
                                        foreach ($rescheduledBooking as $row) {
                                            $count++;
                                    ?>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row["bookingID"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["mobileNo"]; ?></td>
                                            <td><?php echo $row["roomType"]; ?></td>
                                            <td><?php echo $row["checkInDate"]; ?></td>
                                            <td><?php echo $row["checkInTime"]; ?></td>
                                            <td><?php echo $row["stayType"]; ?></td>
                                            <td><?php echo $row["stayDuration"]; ?></td>
                                            <td><?php echo $row["pickUpLocation"]; ?></td>
                                            <td><?php echo $row["count"]; ?>/2</td>
                                            <td class="btn-group">
                                                <a href="admin_rescheduled_reservation.php?bookingData=<?php echo urlencode(serialize($row)); ?>" class="btn btn-primary rounded btn-sm">Reschedule</a>
                                            </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="13">No records found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- Cancelled Bookings Table Modal -->
    <div class="modal fade" id="showCancelledBookingsTableModal" tabindex="-1" aria-labelledby="showCancelledBookingsTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showCancelledBookingsTableModalLabel"><strong>Cancelled Bookings</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class=modal-body scrollable-container">
                    <section class="wrapper-main">
                        <!-- List Booking Record -->
                        <div class="container-fluid table-wrapper">
                            <table class="table table-striped table-bordered mt-4">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S/n</th>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Room-Type</th>
                                        <th>CID</th>
                                        <th>CIT</th>
                                        <th>Stay-Type</th>
                                        <th>Stay-Duration</th>
                                        <th>Pick-Up Location</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cancelledBooking = $operation->retrieveAllRecords("cancelledbookings");
                                    if (!empty($cancelledBooking)) {
                                        $count = 0;
                                        foreach ($cancelledBooking as $row) {
                                            $count++;
                                    ?>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row["bookingID"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["mobileNo"]; ?></td>
                                            <td><?php echo $row["roomType"]; ?></td>
                                            <td><?php echo $row["checkInDate"]; ?></td>
                                            <td><?php echo $row["checkInTime"]; ?></td>
                                            <td><?php echo $row["stayType"]; ?></td>
                                            <td><?php echo $row["stayDuration"]; ?></td>
                                            <td><?php echo $row["pickUpLocation"]; ?></td>
                                            <td class="btn-group">
                                                <a href="restore_reservation.php?bookingID=<?php echo $row["bookingID"]; ?>" class="btn btn-primary rounded btn-sm">Restore</a>
                                            </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="12">No records found.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>

</html>