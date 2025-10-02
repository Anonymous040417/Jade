<?php 
require_once 'php_action/db_connect.php';
session_start();

if(isset($_SESSION['userId'])) {
	header('location:dashboard.php');	
}

$errors = array();

if($_POST) {		
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		} 
		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql="SELECT * FROM users WHERE username='$username' AND password='$password';";
		$result=mysqli_query($connect,$sql);
		$count=mysqli_num_rows($result);
		$row=mysqli_fetch_array($result);

		if ($count == 1) { 
			$_SESSION['userId'] = $row['username'];
			header("location:dashboard.php");
		} else {
			echo "<script>alert('Wrong details!!'); window.location='index.php';</script>";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Management System</title>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

	<!-- Custom Styles -->
	<style>
		body {
			background: linear-gradient(135deg, #2980b9, #6dd5fa);
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
		.signup-link {
			text-align: right;
			margin-top: 10px;
		}
		.signup-link a {
			color: #3498db;
			text-decoration: none;
			font-weight: 500;
		}
		.signup-link a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>

	<!-- Logo & Name -->
	<div class="logo-header">
		<i class="fa fa-diamond"></i> Jade Accessories
	</div>

	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Please Sign In</h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
								}
							} ?>
						</div>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="username" class="col-sm-2 control-label"> User</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Code</label>
									<div class="col-sm-10">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Sign In</button>
									  <div class="signup-link">
										Don't have an account? <a href="signup.php">Sign Up</a>
									  </div>
									</div>
								</div>
							</fieldset>
						</form>
					</div> <!-- panel-body -->
				</div> <!-- /panel -->
			</div> <!-- /col-md-4 -->
		</div> <!-- /row -->
	</div> <!-- container -->	

</body>
</html>
