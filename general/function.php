<!--This file contains all functions used in the application -->

<?php

function loginAuthentication($regid, $pwd)
{
	include "pdo.php";
	if ( empty($regid) || empty($pwd))
	{
		return "All fields are required";
	}
	else
	{
		$stmt = $pdo->prepare("SELECT registration_id FROM account WHERE registration_id = :registration_id");
		$stmt->execute(array(':registration_id'=>$regid
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ( $row === false)
		{
			return "Registration ID is incorrect";
		}
		else
		{	
			$stmt = $pdo->prepare("SELECT * FROM account WHERE registration_id = :registration_id AND password = :password");
			$stmt->execute( array( ':registration_id'=>$regid, ':password'=>hash('md5', $pwd)) );
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ( $row === false)
			{
				return "Password is incorrect";
			}
			else
			{
				$_SESSION['first_name'] = htmlentities($row['first_name']);
				$_SESSION['middle_name'] = htmlentities($row['middle_name']);
				$_SESSION['last_name'] = htmlentities($row['last_name']);
				$_SESSION['registration_id'] = htmlentities($row['registration_id']);
				$_SESSION['account_role'] = htmlentities($row['account_role']);
				return true;
			}	
		}
	}
}

function flashMessage()
{
	if ( isset($_SESSION['error']))
	{
		echo '<p style="color: red;">'.$_SESSION['error']."</p>";
		unset($_SESSION['error']);
	}
	if ( isset($_SESSION['success']))
	{
		echo '<p style="color: green;">'.$_SESSION['success']."</p>";
		unset($_SESSION['success']);
	}
}

function addNewUser($regid, $first, $middle, $last, $role)
{
	include "pdo.php";
	$_SESSION['exists1'] = $regid;
	if ( empty($regid) || empty($first) || empty($middle) || empty($last) || empty($role))
	{
		return "All fields are required";
	}
	else 
	{
		$stmt = $pdo->prepare("SELECT registration_id FROM account WHERE registration_id = :registration_id");
		$stmt->execute(array(
			':registration_id'=>$regid
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			return 'Record exists';
		}
		else
		{
			$hashedpassword = hash('md5', '123456789');
			$sql = "INSERT INTO account (registration_id, first_name, middle_name, last_name, password, account_role) VALUES (:registration_id, :first_name, :middle_name, :last_name, :password, :account_role)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
				':registration_id'=>$regid,
				':first_name'=>$first,
				':middle_name'=>$middle,
				':last_name'=>$last,
				':password'=>$hashedpassword,
				':account_role'=>$role,));
			return true;
		}
	}
}

function flashMessageAdd()
{
	if ( isset($_SESSION['adderror']))
	{
		echo '<p style="color: red;">'.$_SESSION['adderror']."</p>";
		unset($_SESSION['adderror']);
	}
	if ( isset($_SESSION['addsuccess']))
	{
		echo '<p style="color: green;">'.$_SESSION['addsuccess']."</p>";
		unset($_SESSION['addsuccess']);
	}
}

function delete_edit($regid, $role, $action)
{
	include "pdo.php";
	if( $action == 'none')
	{
		return 'Please select a valid account';
	}
	else if( empty($regid) )
	{
		return 'enter a valid registration ID';
	}
	else
	{
		$sql = "SELECT * FROM account WHERE registration_id = :registration_id AND account_role = :account_role";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':registration_id'=>$regid,
			':account_role'=>$role
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			$_SESSION['deled_first_name'] = $row['first_name'];
			$_SESSION['deled_middle_name'] = $row['middle_name'];
			$_SESSION['deled_last_name'] = $row['last_name'];
			$_SESSION['deled_registration_id'] = $row['registration_id'];
			$_SESSION['deled_secret_id'] = $row['account_id'];
			$_SESSION['deled_account_role'] = $row['account_role'];
			$_SESSION['deled_action'] = $action;
			switch ($role)
			{
				case 1:
					$_SESSION['deled_account_role_name'] = 'Student';
					break;
				case 2:
					$_SESSION['deled_account_role_name'] = 'Teacher';
					break;
				case 3:
					$_SESSION['deled_account_role_name'] = 'Administrator';
					break;
			}
			return true;
		}
		else{
			return "Account with that registration id and role does not exist";
		}
		
	}
}

