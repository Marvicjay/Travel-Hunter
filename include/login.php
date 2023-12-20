<?php
session_start();

require_once '../connect/dbcon.php';

try {
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';

        } else {
            // Check administrators and teachers table
            $user = checkAdmin($_POST["username"], $_POST["password"]);
            if ($user) {
                $_SESSION["id"] = $user["id"];

                handleSuccessfulLogin($user, "../admin/index.php");

            } else {
                // Check teachers table
                $user = checkTeacher($_POST["username"], $_POST["password"]);
                if ($user) {
                    $_SESSION["TeacherID"] = $user["TeacherID"];

                    handleSuccessfulLogin($user, "../teacher/index.php");

                } else {
                    // Check students table
                    $user = checkStudent($_POST["username"], $_POST["password"]);
                    if ($user) {
                        $_SESSION["StudentID"] = $user["StudentID"];

                        handleSuccessfulLogin($user, "../student/index.php");

                    } else {
                        // If none of the above conditions match, it's an invalid login
                        $message = "<label>Wrong Data</label>";
                    }
                }
            }
        }
    }

} catch (PDOException $error) {
    // Log the error instead of exposing it directly
    error_log($error->getMessage());
    $message = "An error occurred. Please try again later.";
}



function checkAdmin($username, $password)
{
    global $pdoConnect;

    $pdoQuery = "SELECT * FROM accounts WHERE UserName = :UserName ";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoResult->execute(['UserName' => $username]);

    return $pdoResult->fetch();
}

function checkTeacher($username, $password)
{
    global $pdoConnect;

    $pdoQuery = "SELECT * FROM teachers WHERE UserName = :UserName ";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoResult->execute(['UserName' => $username]);

    return $pdoResult->fetch();
}

function checkStudent($username, $password)
{
    global $pdoConnect;

    $pdoQuery = "SELECT * FROM students WHERE UserName = :UserName ";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoResult->execute(['UserName' => $username]);

    return $pdoResult->fetch();
}

function handleSuccessfulLogin($user, $redirectLocation)
{
    $_SESSION["UserName"] = $user["UserName"];
    $_SESSION["id"] = $user["id"];

    header("location: $redirectLocation");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <style>

    </style>
    <title>Login Page</title>
</head>

<body>

    <div class="login-container">
        <header>Student Management Portal</header>
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <!-- Add registration button -->
        <form action="register.php" method="get">
            <button type="submit" class="register">Register</button>
        </form>
    </div>
</body>

</html>