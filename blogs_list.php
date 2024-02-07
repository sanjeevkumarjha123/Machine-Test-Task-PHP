<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .blog {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .blog h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .blog p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .blog img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .comment-form {
            margin-top: 20px;
        }

        .comment-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .comment-form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .comment-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blog List</h1>
        <?php
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

        // Retrieve blogs from the database
        $sql = "SELECT * FROM blogs";
        $result = $conn->query($sql);

        // Check if any blogs are found
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='blog'>";
                echo "<h2>" ."Title : ". $row["title"] . "</h2>";
                echo "<p>" ."Description : ". $row["description"] . "</p>";
                if (!empty($row["image"])) {
                    echo "Image : ".'<img src="upload-image/' . $row["image"] . '" alt="Blog Image" width="100px" height="100px">';
                }

                // Comment form
                echo "<form class='comment-form' action='submit_comment.php' method='POST'>";
                echo "<textarea name='comment_content' placeholder='Write your comment...' required></textarea><br>";
                echo "<input type='hidden' name='blog_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' value='Submit Comment'>";
                echo "</form>";

                echo "</div>";
                echo "<hr>";
            }
            
        } else {
            echo "<p>No blogs found</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
