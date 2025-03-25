<?php
session_start(); // Start session

// Check if user is logged in and is a Sales Representative
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Sales Representative') {
    header("Location: signin.php"); // Redirect to login if not authenticated
    exit();
}

$servername = "127.0.0.1";
$username = "root";
$password = "abcd"; // Change if needed
$dbname = "crmsystem";
$port = 3311;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get sales rep ID from session
$salesrep_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $company = trim($_POST['company']);

    // Insert data into the customer table with the sales_id
    $stmt = $conn->prepare("INSERT INTO customer (name, email, phone_num, company, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $email, $phone, $company, $salesrep_id);

    if ($stmt->execute()) {
        echo "<script>alert('Customer added successfully!'); window.location.href='salesrep-hp.php';</script>";
    } else {
        echo "<script>alert('Error adding customer.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Customer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../general/styles/header.css">
    <link rel="stylesheet" href="../general/styles/style.css">
    <link rel="stylesheet" href="../general/styles/menu.css">
    <link rel="stylesheet" href="../general/styles/table.css">
    <link rel="stylesheet" href="../general/styles/back-button.css">
    <link rel="stylesheet" href="styles/form.css">
</head>
<body>
    <div class="back-button">
        <a href="salesrep-hp.php">
            <img class="return-icon" src="../general/menu-images/return-icon.png">
        </a>
    </div>

    <div class="header"></div>

    <div class="menu">
        <div class="menu-content">
            <div class="menu-input">
                <input type="text" placeholder="Search">
            </div>

            <div class="menu-item">
                <a href="">Customer Management</a>
            </div>

            <div class="menu-item">
                <a href="">Lead Management</a>
            </div>
        </div>
    </div>

    <div class="add-user-form-container">
        <h2>Add New Customer</h2>
        <form action="" method="POST">
            <input placeholder="Name" type="text" name="name" required><br><br>
            <input placeholder="Email" type="email" name="email" required><br><br>
            <input placeholder="Phone Number" type="text" name="phone" required><br><br>
            <input placeholder="Company" type="text" name="company" required><br><br>
            <button class="add-user-button" type="submit">Add New Customer</button>
        </form>
    </div>

    <script src="../general/scripts/header-admin.js"></script>
    <script src="../general/scripts/menu-animation.js"></script>
</body>
</html>
