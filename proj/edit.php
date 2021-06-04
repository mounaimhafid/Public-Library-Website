<?
session_start();
if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
    header('Location: Login.html');
    exit;
}
?>

<html>
    <head>
        <title>Edit</title>
            <script
          src="https://code.jquery.com/jquery-3.4.1.js"
          integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
          crossorigin="anonymous"></script>

          <script src="edit.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
   <style>
       .input {
           width:250px;
       }
   </style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
        <li class="nav-item active">
                <a class="nav-link" href="homepage.html">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>

      
  </head>
<body style="background-color:white">
<?
if (intval($_SESSION['role']) != 1) {
    echo "You don't have access to this page. Please log in with valid admin credentials.";
    echo "</body>";
    echo "</html>";
    exit;
}
if (!isset($_SESSION['userid']) || !isset($_SESSION['role'])) {
    header('Location: Login.php');
}
if (intval($_SESSION['role']) != 1) {
    echo "You don't have access to this page";
    exit;
}
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  
$sqlStr = "SELECT * FROM book where Deleted = 0 AND BookId = " . $_GET['id']; 
$data = mysqli_query($conn, $sqlStr);
$count=mysqli_num_rows($data);
$title = "";
$id = "";
$pub = "";
$author = "";
$genre = "";
$isbn = "";
$aisle = "";
$section = "";
$img = "";
$isbn = "";
$num = "";
if ($count > 0) {
    $row=mysqli_fetch_assoc($data);
   $id = $row["BookId"];
   $title =  $row["BookTitle"];
   $pub =  $row["PublishedDate"];
   $aisle = $row["Aisle"];
   $section = $row["Section"];
   $genre = $row["Genre"];
   $isbn = $row["ISBN"];
   $author = $row["AuthorId"];
   $img = $row["img"]; 
   $num = $row["Num_Copies"]; 
   $sqlStr = "SELECT * FROM library.author Order By FirstName, LastName";
   $data = mysqli_query($conn, $sqlStr);
} else {
    header('Location: admin.php');
    exit;
}

?>
  <div class="container" style="padding: 10px; float:left"> 
    <div class="row">
        <div class="col-sm-2">

        </div>
        <div class="col-sm-10">
          <div id='add'>
        
        <form id="frm" action="saveEdit.php" method="POST">  
        <input type="hidden"  id="fl" name="fl" />
        <input type="hidden"  id="bookid" name="bookid"  value="<? echo $id;?>"/>
            <h4>Edit Book</h4><br/>
            Fields marked with * are required

        <span id="error"  class=".err"></span> <br/> <br/>

        <div class="row">
            <div class="col-md-4">
                <label for="Title">Title*</label>
                <input type="text" id="title" class="form-control input" name="title" value="<? echo $title; ?>"> 
                <span id="titleError"  class=".err"></span> <br/>
            </div>

            <div class="col-md-4">
                <label for="date">Date Published* </label>
                <input type="date" id="pub" class="form-control input" name="pub" placeholder="Date Published" value="<? echo $pub; ?>">  
                <span id="pubError"  class=".err"></span>
            </div>

            <div class="col-md-4">
                <label for="author">Author*</label><bt/>
                <select id="author" class="form-control" style="width:250px" name="author">
                <option></option>
                <?
                    while ($row = mysqli_fetch_array($data)) {
                        $s = "";
                        if ($author == $row['Author_Id'])
                            $s = "selected";
                        echo "<option value='" . $row['Author_Id'] . "' " . $s .  ">" . $row['FirstName'] . " " . $row['LastName']. "</option>";
                    }
                ?>

                </select>
                <span id="authError"  class=".err"></span>
            </div> 

           

        </div>
        <div class="row">

        <div class="col-md-4">
                <label for="isbn">ISBN </label>
                <input type="text" id="isbn" class="form-control input" name="isbn" placeholder="ISBN" value="<? echo $isbn; ?>">  
            </div>
            <div class="col-md-4">
                <label for="Title">Aisle</label>
                <input type="text" id="aisle" class="form-control input" name="aisle" placeholder="Aisle" value="<? echo $aisle; ?>"> 
            </div>

            <div class="col-md-4">
                <label for="date">Section </label>
                <input type="text" id="section" class="form-control input" name="section" placeholder="Section" value="<? echo $section; ?>">  
            </div>


        </div>
        <br/>
        <div class="row">
        <div class="col-md-4">
                <label for="Genre">Genre </label>
                <input type="text" id="genre" name="genre" class="form-control" placeholder="Genre" value="<? echo $genre; ?>"/>
            </div>
            <div class="col-md-4">
                <label for="isbn"> Update Image </label>
                <input type="file" id="ig" class="form-control input" name="ig">  
            </div>
            <div class="col-md-4" style="float:left">
                <label for="isbn"> Current Image </label> 
                <div id='imgDiv'>
                <? 
                if (isset($img) && $img !== "") {
                    echo $img; 
                }
                    else { 
                    echo "None";}
                ?>
                </div>  
                <input type="btton" class="btn btn-link" id="remove" onclick="remove()" value="Remove" style="width:100px"/>
            </div>
                </div>
                <div class="row">
        <div class="col-md-4">
                <label for="Genre">Number of Copies </label>
                <input type="text" id="num" name="num" class="form-control" placeholder="Number of Copes" value="<? echo $num; ?>"/>
            </div>
                    </div>
            
        </form>
        <!-- <div class="col-md-4">
                <label for="isbn">Upload Image </label>
                <input type="file" id="ig" class="form-control input" name="ig" placeholder="ISBN">  
            </div> -->

            <div id="imgTest"></div>
            <br/>
                </div>

        <input type="button" id="btnSubmit" class="btn btn-primary" value="Save" onclick="addBook()">
        <br/>
      </div>
  </div>

   
</div>
</body>
</html>
