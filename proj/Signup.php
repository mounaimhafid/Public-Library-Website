<?php
session_start();
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = cleanInput($_POST['username']);
    
    $email = cleanInput($_POST['email']);
    $sqlStr = "select * from user where UserName = '$username' OR Email = '$email'";
    if ($data = mysqli_query($conn, $sqlStr)) {
        $count=mysqli_num_rows($data);
        if ($count > 0) {
            echo json_encode("1");
            exit;
        } 
        mysqli_free_result($data);
    } else {
        echo json_encode("2");
        exit;
     }
    $str = getSql();
    if (!mysqli_query($conn,$str)){ 

        die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    echo json_encode("redirect");
    exit;
}

 function getSql()
{
    $username = $_POST['username'];
    $password = cleanInput($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = cleanInput($_POST['email']);
    $dob = cleanInput($_POST['dob']);
    $firstname = cleanInput($_POST['firstname']);
    $lname = cleanInput($_POST['lname']);
    $str = "insert into user (Username, Password, Email, Date_Of_Birth, RoleId, FirstName, LastName";
    $val = "('$username', '$password', '$email', '$dob',2, '$firstname', '$lname'";
    if (isset($_POST['mname']) && $_POST['mname'] != '') {
        $str = $str . "," . "MiddleName";
        $val = $val . ",'" . cleanInput($_POST['mname']) . "'";
    }
    if (isset($_POST['addr1']) && $_POST['addr1'] != '') {
        $str = $str . "," . "Address_Line_One";
        $val = $val . ",'" . cleanInput($_POST['addr1']) . "'";
    }
    if (isset($_POST['addr2']) && $_POST['addr2'] != '') {
        $str = $str . "," . "Address_Line_Two";
        $val = $val . ",'" . cleanInput($_POST['addr2']) . "'";
    }
    if (isset($_POST['state']) && $_POST['state'] != '') {
        $str = $str . "," . "State";
        $val = $val . ",'" . cleanInput($_POST['state']) . "'";
    }
    if (isset($_POST['zip']) && $_POST['zip'] != '') {
        $str = $str . "," . "Zip";
        $val = $val . ",'" . cleanInput($_POST['zip']) . "'";
    }
    if (isset($_POST['phone']) && $_POST['phone'] != '') {
        $str = $str . "," . "Phone";
        $val = $val . ",'" . cleanInput($_POST['phone']) . "'";
    }
    
    return $str . ") values " . $val . ")";
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