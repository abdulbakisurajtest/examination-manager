<?php
require_once "../general/pdo.php";
require_once "../general/function.php";
session_start();

if($_SESSION['account_role'] != 3)
{
	session_destroy();
	header('location: ../index.php');
	return;
}

if ( isset($_POST['cancel_edit']))
{
	unset($_SESSION['deled_first_name'] );
	unset($_SESSION['deled_middle_name']);
	unset($_SESSION['deled_last_name']);
	unset($_SESSION['deled_registration_id']);
	unset($_SESSION['deled_secret_id'] );
	unset($_SESSION['deled_action']);
	unset($_SESSION['deled_account_role_name']);
	unset($_SESSION['deled_account_role']);
	header('location: index.php');
	return;
}
if (isset ($_POST['continue_edit']))
{
	$update = editUser( $_SESSION['deled_secret_id'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name']);
	if($update === true)
	{	
		$_SESSION['deledsuccess'] = 'Account updated';
		unset($_SESSION['deled_first_name'] );
		unset($_SESSION['deled_middle_name']);
		unset($_SESSION['deled_last_name']);
		unset($_SESSION['deled_registration_id']);
		unset($_SESSION['deled_secret_id'] );
		unset($_SESSION['deled_action']);
		unset($_SESSION['deled_account_role_name']);
		unset($_SESSION['deled_account_role']);
		header('location: index.php');
		return;
	}
	else
	{	
		$_SESSION['error'] = $update;
		header('location: edit.php');
		return;
	}
}
?>


<?php include "../general/header.php"; ?>
<h2><?= htmlentities($_SESSION['deled_account_role_name']); ?> Account Edit</h2>
<?= flashMessage(); ?>
<form method="post" autocomplete="off">
	First Name: <input required type="text" name="first_name" value="<?= htmlentities($_SESSION['deled_first_name']); ?>"><br>
	Middle Name: <input type="text" name="middle_name" value="<?= htmlentities($_SESSION['deled_middle_name']); ?>" required><br>
	Last Name: <input type="text" name="last_name" value="<?= htmlentities($_SESSION['deled_last_name']); ?>" required><br>
	<input type="submit" name="continue_edit" value="Update">
	<input type="submit" name="cancel_edit" value="Cancel">
</form>