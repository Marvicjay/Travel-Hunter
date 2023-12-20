<?php
session_start();

require_once '../connect/dbcon.php';

// Function to sanitize input data
function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

// Create
if (isset($_POST['addCourse'])) {
    $courseName = sanitizeInput($_POST['courseName']);

    // Perform validation if necessary

    $pdoQuery = "INSERT INTO courses (CourseName) VALUES (:courseName)";
    $insertStatement = $pdoConnect->prepare($pdoQuery);
    $insertStatement->bindParam(':courseName', $courseName);

    if ($insertStatement->execute()) {
        header('Location: courses.php');
        exit();
    } else {
        echo "Error adding course.";
    }
}

// Update
if (isset($_POST['editCourse'])) {
    $courseID = sanitizeInput($_POST['courseID']);
    $newCourseName = sanitizeInput($_POST['newCourseName']);

    // Perform validation if necessary

    $pdoQuery = "UPDATE courses SET CourseName = :newCourseName WHERE CourseID = :courseID";
    $updateStatement = $pdoConnect->prepare($pdoQuery);
    $updateStatement->bindParam(':newCourseName', $newCourseName);
    $updateStatement->bindParam(':courseID', $courseID);

    if ($updateStatement->execute()) {
        header('Location: courses.php');
        exit();
    } else {
        echo "Error updating course.";
    }
}

// Delete
if (isset($_GET['deleteCourse'])) {
    $courseID = sanitizeInput($_GET['deleteCourse']);

    $pdoQuery = "DELETE FROM courses WHERE CourseID = :courseID";
    $deleteStatement = $pdoConnect->prepare($pdoQuery);
    $deleteStatement->bindParam(':courseID', $courseID);

    if ($deleteStatement->execute()) {
        header('Location: courses.php');
        exit();
    } else {
        echo "Error deleting course.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/course.css">
    <title>View Courses</title>
</head>

<body>
    <header>
        <h1>View Courses</h1>
        <a href="index.php" class="back-to-dashboard">Back to Dashboard</a>
    </header>

    <div class="container">
        <?php
        // Fetch data from the database
        $pdoQuery = "SELECT * FROM courses";
        $pdoResult = $pdoConnect->query($pdoQuery);

        if ($pdoResult->rowCount() > 0) {
            // Output data in a table
            echo "<table>";
            echo "<thead><tr><th>Course ID</th><th>Course Name</th><th>Action</th></tr></thead>";
            echo "<tbody>";

            while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["CourseID"] . "</td>";
                echo "<td>" . $row["CourseName"] . "</td>";
                echo "<td>
                            <form method='post' style='display: inline;'>
                                <input type='hidden' name='courseID' value='" . $row["CourseID"] . "'>
                                <input type='text' name='newCourseName' placeholder='New Course Name'>
                                <button type='submit' name='editCourse'>Edit</button>
                            </form>
                            <a href='courses.php?deleteCourse=" . $row["CourseID"] . "'>Delete</a>
                          </td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No courses found.</p>";
        }
        ?>
 </div>
        <!-- Add Course Form -->
        <form method="post">
            <label for="courseName">Course Name:</label>
            <input type="text" name="courseName" required>
            <button type="submit" name="addCourse">Add Course</button>
        </form>
   

    <footer>
        <p>&copy; 2023 Enrollment System</p>
    </footer>
</body>

</html>