<?php
// Start the session
session_start();

// Include the database connection code
$con = mysqli_connect("localhost", "root", "", "obbs");

// Check the connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $gender = $_POST['gender'];

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO message (name, email, comment, gender) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt === false) {
        $_SESSION['message'] = "Failed to prepare statement: " . mysqli_error($con);
        header("Location: message-us.php");
        exit();
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $comment, $gender);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Successfully submitted message";
        header("Location: message-us.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to submit message: " . mysqli_stmt_error($stmt);
        header("Location: message-us.php");
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($con);
?>
