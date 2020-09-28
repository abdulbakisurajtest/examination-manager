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
?>

<?php include "../includes/header.php"; ?>
	<main>
		<h2>Lecturer Dashboard</h2>
		<p><?php echo "Welcome ".$_SESSION['first_name']." ".$_SESSION['middle_name']." ".$_SESSION['last_name']; ?></p>
		<p><strong>Site is still under construction................</strong></p>
		<p><a href="../includes/pwdchange.php">Change Password</a></p>
		<h3>Add new course</h3>
		<form method="post" action="addcourse.php">
			<?= flashMessageAddCourse(); ?>
			<label>
				Enter full course name<br/>
				<input type="text" name="course_name">
			</label><br/>
			<label>
				Enter course code<br/>
				<input type="text" name="course_code">
			</label><br/>
			<input type="hidden" name="regid" value="<?= $_SESSION['registration_id']; ?>">
			<input type="submit" name="addcourse" value="Add">
		</form>
		<h3>List of courses created</h3>
		<?= flashMessageDeleteCourse(); ?>
		<?= flashMessageEditCourse(); ?>
		<?= displayListOfCourses($_SESSION['registration_id']); ?>
		<p><a href="../includes/logout.php">Logout</a></p>
	</main>