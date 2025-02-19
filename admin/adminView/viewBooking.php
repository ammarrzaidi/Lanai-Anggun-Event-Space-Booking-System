<?php
include_once __DIR__ . "/../config/dbconnect.php";

// Function to delete a booking
function deleteBooking($conn, $bookingID) {
    $stmt = $conn->prepare("DELETE FROM booking WHERE booking_id = ?");
    $stmt->bind_param("i", $bookingID);
    if ($stmt->execute()) {
        echo "Booking deleted successfully.";
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
    $stmt->close();
}

// Check if delete request is submitted
if (isset($_GET['delete']) && isset($_GET['bookingID'])) {
    $bookingID = (int)$_GET['bookingID'];
    deleteBooking($conn, $bookingID);
}

// Retrieve and display bookings
$bookingSql = "SELECT booking_id, booking_time, client_name, mobile_number, event_date, event_time, package FROM tblbooking";
$bookingResult = $conn->query($bookingSql);

if ($bookingResult === false) {
    echo "Error executing query: " . $conn->error;
} else {
    if ($bookingResult->num_rows > 0) {
        echo "<h2>All Bookings</h2>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='text-center'>S.N.</th>";
        echo "<th class='text-center'>Booking Time</th>";
        echo "<th class='text-center'>Client Name</th>";
        echo "<th class='text-center'>Mobile Number</th>";
        echo "<th class='text-center'>Event Date</th>";
        echo "<th class='text-center'>Event Time</th>";
        echo "<th class='text-center'>Event Type</th>";
        echo "<th class='text-center'>Action</th>";
        echo "</tr>";
        echo "</thead>";

        $count = 1;
        while ($bookingRow = $bookingResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$count}</td>";
            echo "<td>{$bookingRow['booking_time']}</td>";
            echo "<td>{$bookingRow['client_name']}</td>";
            echo "<td>{$bookingRow['mobile_number']}</td>";
            echo "<td>{$bookingRow['event_date']}</td>";
            echo "<td>{$bookingRow['event_time']}</td>";
            echo "<td>{$bookingRow['package']}</td>";
            echo "<td><a href='?delete=true&bookingID={$bookingRow['booking_id']}' onclick='return confirm(\"Are you sure you want to delete this booking?\");'>Delete</a></td>";
            echo "</tr>";
            $count++;
        }

        echo "</table>";
    } else {
        echo "No bookings found.";
    }
}

$conn->close();
?>
