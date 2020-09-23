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

/////////////////////////////////////////

?>

<?php include "../../../general/header.php"; ?>
<main>
	<h2>Result</h2>
	<p><a href="../../../teacher/course?course_name=<?=urlencode($_GET['course_name']);?>&course_code=<?=urlencode($_GET['course_code']);?>&course_id=<?=urlencode($_GET['course_id']);?>">Go back</a></p>
	<?php displayResults($_GET['course_id']); ?>
</main>