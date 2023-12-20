<?php
session_start();

// Check if the user is logged in and has the "teacher" role
if (!isset($_SESSION["UserName"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/view.css">
    <title>Admin Dashboard</title>

</head>

<body>
    <header>
        <h1>Welcome,
            <?php echo $_SESSION["UserName"]; ?> (Admin)
        </h1>
        <a class="logout-button" href="../include/logout.php">Logout</a>
    </header>

    <div class="container">
        <div class="dashboard">
            <div class="card">
                <h2>New Enrollment</h2>
                <p>Enroll new students</p>
                <a href="new.php">Enroll Now</a>
            </div>

            <div class="card">
                <h2>View Enrollments</h2>
                <p>View and manage enrolled students</p>
                <a href="enroll.php">View Enrollments</a>
            </div>

            <!-- New card for Courses -->
            <div class="card">
                <h2>View Courses</h2>
                <p>Explore available courses</p>
                <a href="courses.php">View Courses</a>
            </div>

            <div class="card">
                <h2>New Teacher</h2>
                <p>Register as a new teacher with us</p>
                <a href="teacher.php">Add Now</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Admin Portal</p>
    </footer>
</body>

</html>