<?php
ini_set('display_errors', 1);
    
    display_errors = On
    error_reporting = E_ALL
// register.php
session_start();
// require_once __DIR__ . "/includes/config.php";   // contains DB constants
// require_once __DIR__ . "/includes/db.php";       // mysqli connection ($conn)

$host = 'localhost';
$db   = 'kenexoft_shield_v1_1';
$user = 'kenexoft_shield_dba';
$pass = 'kenexoft_shield_pass';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Handle POST only
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input
    $companyName   = trim($_POST['companyName']);
    $website       = trim($_POST['website']);
    $phone         = trim($_POST['phone']);
    $email         = trim($_POST['email']);
    $branches      = trim($_POST['branches']);
    $address1      = trim($_POST['address1']);
    $address2      = trim($_POST['address2']);
    $street        = trim($_POST['street']);
    $city          = trim($_POST['city']);
    $state         = trim($_POST['state']);
    $country       = trim($_POST['country']);

    $firstName     = trim($_POST['firstName']);
    $middleName    = trim($_POST['middleName']);
    $lastName      = trim($_POST['lastName']);
    $role          = trim($_POST['role']);
    $repEmail      = trim($_POST['repEmail']);
    $personalEmail = trim($_POST['personalEmail']);
    $mobile        = trim($_POST['mobile']);
    $repAddress    = trim($_POST['repAddress']);

    // reCAPTCHA verification (optional, skip if using test key)
    $recaptchaSecret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; // test secret
    if (!empty($_POST['g-recaptcha-response'])) {
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret="
            . $recaptchaSecret . "&response=" . $_POST['g-recaptcha-response']);
        $captchaSuccess = json_decode($verify);
        if (!$captchaSuccess->success) {
            die("Captcha verification failed. Please try again.");
        }
    }

    try {
        // Start transaction
        $conn->begin_transaction();

        // Insert into companies table
        $stmt1 = $conn->prepare("INSERT INTO companies 
            (company_name, website, phone, email, branches, address1, address2, street, city, state, country, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt1->bind_param(
            "sssssssssss",
            $companyName, $website, $phone, $email, $branches,
            $address1, $address2, $street, $city, $state, $country
        );
        $stmt1->execute();
        $companyId = $stmt1->insert_id;
        $stmt1->close();

        // Insert into representatives table
        $stmt2 = $conn->prepare("INSERT INTO representatives 
            (company_id, first_name, middle_name, last_name, role, rep_email, personal_email, mobile, rep_address, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt2->bind_param(
            "issssssss",
            $companyId, $firstName, $middleName, $lastName, $role,
            $repEmail, $personalEmail, $mobile, $repAddress
        );
        $stmt2->execute();
        $stmt2->close();

        // Commit
        $conn->commit();

        // Redirect back with success
        $_SESSION['success'] = "Company registered successfully!";
        header("Location: login.html?registered=1");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Registration error: " . $e->getMessage());
        die("An error occurred during registration. Please try again.");
    }
} else {
    header("Location: login.html");
    exit();
}