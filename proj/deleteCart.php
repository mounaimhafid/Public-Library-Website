
<?php
	session_start();
	header('Location: cart.html');
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	
	//echo "here";
	if(isset($_SESSION['UserName'])){
		try 
		{
			$deleteTitle = $_GET['deleteItem'];
			echo $deleteTitle;
			$json = file_get_contents('json/shoppingCart.json');
			$data = json_decode($json, true);
			echo $data;

			$n = count($data);

			for($i = 0; $i < $n; $i++){
				if($data[$i]['bookTitle'] == $deleteTitle){
					echo $data[$i];
					unset($data[$i]);
					$data = array_values($data);
					break;
				}
			}

			$newJson = json_encode($data);
			echo $newJson;
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
