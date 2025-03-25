<?php
session_start(); // Start session to get the logged-in user ID

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
    die("Access denied. Please log in."); // Prevent unauthorized access
}

$user_id = $_SESSION['user_id']; // Get the logged-in sales rep's ID

// Fetch only the leads assigned to the logged-in sales rep
$sql = "SELECT lead_id, name, company, email, phone_num, status, notes FROM `lead` WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leads</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../general/styles/header.css">
    <link rel="stylesheet" href="../general/styles/style.css">
    <link rel="stylesheet" href="../general/styles/menu.css">
    <link rel="stylesheet" href="../general/styles/table.css">
    <link rel="stylesheet" href="../general/styles/back-button.css">
</head>
<body>
    <div class="header"></div>

    <div class="menu">
        <div class="menu-content">
            <div class="menu-input">
                <input type="text" placeholder="Search">
            </div>
            <div class="menu-item">
                <a href="salesrep-hp.php">Customer Management</a>
            </div>
        </div>
    </div>

    <div class="welcome">
        <p>Leads</p>
    </div>

    <div class="container">
        <div class="table-header">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search leads">
            </div>
        </div>

        <table id="customerTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Update</th>
                    <th>Delete</th>
                    <th>Set Reminder</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["lead_id"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["company"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["phone_num"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["notes"]) . "</td>";
                        echo "<td><button class='viewButton' onclick='updateLead(" . $row["lead_id"] . ")'>Update</button></td>";
                        echo "<td><button class='viewButton delButton' onclick='deleteLead(" . $row["lead_id"] . ")'>Delete</button></td>";
                        echo "<td><button class='viewButton setReminderButton' onclick='setReminder(" . $row["lead_id"] . ")'>Set Reminder</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No leads found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="table-actions">
            <a class="addButton" href="add-new-lead.php">Add</a>
        </div>
    </div>

    <script src="../general/scripts/header-admin.js"></script>
    <script src="../general/scripts/menu-animation.js"></script>
    <script>
        function updateLead(id) {
            window.location.href = 'update-lead.php?id=' + id;
        }
        function deleteLead(id) {
            if (confirm('Are you sure you want to delete this lead?')) {
                window.location.href = 'delete-lead.php?id=' + id;
            }
        }
        function setReminder(id) {
            alert('Reminder set for lead ID: ' + id);
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
