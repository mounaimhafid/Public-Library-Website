<?php
	//$doc = new DOMDocument();
	session_start();

	//$_SESSION['UserName'] = "john";
	//$_SESSION['firstname'] = "fname1";
	//$_SESSION['lastname'] = "lname1";
	
	//echo $_SESSION['UserName'];
	//echo $_SESSION['firstname'];
	//echo $_SESSION['lastname'];
	//unset($_SESSION['UserName']);
	if(isset($_SESSION['UserName']))
	{
		echo $_SESSION['UserName'];

	}
	else
	{
		echo "login";
	}


?>
