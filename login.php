<?php
session_start();

if( isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}

require 'koneksi.php';

if( isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];


	$result = mysqli_query($kon, "SELECT * FROM admin WHERE username = '$username'");


	//cek username
	if( mysqli_num_rows($result) === 1 ){

		//cek password
		$row =  mysqli_fetch_assoc($result);

		//set session
		$_SESSION["login"] = true;
			header("Location: index.php");
			exit;
	
	}

	$error = true;
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/sigin.css">
	<script src="asset/js/jquery-3.2.1.slim.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
</head>
<body class="text-center">
	

<form class="form-signin" action="" method="post">
    
      <h1 class="h3 mb-3 font-weight-normal">Aplikasi Penjadwalan Karyawan Genetika</h1>
      <label for="inputEmail" class="sr-only">Username</label>
      <input type="text" id="username" name="username" class="form-control" placeholder="username" required autofocus>
	  <br>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
      
      <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Login</button>
     
    </form>


</body>
</html>