<?php
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

$sql = "SELECT user_id, username, name, email, phone_num FROM user"; // Removed password
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin Home</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
                    <a href="all-customers.php">View All Customers</a>
                </div>
                <div class="menu-item">
                    <a href="all-leads.php">View All Leads</a>
                </div>
            </div>
        </div>

        <div class="welcome">
            <p>Users</p>
        </div>

        <div class="container">
            <div class="table-header">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search users">
                </div>
            </div>

            <table id="customerTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone_num']) . "</td>";
                            echo "<td><a href='update-user.php?id=" . $row['user_id'] . "' class='updateButton'>Update</a></td>";
                            echo "<td><a href='delete-user.php?id=" . $row['user_id'] . "' class='deleteButton' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>

            <div class="table-actions">
                <a href="add-new-user.php" class="addButton">Add</a>
            </div>
        </div>

        <script src="../general/scripts/header-admin.js"></script>
        <script src="../general/scripts/menu-animation.js"></script>
    </body>
</html>
