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

if ( isset($_POST['remove']))
{
	removeAuthorization($_POST['auth_id']);
	header('Location: ../studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code'])."&course_id=".urlencode($_GET['course_id']) );
	return;
}

if( isset( $_POST['add_auth']))
{
	$add_auth = addAuthorization( $_POST['authorize_regid'], $_GET['course_id']);
	if( $add_auth == 'success')
	{
		$_SESSION['addAuthSuccess'] = 'Student added';
		header('Location: ../studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code'])."&course_id=".urlencode($_GET['course_id']) );
		return;
	}
	else
	{
		$_SESSION['addAuthError'] = $add_auth;
		header('Location: ../studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code'])."&course_id=".urlencode($_GET['course_id']) );
		return;
	}
}

/////////////////////////////////////////
?>

<?php include "../../../general/header.php"; ?>
<main>
	<p><a href="../../../teacher/course?course_name=<?=urlencode($_GET['course_name']);?>&course_code=<?=urlencode($_GET['course_code']);?>&course_id=<?=urlencode($_GET['course_id']);?>">Go back</a></p>
	<h4>List of Students Allowed To Take Exam</h4>
	<?= displayListOfStudents( $_GET['course_id'] ); ?>
	<h4>Add New Student To List</h4>
	<p><?= flashMessageAddAuthorization(); ?></p>
	<form method="post">
		<input type="text" name="authorize_regid" placeholder="enter registration id">
		<input type="submit" name="add_auth" value="Add"> 
	</form>
</main>
