<?php
include('../includes/dbconnection.php');
// include('../includes/functions.php');
session_start();
error_reporting(0);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $sql = "SELECT ID, Email, role FROM tbluser WHERE Email=:email AND Password=:password";
    try {
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {

            foreach ($results as $result) {

                $_SESSION['obbsuid'] = $result->ID;
                $_SESSION['auth'] = true;
                $_SESSION['login'] = $email;
                $_SESSION['auth_user'] = [
                    'user_id' => $result->ID,
                    'name' => $result->Name,
                    'email' => $result->Email
                ];
                
                $_SESSION['role'] = $result->role;

                if ($result->role == 1) {
                    $_SESSION['message'] = "Welcome to the dashboard";
                    header("Location: ../admin/adminindex.php");
                    // redirect("../admin/adminindex.php", "Welcome to the dashboard");
                } else {
                    $_SESSION['message'] = "Success Login";
                    header("Location: ../index.php");
                    // redirect("../index.php", "Welcome to the registration page");
                }
            }
        } else {
            $_SESSION['message'] = "Invalid Details";
            // Redirect to login page with error message
            header("Location: ../login.php");
            exit();
        }
    } catch (PDOException $e) {
        die('Error in SQL query: ' . $e->getMessage() . '<br>Query: ' . $sql);
    }
}