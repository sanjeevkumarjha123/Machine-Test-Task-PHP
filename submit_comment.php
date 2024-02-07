<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "myDatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the comment content and blog post ID from the form
     $comment_content = $_POST['comment_content'];
     $post_id = $_POST['blog_id'];

    // Prepare and execute the SQL statement to insert the comment into the database
    $sql = "INSERT INTO comments (post_id, content) VALUES ('$post_id', '$comment_content')";
    if ($conn->query($sql) === TRUE) {
        // Comment inserted successfully
        // Redirect back to the blog list page
        // header("Location: blogs_list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
