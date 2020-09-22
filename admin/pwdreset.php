<?php
require_once "../general/pdo.php";
require_once "../general/function.php";
session_start();

if ( !isset( $_SESSION['registration_id']))
{
	$_SESSION['error'] = 'Login required';
	header('location: ../index.php');
	return;
}
if  ( $_SESSION['account_role'] != 3)
{
	$_SESSION['error'] = 'Access unauthorized';
	header('location: ../index.php');
	return;
}

if ( isset($_POST['reset']))
{
	if( isset($_POST['reset_account_role']))
	{
		if ($_POST['reset_account_role'] == 'none')
		{
			$_SESSION['pwdResetError'] = 'Please select a valid account';
			header('location: index.php');
			return;
		}
	}
	$getResetInfo = resetInfo($_POST['reset_registration_id'], $_POST['reset_account_role']);
	if ( $getResetInfo === true)
	{
		header('location: pwdreset.php');
		return;
	}
	else
	{
		$_SESSION['pwdResetError'] = $getResetInfo;
		header('location: index.php');
		return;
	}
}
if ( isset($_POST['continue_reset']))
{
	$resetPassword = passwordReset($_SESSION['reset_secret_id']);
	$_SESSION['pwdResetSuccess'] = "Password has been set to ' ".$resetPassword. " '";
	unset($_SESSION['reset_first_name'] );
	unset($_SESSION['reset_middle_name']);
	unset($_SESSION['reset_last_name']);
	unset($_SESSION['reset_registration_id']);
	unset($_SESSION['reset_secret_id'] );
	unset($_SESSION['reset_action']);
	unset($_SESSION['reset_account_role_name']);
	unset($_SESSION['reset_account_role']);
	header('location: index.php');
	return;
}
if ( isset($_POST['cancel_reset']))
{
	$_SESSION['pwdResetError'] = "Operation terminated !";
	unset($_SESSION['reset_first_name'] );
	unset($_SESSION['reset_middle_name']);
	unset($_SESSION['reset_last_name']);
	unset($_SESSION['reset_registration_id']);
	unset($_SESSION['reset_secret_id'] );
	unset($_SESSION['reset_action']);
	unset($_SESSION['reset_account_role_name']);
	unset($_SESSION['reset_account_role']);
	header('location: index.php');
	return;
}

?>

<?php include "../general/header.php"; ?>
<h2>Reset Confirmation:</h2>
<p>
	Do you want to reset password for user account with the following details?
	<ul>
		<li>First Name: <?= htmlentities($_SESSION['reset_first_name']) ?></li>
		<li>Middle Name: <?= htmlentities($_SESSION['reset_middle_name']) ?></li>
		<li>Last Name: <?= htmlentities($_SESSION['reset_last_name']) ?></li>
		<li>Registration ID: <?= htmlentities($_SESSION['reset_registration_id']) ?></li>
	</ul>
	<form method="post">
		<input type="submit" name="cancel_reset" value="No">
		<input type="submit" name="continue_reset" value="Yes">
	</form>