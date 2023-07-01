<?php

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "hotelreservation");
$conn = $connection->getConnection();
$operation = new DatabaseTableOperations($conn);

$tableFields = ['reviews.name', 'reviews.rating', 'reviews.reviews', 'reviews.datecreated'];

$joins = [
  [
    'type' => 'INNER',
    'table' => 'services',
  ],
  [
    'type' => 'INNER',
    'table' => 'bookings',
  ],
];

$joinConditions = ['reviews.serviceID = services.serviceID', 'reviews.email = bookings.email'];

$validreviews = $operation->retrieveTableReport("reviews", $tableFields, $joins, $joinConditions);

// ***************************************** Function: Validating and Cleaning Userinputs ******************************************
function validate_name(string $name): bool
{
  /**
   * @param string $name
   * returns bool
   */
  $name = ucwords(trim(htmlspecialchars(($name))));
  return preg_match('/^[a-zA-Z ]+$/', $name); // returns true if argument matches regex pattern
}

function validate_email(string $email): bool
{
  /**
   * @param string $email
   * returns bool
   */
  return filter_var(htmlspecialchars($email), FILTER_VALIDATE_EMAIL); // returns true if argument is a valid email address
}

function validate_serviceType(string $serviceType): bool
{
  /**
   * @param string $serviceType
   * returns bool
   */
  $serviceType = trim(htmlspecialchars($serviceType)); // remove whitespaces and language tags
  $validserviceType = ["RM", "EH", "CR", "PP"]; // define an array of allowed values
  return in_array($serviceType, $validserviceType); // returns true if argument is in allowed list of values
}

function clean_review(string $review): string
{
  /**
   * @param string $review
   * return string
   */
  if (is_string($review)) {
    $review = ucfirst(trim(htmlspecialchars($review))); // remove whitespaces and language tags
    return $review;
  }
  $review = "";
  return $review;
}

// ***************************************** Form Handling ******************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //  Retrieve form field values
  $name = clean_review($_POST['customerName']);
  $email = $_POST['customerEmail'];
  $serviceType = $_POST['serviceType'];
  $rating = $_POST['reviewRating'];
  $review = clean_review($_POST['reviewText']);

  // Validate and Clean Userinputs
  $errors = [];
  if (!validate_name($name))
    $errors[] = "Invalid Name! Please enter a valid name without numbers or meta-characters.";
  if (!validate_email($email))
    $errors[] = "Invalid Email! Please enter a valid email address.";
  if (!validate_serviceType($serviceType))
    $errors[] = "Invalid! Selection doesn't exist.";

  // Check for Errors and redirect to  reviews.php with error message
  if (!empty($errors)) {
    $errorMessage = implode("", $errors);
    $address = "Location: reviews.php?reviewErrorMessage=" . urlencode($errorMessage);
    // ob_end_flush();
    header($address);
    exit();
  }

  // Create an array of values for each customer review
  $newReview = array(
    "name" => $name,
    "email" => $email,
    "serviceID" => $serviceType,
    "rating" => (int)$rating,
    "review" => $review
  );

  $status = $operation->createRecords("reviews", $newReview); // Add review to database

  if ($status === true) {
    // Redirect to reviews.php with success message
    $successMessage = "Thanks for the feedback! We hope to continue putting a smile on your face.";
    $address = "Location: reviews.php?reviewSuccessMessage=" . urlencode($successMessage);
    // ob_end_flush();
    header($address);
    exit();
  }
  $errorMessage = "Error! Please try again.";
  $address = "Location: reviews.php?reviewErrorMessage=" . urlencode($errorMessage);
  // ob_end_flush();
  header($address);
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Review</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="reviewstyles.css" />
</head>

