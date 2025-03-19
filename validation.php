
<?php
// Define 
$firstName = $lastName = $email = $phone = $message = "";
$firstNameErr = $lastNameErr = $emailErr = $phoneErr = $messageErr = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validation
    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required.";
        $isValid = false;
    } else {
        $firstName = htmlspecialchars($_POST["firstName"]);
    }

    
    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required.";
        $isValid = false;
    } else {
        $lastName = htmlspecialchars($_POST["lastName"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required.";
        $isValid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
        $isValid = false;
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone Number is required.";
        $isValid = false;
    } elseif (!preg_match("/^[0-9]{10}$/", $_POST["phone"])) {
        $phoneErr = "Invalid phone number.";
        $isValid = false;
    } else {
        $phone = htmlspecialchars($_POST["phone"]);
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required.";
        $isValid = false;
    } else {
        $message = htmlspecialchars($_POST["message"]);
    }

    // If all validations pass, display success message
    if ($isValid) {
        $successMsg = "Form submitted successfully!";
    }
}
?>