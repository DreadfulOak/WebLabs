<?php 
	session_start();
?>

<DOCTYPE html>
<html>
<head>
	<title>Website - Home</title>
	<link rel="icon" type="icon/png" href="assets/images/icon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="content-container">
		<content class="content">
			<div class="logo">
				<a href="index.php">
					<img src="assets/images/logo.png">
				</a>
			</div>
			<div class="login">
				<?php
					if(!empty($_SESSION['password']) && !empty($_SESSION['email'])){
						echo '<a href="user-profile.php">My profile</a>';
						echo '<span style="font-size: 22px;">|</span>';
						echo '<a href="logout.php">Logout</a>';
					}else{ 
				?>
					<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form">
						<input type="email" name="email" placeholder="email">
						<input type="password" name="password1" placeholder="********">
						<button type="submit" name="submit">Sign In</button>
						<span>|</span>
						<a href="register.php">Sign Up</a>
					</form>
					
				<?php
					}
				?>
			</div>
		</content>
		<div class="separator"></div>
		<h1 class="title">This is a Lab1</h1>
		<?php
			require_once 'connectionWeb.php';
			 
			$link = mysqli_connect($host, $user, $password, $database) 
			    or die("Ошибка " . mysqli_error($link)); 
			     
			$query ="SELECT * FROM `signup`";
			 
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
			if($result)
			{
			    $rows = mysqli_num_rows($result);
			     
			    echo '<table class="tg">
				  <tr>
				    <th class="tg-cly1">ID</th>
				    <th class="tg-0lax">first name</th>
				    <th class="tg-0lax">last name</th>
				    <th class="tg-0lax">email</th>
				    <th class="tg-0lax">photo</th>
				    <th class="tg-0lax">role</th>';
				    if(isset($_SESSION['email']) && isset($_SESSION['password']) && ($_SESSION['role_id'] == 0)){
				    	echo '<th class="tg-0lax">Delete</th>';
				    }
				  echo '</tr>';
			    for ($i = 0; $i < $rows; ++$i)
			    {
			        $row = mysqli_fetch_row($result);
			        echo "<tr>";
			            for ($j = 0; $j < 4; ++$j){
			            	if($j == 0){
			            		echo "<td><a href='user-profile.php?id=".$row[0]."'>$row[$j]</a></td>";
			            	}else{
			            		echo "<td>$row[$j]</td>";
			            	}
			            }
			            echo '<td style="background-image: url('.$row[4].'); background-size: contain; background-repeat: no-repeat; background-position: center;"></td>';
			            if($row[5] == 0){
			            	echo "<td>Admin</td>";
			            }else{
			       			echo "<td>User</td>";
			       		}
			       		if(isset($_SESSION['email']) && isset($_SESSION['password']) && ($_SESSION['role_id'] == 0)){
			       			echo'<td><a class="delete-button-td" name="delete-user" href="delete.php?id='.$row[0].'">Delete</a></td>';
			       		}
			        echo "</tr>";
			    }
			    echo "</table>";
			    
			    mysqli_free_result($result);
			}
			 
			mysqli_close($link);
		?>
	</div>
	<footer class="footer">
		<h3>Just a casual footer, not much to see.</h3>
	</footer>
</body>
</html>
<?php 
$dbc = mysqli_connect('localhost', 'root', '', 'table1');
if(isset($_POST['submit'])){
	$user_email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	$user_password = mysqli_real_escape_string($dbc, trim($_POST['password1']));
	if(!empty($user_email) && !empty($user_password)){
		$query = "SELECT * FROM `signup` WHERE email = '$user_email' AND password = SHA('$user_password')";
		$data = mysqli_query($dbc, $query);
	    if(mysqli_num_rows($data) == 1){
	    	$field = mysqli_fetch_array($data);
			$_SESSION['userID'] = $field['id'];
			$_SESSION['first_name'] = $field['first_name'];
			$_SESSION['last_name'] = $field['last_name'];
			$_SESSION['email'] = $field['email'];
			$_SESSION['photo'] = $field['photo'];
			$_SESSION['role_id'] = $field['role_id'];
			$_SESSION['password'] = $field['password'];
			echo "<script language=javascript>document.location.href='user-profile.php'</script>";
	    }else{
	    	echo '<div class="error-msg">Email or password are not correct</div>';
	    }

	}else{
		echo '<div class="error-msg">Please fill up all the fields</div>';
	}
}
?>