<?php

function createDatabase()
{
    /**
     * Establish Connection
     * Create Database
     */
    // Establish Connection
    $serverName = "localhost";
    $userName = "root";
    $password = "";

    $connection = new mysqli($serverName, $userName, $password);
    if ($connection->connect_error) {
        die($connection->connect_error . PHP_EOL);
    }

    // Create Database
    $sql_query = "CREATE DATABASE hotelreservation";
    $connection->query($sql_query);
}

function connection(): mysqli
{
    /**
     * Source resource: Connection Object
     * Provide resource: Connection Object
     */
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $database = "hotelreservation";

    $connection = new mysqli($serverName, $userName, $password, $database);
    if ($connection->connect_error) {
        die($connection->connect_error . PHP_EOL);
    }

    return $connection; // Provide resource
}
