<?php session_start(); ?>
<html>
	<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	</head>
		<body>

<?php
	$db = new PDO("mysql:host=localhost;dbname=blog;", "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 		//Inställningar för error hantering
	$db->exec("SET NAMES 'utf8'");	
	
	$_SESSION['msg'] = null;
	$userErr = $emailErr = $passErr = $rePassErr = "";
	if(isset($_POST['spara'])){
		
		$type = $_POST['userRight'];
		$user = trim($_POST['username']);
		$email = trim($_POST['email']);
		$pass = trim($_POST['pass']);
		$rePass = trim($_POST['rePass']);
		
		
		if (!preg_match("/^[a-zA-Z0-9åäöÅÄÖ]*$/",$user)) {
		  $userErr = "Only letters and numbers are allowed"; 
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "Invalid email format"; 
		}
		
		if(empty($user)){
			$userErr = "Username is required"; 
		}
		if(empty($email)){
			$emailErr = "Email is required"; 
		}
		if(empty($pass)){
			$passErr = "Password is required"; 
		}
		if($rePass !== $pass){
			$rePassErr = "Re-entered password doesn't match"; 
		}
		
		try{
			$query = "SELECT username FROM users WHERE username = :user";
			$ps = $db->prepare($query);
			
			$result = $ps->execute([
				'user' => $user
			]);
			
		} catch(Exception $err ){
			$_SESSION['msg'] = $err;
		}
		
		$users = $ps->fetch(PDO::FETCH_ASSOC); // hämtar en rad
		//$users = $ps->fetchAll; // hämtar flera rader
		
		if($users){
			$userErr = "Username is taken. Please choose another username";
		}
		
		if(empty($userErr) && empty($emailErr) && empty($passErr) && empty($rePassErr)){
			
			$pass = password_hash($pass, PASSWORD_BCRYPT);
			
			try{
				$query  = "INSERT INTO users (username, hashed_password, email, usertype) ";
				$query .= "VALUES (:user, :pass, :email, :type)";
			
				$ps = $db->prepare($query);
				
				$result = $ps->execute([
					'user' 	=> $user,
					'pass' 	=> $pass,
					'email' => $email,
					'type' 	=> $type
				]);
			
			} catch(Exception $err ){
				$_SESSION['msg'] = $err;
			}
			
			if($result){
				$_SESSION['msg'] = "Success";
			} else {
				$_SESSION['msg'] = "Failed";
			}
		}
	}
?>
<h1>Sign Up!</h1>
<?php echo $_SESSION['msg']; ?><br />
<table>
	<form action="signup.php" method="POST">
		
		<tr>
			<td>Usertype:</td>
			<td>
			<select name="userRight">
				<option value="0">Student</option>						<!-- 0 for student,  1 for teacher, 2 for admin -->
				<option value="1">Teacher</option>						<!-- 0 for student,  1 for teacher, 2 for admin -->
				<option value="2">Admin</option>						<!-- 0 for student,  1 for teacher, 2 for admin -->
			</select>
			</td>
		</tr>
	
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"><span> <?php echo $userErr; ?></span></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="text" name="email"><span> <?php echo $emailErr; ?></span></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass"><span> <?php echo $passErr; ?></span></td>
		</tr>
		<tr>
			<td>Re-password:</td>
			<td><input type="password" name="rePass"><span> <?php echo $rePassErr; ?></span></td>
		</tr>
		<tr>
			<td><input type="submit" name="spara" value="signup"></td>
		</tr>
		
	</form>
</table>
</body>
</html>
