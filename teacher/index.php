<?php
session_start();
require_once "../general/function.php";
require_once "../general/pdo.php";

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

<?php include "../general/header.php"; ?>
	<main>
		<p>
			<?php echo "Welcome ".$_SESSION['first_name']." ".$_SESSION['middle_name']." ".$_SESSION['last_name']; ?>
			<a style="float: right" href="../general/pwdchange.php">Change Password</a>
		</p>
		<p><strong>Site is still under construction................</strong></p>
		<h4>Add new course</h4>
		<form method="post" action="addcourse.php">
			<?= flashMessageAddCourse(); ?>
			Enter full course name
			<input type="text" name="course_name"><br>
			Enter course code
			<input type="text" name="course_code"><br>
			<input type="hidden" name="regid" value="<?= $_SESSION['registration_id']; ?>">
			<button type="submit" name="addcourse">Add</button>
		</form>
		<h4>List of courses created</h4>
		<?= flashMessageDeleteCourse(); ?>
		<?= flashMessageEditCourse(); ?>
		<?= displayListOfCourses($_SESSION['registration_id']); ?>
		<p><a href="../general/logout.php">Logout</a></p>
	</main>
</body>
</html>