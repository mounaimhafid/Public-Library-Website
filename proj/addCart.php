
<?php
	session_start();
	header('Location: cart.html');
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	
	if(isset($_SESSION['UserName'])){
		try 
		{
			$addTitle = $_GET['addcart'];
			$json = file_get_contents('json/shoppingCart.json');
			$data = json_decode($json, true);

			$book = explode("?", $addTitle);
			
			$length = count($data);
			$data[$length]['bookTitle'] = $book[0];
			$data[$length]['bookId'] = $book[1];
			$data[$length]['numCopies'] = $book[2];
			$data[$length]['imgSrc'] = $book[3];
			$data[$length]['userId'] = 1234567;
			$data[$length]['dateBorrowed'] = "2020-12-01";
			$data[$length]['dateDue'] = "2020-12-15";



			$newJson = json_encode($data);
			file_put_contents("json/shoppingCart.json", $newJson);
		} 
		catch (Exception $e) 
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	else{
		header("Location: Login.html");
	}
	
	

	//session_destroy();
?>
