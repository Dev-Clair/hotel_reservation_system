<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bookings_database_controller.php'; // Import Database File
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
        <!-- Button trigger modal -->
        <button type="button" class="btn-primary rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showTableModal">Bookings
        </button>
        <!-- Button trigger modal -->
        <button type="button" class="btn-success rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showTableModal">Assigned
        </button>
        <!-- Button trigger modal -->
        <button type="button" class="btn-warning rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showTableModal">Rescheduled
        </button>
        <!-- Button trigger modal -->
        <button type="button" class="btn-danger rounded my-3 mb-3" data-bs-toggle="modal" data-bs-target="#showTableModal">Cancelled
        </button>
    </div>

    <h1>Booking Records</h1>

    <!-- Table Modal -->
    <div class="modal fade" id="showTableModal" tabindex="-1" aria-labelledby="showTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showTableModalLabel"><strong>Create Service</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class=modal-body scrollable-container">
                    <!-- Table goes here -->
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
                                    $bookingRecords = readAllBookings();
                                    if (!empty($bookingRecords)) {
                                        $count = 0;
                                        foreach ($bookingRecords as $row) {
                                            $count++;
                                    ?>
                                            <>
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
                                                    <a href="reschedule_reservation.php?bookingID=<?php echo $row["bookingID"]; ?>" class="btn btn-primary rounded btn-sm">Reschedule</a>
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
    <footer>
        <div class="bottomleft-container">
            <p class="copyright">
                &copy; jagaad_group_2 class 2023
            </p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>