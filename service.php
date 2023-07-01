<?php

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

// ***************************************** Function: Validating and Cleaning Userinputs ******************************************
function validate_serviceID(string $serviceID): bool
{
    /**
     * @param string $serviceID
     * returns bool
     */
    $serviceID = strtoupper(trim(htmlspecialchars($serviceID))); // remove whitespaces and language tags
    $validserviceID = ["RM", "EH", "CR", "PP"]; // define an array of allowed values
    return in_array($serviceID, $validserviceID); // returns true if argument is in allowed list of values
}

function validate_serviceStatus(string $serviceStatus): bool
{
    /**
     * @param string $serviceStatus
     * returns bool
     */
    $serviceStatus = trim(htmlspecialchars($serviceStatus)); // remove whitespaces and language tags
    $validserviceStatus = ["available", "unavailable", "closed"]; // define an array of allowed values
    return in_array($serviceStatus, $validserviceStatus); // returns true if argument is in allowed list of values
}

function clean_userInput(string $userinput): string
{
    /**
     * @param string $userinput
     * return string
     */
    if (is_string($userinput)) {
        $userinput = ucfirst(trim(htmlspecialchars($userinput))); // remove whitespaces and language tags
        return $userinput;
    }
    $userinput = "";
    return $userinput;
}

// ***************************************** Form Handling ******************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //  Retrieve aand clean form field values
    $serviceID = $_POST['serviceID'];
    $serviceName = clean_userInput($_POST['serviceName']);
    $serviceDescription = clean_userInput($_POST['serviceDescription']);
    $servicePrice = $_POST['servicePrice'];
    $serviceStatus = $_POST['serviceStatus'];

    // Validate and Clean Userinputs
    $errors = [];
    if (!validate_serviceID($serviceID))
        $errors[] = "Invalid Service ID! Please enter a valid ID.";
    if (!validate_serviceStatus($serviceStatus))
        $errors[] = "Invalid! Selection doesn't exist.";

    // Check for Errors and redirect to  reviews.php with error message
    if (!empty($errors)) {
        $errorMessage = implode("", $errors);
        $address = "Location: service.php?serviceErrorMessage=" . urlencode($errorMessage);
        // ob_end_flush();
        header($address);
        exit();
    }

    // Create an array of values for each customer review
    $newService = array(
        "serviceID" => $serviceID,
        "serviceName" => $serviceName,
        "serviceDescription" => $serviceDescription,
        "servicePrice" => (int)$servicePrice,
        "serviceStatus" => $serviceStatus
    );

    $status = $operation->createRecords("s", $newService); // Add review to database

    if ($status === true) {
        // Redirect to reviews.php with success message
        $successMessage = "Success! Service added successfully.";
        $address = "Location: service.php?serviceSuccessMessage=" . urlencode($successMessage);
        // ob_end_flush();
        header($address);
        exit();
    }
    $errorMessage = "Error! Please try again.";
    $address = "Location: service.php?serviceErrorMessage=" . urlencode($errorMessage);
    // ob_end_flush();
    header($address);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="reviewstyles.css">
    <title>Create Reservation Service</title>
</head>

<body class="container-fluid">
    <div class="mt-4 mb-0">
        <header>
            <div class="left-container">
                <img src="img/water.png" alt="" />
                <!-- <a href=" https://www.flaticon.com/free-icons/architecture-and-city" - Flaticon></a>" -->
            </div>
            <div class="right-container">
                <div>
                    <a href="reviews.php" class="btn btn-sm btn-danger rounded">
                        back to Reviews
                    </a>
                </div>
            </div>
        </header>

        <?php
        if (isset($_GET['serviceSuccessMessage'])) {
            $successMessage = $_GET['serviceSuccessMessage'];
            echo '<div class="alert alert-success">' . $successMessage . '</div>';
        }
        ?>
        <?php
        if (isset($_GET['serviceErrorMessage'])) {
            $errorMessage = $_GET['serviceErrorMessage'];
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>

        <main class="wrapper-main">
            <!-- List Product Table -->
            <div class="container table-wrapper">
                <div class="float-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                        Create Service
                    </button>
                </div>
                <table class="table table-striped table-bordered mt-4">
                    <thead class="thead-dark">
                        <tr>
                            <th>S/n</th>
                            <th>Service ID</th>
                            <th>Service Name</th>
                            <th>Service Description</th>
                            <th>Service Price</th>
                            <th>Service Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $service = $operation->retrieveAllRecords("services");
                        if (!empty($service)) {
                            foreach ($service as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["serviceID"]; ?></td>
                                    <td><?php echo $row["serviceName"]; ?></td>
                                    <td><?php echo $row["serviceDescription"]; ?></td>
                                    <td><?php echo $row["servicePrice"]; ?></td>
                                    <td><?php echo $row["serviceStatus"]; ?></td>
                                    <td class="btn-group">
                                        <a href="update.php?serviceID=<?php echo $row["serviceID"]; ?>" class="btn btn-primary btn-sm ms-2">Update</a>
                                        <a href="admin.php?action=delete&serviceID=<?php echo $row["serviceID"]; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7">No records found.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

    </div>

    <!-- New Product Modal -->
    <div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createServiceModalLabel"><strong>Create Service</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="serviceForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="serviceID"><strong>Service ID:</strong></label>
                            <input type="text" class="form-control mb-2" id="serviceID" name="serviceID" autocomplete="off" placeholder="Enter service ID" />
                        </div>
                        <div class="form-group">
                            <label for="serviceName"><strong>Service Name:</strong></label>
                            <input type="text" class="form-control mb-2" id="serviceName" name="serviceName" autocomplete="off" placeholder="Enter service name" />
                        </div>
                        <div class="form-group">
                            <label for="serviceDescription"><strong>Service Description:</strong></label>
                            <textarea class="form-control mb-2" id="serviceDescription" name="serviceDescription" rows="3" autocomplete="off" placeholder="Enter service description" maxlength="150"></textarea>
                        </div>
                        <div class=" form-group">
                            <label for="servicePrice"><strong>Average Service Price:</strong></label>
                            <input type="text" class="form-control mb-2" id="servicePrice" name="servicePrice" autocomplete="off" placeholder="Enter service price" />
                        </div>
                        <div class=" form-group">
                            <label for="serviceStatus"><strong>Service Status:</strong></label>
                            <select class="form-control mb-2" id="serviceStatus" name="serviceStatus">
                                <option value="">--Click to Select--</option>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        <button type="submit" class="float-end btn btn-primary">
                            Submit
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>