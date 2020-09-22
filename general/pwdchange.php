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
	header('Location: ../general/pwdchange.php');
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
			header('Location: ../general/logout.php');
			return;
			break;
	}
}

?>

<!--	VIEW START	-->

<?php include "../general/header.php"; ?>
<h2>Password Change</h2>
<form method="POST">
	<?= flashMessagePwdChange(); ?>
	Enter old password
	<input type="password" name="oldpwd" placeholder="enter old password" required>
	Enter new password
	<input type="password" name="newpwd" placeholder="enter new password" required>
	Retype new password
	<input type="password" name="repnewpwd" placeholder="enter new password again" required>
	<button type="submit" name="pwdChange">Change</button>
</form>
<form method="post">
	<p><button type="submit" name="direction">Go back</button></p>
</form>