<body class="container-fluid">
  <div class="mt-4 mb-0">
    <header>
      <div class=" left-container">
        <img src="water.png" alt="" />
        <!-- <a href=" https://www.flaticon.com/free-icons/architecture-and-city" - Flaticon></a>" -->
      </div>
      <div class="right-container">
        <div>
          <form method="post" action="">
            <input type="text" class="rounded" id="userId" name="userId" placeholder="Enter email" autocomplete="off" />
            <input type="password" class="rounded" id="userPassword" name="password" placeholder="Enter password" />
            <button type="submit" class=" btn btn-sm btn-primary rounded">
              Log in
            </button>
          </form>
        </div>
      </div>
    </header>

    <!-- Check Review Success and Error Alert -->
    <?php
    if (isset($_GET['reviewSuccessMessage'])) {
      $successMessage = $_GET['reviewSuccessMessage'];
      echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <?php
    if (isset($_GET['reviewErrorMessage'])) {
      $errorMessage = $_GET['reviewErrorMessage'];
      echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>

    <main>
      <div class="row">
        <div id="reviewSubmission" class="leftform-container">
          <h4>Add Review</h4>
          <span class="welcome-note"><em>All reviews and ratings are valid and are from people who have
              used our reservation service</em></span>
          <hr />
          <form id="reviewForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
              <label for="customerName"><strong>Name:</strong></label>
              <input type="text" class="form-control" id="customerName" name="customerName" autocomplete="off" placeholder="Please enter your name" />
            </div>
            <div class="form-group">
              <label for="customerEmail"><strong>Email:</strong></label>
              <input type="email" class="form-control" id="customerEmail" name="customerEmail" autocomplete="off" placeholder="Please enter your email address" />
            </div>
            <div class="form-group">
              <label for="serviceType"><strong>Select Reservation Type:</strong></label>
              <select class="form-control" id="serviceType" name="serviceType">
                <option value="">--Click to Select--</option>
                <option value="RM">Room</option>
                <option value="EH">Event Hall</option>
                <option value="CR">Conference Room</option>
                <option value="PP">Private Pool</option>
              </select>
            </div>
            <div class="form-row">
              <div class="left-container">
                <label><strong>Review:</strong></label>
              </div>
              <div class="right-container">
                <div class="star-rating">
                  <i class="star far fa-star" data-rating-value="1"></i>
                  <i class="star far fa-star" data-rating-value="2"></i>
                  <i class="star far fa-star" data-rating-value="3"></i>
                  <i class="star far fa-star" data-rating-value="4"></i>
                  <i class="star far fa-star" data-rating-value="5"></i>

                  <input type="hidden" name="reviewRating" id="reviewRating" value="" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="reviewText" rows="3" autocomplete="off" placeholder="Kindly describe your reservation experience" maxlength="150"></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </form>
        </div>
        <div class="rightform-container">
          <h4>Reservation Ratings & Reviews</h4>
          <div id="reviewReport">
            <!-- Review report will be dynamically generated here -->
            <?php
            if (!empty($validreviews)) {
              foreach ($validreviews as $review) {
            ?>
                <div class="review-card">
                  <div class="review-header">
                    <div class="review-name"><?php echo $review["name"]; ?></div>
                    <div class="review-rating"><strong>Rating:</strong> <?php echo $review["rating"]; ?>/5</div>
                    <div class="review-date"><strong>Date:</strong> <?php echo isset($review["dateupdated"]) ? $review["dateupdated"] : $review["datecreated"]; ?></div>
                  </div>
                  <div class="review-text"><?php echo $review["reviews"]; ?></div>
                </div>
            <?php
              }
            } else {
              echo "<p>No reviews found.</p>";
            }
            ?>
          </div>
        </div>

      </div>
    </main>

  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".star").click(function() {
        var rating = $(this).data("rating-value");
        $("#reviewRating").val(rating);

        $(".star").removeClass("fas").addClass("far"); // Reset all stars to white
        $(this).prevAll(".star").removeClass("far").addClass("fas"); // Change previous stars to gold
        $(this).removeClass("far").addClass("fas"); // Change clicked star to gold
      });
    });
  </script>

</body>

</html>