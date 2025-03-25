<?php
session_start(); // Start session to check if user is logged in

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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : null; // Get customer_id if set

// Fetch customer interactions for the specific customer if selected, otherwise show all assigned to sales rep
if ($customer_id) {
    $sql = "SELECT interaction_id, interaction_type, description, date FROM customerinteraction WHERE user_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $customer_id);
} else {
    $sql = "SELECT interaction_id, customer_id, interaction_type, description, date FROM customerinteraction WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Interaction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../general/styles/style.css">
    <link rel="stylesheet" href="../general/styles/header.css">
    <link rel="stylesheet" href="../general/styles/menu.css">
    <link rel="stylesheet" href="../general/styles/table.css">
    <link rel="stylesheet" href="../general/styles/back-button.css">
</head>
<body>
    <div class="back-button">
        <a href="salesrep-hp.php">
            <img class="return-icon" src="../general/menu-images/return-icon.png" alt="Back">
        </a>
    </div>

    <div class="header"></div>

    <div class="menu">
        <div class="menu-content">
            <div class="menu-input">
                <input type="text" placeholder="Search">
            </div>
            <div class="menu-item">
                <a href="salesrep-hp.php">Home</a>
            </div>
        </div>
    </div>

    <div class="welcome">
        <p>Customer Interactions</p>
    </div>

    <div class="container">
        <div class="table-header">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search interactions">
            </div>
        </div>

        <table id="customerTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Interaction Type</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["interaction_id"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["interaction_type"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                        echo "<td>
                                <a href='customer-interaction.php?customer_id=" . $row['customer_id'] . "'>
                                    <button class='viewButton'>View</button>
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No customer interactions found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="table-actions">
            <a class="addButton" href="add-new-interaction.php">Add</a>
        </div>
    </div>

    <script src="../general/scripts/header-customer.js"></script>
    <script src="../general/scripts/menu-animation.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
