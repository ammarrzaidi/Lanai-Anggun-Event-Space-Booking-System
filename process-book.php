<?php
// Include the database connection code
$con = mysqli_connect("localhost", "root", "", "obbs");

// Check the connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientName = $_POST['client_name'];
    $mobileNumber = $_POST['mobile_number'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'];
    $eventType = $_POST['package'];

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO tblbooking (client_name, mobile_number, event_date, event_time, package) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssss", $clientName, $mobileNumber, $eventDate, $eventTime, $eventType);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Close the statement
            mysqli_stmt_close($stmt);

            // Get the last inserted booking ID
            $bookingID = mysqli_insert_id($con);

            // Close the database connection
            mysqli_close($con);

            // Check if the booking ID is valid
            if ($bookingID > 0) {
                // Redirect to booking-payment.php with the booking ID
                header("Location: booking-payment.php?id=" . $bookingID);
                exit();
            } else {
                echo "Error: Invalid booking ID.";
                exit();
            }
        } else {
            // Handle execution error
            echo "Error executing statement: " . mysqli_stmt_error($stmt);
        }
    } else {
        // Handle preparation error
        echo "Error preparing statement: " . mysqli_error($con);
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($con);
?>
