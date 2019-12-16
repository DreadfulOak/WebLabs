<?php 
	session_start();
	$dbc = mysqli_connect('localhost', 'root', '', 'table1');
	if(empty($_SESSION['userID']) && empty($_SESSION['email']) && empty($_SESSION['password'])){
		$userViewID = $_GET['id'];
		$query = "SELECT * FROM `signup` WHERE id = '$userViewID'";
		$records = mysqli_query($dbc, $query);
		$field = mysqli_fetch_array($records);
		$_SESSION['userID'] = $field['id'];
		$_SESSION['first_name'] = $field['first_name'];
		$_SESSION['last_name'] = $field['last_name'];
		$_SESSION['email'] = $field['email'];
		$_SESSION['photo'] = $field['photo'];
		$_SESSION['role_id'] = $field['role_id'];
	}else{
		$userID = $_SESSION['userID'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Website - User</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="icon" type="icon/png" href="assets/images/icon.png">
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
				<a href="logout.php">Logout</a>
			</div>
		</content>
		<div class="separator"></div>
		<h1 class="title"><?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']; ?>`s profile</h1>
		<div class="full-container">
			<div id="desc">
				<div class="photo-box" style="background-image: url(
				<?php 
				if(!empty($_SESSION['photo'])){
					echo $_SESSION['photo'];
				}else{
					if($_SESSION['role_id'] == 0){
						echo 'assets/images/admin.png';
					}else{
						echo 'assets/images/user.png';
					}
				}
				?>
				)"></div>
				<?php
					if(!empty($_SESSION['password'])){
				?>
					<form method="POST" action="upload.php" enctype="multipart/form-data" class="upload-form">
						Select image to upload:<br>
				    		<input type="file" name="photo" id="photo">
				    		<input type="submit" value="Upload Image" name="upload" class="upload-button">
				    </form>
				<?php
					}else{
				?>
					<form method="POST" action="upload.php" enctype="multipart/form-data" class="upload-form">
							User Avatar
				    </form>
				<?php    
					}
				?>
			</div>
			<form method="POST" action="edit.php" class="register-form">
				<label for="firstname">First name:</label>
				<input type="text" name="firstname" <?php if(empty($_SESSION['password'])) echo 'disabled';?> value="<?php echo $_SESSION['first_name'];?>">
				<label for="lastname">Last name:</label>
				<input type="text" name="lastname" <?php if(empty($_SESSION['password'])) echo 'disabled';?> value="<?php echo $_SESSION['last_name'];?>">
				<label for="email">Email:</label>
				<input type="email" name="email" <?php if(empty($_SESSION['password'])) echo 'disabled';?> value="<?php echo $_SESSION['email']; ?>">
				<label for="role">Role:</label>
				<select type="role" name="role" <?php if(empty($_SESSION['password'])) echo 'disabled';?>>
				   <option value="admin"
				   <?php
				    if($_SESSION['role_id'] == 0)
				   		echo 'selected';
				   	?>
				   >Admin</option>
				   <option value="user"
				   <?php
				    if($_SESSION['role_id'] == 1)
				   		echo 'selected';
				   	?>
				   >User</option>
				</select>
				<?php
					if(!empty($_SESSION['password'])){
				?>
				<label for="password">Enter the new password:</label>
				<input type="password" name="password1">
				<label for="password">Enter the new password again:</label>
				<input type="password" name="password2">
				<div id="profile-button">
					<button type="edit" name="edit">Edit</button>
					<button type="delete" name="delete">Delete</button>
				</div>
				<?php
					}
				?>
			</form>
		</div>
	</div>
	<footer class="footer">
		<h3>Just a casual footer, not much to see.</h3>
	</footer>
</body>
</html>