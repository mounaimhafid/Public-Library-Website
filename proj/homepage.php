<?php
session_start();
$con = mysqli_connect("localhost", "root", "root", "library");
if($con){
	$sql = "SELECT * FROM book where Deleted = 0";
	$result = mysqli_query($con, $sql);	
	if(mysqli_num_rows($result) != 0){
		$library = array();
		while($row = mysqli_fetch_array($result))
		{
			$bookObj = new stdClass();
			$bookObj->bookid = $row['BookId'];
			$bookObj->booktitle = $row['BookTitle'];
			$bookObj->authorid = $row['AuthorId'];
			$bookObj->isbn = $row['ISBN'];
			$bookObj->aisle = $row['Aisle'];
			$bookObj->section = $row['Section'];
			$bookObj->publisheddate = $row['PublishedDate'];
			$bookObj->numcopies = $row['Num_Copies'];
			$bookObj->img = $row['img'];
			$bookObj->genre = $row['Genre'];
			array_push($library, $bookObj);
		}
		echo json_encode($library);
	}
	
}
else{
	echo "Failed to connect to sql server";
	echo "Debugging error: " . mysqli_connect_errno();
}
?>