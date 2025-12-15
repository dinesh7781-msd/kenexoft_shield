<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// register.php: Store registration form data in MySQL
// Update these variables with your DB credentials
$host = 'localhost';
$db   = 'kenexoft_shield_v1_1';
$user = 'kenexoft_shield_dba';
$pass = 'kenexoft_shield_pass';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect form data
    $companyName = $conn->real_escape_string($_POST['companyName'] ?? '');
    $website = $conn->real_escape_string($_POST['website'] ?? '');
    $phone = $conn->real_escape_string($_POST['phone'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $branches = $conn->real_escape_string($_POST['branches'] ?? '');
    $address1 = $conn->real_escape_string($_POST['address1'] ?? '');
    $address2 = $conn->real_escape_string($_POST['address2'] ?? '');
    $street = $conn->real_escape_string($_POST['street'] ?? '');
    $city = $conn->real_escape_string($_POST['city'] ?? '');
    $state = $conn->real_escape_string($_POST['state'] ?? '');
    $country = $conn->real_escape_string($_POST['country'] ?? '');
    $firstName = $conn->real_escape_string($_POST['firstName'] ?? '');
    $middleName = $conn->real_escape_string($_POST['middleName'] ?? '');
    $lastName = $conn->real_escape_string($_POST['lastName'] ?? '');
    $role = $conn->real_escape_string($_POST['role'] ?? '');
    $repEmail = $conn->real_escape_string($_POST['repEmail'] ?? '');
    $personalEmail = $conn->real_escape_string($_POST['personalEmail'] ?? '');
    $mobile = $conn->real_escape_string($_POST['mobile'] ?? '');
    $repAddress = $conn->real_escape_string($_POST['repAddress'] ?? '');

    // Insert into database (table: registrations)
    $sql = "INSERT INTO users (companyName, website, phone, email, branches, address1, address2, street, city, state, country, firstName, middleName, lastName, role, repEmail, personalEmail, mobile, repAddress) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssssssssssssss', $companyName, $website, $phone, $email, $branches, $address1, $address2, $street, $city, $state, $country, $firstName, $middleName, $lastName, $role, $repEmail, $personalEmail, $mobile, $repAddress);
    if ($stmt->execute()) {
        echo '<h2>Registration successful!</h2>';
    } else {
        echo '<h2>Error: ' . $stmt->error . '</h2>';
    }
    $stmt->close();
}
$conn->close();
?>
