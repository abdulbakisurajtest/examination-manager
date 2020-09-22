<?php
session_start();
require_once "../../../general/function.php";
require_once "../../../general/pdo.php";

// ensure session values are set and valid

if ( !isset( $_SESSION['registration_id']))
{
	$_SESSION['error'] = 'Login required';
	header('location: ../../../index.php');
	return;
}
if  ( $_SESSION['account_role'] != 2)
{
	$_SESSION['error'] = 'Access unauthorized';
	header('location: ../../../index.php');
	return;
}

/////////////////////////////////////////
print_r($_GET);