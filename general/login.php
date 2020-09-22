<?php
session_start();

if($_SESSION['account_role'] == 1)
{
	header('location: ../student');
	return;
}
else if($_SESSION['account_role'] == 2)
{
	header('location: ../teacher');
	return;
}
else if($_SESSION['account_role'] == 3)
{
	header('location: ../admin');
	return;
}
else
{
	$_SESSION['error'] = "This account can't be redirected";
	header('location: ../index.php');
	return;
}

?>
