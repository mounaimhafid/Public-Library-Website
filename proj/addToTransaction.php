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
	
	$id = $_GET['r'];
	$title = $_GET['title'];
	$borrowDate = $_GET['borrow'];
	$returnDate = $_GET['return'];
	$name = $_GET['name'];

	$con = mysqli_connect("localhost", "root", "root", "library");
	if($con){

		$query = "INSERT INTO library.transactions (Id, BookTitle, UserName, Date_Borrowed, Date_Due)VALUES (". $id . ",'" . $title . "','" . $name . "','" . $borrowDate . "','" . $returnDate . "')";
		echo $query;
		if(mysqli_query($con, $query))
		{
			echo "Transactions Recorded";
		}
		else
		{
			echo "Error: " . $query . "<br>" . mysqli_error($con);
		}

		$query2 = "UPDATE library.book SET Num_Copies = Num_Copies - 1 WHERE BookTitle = '" . $title . "'";
		echo $query2;
		if(mysqli_query($con, $query2))
		{
			echo "Copies decreased";
		}
		else
		{
			echo "Error: " . $query . "<br>" . mysqli_error($con);
		}
			//$transactions  = array();
			
			/*while ($row = mysqli_fetch_assoc($result)) {
				
				$transactions[] = $row;

				
			}*/

			

			//$json = json_encode($transactions);

			
			//echo $json;
			
	}
	else
	{
			echo "Unable to connect to database!";
			echo "Debugging errno: " . mysqli_connect_errno();
	}


?>
