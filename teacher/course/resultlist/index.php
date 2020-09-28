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

/////////////////////////////////////////

// ensure the required $_GET[''] values are set

if ( !isset($_GET['course_name']) || !isset($_GET['course_code']) )
{
	header('Location: ../../index.php');
	return;
}

?>

<?php include "../../../includes/header.php"; ?>
<main>
	<h2>Results</h2>
	<p>Site is still under construction.......</p>
	<p><a href="../../../teacher/course?course_name=<?=urlencode($_GET['course_name']);?>&course_code=<?=urlencode($_GET['course_code']);?>">Go back</a></p>
	<?php displayResults($_GET['course_name'], $_GET['course_code']); ?>
</main>