<?php
session_start();
include('includes/dbconnection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingInfo = $_SESSION['booking_info'];
    $bookingID =$bookingInfo['booking_id'];
    // Retrieve payment information from the form
    $cardName = $_POST['card_name'];
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $totalPrice = $_POST['total_price'];
    $email = $bookingInfo['email'];

    // Here you would integrate with a real payment gateway API to process the payment
    // For this example, we will simulate a successful payment

    // Simulate payment success
    $paymentSuccess = true;

    if ($paymentSuccess) {
        $sqlUpdate = "UPDATE tblbooking SET payment_stat = 1 WHERE booking_id = :booking_id";
        $stmt = $dbh->prepare($sqlUpdate);
        $stmt->bindParam(':booking_id', $bookingID, PDO::PARAM_INT);
        $stmt->execute();
        // Clear booking information from session
        unset($_SESSION['booking_info']);

        // Redirect to a success page
        header("Location: payment_success.php");
        exit();
    } else {
        // Handle payment failure
        echo "<script>alert('Payment failed. Please try again.');</script>";
        header("Location: payment.php");
        exit();
    }
}
