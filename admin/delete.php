<?php
require_once "../includes/pdo.php";
require_once "../includes/function.php";
session_start();

if($_SESSION['account_role'] != 3)
{
	session_destroy();
	header('location: ../index.php');
	return;
}

if ( isset($_POST['cancel_delete']))
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
if (isset ($_POST['continue_delete']))
{
	$sql = "DELETE FROM account WHERE account_id = :account_id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':account_id' => $_SESSION['deled_secret_id']));
	$_SESSION['deledsuccess'] = 'Account deleted';
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
?>

<?php include "../includes/header.php"; ?>
<h2>Delete Confirmation:</h2>
<p>
	Do you want to delete user account with the following details?
	<ul>
		<li>First Name: <?= htmlentities($_SESSION['deled_first_name']) ?></li>
		<li>Middle Name: <?= htmlentities($_SESSION['deled_middle_name']) ?></li>
		<li>Last Name: <?= htmlentities($_SESSION['deled_last_name']) ?></li>
		<li>Registration ID: <?= htmlentities($_SESSION['deled_registration_id']) ?></li>
	</ul>
</p>
<form method="post">
	<input type="submit" name="cancel_delete" value="No">
	<input type="submit" name="continue_delete" value="Yes">
</form>