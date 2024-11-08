<?php
session_start();
$message = '';

// Initialize session array for applications if not set
if (!isset($_SESSION['applications'])) {
    $_SESSION['applications'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Simulate a successful login for demonstration
        $_SESSION['student_logged_in'] = true;
        $_SESSION['student_email'] = htmlspecialchars($_POST['email']);
        $message = "Student logged in with email: " . $_SESSION['student_email'];
    } elseif (isset($_POST['instituteName']) && isset($_POST['courseName']) && isset($_POST['grades'])) {
        // Save application details
        $application = [
            'institute' => htmlspecialchars($_POST['instituteName']),
            'course' => htmlspecialchars($_POST['courseName']),
            'grades' => htmlspecialchars($_POST['grades'])
        ];
        $_SESSION['applications'][] = $application;
        $message = "Application submitted successfully!";
    } elseif (isset($_POST['studentName'])) {
        $message = "Profile updated successfully!";
    }
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['student_logged_in']) && $_SESSION['student_logged_in'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <header>
        <h1><?php echo $isLoggedIn ? 'Student Dashboard' : 'Student Login'; ?></h1>
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
                <h2>Student Login</h2>
                <form action="" method="POST">
                    <label for="studentEmail">Email:</label>
                    <input type="email" id="studentEmail" name="email" required>

                    <label for="studentPassword">Password:</label>
                    <input type="password" id="studentPassword" name="password" required>
                    <button type="submit">Login</button>
                </form>
            </section>
        <?php else: ?>
            <section id="apply">
                <h2>Submit Application</h2>
                <form action="" method="POST">
                    <label for="instituteName">Institute Name:</label>
                    <input type="text" id="instituteName" name="instituteName" required>

                    <label for="courseName">Select Course:</label>
                    <select id="courseName" name="courseName" required>
                        <option value="">--Select Course--</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Business Administration">Business Administration</option>
                        <option value="Psychology">Psychology</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Education">Education</option>
                        <option value="Fine Arts">Fine Arts</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Physics">Physics</option>
                        <option value="Chemistry">Chemistry</option>
                        <option value="Biology">Biology</option>
                    </select>

                    <label for="grades">Grades:</label>
                    <input type="text" id="grades" name="grades" required>

                    <button type="submit">Submit Application</button>
                </form>
            </section>

            <section id="viewApplications">
                <h2>View Applications</h2>
                <button onclick="document.getElementById('applicationsList').style.display='block'">View Applications</button>
                <div id="applicationsList" style="display:none;">
                    <ul>
                        <?php if (empty($_SESSION['applications'])): ?>
                            <li>No applications submitted yet.</li>
                        <?php else: ?>
                            <?php foreach ($_SESSION['applications'] as $app): ?>
                                <li>
                                    <strong>Institute:</strong> <?php echo $app['institute']; ?>, 
                                    <strong>Course:</strong> <?php echo $app['course']; ?>, 
                                    <strong>Grades:</strong> <?php echo $app['grades']; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>

            <section id="profile">
                <h2>Student Profile</h2>
                <form action="" method="POST">
                    <label for="studentName">Name:</label>
                    <input type="text" id="studentName" name="studentName" required>

                    <label for="studentEmailProfile">Email:</label>
                    <input type="email" id="studentEmailProfile" name="studentEmail" required>
                    <button type="submit">Update Profile</button>
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