


<?php
	if(isset($_POST['spara'])){
	
		echo "tjaba";
	
	}
?>
<h1>Sign Up!</h1>
<table>
	<form action="signup.php" method="POST">
		<tr>
			<td>username:</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>email:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass"></td>
		</tr>
		<tr>
			<td>Re-password:</td>
			<td><input type="password" name="rePass"></td>
		</tr>
		<tr>
			<td><input type="submit" name="spara" value="signup"></td>
		</tr>
		
	</form>
</table>


