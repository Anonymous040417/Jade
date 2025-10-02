<?php 
require_once 'php_action/db_connect.php';
session_start();

$errors = array();
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Check if user already exists
        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($connect, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Username already exists!";
        } else {
            $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($connect, $insert_sql)) {
                $success = "Sign up successful! You can now log in.";
            } else {
                $errors[] = "Error: " . mysqli_error($connect);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign Up - Jade Accessories</title>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

	<style>
		body {
			background: linear-gradient(135deg, #6dd5fa, #2980b9);
			font-family: 'Poppins', sans-serif;
		}
		.logo-header {
			position: absolute;
			top: 20px;
			left: 30px;
			color: white;
			font-size: 24px;
			font-weight: 600;
			display: flex;
			align-items: center;
		}
		.logo-header i {
			margin-right: 10px;
		}
		.vertical {
			margin-top: 80px;
		}
		.panel-info {
			background: white;
			border-radius: 20px;
			box-shadow: 0 8px 25px rgba(0,0,0,0.2);
			padding: 30px;
		}
		.panel-heading {
			background: #3498db;
			color: white;
			border-top-left-radius: 20px;
			border-top-right-radius: 20px;
			padding: 15px 20px;
		}
		.panel-title {
			font-size: 20px;
		}
		.form-control {
			border-radius: 10px;
		}
		.btn-default {
			background: #3498db;
			color: white;
			border: none;
			border-radius: 10px;
			transition: 0.3s;
		}
		.btn-default:hover {
			background: #2980b9;
			color: white;
		}
		.login-link {
			text-align: right;
			margin-top: 10px;
		}
		.login-link a {
			color: #3498db;
			text-decoration: none;
			font-weight: 500;
		}
		.login-link a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="logo-header">
		<i class="fa fa-diamond"></i> Jade Accessories
	</div>

	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Create Account</h3>
					</div>
					<div class="panel-body">
						<?php if ($errors): ?>
							<?php foreach ($errors as $error): ?>
								<div class="alert alert-warning">
									<i class="glyphicon glyphicon-exclamation-sign"></i> <?= $error ?>
								</div>
							<?php endforeach; ?>
						<?php elseif ($success): ?>
							<div class="alert alert-success">
								<i class="glyphicon glyphicon-ok"></i> <?= $success ?>
							</div>
						<?php endif; ?>

						<form class="form-horizontal" method="post" action="">
							<div class="form-group">
								<label for="username" class="col-sm-2 control-label">User</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="username" name="username" placeholder="Username">
								</div>
							</div>

							<div class="form-group">
								<label for="password" class="col-sm-2 control-label">Code</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-user"></i> Sign Up</button>
								</div>
							</div>

							<div class="login-link col-sm-offset-2 col-sm-10">
								Already have an account? <a href="index.php">Sign In</a>
							</div>
						</form>
					</div>
				</div> <!-- /panel -->
			</div>
		</div>
	</div>
</body>
</html>
