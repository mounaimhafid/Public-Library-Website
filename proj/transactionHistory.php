

<?php
	//$doc = new DOMDocument();
	session_start();

	//$_SESSION['UserName'] = "john";
	
	//echo $_SESSION['UserName'];
	if(isset($_SESSION['UserName'])){


		$con = mysqli_connect("localhost", "root", "root", "library");
		if($con){

			$query = "SELECT * FROM library.transactions WHERE Username = '" . $_SESSION['UserName'] . "'";
			//echo $query;
			if($result = mysqli_query($con, $query)){
			}
			else{
			}

			
			$transactions  = array();
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				$transactions[] = $row;

				
			}

			

			$json = json_encode($transactions);

			
			echo $json;
			
		}
		else{
			echo "Unable to connect to database!";
			echo "Debugging errno: " . mysqli_connect_errno();
		}
	}
	else
	{
		echo 0;
	}


?>
