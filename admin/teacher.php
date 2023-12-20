<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_name = $_POST['user_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $course_id = $_POST['course_id'];

    // You may want to add more validation and sanitization here

    // Establish database connection
    require_once '../connect/dbcon.php';

    // Insert data into the teachers table
    $insertTeacherQuery = "INSERT INTO teachers (FirstName, LastName, UserName, PassWord, CourseID) VALUES (?, ?, ?, ?, ?)";
    $stmtInsertTeacher = $pdoConnect->prepare($insertTeacherQuery);
    $stmtInsertTeacher->execute([$first_name, $last_name, $user_name, $password, $course_id]);

    // Check if the teacher insertion was successful
    if ($stmtInsertTeacher->rowCount() > 0) {
        echo "Teacher registration successful!";
    } else {
        echo "Teacher registration failed. Please check the input data.";
    }
} else {
    // Redirect if the form is not submitted via POST method
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/view.css">
    <title>New Teacher Registration</title>
</head>

<body>
    <header>
        <h1>New Teacher Registration</h1>
        <a href="index.php" class="back-to-dashboard">Back to Dashboard</a>
    </header>

    <div class="container">
        <form action="" method="post">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>

            <label for="user_name">Username:</label>
            <input type="text" name="user_name" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="course_id">Course:</label>
            <select name="course_id" required>
                <?php
                // Establish database connection
                require_once '../connect/dbcon.php';

                // Fetch courses from the database
                $courseQuery = "SELECT * FROM courses";
                $courseResult = $pdoConnect->query($courseQuery);

                // Display options in the dropdown
                while ($row = $courseResult->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['CourseID'] . "'>" . $row['CourseName'] . "</option>";
                }
                ?>
            </select>

            <button type="submit" name="register">Register</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2023 Enrollment System</p>
    </footer>
</body>

</html>