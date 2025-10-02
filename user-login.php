
<?php
include 'php_action/db_connect.php';
session_start();  // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM client WHERE email = '$email'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set a session variable to indicate user is logged in
            $_SESSION['user_id'] = $row['id'];
            // Login successful, redirect to index.html with a success message
            header("Location: client.php?login=success");
            exit();
        } else {
            // Incorrect password, redirect to login.html with an error message
            header("Location: user.php?login=error");
            echo "Incorrect email or password";
            exit();
        }
    } else {
        // User not found, redirect to login.html with an error message
        header("Location: user.php?login=error");
        exit();
    }
}

$connect->close();
?>

<?php
if (isset($_GET['login']) && $_GET['login'] == 'error') {
    echo '<p class="error-message">Incorrect email or password. Please try again.</p>';
}