function flashMessageDeled()
{
	if (isset($_SESSION['delederror']))
	{
		echo '<div style="color: red;">'.$_SESSION['delederror']."</div>";
		unset($_SESSION['delederror']);
	}
	if (isset($_SESSION['deledsuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['deledsuccess']."</div>";
		unset($_SESSION['deledsuccess']);
	}
}

function editUser($id, $first, $middle, $last)
{
	include "pdo.php";
	if ( empty($id) || empty($first) || empty($middle) || empty($last))
	{
		return "All fields are required";
	}
	else 
	{
		$sql = "UPDATE account SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name WHERE account_id = :account_id" ;
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':account_id' => $id,
			':first_name' => $first, 
			':middle_name' => $middle,
			':last_name' => $last
		));
		return true;
	}
}

function resetInfo($regid, $role)
{
	include "pdo.php";
	if( empty($regid) )
	{
		return 'enter a valid registration ID';
	}
	else
	{
		$sql = "SELECT * FROM account WHERE registration_id = :registration_id AND account_role = :account_role";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':registration_id'=>$regid,
			':account_role'=>$role
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			$_SESSION['reset_first_name'] = $row['first_name'];
			$_SESSION['reset_middle_name'] = $row['middle_name'];
			$_SESSION['reset_last_name'] = $row['last_name'];
			$_SESSION['reset_registration_id'] = $row['registration_id'];
			$_SESSION['reset_secret_id'] = $row['account_id'];
			$_SESSION['reset_account_role'] = $row['account_role'];
			$_SESSION['reset_action'] = $action;
			switch ($role)
			{
				case 1:
					$_SESSION['reset_account_role_name'] = 'Student';
					break;
				case 2:
					$_SESSION['reset_account_role_name'] = 'Teacher';
					break;
				case 3:
					$_SESSION['reset_account_role_name'] = 'Administrator';
					break;
			}
			return true;
		}
		else{
			return "Account with that registration id and role does not exist";
		}
		
	}
}

function passwordReset($id)
{
	include "pdo.php";
	$defaultpassword = '123456789';
	$hashedpassword = hash('md5', $defaultpassword);
	$sql = "UPDATE account SET password = :password WHERE account_id = :account_id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':password'=>$hashedpassword,
		':account_id'=>$id));
	return $defaultpassword;
}

