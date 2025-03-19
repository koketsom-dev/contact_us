<?php
// Define variables
$firstName = $lastName = $email = $phoneNumber = $message = "";
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (!isset($_POST["firstName"]) || empty(trim($_POST["firstName"]))) {
        $errors['firstName'] = "First Name is required.";
    } else {
        $firstName = htmlspecialchars(trim($_POST["firstName"]));
    }

    // Validate last name
    if (!isset($_POST["lastName"]) || empty(trim($_POST["lastName"]))) {
        $errors['lastName'] = "Last Name is required.";
    } else {
        $lastName = htmlspecialchars(trim($_POST["lastName"]));
    }

    // Validate email
    if (!isset($_POST["email"]) || empty(trim($_POST["email"]))) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    // Validate phone number
    if (!isset($_POST["phoneNumber"]) || empty(trim($_POST["phoneNumber"]))) {
        $errors['phoneNumber'] = "Phone Number is required.";
    } elseif (!preg_match('/^\d+$/', $_POST["phoneNumber"])) {
        $errors['phoneNumber'] = "Phone Number must contain only digits.";
    } else {
        $phoneNumber = htmlspecialchars(trim($_POST["phoneNumber"]));
    }

    // Validate message
    if (!isset($_POST["message"]) || empty(trim($_POST["message"]))) {
        $errors['message'] = "Message is required.";
    } else {
        $message = htmlspecialchars(trim($_POST["message"]));
    }

    // If no errors, save to the database
    if (empty($errors)) {
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "contact_us";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert query
        $sql = "INSERT INTO contact (firstName, lastName, email, phoneNumber, message) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $message);

        if ($stmt->execute()) {
            $successMessage = "Form submitted successfully!";
        } else {
            $errorMessage = "Error: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        form {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
        }
        table td {
            padding: 8px 0;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-messages {
            margin-top: 20px;
            color: red;
            text-align: center;
        }
        .success-message {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2 style="text-align: center;">Contact Us</h2>
        <table>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="firstName" value="<?php echo $firstName; ?>" style="width: 100%;"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastName" value="<?php echo $lastName; ?>" style="width: 100%;"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="email" value="<?php echo $email; ?>" style="width: 100%;"></td>
            </tr>
            <tr>
                <td>Phone Number:</td>
                <td><input type="text" name="phoneNumber" value="<?php echo $phoneNumber; ?>" style="width: 100%;"></td>
            </tr>
            <tr>
                <td>Message:</td>
                <td><textarea name="message" style="width: 100%;"><?php echo $message; ?></textarea></td>
            </tr>
        </table>
        <button type="submit">Send Message</button>

        <!-- Display error or success messages below the button -->
        <?php if (!empty($errors) || isset($successMessage)): ?>
            <div class="success-message">
                <?php if (isset($successMessage)) echo $successMessage; ?>
            </div>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>
