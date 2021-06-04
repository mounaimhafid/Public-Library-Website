<?php
session_start();
$message = "";
 $username = $_POST['username'];
$password = cleanInput($_POST['password']);
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  
$sqlStr = "Select * from user where UserName = '" . $username . "'";
//echo json_encode(password_hash($password, PASSWORD_DEFAULT));
//exit;
$arr = array();
if ($data = mysqli_query($conn, $sqlStr)) {
    $count=mysqli_num_rows($data);
    if ($count > 0) {
        while($row = mysqli_fetch_array($data))
        {
            //echo json_encode($row["Password"]);
            //exit;
            if(password_verify($password, $row["Password"])) {
                echo json_encode("1");
                $_SESSION['username'] = $row["UserName"];
                $_SESSION['UserName'] = $row["UserName"];
                $_SESSION['userid'] = $row["UserId"];
                $_SESSION['firstname'] = $row["FirstName"];
                $_SESSION['lastname'] = $row["LastName"];
                $_SESSION['email'] = $row["Email"];
                $_SESSION['role'] = $row["RoleId"];
            }
            else
                echo json_encode("0");
        }
    } else {
        echo json_encode("0");
    }
    mysqli_free_result($data);
    exit;
}
echo json_encode("-1");
mysqli_close($conn);

function cleanInput($data) {
    if(empty($data))
        return null;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>