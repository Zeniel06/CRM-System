<?php
session_start(); // Start session

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Get logged-in user's ID
    $name = $_POST['name'];
    $company = !empty($_POST['company']) ? $_POST['company'] : NULL; // Optional field
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $notes = !empty($_POST['notes']) ? $_POST['notes'] : NULL; // Optional field

    // Insert data into lead table
    $sql = "INSERT INTO `lead` (user_id, name, company, email, phone_num, status, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $name, $company, $email, $phone, $status, $notes);

    if ($stmt->execute()) {
        echo "<script>alert('Lead added successfully!'); window.location.href='salesrep-lead.php';</script>";
    } else {
        echo "<script>alert('Error adding lead: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Lead</title>
    <link rel="stylesheet" href="../general/styles/header.css">
    <link rel="stylesheet" href="../general/styles/style.css">
    <link rel="stylesheet" href="../general/styles/menu.css">
    <link rel="stylesheet" href="../general/styles/table.css">
    <link rel="stylesheet" href="../general/styles/back-button.css">
    <link rel="stylesheet" href="styles/form.css">
</head>
<body>
    <div class="back-button">
        <a href="salesrep-lead.php">
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
        <h2>Add New Lead</h2>
        <form action="add-new-lead.php" method="POST">
            <input placeholder="Name" type="text" id="name" name="name" required><br><br>
            <input placeholder="Company" type="text" id="company" name="company"><br><br>
            <input placeholder="Email" type="email" id="email" name="email" required><br><br>
            <input placeholder="Phone Number" type="text" id="phone" name="phone" required><br><br>
            <select id="status" name="status" required>
                <option value="" disabled selected>Status</option>
                <option value="New">New</option>
                <option value="Contacted">Contacted</option>
                <option value="In Progress">In Progress</option>
                <option value="Closed">Closed</option>
            </select><br><br>
            <input placeholder="Notes" type="text" id="notes" name="notes"><br><br>
            <button class="add-user-button" type="submit">Add New Lead</button>
        </form>
    </div>

    <script src="../general/scripts/header-admin.js"></script>
    <script src="../general/scripts/menu-animation.js"></script>
</body>
</html>
