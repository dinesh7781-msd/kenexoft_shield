<<<<<<< HEAD
<?php
// Start session to manage login
session_start();

// Database configuration
$host = 'localhost';
$db   = 'kenexoft_shield_v1_1';
$user = 'kenexoft_shield_dba';
$pass = 'kenexoft_shield_pass';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check for form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs, sanitize to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // password should be hashed in DB

    // Query for user by username/email (add email support if needed)
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        // User found, verify password (hashed comparison recommended)
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.html"); // Change destination as needed
            exit();
        } else {
            // Wrong password
            header("Location: index.html?error=Invalid%20Password");
            exit();
        }
    } else {
        // User not found
        header("Location: index.html?error=User%20not%20found");
        exit();
    }
}
$conn->close();
?>
=======
<?php
// Start session to manage login
session_start();

// Database configuration
$host = 'localhost';
$db   = 'kenexoft_shield_v1_1';
$user = 'kenexoft_shield_dba';
$pass = 'kenexoft_shield_pass';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check for form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs, sanitize to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // password should be hashed in DB

    // Query for user by username/email (add email support if needed)
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        // User found, verify password (hashed comparison recommended)
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.html"); // Change destination as needed
            exit();
        } else {
            // Wrong password
            header("Location: index.html?error=Invalid%20Password");
            exit();
        }
    } else {
        // User not found
        header("Location: index.html?error=User%20not%20found");
        exit();
    }
}
$conn->close();
?>
>>>>>>> ef4b093bc20f5958af3f4e719bf5a41b54a6d289
