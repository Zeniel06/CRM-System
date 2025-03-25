<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: registration.php");
    exit();
}

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "abcd";
$dbname = "crmsystem";
$port=3311;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT role_id FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $role_id = $row['role_id'];
} else {
    header("Location: registration.php");
    exit();
}

$stmt->close();
$conn->close();

// Determine redirection URL
if ($role_id == 1) {
    $redirect_url = "Admin/admin.php";
} elseif ($role_id == 2) {
    $redirect_url = "SalesRepresentative/salesrep-hp.php";
} else {
    $redirect_url = "registration.php"; // Fallback
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>New User</title>
        <link rel="stylesheet" href="styles/successregister.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="crm-logo-container">
                <img class="crm-logo" src="hp-reg-images/hp-logo.png">
            </div>
            <div class="welcome-container">
                <h2 class="welcome-message">Welcome!</h2>
            </div>
            <div class="get-started-button-container">
                <button class="get-started-button" onclick="window.location.href='<?php echo $redirect_url; ?>'">Get Started</button>
            </div>
        </div>
    </body>
</html>
