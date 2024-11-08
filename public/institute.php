<?php
session_start();
$message = '';
include 'database.php'; // Ensure this file handles database connections

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Simulate a successful login for demonstration
        $_SESSION['institute_logged_in'] = true;
        $_SESSION['institute_email'] = htmlspecialchars($_POST['email']);
        $message = "Institute logged in with email: " . $_SESSION['institute_email'];
    } elseif (isset($_POST['instituteName'])) {
        // Save new institute
        $instituteName = htmlspecialchars($_POST['instituteName']);
        $stmt = $pdo->prepare("INSERT INTO faculties (faculty_name) VALUES (:facultyName)");
        $stmt->execute(['facultyName' => $instituteName]);
        $message = "Institute '" . $instituteName . "' registered successfully!";
    } elseif (isset($_POST['facultyName'])) {
        // Save new faculty
        $facultyName = htmlspecialchars($_POST['facultyName']);
        $stmt = $pdo->prepare("INSERT INTO faculties (faculty_name) VALUES (:facultyName)");
        $stmt->execute(['facultyName' => $facultyName]);
        $message = "Faculty '" . $facultyName . "' added successfully!";
    } elseif (isset($_POST['courseName']) && isset($_POST['faculty'])) {
        // Save new course
        $courseName = htmlspecialchars($_POST['courseName']);
        $facultyId = $_POST['faculty'];
        $stmt = $pdo->prepare("INSERT INTO courses (course_name, faculty_id) VALUES (:courseName, :facultyId)");
        $stmt->execute(['courseName' => $courseName, 'facultyId' => $facultyId]);
        $message = "Course '" . $courseName . "' added successfully!";
    } elseif (isset($_POST['admissionDetails']) && isset($_POST['course'])) {
        // Save new admission
        $admissionDetails = htmlspecialchars($_POST['admissionDetails']);
        $courseId = $_POST['course'];
        $stmt = $pdo->prepare("INSERT INTO applications (admission_details, course_id) VALUES (:admissionDetails, :courseId)");
        $stmt->execute(['admissionDetails' => $admissionDetails, 'courseId' => $courseId]);
        $message = "Admissions published successfully!";
    }
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['institute_logged_in']) && $_SESSION['institute_logged_in'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institute Dashboard</title>
    <link rel="stylesheet" href="institute.css">
</head>
<body>
    <header>
        <h1><?php echo $isLoggedIn ? 'Institute Dashboard' : 'Institute Login'; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="institute.php">Institute</a></li>
                <li><a href="Student.php">Student</a></li>
            </ul>
        </nav>
        <?php if ($isLoggedIn): ?>
            <nav>
                <ul>
                    <li><a href="?logout=true">Logout</a></li>
                </ul>
            </nav>
        <?php endif; ?>
    </header>

    <main>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
            <section id="login">
                <h2>Institute Login</h2>
                <form action="" method="POST">
                    <label for="instituteEmail">Email:</label>
                    <input type="email" id="instituteEmail" name="email" required>

                    <label for="institutePassword">Password:</label>
                    <input type="password" id="institutePassword" name="password" required>
                    <button type="submit">Login</button>
                </form>
            </section>
        <?php else: ?>
            <!-- Register Institute -->
            <section id="register">
                <h2>Register Institute</h2>
                <form action="" method="POST">
                    <label for="instituteName">Institute Name:</label>
                    <input type="text" id="instituteName" name="instituteName" required>

                    <label for="instituteEmailReg">Email:</label>
                    <input type="email" id="instituteEmailReg" name="instituteEmail" required>
                    <button type="submit">Register</button>
                </form>
            </section>

            <!-- Add Faculty -->
            <section id="addFaculty">
                <h2>Add Faculty</h2>
                <form action="" method="POST">
                    <label for="facultyNameInst">Faculty Name:</label>
                    <input type="text" id="facultyNameInst" name="facultyName" required>
                    <button type="submit">Add Faculty</button>
                </form>
            </section>

            <!-- Add Courses -->
            <section id="addCoursesInst">
                <h2>Add Courses under Faculty</h2>
                <form action="" method="POST">
                    <label for="courseNameInst">Course Name:</label>
                    <input type="text" id="courseNameInst" name="courseName" required>

                    <label for="facultySelectInst">Select Faculty:</label>
                    <select id="facultySelectInst" name="faculty" required>
                        <option value="">--Select Faculty--</option>
                        <!-- Hardcoded Faculty Options -->
                        <option value="1">Faculty of Science</option>
                        <option value="2">Faculty of Arts</option>
                        <option value="3">Faculty of Business</option>
                        <option value="4">Faculty of Engineering</option>
                        <option value="5">Faculty of Medicine</option>
                    </select>
                    <button type="submit">Add Course</button>
                </form>
            </section>

            <!-- Publish Admissions -->
            <section id="publishAdmissionsInst">
                <h2>Publish Admissions</h2>
                <form action="" method="POST">
                    <label for="admissionDetailsInst">Admission Details:</label>
                    <textarea id="admissionDetailsInst" name="admissionDetails" required></textarea>

                    <label for="courseSelectPublish">Select Course:</label>
                    <select id="courseSelectPublish" name="course" required>
                        <option value="">--Select Course--</option>
                        <!-- Hardcoded Course Options -->
                        <option value="1">Bachelor of Science in Biology</option>
                        <option value="2">Bachelor of Science in Physics</option>
                        <option value="3">Bachelor of Arts in History</option>
                        <option value="4">Bachelor of Business Administration</option>
                        <option value="5">Bachelor of Engineering in Civil Engineering</option>
                        <option value="6">Bachelor of Engineering in Computer Science</option>
                        <option value="7">Bachelor of Medicine and Surgery</option>
                        <option value="8">Bachelor of Arts in Psychology</option>
                        <option value="9">Bachelor of Science in Chemistry</option>
                        <option value="10">Bachelor of Business in Marketing</option>
                    </select>
                    
                    <button type="submit">Publish Admissions</button>
                </form>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2023 Education Portal</p>
    </footer>
</body>
</html>

<?php
// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
