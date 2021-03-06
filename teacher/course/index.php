<?php
session_start();
require_once "../../includes/function.php";
require_once "../../includes/pdo.php";

// ensure session values are set and valid

if ( !isset( $_SESSION['registration_id']))
{
	$_SESSION['error'] = 'Login required';
	header('location: ../../index.php');
	return;
}
if  ( $_SESSION['account_role'] != 2)
{
	$_SESSION['error'] = 'Access unauthorized';
	header('location: ../../index.php');
	return;
}

// ensure the required $_GET[''] values are set

if ( !isset($_GET['course_name']) || !isset($_GET['course_code']) )
{
	header('Location: ../index.php');
	return;
}

if ( isset($_POST['changestatus']))
{
	$changestatus = changeCourseStatus( $_GET['course_name'], $_GET['course_code'], $_POST['status']);
	if( $changestatus == 'online')
	{
		$_SESSION['changeCourseStatusOnline'] = 'Course is now online';
		header('Location: index.php?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']));
		return;
	}
	elseif ( $changestatus == 'offline')
	{
		$_SESSION['changeCourseStatusOffline'] = 'Course is now offline';
		header('Location: index.php?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']));
		return;
	}
	else
	{
		$_SESSION['changeCourseStatusError'] = $changestatus;
		header('Location: index.php?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']));
		return;
		return;
	}
}
?>


<?php include "../../includes/header.php"; ?>
<main>
	<p><a href="../../teacher/index.php">Go back</a></p>
	<h4><?= strtoupper($_GET['course_name'])." - ".strtoupper($_GET['course_code']); ?></h4>
	<ul>
		<li>
			Course Status: <?= courseAvailabityStatus( $_GET['course_name'], $_GET['course_code']); ?><br>
			<?= flashMessageChangeCourseStatus(); ?>
			<form method="post">
				<select name="status">
					<option value="none">--change status--</option>
					<option value="on"> online </option>
					<option value="off"> offline </option>
				</select><br/>
				<input type="submit" name="changestatus" value="Change">
			</form>
		</li><br/>
		<li><a href="<?= 'questionlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']); ?>"> View/Edit questions </a></li><br/>
		<li><a href="<?= 'studentlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']); ?>"> List of authorized students </a></li><br/>
		<li><a href="<?= 'resultlist?course_name='.urlencode($_GET['course_name'])."&course_code=".urlencode($_GET['course_code']); ?>"> View results </a></li>
	</ul>
</main>