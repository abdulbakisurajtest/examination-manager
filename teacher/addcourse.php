<?php
session_start();
require_once "../includes/function.php";
require_once "../includes/pdo.php";

// ensure session values are set and valid

if ( !isset( $_SESSION['registration_id']))
{
	$_SESSION['error'] = 'Login required';
	header('location: ../index.php');
	return;
}
if  ( $_SESSION['account_role'] != 2)
{
	$_SESSION['error'] = 'Access unauthorized';
	header('location: ../index.php');
	return;
}

/////////////////////////////////////////

if ( isset($_POST['addcourse']))
{
	$addcourse = addNewCourse($_POST['course_name'], $_POST['course_code'], $_POST['regid']);
	if ($addcourse == 'success')
	{
		$_SESSION['addCourseSuccess'] = 'Course added';
		header('location: index.php');
		return;
	}
	else
	{
		$_SESSION['addCourseError'] = $addcourse;
		header('location: index.php');
		return;
	}
}
?>