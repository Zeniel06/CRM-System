<?php
session_start();

// Database connection
$host = '127.0.0.1';
$user = 'root';  
$pass = 'abcd';  
$dbname = 'crmsystem';
$port = 3311;

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query to check user credentials
    $sql = "SELECT user.user_id, user.username, role.role_name 
            FROM user 
            INNER JOIN role ON user.role_id = role.role_id 
            WHERE user.username = ? AND user.password = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Store user session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role_name'];

        // Redirect based on role
        if ($user['role_name'] === 'Admin') {
            header("Location: Admin/admin.php");
        } elseif ($user['role_name'] === 'Sales Representative') {
            header("Location: SalesRepresentative/salesrep-hp.php");
        } else {
            header("Location: signin.php");
        }

        $stmt->close();
        $conn->close();
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRM Sign In</title>
    <link rel="stylesheet" href="styles/hp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="homepage-logo-container">
            <img class="homepage-logo" src="hp-reg-images/hp-logo.png">
        </div>
        
        <div class="sign-in-container">
            <form id="signinForm" method="POST" action="">
                <input type="text" name="username" id="userName" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit">Sign in</button>
                <?php if (!empty($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </form>
        </div>

        <div class="create-account">
            <p>Don't have an account? <a class="create-account-link" href="registration.php">Create yours now</a></p>
        </div>
    </div>

    <script src="general/scripts/exit-control.js"></script>
</body>
</html>


