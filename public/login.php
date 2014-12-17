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
	if(isset($_POST['spara'])){
		
		$user = trim($_POST['username']);
		$pass = trim($_POST['pass']);

		try{
			$query = "SELECT * FROM users WHERE username = :user";
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
			if(password_verify($pass, $users['hashed_password'] )){
				$_SESSION['msg'] = "Logged in";
			} else {
				$_SESSION['msg'] = "Failed";
			}
		} else {
				$_SESSION['msg'] = "Failed";
		}
	}
?>

<h1>Login!</h1>
<?php echo $_SESSION['msg']; ?>
<table>
	<form action="login.php" method="POST">
	
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass"></td>
		</tr>
		<tr>
			<td><input type="submit" name="spara" value="login"></td>
		</tr>
	</form>
</table>
</body>
</html>