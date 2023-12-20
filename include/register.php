<?php
session_start();
require_once '../connect/dbcon.php';

if (isset($_POST["register"])) {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $date_of_birth = $_POST['dateOfBirth'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Corrected here
    $email = $_POST['email'];
    $contact_number = $_POST['contactNumber'];
    $address = $_POST['address'];

    $pdoQuery = "INSERT INTO `students`(`FirstName`, `LastName`, `DateOfBirth`, `UserName`, `PassWord`, `Email`, `ContactNumber`, `Address`) 
                 VALUES(:first_name, :last_name, :date_of_birth, :username, :password, :email, :contact_number, :address)";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute([
        ":first_name" => $first_name,
        ":last_name" => $last_name,
        ":date_of_birth" => $date_of_birth,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email,
        ":contact_number" => $contact_number,
        ":address" => $address,
    ]);

    header("location: login.php");
    exit();
    // Add any additional code for success or error handling after the insertion
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reg.css">
    <style>
       
    </style>
    <title>Registration Page</title>
</head>

<body>
    <div class="registration-container">
        <h2>Registration</h2>
        <form action="" method="POST">
            <div class="grid-row">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div class="grid-row">
                <label for="dateOfBirth">Date of Birth:</label>
                <input type="date" id="dateOfBirth" name="dateOfBirth" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3" required></textarea>

            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>

</html>