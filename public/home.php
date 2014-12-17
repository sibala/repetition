<?php require_once("../includes/functions.php"); ?>
<?php	  
	  if(time() - $_SESSION['timestamp'] > 10) { //subtract new timestamp from the old one
		unset($_SESSION['username'], $_SESSION['timestamp']);
		header("Location: logout.php"); //redirect to login.php
		exit;
	  } else {
		$_SESSION['timestamp'] = time(); //set new timestamp
	  }
	  echo $_SESSION['username'] . " är inloggad";

?>



<br />
<a href="logout.php">logout</a>
<a href="home.php">updatera hemsidan</a>