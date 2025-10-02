<?php
include 'php_action/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO client (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($connect->query($sql) === TRUE) {
        // Registration successful, redirect back to register.html with a success message
        header("Location: user.php?registration=success");
        exit();
    } else {
        // Display error message on the same page
        header("Location: user.php?registration=error");
        echo "Registration failed";
        exit();
    }
}

$connect->close();
?>
