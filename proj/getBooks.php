<?php
session_start();
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  
$sqlStr = "Select * from book where deleted  = 0  order by BookTitle";
$data = mysqli_query($conn, $sqlStr);
$json= array();
$arr=array();
while($row=mysqli_fetch_assoc($data)){
    $arr['idb']= $row['BookId'];
    $arr['id']= "img_" . $row['BookId'];
    $arr['title']=$row['BookTitle'];
    $arr['aisle']=$row['Aisle'];
    $arr['section']=$row['Section'];
    $arr['genre']=$row['Genre'];
    $arr['isbn']=$row['ISBN'];
    $arr['img']=$row['img'];
    $arr['status']=$row['Status'];
    array_push($json,$arr); 
}
echo  json_encode($json);

mysqli_close($conn);
//header('Location: admin.php');
//echo json_encode($data);
?>