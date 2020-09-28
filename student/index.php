<?php
session_start();

// ensure session values are set and valid

if ( !isset( $_SESSION['registration_id']))
{
	$_SESSION['error'] = 'Login required';
	header('location: ../index.php');
	return;
}
if  ( $_SESSION['account_role'] != 1)
{
	$_SESSION['error'] = 'Access unauthorized';
	header('location: ../index.php');
	return;
}

/////////////////////////////////////////
?>

<?php include "../includes/header.php"; ?>
	<main>
		<p><?php echo "Welcome ".$_SESSION['first_name']." ".$_SESSION['middle_name']." ".$_SESSION['last_name']; ?></p>
		<p><strong>Site is still under construction................</strong></p>
		<p><a href="../includes/pwdchange.php">Change Password</a></p>
		<p><a href="../includes/logout.php">Logout</a></p>
	</main>