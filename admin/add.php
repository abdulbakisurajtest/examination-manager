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
if($_SESSION['account_role'] != 3)
{
	$_SESSION['error'] = 'Access unauthorized';
	session_destroy();
	header('location: ../index.php');
	return;
}
if ( isset($_POST['add']))
{
	$add_new = addNewUser($_POST['registration_id'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['role']);
	if ( $add_new === true)
	{
		$_SESSION['addsuccess'] = 'Record added';
		header('location: index.php');
		return;
	}
	else
	{
		$_SESSION['error'] = $add_new;
		header('location: add.php');
		return;
	}
}

if(isset($_POST['account_role']))
{
	if($_POST['account_role'] == 'none')
	{
		$_SESSION['adderror'] = 'Please select a valid account';
		header('location: index.php');
		return;
	}
	else
	{	
		$_SESSION['add_role'] = $_POST['account_role'];
	}
}

?>


<?php include "../general/header.php";?>
<h2>Add New Entry</h2>
<?php flashMessage(); ?>
<label for="add">
	<form method="post">
		<label for="firstname">
			First name:<input type="text" name="firstname">
		</label>
		<label for="middlename">
			Middle name:<input type="text" name="middlename">
		</label>
		<label for="lastname">
			Surname/Last name:<input type="text" name="lastname">
		</label>
		<label for="registration_id">
			Registration ID:<input type="text" name="registration_id">
		</label>
		<?php
		if ( $_SESSION['add_role'] == 'admin')
		{
			?>
			<input type="hidden" name="role" value="3">
			<?php
		}
		if ( $_SESSION['add_role'] == 'teacher')
		{
			?>
			<input type="hidden" name="role" value="2">
			<?php
		}
		if ( $_SESSION['add_role'] == 'student')
		{
			?>
			<input type="hidden" name="role" value="1">
			<?php
		}
		?>
		<input type="submit" name="add" value="Add">
		<p><a href="../admin/index.php"><<< Back</a><p>
	</form>
</label>