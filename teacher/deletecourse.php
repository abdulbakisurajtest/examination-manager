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

if ( isset($_POST['confirmdelete']))
{
	$deleteCourse = deleteCourse( $_REQUEST['course_name'], $_REQUEST['course_code'] );
	if($deleteCourse == 'success')
	{
		$_SESSION['deleteCourseSuccess'] = 'Course deleted';
		header('Location: index.php');
		return;
	}
	else
	{
		$_SESSION['deleteCourseError'] = $deleteCourse;
		header('Location: index.php');
		return;
	}
}

if ( isset( $_POST['canceldelete']))
{
	$_SESSION['deleteCourseError'] = 'Operation aborted';
	header('Location: index.php');
	return;
}

?>

<?php include "../includes/header.php"; ?>
<main>
	<h3>Delete Course</h3>
	<p>
		You are about to delete <strong><?= htmlentities($_REQUEST['course_name']); ?></strong> with course code <strong><?= htmlentities($_REQUEST['course_code']); ?></strong>?
	</p>
	<form method="post">
		<input type="hidden" name="course_name" value="<?= htmlentities($_REQUEST['course_name']); ?>">
		<input type="hidden" name="course_code" value="<?= htmlentities($_REQUEST['course_code']); ?>">
		<input type="submit" name="confirmdelete" value="Delete">
		<input type="submit" name="canceldelete" value="Cancel">
	</form>
</main>