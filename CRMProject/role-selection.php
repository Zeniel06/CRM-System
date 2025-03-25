<?php
session_start();
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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $error_message = "No user found. Please register first.";
    header("Location: registration.php");
    exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $role_id = $_POST['role'];

    if (!empty($role_id)) {
        // Update role_id for the user
        $sql = "UPDATE user SET role_id = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $role_id, $user_id);

        if ($stmt->execute()) {
            header("Location: successful-register.php");
            exit();
        } else {
            $error_message = "Error updating record: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error_message = "Please select a role.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Role Selection</title>
    <link rel="stylesheet" href="styles/roleselection.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="crm-logo-container">
            <img class="crm-logo" src="hp-reg-images/hp-logo.png">
        </div>
        <div class="instruction-container">
            <h2>Please select a role</h2>
        </div>

        <form method="POST" action="">
            <div class="new-data-input">
                <label for="role">Choose Role:</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Sales Representative</option>
                </select>
            </div>

            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <div class="continue-container">
                <button type="submit" class="continue-button">Continue</button>
            </div>
        </form>
    </div>
</body>
</html>

