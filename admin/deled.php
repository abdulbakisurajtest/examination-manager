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
	session_destroy();
	header('location: ../index.php');
	return;
}
if( isset($_POST['deled']))
{
	if( (isset($_POST['deled_account_role'])) && ($_POST['deled_account_role'] == 'none'))
	{
		$_SESSION['delederror'] = 'Please select a valid account';
		header('location: ../admin/index.php');
		return;
	}
	$status = delete_edit($_POST['deled_registration_id'], $_POST['deled_account_role'], $_POST['deled']);
	if ($status !== true)
	{
		$_SESSION['delederror'] = $status;
		header('location: ../admin/index.php');
		return;
	}
	else
	{
		if ($_SESSION['deled_action'] === 'edit')
		{
			header('location: edit.php');
			return;
		}
		else if ($_SESSION['deled_action'] === 'delete')
		{
			header('location: delete.php');
			return;
		}
	}
}