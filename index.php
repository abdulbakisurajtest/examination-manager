<?php

session_start();

require_once "general/pdo.php";
require_once "general/function.php";

if( isset($_POST['login']))
{
	$auth = loginAuthentication($_POST['registrationid'], $_POST['password']);
	if ($auth === true)
	{
		header('location: general/login.php');
		return;
	}
	else
	{	
		$_SESSION['error'] = $auth;
		header('location: index.php');
		return;
	}
}
?>

<!--html header-->
<?php include "general/header.php"; ?>
<div class="login-form">
	<form method="post" autocomplete="off">
		<div class="login-form-container">
			<h2>Login To Proceed</h2>
			<label for="regid"><b>Registration ID</b></label>
			<input type="text" name="registrationid" placeholder="Enter registration ID">
			<label for="psw"><b>Password</b></label>
			<input type="password" name="password" placeholder="Enter password">
			<p><?php flashMessage(); ?></p>
			<button type="submit" name="login">Login</button>
		</div>
	</form>
</div>