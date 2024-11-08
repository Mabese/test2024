<?php
session_start();
$message = '';

// Initialize session arrays if not set
if (!isset($_SESSION['institutions'])) {
    $_SESSION['institutions'] = [];
}
if (!isset($_SESSION['faculties'])) {
    $_SESSION['faculties'] = [];
}
if (!isset($_SESSION['courses'])) {
    $_SESSION['courses'] = [];
}
if (!isset($_SESSION['admissions'])) {
    $_SESSION['admissions'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Simulate a successful login for demonstration
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = htmlspecialchars($_POST['email']);
        $message = "Welcome, " . $_SESSION['admin_email'] . "!";
    } elseif (isset($_POST['institutionName'])) {
        $_SESSION['institutions'][] = htmlspecialchars($_POST['institutionName']);
        $message = "Institution '" . htmlspecialchars($_POST['institutionName']) . "' added successfully!";
    } elseif (isset($_POST['facultyName'])) {
        $_SESSION['faculties'][] = htmlspecialchars($_POST['facultyName']);
        $message = "Faculty '" . htmlspecialchars($_POST['facultyName']) . "' added successfully!";
    } elseif (isset($_POST['courseName'])) {
        $courseData = [
            'name' => htmlspecialchars($_POST['courseName']),
            'faculty' => htmlspecialchars($_POST['faculty'])
        ];
        $_SESSION['courses'][] = $courseData;
        $message = "Course '" . htmlspecialchars($_POST['courseName']) . "' added successfully under Faculty: " . htmlspecialchars($_POST['faculty']);
    } elseif (isset($_POST['deleteInstitution'])) {
        $institutionName = htmlspecialchars($_POST['deleteInstitution']);
        if (($key = array_search($institutionName, $_SESSION['institutions'])) !== false) {
            unset($_SESSION['institutions'][$key]);
            $message = "Institution '" . $institutionName . "' deleted successfully.";
        }
    } elseif (isset($_POST['deleteCourse'])) {
        $courseName = htmlspecialchars($_POST['deleteCourse']);
        foreach ($_SESSION['courses'] as $key => $course) {
            if ($course['name'] === $courseName) {
                unset($_SESSION['courses'][$key]);
                $message = "Course '" . $courseName . "' deleted successfully.";
                break;
            }
        }
    } elseif (isset($_POST['admissionDetails'])) {
        $_SESSION['admissions'][] = htmlspecialchars($_POST['admissionDetails']);
        $message = "Admissions published successfully!";
    }
}

// Redirect to dashboard if already logged in
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1><?php echo $isLoggedIn ? 'Admin Dashboard' : 'Admin Login'; ?></h1>
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
                <h2>Admin Login</h2>
                <form action="" method="POST">
                    <label for="adminEmail">Email:</label>
                    <input type="email" id="adminEmail" name="email" required>
                    
                    <label for="adminPassword">Password:</label>
                    <input type="password" id="adminPassword" name="password" required>

                    <button type="submit">Login</button>
                </form>
            </section>
        <?php else: ?>
            <section id="addInstitutions">
                <h2>Add High Learning Institutions</h2>
                <form action="" method="POST">
                    <label for="institutionName">Institution Name:</label>
                    <input type="text" id="institutionName" name="institutionName" required>
                    <button type="submit">Add Institution</button>
                </form>
            </section>

            <section id="addFaculties">
                <h2>Add Faculties</h2>
                <form action="" method="POST">
                    <label for="facultyName">Faculty Name:</label>
                    <input type="text" id="facultyName" name="facultyName" required>
                    <button type="submit">Add Faculty</button>
                </form>
                <h3>Available Faculties</h3>
                <ul>
                    <li>Faculty of Science</li>
                    <li>Faculty of Arts</li>
                    <li>Faculty of Engineering</li>
                    <li>Faculty of Business Administration</li>
                    <li>Faculty of Education</li>
                </ul>
            </section>

            <section id="addCourses">
                <h2>Add Courses under Faculty</h2>
                <form action="" method="POST">
                    <label for="courseName">Course Name:</label>
                    <select id="courseSelect" name="courseName" required>
                        <option value="">--Select Course--</option>
                        <option value="Introduction to Computer Science">Introduction to Computer Science</option>
                        <option value="Calculus I">Calculus I</option>
                        <option value="Organic Chemistry">Organic Chemistry</option>
                        <option value="Modern Physics">Modern Physics</option>
                        <option value="Introduction to Psychology">Introduction to Psychology</option>
                        <option value="Macroeconomics">Macroeconomics</option>
                        <option value="Corporate Finance">Corporate Finance</option>
                        <option value="Data Structures">Data Structures</option>
                        <option value="Digital Marketing">Digital Marketing</option>
                        <option value="Educational Psychology">Educational Psychology</option>
                    </select>

                    <label for="facultySelect">Select Faculty:</label>
                    <select id="facultySelect" name="faculty" required>
                        <option value="">--Select Faculty--</option>
                        <option value="Faculty of Science">Faculty of Science</option>
                        <option value="Faculty of Arts">Faculty of Arts</option>
                        <option value="Faculty of Engineering">Faculty of Engineering</option>
                        <option value="Faculty of Business Administration">Faculty of Business Administration</option>
                        <option value="Faculty of Education">Faculty of Education</option>
                    </select>
                    <button type="submit">Add Course</button>
                </form>
            </section>

            <section id="deleteItems">
                <h2>Delete Institutions or Courses</h2>
                <form action="" method="POST">
                    <label for="deleteInstitution">Delete Institution Name:</label>
                    <input type="text" id="deleteInstitution" name="deleteInstitution" placeholder="Institution Name">

                    <label for="deleteCourse">Delete Course Name:</label>
                    <input type="text" id="deleteCourse" name="deleteCourse" placeholder="Course Name">
                    <button type="submit">Delete</button>
                </form>
            </section>

            <section id="publishAdmissions">
                <h2>Publish Admissions</h2>
                <form action="" method="POST">
                    <label for="admissionDetails">Admission Details:</label>
                    <textarea id="admissionDetails" name="admissionDetails" required></textarea>
                    <button type="submit">Publish Admissions</button>
                </form>
            </section>

            <section id="profile">
                <h2>Admin Profile</h2>
                <form action="" method="POST">
                    <label for="adminName">Name:</label>
                    <input type="text" id="adminName" name="adminName" required>

                    <label for="adminEmailProfile">Email:</label>
                    <input type="email" id="adminEmailProfile" name="adminEmail" required>
                    <button type="submit">Update Profile</button>
                </form>
            </section>

            <section id="records">
                <h2>Records</h2>
                <h3>Institutions</h3>
                <ul>
                    <?php foreach ($_SESSION['institutions'] as $institution): ?>
                        <li><?php echo $institution; ?></li>
                    <?php endforeach; ?>
                </ul>

                <h3>Faculties</h3>
                <ul>
                    <?php foreach ($_SESSION['faculties'] as $faculty): ?>
                        <li><?php echo $faculty; ?></li>
                    <?php endforeach; ?>
                </ul>

                <h3>Courses</h3>
                <ul>
                    <?php foreach ($_SESSION['courses'] as $course): ?>
                        <li><?php echo $course['name'] . " (Faculty: " . $course['faculty'] . ")"; ?></li>
                    <?php endforeach; ?>
                </ul>

                <h3>Admissions</h3>
                <ul>
                    <?php foreach ($_SESSION['admissions'] as $admission): ?>
                        <li><?php echo $admission; ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>

        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Education Portal</p>
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