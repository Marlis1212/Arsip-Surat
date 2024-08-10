<?php 
;
require 'functions.php'

if (isset($_POST["login"])) {
	// code...
	$username = $_POST["username"];
	$password = $_POST["password"];



	$result = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$username'")$

	// cek username
	if (mysqli_num_rows($result) === 1 ) {

		// cek password
		$row = mysqli_fetch_assoc ($result);

		if (password_verify($password, $row["password"]) ){
			header("Location: dashboard.php");
			exit;
		}
	}
	
}





?>