function flashMessagePwdReset()
{
	if (isset($_SESSION['pwdResetError']))
	{
		echo '<div style="color: red;">'.$_SESSION['pwdResetError']."</div>";
		unset($_SESSION['pwdResetError']);
	}
	if (isset($_SESSION['pwdResetSuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['pwdResetSuccess']."</div>";
		unset($_SESSION['pwdResetSuccess']);
	}
}

function validatePassword($regid, $role, $oldpwd, $newpwd1, $newpwd2)
{
	include "pdo.php";
	if ( empty($oldpwd) || empty($newpwd1) || empty($newpwd2))
	{
		return 'Password field must not be empty';
	}
	else if( (strlen($newpwd1) < 8) || (strlen($newpwd2) < 8) )
	{
		return 'New password length must be at least 8 characters';
	}
	else if ($newpwd1 != $newpwd2)
	{
		return 'New passwords do not match';
	}
	else
	{
		$oldpwd = hash('md5', $oldpwd);
		$sql = "SELECT * FROM account WHERE registration_id = :registration_id AND password = :password";
		$stmt = $pdo->prepare($sql);
			$stmt->execute( array(
				':registration_id'=>$regid, 
				':password'=> $oldpwd) );
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ( $row === false)
			{
				return "Old password is incorrect";
			}
			else
			{
				$account_id = $row['account_id'];
				$newpwd = hash('md5', $newpwd1);
				$sql = "UPDATE account SET password = :password WHERE account_id = :account_id";
				$stmt = $pdo->prepare($sql);
				$stmt->execute( array(
					':account_id'=>$account_id, 
					':password'=> $newpwd) );
				return 'success';
			}
	}
}

function flashMessagePwdChange()
{
	if (isset($_SESSION['pwdchangeerror']))
	{
		echo '<div style="color: red;">'.$_SESSION['pwdchangeerror']."</div>";
		unset($_SESSION['pwdchangeerror']);
	}
	if (isset($_SESSION['pwdchangesuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['pwdchangesuccess']."</div>";
		unset($_SESSION['pwdchangesuccess']);
	}
}

function getAccountId($regid)
{
	include "pdo.php";
	$getid = "SELECT account_id FROM account WHERE registration_id = :registration_id ";
		$getidstmt = $pdo->prepare($getid);
		$getidstmt->execute(array(
			':registration_id' => $regid
		));
	$getrow = $getidstmt->fetch(PDO::FETCH_ASSOC);
	if(!$getrow)
	{
		return "error";
	}
	else
	{
		return $getrow['account_id'];
	}
}

function addNewCourse($course_name, $course_code, $regid)
{
	include "pdo.php";
	if ( empty($course_name) || empty($course_code) || empty($regid) )
	{
		return "All fields are required";
	}
	else 
	{
		$stmt = $pdo->prepare("SELECT course_name, course_code FROM course WHERE course_name = :course_name AND course_code = :course_code");
		$stmt->execute(array(
			':course_name'=>$course_name,
			':course_code' => $course_code
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			return 'Record exists';
		}
		else
		{
			$secret_id = getAccountId($regid);
			if ($secret_id == 'error')
			{
				return "couldn't retrieve account id";
			}
			else
			{
				$sql = "INSERT INTO course (course_name, course_code, account_id) VALUES (:course_name, :course_code, :account_id)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array(
					':course_name'=>$course_name,
					':course_code'=>$course_code,
					':account_id'=>$secret_id,
				));

				$sql2 = "SELECT * FROM course WHERE course_name = :course_name AND course_code = :course_code";
				$stmt2 = $pdo->prepare($sql2);
				$stmt2->execute(array(
					':course_name'=>$course_name,
					':course_code'=>$course_code
				));
				$row2 = $stmt2->fetch( PDO::FETCH_ASSOC);
				if ($row2)
				{
					$course_id = $row2['course_id'];

					$sql3 = "INSERT INTO state ( course_id, status ) VALUES ( :course_id, :status )";
					$stmt3 = $pdo->prepare( $sql3 );
					$stmt3->execute(array(
						':course_id'=>$course_id,
						':status'=> '3'
					));
				}
				return 'success';
			}
		}
	}
}

function flashMessageAddCourse()
{
	if (isset($_SESSION['addCourseError']))
	{
		echo '<div style="color: red;">'.$_SESSION['addCourseError']."</div>";
		unset($_SESSION['addCourseError']);
	}
	if (isset($_SESSION['addCourseSuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['addCourseSuccess']."</div>";
		unset($_SESSION['addCourseSuccess']);
	}
}

function displayListOfCourses($regid)
{
	include "pdo.php";
	$getId = getAccountId($regid);
	if($getId == 'error')
	{
		return "could't retrieve account details";
	}
	else
	{
		$sql = "SELECT * FROM course WHERE account_id = :account_id ORDER BY course_code";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':account_id' => $getId
		));
		echo '<table border="1">';
		echo "<th>Course Name</th>";
		echo "<th>Course Code</th>";
		echo "<th>Action</th>";
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo "<tr><td>";
			echo htmlentities($row['course_name']);
			echo "</td><td>";
			echo htmlentities($row['course_code']);
			echo "</td><td>";
			echo "<a href='course?course_name=".htmlentities($row['course_name'])."&course_code=".htmlentities($row['course_code'])."&course_id=".htmlentities($row['course_id'])."'>Open</a>";
			echo " | ";
			echo "<a href='editcourse.php?course_name=".htmlentities($row['course_name'])."&course_code=".htmlentities($row['course_code'])."'>Edit</a>";
			echo " | ";
			echo "<a href='deletecourse.php?course_name=".htmlentities($row['course_name'])."&course_code=".htmlentities($row['course_code'])."'>Delete</a>";
			echo "</td><tr>";	
		}
		echo "</table>";
	}
}

function deleteCourse($course_name, $course_code)
{
	include "pdo.php";
	$sql1 = "SELECT * FROM course WHERE course_name = :course_name AND course_code = :course_code";
	$stmt1 = $pdo->prepare($sql1);
	$stmt1->execute(array(
		':course_name'=>$course_name,
		':course_code'=>$course_code
	));
	$row = $stmt1->fetch(PDO::FETCH_ASSOC);
	if($row)
	{
		$deleteid = $row['course_id'];
		$sql2 = "DELETE FROM course WHERE course_id = :course_id";
		$stmt2 = $pdo->prepare($sql2);
		$stmt2->execute(array(
			':course_id'=>$deleteid
		));
		return 'success';
	}
	else
	{
		return "Course or course code is invalid";
	}
}

function flashMessageDeleteCourse()
{
	if (isset($_SESSION['deleteCourseError']))
	{
		echo '<div style="color: red;">'.$_SESSION['deleteCourseError']."</div>";
		unset($_SESSION['deleteCourseError']);
	}
	if (isset($_SESSION['deleteCourseSuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['deleteCourseSuccess']."</div>";
		unset($_SESSION['deleteCourseSuccess']);
	}
}

function editCourse( $old_course_name, $old_course_code, $new_course_name, $new_course_code)
{
	include "pdo.php";
	if ( empty($new_course_name) || empty($new_course_code) )
	{
		return "All fields are required";
	}
	else 
	{
		$sql1 = "SELECT * FROM course WHERE course_name = :new_course_name AND course_code = :new_course_code";
		$stmt1 = $pdo->prepare($sql1);
		$stmt1->execute(array(
			':new_course_name' => $new_course_name,
			':new_course_code' => $new_course_code
		));
		$row = $stmt1->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			return 'Course with such combinations exists already !';
		}
		else
		{
			$sql2 = "UPDATE course SET course_name = :new_course_name, course_code = :new_course_code WHERE course_name = :old_course_name AND course_code = :old_course_code";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->execute(array(
				':new_course_name' => $new_course_name,
				':new_course_code' => $new_course_code,
				':old_course_name' => $old_course_name,
				':old_course_code' => $old_course_code
			));
			return 'success';
		}
	}
}

function flashMessageEditCourse()
{
	if (isset($_SESSION['editCourseError']))
	{
		echo '<div style="color: red;">'.$_SESSION['editCourseError']."</div>";
		unset($_SESSION['editCourseError']);
	}
	if (isset($_SESSION['editCourseSuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['editCourseSuccess']."</div>";
		unset($_SESSION['editCourseSuccess']);
	}
}

function courseAvailabityStatus($course_id)
{
	include "pdo.php";
	$sql = "SELECT * FROM state WHERE course_id = :course_id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute( array(
			':course_id' => $course_id
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ( !$row )
		{
			return '<span style="color: red;">status unavailable</span>';
		}
		else
		{
			if ( $row['status'] == 2)
			{
				return '<span style="color: green;">online</span>';
			}
			if ( $row['status'] == 3)
			{
				return '<span style="color: red;">offline</span>';
			}
		}
}

function changeCourseStatus($course_id, $course_status)
{
	include "pdo.php";
	if ( $course_status == 'none')
	{
		return "Please select a status (online/offline)";
	}
	else
	{
		$status = 3;
		if ( $course_status == 'on')
		{
			$status = 2;
		}
		else if ( $course_status == 'off')
		{
			$status = 3;
		}
		else
		{
			$status = 3;
		}

		$sql1 = "SELECT * FROM state WHERE course_id = :course_id";
		$stmt1 = $pdo->prepare($sql1);
		$stmt1->execute( array(
			':course_id' => $course_id
		));
		$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
		if (!$row1)
		{
			return "Couldn't find course";
		}
		else
		{
			$state_id = $row1['state_id'];
			$sql2 = "UPDATE state SET status = :status WHERE state_id = :state_id";
			$stmt2 = $pdo->prepare( $sql2 );
			$stmt2->execute( array( 
				':status' => $status,
				':state_id' => $state_id
			));
			if ( $status == 2)
			{
				return 'online';
			}
			if ( $status == 3)
			{
				return 'offline';
			}
		}
	}
}
function flashMessageChangeCourseStatus()
{
	if (isset($_SESSION['changeCourseStatusError']))
	{
		echo '<div style="color: red;">'.$_SESSION['changeCourseStatusError']."</div>";
		unset($_SESSION['changeCourseStatusError']);
	}
	if (isset($_SESSION['changeCourseStatusOffline']))
	{
		echo '<div style="color: green;">'.$_SESSION['changeCourseStatusOffline']."</div>";
		unset($_SESSION['changeCourseStatusOffline']);
	}
	if (isset($_SESSION['changeCourseStatusOnline']))
	{
		echo '<div style="color: green;">'.$_SESSION['changeCourseStatusOnline']."</div>";
		unset($_SESSION['changeCourseStatusOnline']);
	}
}

function displayListOfStudents($course_id)
{
	include "pdo.php";
	$getId = $course_id;
	if($getId == 'error')
	{
		return "could't retrieve course details";
	}
	else
	{
		$sql = "SELECT * FROM authorization WHERE course_id = :course_id";
		$stmt = $pdo->prepare( $sql );
		$stmt->execute( array(
			':course_id' => $getId
		));
		echo '<table border="1" style="text-align: center;">';
		echo "<th>Registration Number</th>";
		echo "<th>Name</th>";
		echo "<th>Action</th>";
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$account_id = $row['account_id'];	
			$sql2 = "SELECT * FROM account WHERE account_id = :account_id";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->execute( array(
				':account_id' => $account_id
			));
			$row2 = $stmt2->fetch( PDO::FETCH_ASSOC);
			$full_name = $row2['first_name']." ".$row2['middle_name']." ".$row2['last_name'];
			$regid = $row2['registration_id'];
			$auth_id = $row['authorization_id'];
			echo "<tr><td>";
			echo $regid;
			echo "</td><td>";
			echo $full_name;
			echo "</td><td>";
			echo "<form method='post'>";
			echo '<input type="hidden" name="auth_id" value="'.$auth_id.'">';
			echo '<button type="submit" name="remove" style="background-color: #ff4444;color: white;">Remove </button>';
			echo "</form>";
			echo "</td></tr>";
		}
		echo '</table>';
	}
}

function removeAuthorization($auth_id)
{
	include "pdo.php";
	$stmt = $pdo->prepare("DELETE FROM authorization WHERE authorization_id=:authorization_id");
	$stmt->execute( array(
		':authorization_id'=>$auth_id));
}
function addAuthorization($regid, $course_id)
{
	include "pdo.php";
	if( empty($regid) )
	{
		return "registration id cannot be empty";
	}
	else
	{
		$sql1 = "SELECT * FROM account WHERE registration_id = :registration_id";
		$stmt1 = $pdo->prepare( $sql1 );
		$stmt1->execute( array(
			':registration_id' => $regid
		));
		$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
		if( !$row1 )
		{
			return "Account doesn't exist";
		}
		else
		{
			if ( $row1['account_role'] != 1)
			{
				return 'Only students can be added to this list';
			}
			else
			{
				$account_id = $row1['account_id'];

				$sql2 = "SELECT * FROM authorization WHERE account_id = :account_id AND course_id = :course_id";
				$stmt2 = $pdo->prepare($sql2);
				$stmt2->execute( array(
					':account_id' => $account_id,
					':course_id' => $course_id
				));
				$row2 = $stmt2->fetch( PDO::FETCH_ASSOC);
				if ( $row2)
				{
					return "Student has been added already";
				}
				else
				{
					$sql3 = "INSERT INTO authorization ( account_id, course_id ) VALUES ( :account_id, :course_id )";
					$stmt3 = $pdo->prepare( $sql3 );
					$stmt3->execute( array(
						':account_id' => $account_id,
						':course_id' => $course_id
					));	
				}
			}
		}
	}
}

function flashMessageAddAuthorization()
{
	if (isset($_SESSION['addAuthError']))
	{
		echo '<div style="color: red;">'.$_SESSION['addAuthError']."</div>";
		unset($_SESSION['addAuthError']);
	}
	if (isset($_SESSION['addAuthSuccess']))
	{
		echo '<div style="color: green;">'.$_SESSION['addAuthSuccess']."</div>";
		unset($_SESSION['addAuthSuccess']);
	}
}

function displayResults($course_id)
{
	include "pdo.php";

	$sql1 = "SELECT * FROM result where course_id = :course_id";
	$stmt1 = $pdo->prepare( $sql1 );
	$stmt1->execute( array(
		':course_id' => $course_id
	));
	
	echo '<table border="1">';
	echo '<th>Registration ID</th>';
	echo '<th>Name</th>';
	echo '<th>Score</th>';
	while( $row1 = $stmt1->fetch( PDO::FETCH_ASSOC ) )
	{
		$sql2 = "SELECT * FROM account WHERE account_id = :account_id";
		$stmt2 = $pdo->prepare( $sql2 );
		$stmt2->execute( array(
			':account_id' => $row1['account_id']
		));
		$row2 = $stmt2->fetch( PDO::FETCH_ASSOC );
		$regid = 'N/A';
		$name = 'N/A';
		if( $row2 )
		{
			$regid = $row2['registration_id'];
			$name = $row2['first_name']." ".$row2['middle_name']." ".$row2['last_name'];
		}

		echo '<tr><td>';
		echo $regid;
		echo '</td><td>';
		echo $name;
		echo '</td><td>';
		echo $row1['result_score'];
		echo '</td></tr>';
	}
	echo '</table>';
}
?>