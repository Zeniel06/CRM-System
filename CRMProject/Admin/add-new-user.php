<?php

$servername = "127.0.0.1";
$username = "root";
$password = "abcd"; // Change if needed
$dbname = "crmsystem";
$port=3311;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $role_id = ($role == 'Admin') ? 1 : 2;

    $sql = "INSERT INTO user (username, password, name, email, phone_num, role_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $password, $name, $email, $phone, $role_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User added successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error adding user: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add New User</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../general/styles/header.css">
        <link rel="stylesheet" href="../general/styles/style.css">
        <link rel="stylesheet" href="../general/styles/menu.css">
        <link rel="stylesheet" href="../general/styles/table.css">
        <link rel="stylesheet" href="../general/styles/back-button.css">
        <link rel="">
        <link rel="stylesheet" href="styles/form.css">
    </head>
    <body>
        <div class="back-button">
            <a href="admin.php">
                <img class="return-icon" src="../general/menu-images/return-icon.png">
            </a>
        </div>

        <div class="header">

        </div>

        <div class="menu">
            <div class="menu-content">
                <div class="menu-input">
                    <input type = "text" placeholder="Search">
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
            <h2>Add New User</h2>
            <form action="" method="POST">
                <input placeholder="Username" type="text" id="username" name="username" required><br><br>

                <input placeholder="Password" type="password" id="password" name="password" required><br><br>

                <input placeholder="Name" type="text" id="name" name="name" required><br><br>
        
                <input placeholder="Email" type="email" id="email" name="email" required><br><br>
        
                <input placeholder="Phone Number" type="text" id="phone" name="phone" required><br><br>

                <select id="role" name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="Sales Representative">Sales Representative</option>
                </select><br><br>
        
                <button class="add-user-button" type="submit">Add User</button>
            </form>
        </div>

        <script src="../general/scripts/header-admin.js"></script>
        <script src="../general/scripts/menu-animation.js"></script>
    </body>
</html>
