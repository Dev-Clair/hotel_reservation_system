<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

// Retrieve BookingID from Query String
$bookingID = (int)$_GET['bookingID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bookingstyles.css">
    <title>Reservation Ticket</title>
</head>

<body>
    <div class="container">
        <h1>Booking Ticket</h1>
        <?php
        // Retrieve booking information from database
        $bookingData = $operation->retrieveSingleRecord("bookings", "bookingID", $bookingID);

        if ($bookingData) {
            // Display booking details
            echo "<p><strong>Thank you! " . ucwords($bookingData['name']) . ",\n</strong></p>";
            echo "<p><strong>Booking-ID:</strong> $bookingID</p>";
            echo "<p><strong>Service Type:</strong> Room Reservation</p>";
            echo "<p><strong>Room Type:</strong> " . $bookingData['roomType'] . "</p>";
            echo "<p><strong>Room No.:</strong> " . "n/a" . "</p>";
            echo "<p><strong>Check-in Time:</strong> " . $bookingData['checkInTime'] . "</p>";
            echo "<p><strong>Check-in Date:</strong> " . $bookingData['checkInDate'] . "</p>";
        } else {
            echo "<p>Booking not found.</p>";
        }
        ?>
        <hr>
        <strong>Note:</strong>
        <ul>
            <li>Customer service will put a call across 3Hrs before Check-in Time</li>
            <li>You can reschedule your reservation via the rechedule option on the Home Page</li>
            <li>Please be aware that rescheduling becomes invalid an hour before Check-in Time</li>
            <li>Shortstay Customers can only reschedule twice after first booking. Failure to showup after the second reschedulling deems the contract as executed</li>
        </ul>
        <h5><em>See you Soon!!</em></h5>
        <button class="btn btn-success btn-sm rounded" onclick="window.print()">Print/Save</button>
        <a href="index.php" class="btn btn-primary btn-sm rounded" role="button">back to Home</a>
    </div>
</body>

</html>