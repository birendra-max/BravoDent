<?php
session_start();
include 'connect.php';
header('Content-Type: text/plain');

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if ($data != '') {

    $name = $bd->real_escape_string($_SESSION['name']);
    $email = $bd->real_escape_string($_SESSION['email']);
    $labname = $bd->real_escape_string($_SESSION['labname']);
    $message = $data;


    $sql = "INSERT INTO feedback (user_name, user_email, lab_name, feedback) 
            VALUES ('$name', '$email', '$labname', '$message')";

    if ($bd->query($sql) === TRUE) {
        echo "Feedback received. Thank you!";
    } else {
        http_response_code(500);
        echo "Database error: " . $conn->error;
    }
} else {
    http_response_code(400);
    echo "No valid feedback entered or session data missing.";
}
