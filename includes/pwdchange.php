<?php

require_once "../includes/pdo.php";
require_once "../includes/function.php";

session_start();

if ( !isset( $_SESSION['registration_id']))
{
	$_SESSION['error'] = 'Login required';
	header('location: ../index.php');
	return;
}
if  ( $_SESSION['account_role'] > 3  || $_SESSION['account_role'] < 1)
{
	$_SESSION['error'] = 'Access unauthorized';
	header('location: ../index.php');
	return;
}

if ( isset($_POST['pwdChange']))
{
	$changePwd = validatePassword($_SESSION['registration_id'] , $_SESSION['account_role'], $_POST['oldpwd'], $_POST['newpwd'], $_POST['repnewpwd']);
	if ($changePwd == 'success')
	{
		$_SESSION['pwdchangesuccess'] = 'Password changed';
	}
	else
	{
		$_SESSION['pwdchangeerror'] = $changePwd;
	}
	header('Location: ../includes/pwdchange.php');
	return;
}

if ( isset ($_POST['direction']))
{
	switch ($_SESSION['account_role']) {
		case 1:
			header('Location: ../student/index.php');
			return;
			break;
		case 2:
			header('Location: ../teacher/index.php');
			return;
			break;
		case 3:
			header('Location: ../admin/index.php');
			return;
			break;
		default:
			header('Location: ../includes/logout.php');
			return;
			break;
	}
}

?>

<?php include "../includes/header.php"; ?>
<h2>Password Change</h2>
<form method="post">
	<?= flashMessagePwdChange(); ?>
	<label>
		Enter old password<br/>
		<input type="password" name="oldpwd">
	</label><br/>
	<label>
		Enter new password<br/>
		<input type="password" name="newpwd">
	</label><br/>
	<label>
		Retype new password<br/>
		<input type="password" name="repnewpwd">
	</label><br/>
	<input type="submit" name="pwdChange" value="Change">
	<input type="submit" name="direction" value="Cancel">
</form>