<?php
session_start();

require_once '../connect/dbcon.php';

// Fetch data from the database with a join
$pdoQuery = "SELECT enrollments.EnrollmentID, students.StudentID, students.FirstName, students.LastName, courses.CourseName 
                  FROM enrollments
                  INNER JOIN students ON enrollments.StudentID = students.StudentID
                  INNER JOIN courses ON enrollments.CourseID = courses.CourseID";
$pdoResult = $pdoConnect->query($pdoQuery);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/view.css">
    <title>View Enrollments</title>
</head>

<body>
    <header>
        <h1>View Enrollments</h1>
        <a href="index.php" class="back-to-dashboard">Back to Dashboard</a>


    </header>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Enrollment ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($pdoResult->rowCount() > 0) {
                    // Output data of each row
                    while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row["EnrollmentID"] . "</td>";
                        echo "<td>" . $row["StudentID"] . "</td>";
                        echo "<td>" . $row["FirstName"] . " " . $row["LastName"] . "</td>";
                        echo "<td>" . $row["CourseName"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2023 Enrollment System</p>
    </footer>
</body>

</html>