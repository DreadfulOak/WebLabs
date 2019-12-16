<?php
	$dbc = mysqli_connect('localhost', 'root', '', 'table1');
	session_start();
	$userID = $_SESSION['userID'];	
	if(isset($_POST['edit'])){
		$userID = $_SESSION['userID'];
		$query = "SELECT * FROM `signup` WHERE id = '$userID'";
		$data = mysqli_query($dbc, $query);
		$firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
		$lastname = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
		$role = $_POST['role'];
		if($role == 'admin'){
			$role = 0;
		}else{
			$role = 1;
		}
		if(mysqli_num_rows($data) == 1){
			$query = "UPDATE signup 
				   	  SET first_name = '$firstname', 
				   		  last_name = '$lastname', 
				   		  email = '$email', 
				   		  role_id = '$role', 
				   	  WHERE id = '$userID';";
			$data = mysqli_query($dbc, $query);
			if(!empty($password1) && !empty($password2)){
				$query = "UPDATE signup 
				   		  SET password = SHA('$password2'), 
				   		  WHERE id = '$userID';";
				$data = mysqli_query($dbc, $query);
			}
			$sqlSelect = "SELECT * FROM `signup` WHERE id='$userID'";
			$records = mysqli_query($dbc, $sqlSelect);
			$field = mysqli_fetch_array($records);
			$_SESSION['first_name'] = $field['first_name'];
			$_SESSION['last_name'] = $field['last_name'];
			$_SESSION['email'] = $field['email'];
			$_SESSION['photo'] = $field['photo'];
			$_SESSION['role_id'] = $field['role_id'];
			$_SESSION['password'] = $field['password'];
			echo $_SESSION['first_name'];
			echo "<script language=javascript>document.location.href='user-profile.php?eatshit'</script>";
		}else{
			echo '<div class="error-msg">There is an error with updating your info</div>';
		}
		
	}
	if(isset($_POST['delete'])){
		$query = "DELETE FROM `signup` WHERE id = $userID";
		$data = mysqli_query($dbc, $query);	
		session_destroy();
		echo "<script language=javascript>document.location.href='index.php'</script>";
	}
?>