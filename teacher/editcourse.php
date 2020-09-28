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

if ( isset($_POST['confirmedit']))
{
	$editCourse = editCourse( $_GET['course_name'], $_GET['course_code'], $_POST['course_name'], $_POST['course_code']);
	if ( $editCourse == 'success')
	{
		$_SESSION['editCourseSuccess'] = 'Course details updated';
		header('Location: index.php');
		return;
	}
	else
	{
		$_SESSION['editCourseError'] = $editCourse;
		header('Location: editcourse.php?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']));
		return;
	}
}

if ( isset( $_POST['canceledit']))
{
	header('Location: index.php');
	return;
}
?>

<?php include "../includes/header.php"; ?>
<main>
	<h3>Edit Course</h3>
	<?= flashMessageEditCourse(); ?>
	<form method="post">
		<label>
			Course name<br/>
			<input type="text" name="course_name" value="<?= htmlentities($_REQUEST['course_name']); ?>">
		</label><br/>
		<label>
			Course code<br/>
			<input type="text" name="course_code" value="<?= htmlentities($_REQUEST['course_code']); ?>">
		</label><br/>
		<input type="submit" name="confirmedit" value="Edit">
		<input type="submit" name="canceledit" value="Cancel">
	</form>
</main>