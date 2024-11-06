<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Access denied");
}

$conn = new mysqli('localhost', 'root', '', 'water_monitor');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Get the consumption data from the AJAX request
$liveConsumption = isset($_POST['live_consumption']) ? $_POST['live_consumption'] : 0;
$monthlyConsumption = isset($_POST['monthly_consumption']) ? $_POST['monthly_consumption'] : 0;
$averageConsumption = isset($_POST['average_consumption']) ? $_POST['average_consumption'] : 0;
$yearlyConsumption = isset($_POST['yearly_consumption']) ? $_POST['yearly_consumption'] : 0;

// Update the user's water consumption data in the database
$sql = "UPDATE users SET 
    live_consumption = ?, 
    monthly_consumption = ?, 
    average_consumption = ?, 
    yearly_consumption = ?
    WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("dddds", $liveConsumption, $monthlyConsumption, $averageConsumption, $yearlyConsumption, $username);

if ($stmt->execute()) {
    echo "Data updated successfully";
} else {
    echo "Error updating data: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
