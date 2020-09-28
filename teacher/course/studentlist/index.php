<?php
session_start();
require_once "../../../includes/function.php";
require_once "../../../includes/pdo.php";

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


// ensure the required $_GET[''] values are set

if ( !isset($_GET['course_name']) || !isset($_GET['course_code']) )
{
	header('Location: ../../index.php');
	return;
}


if ( isset($_POST['remove']))
{
	removeAuthorization($_POST['auth_id']);
	header( 'Location: ../studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']) );
	return;
}

if( isset( $_POST['add_auth']))
{
	$add_auth = addAuthorization( $_POST['authorize_regid'], $_GET['course_name'], $_GET['course_code']);
	if( $add_auth == 'success')
	{
		$_SESSION['addAuthSuccess'] = 'Student added';
		header( 'Location: ../studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']) );
		return;
	}
	else
	{
		$_SESSION['addAuthError'] = $add_auth;
		header( 'Location: ../studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']) );
		return;
	}
}

/////////////////////////////////////////
?>

<?php include "../../../includes/header.php"; ?>
<main>
	<h2>List of Authorized Students</h2>
	<p><a href="../../../teacher/course?course_name=<?=urlencode($_GET['course_name']);?>&course_code=<?=urlencode($_GET['course_code']);?>">Go back</a></p>
	<?= displayListOfStudents( $_GET['course_name'], $_GET['course_code'] ); ?>
	<h3>Add New Student To List</h4>
	<?= flashMessageAddAuthorization(); ?>
	<form method="post">
		<label>
			Registration ID<br/>
			<input type="text" name="authorize_regid">
		</label><br/>
		<input type="submit" name="add_auth" value="Add"> 
	</form>
</main>
