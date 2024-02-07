<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style type="text/css">
        /* styles.css */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.blog-post {
    margin-top: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
textarea {
    width: calc(100% - 20px);
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="file"] {
    margin-top: 5px;
}

input[type="submit"] {
    width: 100%;
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.success-message {
    text-align: center;
    color: #4caf50;
    font-weight: bold;
    margin-top: 10px;
}
</style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <div class="blog-post">
            <h3>Create New Blog Post</h3>
            <form action="create_blog.php" method="POST" enctype="multipart/form-data">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" required><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" required></textarea><br><br>
                <label for="image">Image:</label><br>
                <input type="file" id="image" name="image"><br><br>
                <input type="submit" value="Create Post">
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['roll_number'])) {
//     header("Location: login.html");
//     exit();
// }

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "myDatabase";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters
    $title = $_POST['title'];
    $description = $_POST['description'];
    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
      $folder = "upload-image/".$filename; // Directory to store uploaded images

    // Move uploaded image to target directory
        move_uploaded_file($tempname, $folder);

    // Prepare SQL statement
    $sql = "INSERT INTO blogs (title, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $description, $filename);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        echo '<p class="success-message">New blog post created successfully</p>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
