<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "abcd"; // Change if needed
$dbname = "crmsystem";
$port=3311;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST['username']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pass = trim($_POST['password']);

    // Check if username or email exists
    $sql = "SELECT * FROM user WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username or Email already exists!";
    } else {
        // Insert new user with NULL role_id
        $sql = "INSERT INTO user (username, name, email, password, phone_num, role_id) VALUES (?, ?, ?, ?, ?, NULL)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $user, $name, $email, $pass, $phone);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            header("Location: role-selection.php");
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="/CRMProject/styles/registration.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="crm-logo-container">
            <img class="crm-logo" src="/CRMProject/hp-reg-images/hp-logo.png">
        </div>
        <div class="instruction-container">
            <h2>Register a new account with your name, phone number and email to use the service</h2>
        </div>
        
        <form id="registrationForm" method="POST" action="">
            <div class="new-data-input">
                <input class="input-field" type="username" name="username" placeholder="Username" required>
                <input class="input-field" type="name" name="name" placeholder="Name" required>
                <input class="input-field" type="email" name="email" placeholder="Email" required>
                <input class="input-field" type="phone" name="phone" placeholder="Phone Number" required>
                <input class="input-field" type="password" name="password" placeholder="Password" required>
            </div>

            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <div class="continue-container">
                <button type="submit" class="continue-button-inactive">Continue</button>
            </div>
        </form>
    </div>

    <script src="/CRMProject/scripts/registration.js"></script>
</body>
</html>