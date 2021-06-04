<?php
session_start();
if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
    header('Location: Login.html');
    exit;
}
if (intval($_SESSION['role']) != 1) {
    echo "You don't have access to this page. Please log in with valid admin credentials.";
    echo "</body>";
    echo "</html>";
    exit;
}
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $str = "Update book set Deleted = 1 where BookId = $id";
    if (!mysqli_query($conn,$str)){ 

        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    header('Location: admin.php');
    exit;
} 
?>