<?php
session_start(); // Ensure session is active

$servername = "127.0.0.1";
$username = "root";
$password = "abcd";
$dbname = "crmsystem";
$port = 3311;

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

// Check if lead ID is provided
if (isset($_GET['id'])) {
    $lead_id = intval($_GET['id']); // Sanitize input
    $user_id = $_SESSION['user_id']; // Get logged-in user ID

    // First, delete any related records (e.g., reminders)
    $sql1 = "DELETE FROM leadreminder WHERE lead_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $lead_id);
    $stmt1->execute();
    $stmt1->close();

    // Now, delete the lead entry
    $sql2 = "DELETE FROM `lead` WHERE lead_id = ? AND user_id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ii", $lead_id, $user_id);

    if ($stmt2->execute()) {
        // Check if table is empty
        $result = $conn->query("SELECT COUNT(*) as count FROM `lead`");
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            // Reset auto-increment if table is empty
            $conn->query("ALTER TABLE `lead` AUTO_INCREMENT = 1");
        }

        echo "<script>alert('Lead deleted successfully!'); window.location.href='salesrep-lead.php';</script>";
    } else {
        echo "<script>alert('Error deleting lead: " . $stmt2->error . "'); window.location.href='salesrep-lead.php';</script>";
    }

    $stmt2->close();
} else {
    echo "<script>alert('Invalid lead ID.'); window.location.href='salesrep-lead.php';</script>";
}

$conn->close();
?>
