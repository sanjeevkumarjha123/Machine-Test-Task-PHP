<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "myDatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login system implementation
// Implement your login system here and store user information in session upon successful login

// Start HTML output with CSS styling
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .blog-post {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .comment {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        input[type='submit'] {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type='submit']:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
";

// Display blog posts with comment forms
$sql = "SELECT * FROM blog_posts";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='blog-post'>";
        echo "<h2>" . $row["title"] . "</h2>";
        echo "<p>" . $row["content"] . "</p>";
        // Comment form
        echo "<form action='submit_comment.php' method='POST'>";
        echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
        echo "<textarea name='comment_content' placeholder='Write your comment...' required></textarea><br>";
        echo "<input type='submit' value='Submit Comment'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No blog posts found.";
}

// Submit comments
// Implement submit_comment.php to handle comment submission

// Display comments and reply forms
$sql = "SELECT * FROM comments";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<p>" . $row["content"] . "</p>";
        // Reply form
        echo "<form action='submit_reply.php' method='POST'>";
        echo "<input type='hidden' name='comment_id' value='" . $row["id"] . "'>";
        echo "<textarea name='reply_content' placeholder='Write your reply...' required></textarea><br>";
        echo "<input type='submit' value='Submit Reply'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No comments found.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the reply content and comment ID from the form
    $reply_content = $_POST['reply_content'];
    $comment_id = $_POST['comment_id'];

    // Prepare and execute the SQL statement to insert the reply into the database
    $sql = "INSERT INTO replies (comment_id, content) VALUES ('$comment_id', '$reply_content')";
    if ($conn->query($sql) === TRUE) {
        // Reply inserted successfully
        // Redirect back to the blog list page
        header("Location: blog_list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Implement submit_reply.php to handle reply submission

// Optional: Implement editing and deleting of comments/replies

// End HTML output
echo "
</body>
</html>
";

$conn->close();
?>
