<?php
session_start(); // Ensure session is started

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Sales Representative') {
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

// Get logged-in sales representative ID
$sales_id = $_SESSION['user_id'];

// Fetch customers only assigned to the logged-in sales rep
$sql = "SELECT customer_id, user_id, name, company, email, phone_num FROM customer WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sales_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Representative</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../general/styles/style.css">
    <link rel="stylesheet" href="../general/styles/header.css">
    <link rel="stylesheet" href="../general/styles/menu.css">
    <link rel="stylesheet" href="../general/styles/table.css">
</head>
<body>
    <div class="header"></div>

    <div class="menu">
        <div class="menu-content">
            <div class="menu-input">
                <input type="text" placeholder="Search">
            </div>
            
            <div class="menu-item">
                <a href="salesrep-lead.php">Lead Management</a>
            </div>
        </div>
    </div>

    <div class="welcome">
        <p>Customers</p>
    </div>

    <div class="container">
        <div class="table-header">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search customers..." onkeyup="filterCustomers()">
            </div>
        </div>

        <table id="customerTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Interactions</th>
                    <th>Update</th>
                    <th>Delete</th>
                    <th>Set Reminder</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['customer_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['company']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone_num']}</td>
                            <td>
                                <a href='cust-interaction.php?customer_id={$row['customer_id']}'>
                                    <button class='viewButton'>View</button>
                                </a>
                            </td>
                            <td><button class='viewButton' onclick='updateCustomer({$row['customer_id']})'>Update</button></td>
                            <td><button class='viewButton delButton' onclick='deleteCustomer({$row['customer_id']})'>Delete</button></td>
                            <td><button class='viewButton setReminderButton' onclick='setReminder({$row['customer_id']})'>Set Reminder</button></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align: center;'>No customers found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="table-actions">
            <a class="addButton" href="addcust.php">Add</a>
        </div>
    </div>

    <script src="../general/scripts/header-customer.js"></script>
    <script src="../general/scripts/menu-animation.js"></script>
    <script src="../general/scripts/exit-control.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
