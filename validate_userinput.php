<?php

function validate_roomType(string $roomType): bool
{
    /**
     * @param string $roomType
     * returns bool
     */
    $roomType = trim(htmlspecialchars($roomType)); // remove whitespaces and language tags
    $validRoomTypes = ["Regular", "Twin", "King", "Queen", "Deluxe", "Standard Suite", "Presidential Suite", "Cabana", "Pent Floor"]; // define an array of allowed values
    return in_array($roomType, $validRoomTypes); // returns true if argument is in allowed list of values
}

// function validate_checkInDate(string $checkInDate): bool
// {
//     /**
//      * @param string $checkInDate
//      * returns bool
//      */
// $checkInDate = trim(htmlspecialchars($checkInDate)); // remove whitespaces and language tags
//     if (false === strtotime($checkInDate)) // convert string to unix timestamp
//         return false;
//     list($day, $month, $year) = explode('/', $checkInDate); // using the list function assign the result of the explode function to the $day, $month and $year variables
//     return checkdate((int)$month, (int)$day, (int)$year); // returns true if arguments evaluate to a valid date
// }


function validate_stayType(string $stayType): bool
{
    /**
     * @param string $stayType
     * returns bool
     */
    $stayType = trim(htmlspecialchars($stayType)); // remove whitespaces and language tags
    $stayType_array = ["shortStay", "extendedStay"]; // define an array of allowed values
    return in_array($stayType, $stayType_array); // returns true if argument is in allowed list of values
}

function validate_stayDuration(string $stayDuration): bool
{
    /**
     * @param string $stayDuration
     * returns bool
     */
    $stayDuration = trim(htmlspecialchars($stayDuration)); // remove whitespaces and language tags
    $validStayDuration = ["1 day", "2 days", "3 days", "4 days", "5 days", "6 days", "1-2 weeks", "2-3 weeks", "1 month", "1-2 months"]; // define an array of allowed values
    return in_array($stayDuration, $validStayDuration); // returns true if argument is in allowed list of values
}

function validate_pickUpLocation(string $pickUpLocation): bool
{
    /**
     * @param string $pickUpLocation
     * return bool
     */
    $pickUpLocation = ucfirst(trim(htmlspecialchars($pickUpLocation))); // remove whitespaces and language tags
    return is_string($pickUpLocation); // returns true if argument is of type string
}

function validate_name(string $name): bool
{
    /**
     * @param string - $formatted_name
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

// function validate_mobileNo(string $mobile_no): bool
// {
//     /**
//      * @param string $mobile_no
//      * returns bool
//      */
//     return preg_match('/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}
//     /', $mobile_no); // returns true if argument matches regex pattern
// }


function redirect_to(string $page_name)
{
    /**
     * redirects to page name passed as argument
     * @param string - $page_name
     */
    $address = 'Location: ' . $page_name;
    return header($address);
    exit;
}
