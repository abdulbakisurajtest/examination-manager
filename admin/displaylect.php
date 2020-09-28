<?php
require_once "../includes/pdo.php";
require_once "../includes/function.php";

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
?>

<?php include "../includes/header.php"; ?>
<main>
	<h2>List of Registered Lecturers</h2>
	<p><a href="index.php">Go back</a></p>
	<p>
		<?= displayTeacherForAdmin(); ?>
	</p>
	<p><a href="index.php">Go back</a></p>
</main>