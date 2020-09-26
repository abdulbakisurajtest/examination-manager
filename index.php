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

<?php include "general/header.php"; ?>

<form method="post" autocomplete="off">
	<h2>Sign In</h2>
	<label>
		Registration ID<br/>
		<input type="text" name="registrationid">
	</label>
	<br/>
	<label>
		Password<br/>
		<input type="password" name="password">
	</label>
	<br/>
	<?php flashMessage(); ?>
	<input class="submitlogin" type="submit" name="login" value="Login">
</form>