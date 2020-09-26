<?php
require_once "../general/pdo.php";
require_once "../general/function.php";

session_start();

// ensure session values are set and valid

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

/////////////////////////////////////////

if ( isset($_POST['reset']))
{
	$reset = passwordReset($_POST['registration_id'], $_POST['account_role']);
	$resetRole = $_POST['account_role'];
	if($reset === true)
	{
		$_SESSION['passwordResetSuccess'] = 'Password updated';
		$_SESSION['resetRole'] = $resetRole;
	}
	else
	{
		$_SESSION['passwordResetFail'] = $reset;
		$_SESSION['resetRole'] = $resetRole;
	}
	header('location: ../admin/index.php');
	return;
}
?>

<?php include "../general/header.php"; ?>

<h2>Administrator Dashboard</h2>
<?= flashMessage(); ?>
<?= "Welcome, ".strtoupper( $_SESSION['first_name']." ".$_SESSION['last_name']); ?>
<p><a href="../general/pwdchange.php">Change my password</a></p>
<h3>Account</h3>
<ul>
	<li>
		<h4>Add New</h4>
		<form method="post" action="add.php">
			<?= flashMessageAdd(); ?>
			<select name="account_role">
				<option value="none">--select account--</option>
				<option value="student">Student</option>
				<option value="teacher">Teacher</option>
				<option value="admin">Administrator</option>
			</select><br/>
			<input type="submit" name="submit" value="Proceed">
		</form>
	</li>
	<li>
		<h4>Edit / Delete</h4>
		<form method="post" action="deled.php" autocomplete="off">
			<?= flashMessageDeled(); ?>
			<select name="deled_account_role">
				<option value="none">--select account--</option>
				<option value="1">Student</option>
				<option value="2">Teacher</option>
				<option value="3">Administrator</option>
			</select><br/>
			<input type="text" name="deled_registration_id" placeholder="registration id"><br/>
			<input type="submit" name="edit" value="Edit">
			<input type="submit" name="delete" value="Delete">
		</form>
	</li>
	<li>
		<h4>Reset Password</h4>
		<form method="post" action="pwdreset.php" autocomplete="off">
			<?= flashMessagePwdReset(); ?>
			<select name="reset_account_role">
				<option value="none">--select account--</option>
				<option value="1">Student</option>
				<option value="2">Teacher</option>
				<option value="3">Administrator</option>
			</select><br/>
			<input type="text" name="reset_registration_id" placeholder="registration id"><br/>
			<input type="submit" name="reset" value="Reset">
		</form>
	</li>
</ul>
<p><a href="displaylect.php"><strong>View registered lecturers</strong></a></p>
<p><a href="../general/logout.php">Logout</a></p>