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


<!--	VIEW START	-->

<?php include "../general/header.php"; ?>

<h2>ADMINISTRATOR DASHBOARD</h2>
<?= flashMessage(); ?>
<p>
	<?= "Welcome, ".strtoupper( $_SESSION['first_name']." ".$_SESSION['last_name']); ?>
	<a style="float: right;" href="../general/pwdchange.php">Change my password</a>
</p>
<div class="admin-dash-container">
	<div class="admin-dash-item">
		<div class="add-account-container">
			<form method="post" action="add.php">
				<h4>Add New Account</h4>
				<?= flashMessageAdd(); ?>
				<select name="account_role">
					<option value="none">--select account--</option>
					<option value="student">Student</option>
					<option value="teacher">Teacher</option>
					<option value="admin">Administrator</option>
				</select>
				<button type="submit">Proceed</button>
			</form>
		</div>
	</div>
	<div class="admin-dash-item">
		<div class="edit-account-container">
			<form method="post" action="deled.php" autocomplete="off">
				<h4>Edit / Delete Account</h4>
				<?= flashMessageDeled(); ?>
				<select name="deled_account_role">
					<option value="none">--select account--</option>
					<option value="1">Student</option>
					<option value="2">Teacher</option>
					<option value="3">Administrator</option>
				</select>
				<input type="text" name="deled_registration_id" placeholder="Enter registration ID">
				<button type="submit" name="deled" value="edit">Edit</button>
				<button type="submit" name="deled" value="delete">Delete</button>
			</form>
		</div>
	</div>
	<div class="admin-dash-item">
		<div class="edit-account-container">
			<form method="post" action="pwdreset.php" autocomplete="off">
				<h4>Reset Account Password</h4>
				<?= flashMessagePwdReset(); ?>
				<select name="reset_account_role">
					<option value="none">--select account--</option>
					<option value="1">Student</option>
					<option value="2">Teacher</option>
					<option value="3">Administrator</option>
				</select>
				<input type="text" name="reset_registration_id" placeholder="Enter registration ID">
				<button type="submit" name="reset">Reset</button>
			</form>
		</div>
	</div>
</div>
<br><br>
<p><a href="../general/logout.php">Logout</a></p>


<!--	VIEW END	-->