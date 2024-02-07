<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
            color: #4caf50;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Add Student</h1>
    <form action="add_student.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>
        <label for="roll_number">Roll Number:</label><br>
        <input type="text" id="roll_number" name="roll_number"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "myDatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Get data from form
$name = $_POST['name'];
$email = $_POST['email'];
$roll_number = $_POST['roll_number'];
if (!empty($name) && !empty($email) && !empty($roll_number) ) {

// Generate password
$password = generatePassword(8);

// Insert data into database
$sql = "INSERT INTO students (name, email, roll_number, password)
VALUES ('$name', '$email', '$roll_number', '$password')";


if ($conn->query($sql) === TRUE) {
        echo '<p class="success-message">New record created successfully</p>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}
$conn->close();

// Function to generate random password
function generatePassword($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

?>
