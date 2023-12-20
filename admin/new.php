<?php
// process_enrollment.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $course_id = $_POST['course_id'];

    // You may want to add more validation and sanitization here

    // Establish database connection
    require_once '../connect/dbcon.php';

    // Get the StudentID based on first_name and last_name
    $getStudentIdQuery = "SELECT StudentID FROM students WHERE FirstName = ? AND LastName = ?";
    $stmtGetId = $pdoConnect->prepare($getStudentIdQuery);
    $stmtGetId->execute([$first_name, $last_name]);

    // Check if a matching record is found
    if ($row = $stmtGetId->fetch(PDO::FETCH_ASSOC)) {
        $student_id = $row['StudentID'];

        // Insert data into the enrollment table
        $enrollment_date = date('Y-m-d'); // Current date
        $insertQuery = "INSERT INTO enrollments (StudentID, CourseID, EnrollmentDate) VALUES (?, ?, ?)";
        $stmt = $pdoConnect->prepare($insertQuery);
        $stmt->execute([$student_id, $course_id, $enrollment_date]);

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            echo "Enrollment successful!";
        } else {
            echo "Enrollment failed. Please try again.";
        }
    } else {
        echo "Student not found. Please check the first name and last name.";
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
    <title>New Enrollment</title>
</head>

<body>
    <header>
        <h1>New Enrollment</h1>
        <a href="index.php" class="back-to-dashboard">Back to Dashboard</a>

    </header>

    <div class="container">
        <form action="" method="post">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>

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

            <button type="submit" name="enroll">Enroll</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2023 Enrollment System</p>
    </footer>
</body>

</html>
