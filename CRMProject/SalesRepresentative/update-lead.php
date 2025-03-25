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

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Check if lead ID is provided
if (!isset($_GET['id'])) {
    die("Lead ID is missing.");
}

$lead_id = $_GET['id'];

// Fetch existing lead data (only if it belongs to the logged-in user)
$sql = "SELECT name, company, email, phone_num, status, notes FROM `lead` WHERE lead_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $lead_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Lead not found or access denied.");
}

$lead = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $company = !empty($_POST['company']) ? $_POST['company'] : NULL; // Optional
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $notes = !empty($_POST['notes']) ? $_POST['notes'] : NULL; // Optional

    // Update lead in the database
    $update_sql = "UPDATE `lead` SET name = ?, company = ?, email = ?, phone_num = ?, status = ?, notes = ? WHERE lead_id = ? AND user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssii", $name, $company, $email, $phone, $status, $notes, $lead_id, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Lead updated successfully!'); window.location.href='salesrep-lead.php';</script>";
    } else {
        echo "<script>alert('Error updating lead: " . $update_stmt->error . "');</script>";
    }
    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Lead</title>
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
        <h2>Update Lead</h2>
        <form action="update-lead.php?id=<?= $lead_id ?>" method="POST">
            <input placeholder="Name" type="text" id="name" name="name" value="<?= htmlspecialchars($lead['name']) ?>" required><br><br>
            <input placeholder="Company" type="text" id="company" name="company" value="<?= htmlspecialchars($lead['company']) ?>"><br><br>
            <input placeholder="Email" type="email" id="email" name="email" value="<?= htmlspecialchars($lead['email']) ?>" required><br><br>
            <input placeholder="Phone Number" type="text" id="phone" name="phone" value="<?= htmlspecialchars($lead['phone_num']) ?>" required><br><br>
            <select id="status" name="status" required>
                <option value="New" <?= ($lead['status'] == 'New') ? 'selected' : '' ?>>New</option>
                <option value="Contacted" <?= ($lead['status'] == 'Contacted') ? 'selected' : '' ?>>Contacted</option>
                <option value="In Progress" <?= ($lead['status'] == 'In Progress') ? 'selected' : '' ?>>In Progress</option>
                <option value="Closed" <?= ($lead['status'] == 'Closed') ? 'selected' : '' ?>>Closed</option>
            </select><br><br>
            <input placeholder="Notes" type="text" id="notes" name="notes" value="<?= htmlspecialchars($lead['notes']) ?>"><br><br>
            <button class="add-user-button" type="submit">Update Lead</button>
        </form>
    </div>

    <script src="../general/scripts/header-admin.js"></script>
    <script src="../general/scripts/menu-animation.js"></script>
</body>
</html>
