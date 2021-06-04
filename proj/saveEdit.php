<?php
session_start();
if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
    header('Location: Login.html');
    exit;
}
if (intval($_SESSION['role']) != 1) {
    echo "You don't have access to this page";
    exit;
}
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $str = getBookSql();
    if (!mysqli_query($conn,$str)){ 

        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    header('Location: admin.php');
    exit;
} 

function getBookSql() {
    $title = cleanInput($_POST['title']);
    $id = intval($_POST['bookid']);
    $pub = cleanInput($_POST['pub']);
    $author = cleanInput($_POST['author']);
    $isbn = " ";
    $img = $_POST["fl"];
    if(isset($_POST['isbn']))
        $isbn = cleanInput($_POST['isbn']);
    $aisle = " ";
    if(isset($_POST['aisle']))
        $aisle = cleanInput($_POST['aisle']);
    $section = " ";
    if(isset($_POST['section']))
        $section= cleanInput($_POST['section']);
    $genre = " ";
    if(isset($_POST['genre']))
        $genre = cleanInput($_POST['genre']);
    $str = "update book set BookTitle = '$title', AuthorId = '$author', PublishedDate = '$pub', ISBN = '$isbn', img = '$img', Aisle = '$aisle', Section = '$section', Genre = '$genre' where BookId = $id ";
    return $str;
}

function cleanInput($data) {
    if(empty($data))
        return null;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>