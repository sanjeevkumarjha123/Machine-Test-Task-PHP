<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if roll number and password are set and not empty
    if (isset($_POST['roll_number']) && isset($_POST['password']) && !empty($_POST['roll_number']) && !empty($_POST['password'])) {
        // Validate roll number and password (you may want to add more validation)
        $roll_number = $_POST['roll_number'];
        $password = $_POST['password'];

        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password_db = "12345678";
        $dbname = "myDatabase";

        // Create connection
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement
        $sql = "SELECT * FROM students WHERE roll_number = '$roll_number' AND password = '$password'";

        // Execute SQL statement
        $result = $conn->query($sql);

        // Check if a matching record is found
        if ($result->num_rows == 1) {
            // Student is authenticated, set session variable and redirect to dashboard
            $_SESSION['roll_number'] = $roll_number;
                header("Location: blogs_list.php");
        } else {
            // Student authentication failed, redirect back to login page with error message
            header("Location: login.html?error=1");
        }

        // Close connection
        $conn->close();
    } else {
        // Roll number or password is empty, redirect back to login page with error message
        header("Location: login.html?error=2");
    }
} else {
    // Redirect back to login page
    header("Location: login.html");
}
?>
