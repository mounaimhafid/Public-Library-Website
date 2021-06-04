<?
session_start();
?>

<html>
    <head>
        <title>Admin</title>
            <script
          src="https://code.jquery.com/jquery-3.4.1.js"
          integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
          crossorigin="anonymous"></script>

          <script src="Scripts/admin.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
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
session_start();
$message = "";
 //$username = $_POST['username'];
//$password = $_POST['password'];
$conn = mysqli_connect("localhost", "root", "root", "library");
if (!$conn) {
    die("Failed the sql connection: " . mysqli_connect_error());
}  
$sqlStr = "SELECT * FROM library.author Order By FirstName, LastName";
$data = mysqli_query($conn, $sqlStr);
$sqlStr = "Select * from book  order by BookTitle";
$books = mysqli_query($conn, $sqlStr);
mysqli_close($conn);
?>
  <div class="container" style="padding: 10px; float:left"> 
    <div class="row">
        <div class="col-sm-2">

        </div>
        <div class="col-sm-10">
        <input type="button" id='showAdd' class="btn btn-lnk btn-primary" onclick="showAdd()" value="Add New Book"/> <br/>
          <div id='add'>
          
        <form id="frm" action="add.php" method="POST">  
        <input type="hidden"  id="fl" name="fl" />;
            <h4>Add Book</h4>     
        <span id="error"  class=".err"></span> <br/> <br/>

        <div class="row">
            <div class="col-md-4">
                <label for="Title">Title*</label>
                <input type="text" id="title" class="form-control input" name="title" placeholder="Title"> 
                <span id="titleError"  class=".err"></span> <br/>
            </div>

            <div class="col-md-4">
                <label for="date">Date Published* </label>
                <input type="date" id="pub" class="form-control input" name="pub" placeholder="Date Published">  
                <span id="pubError"  class=".err"></span>
            </div>

            <div class="col-md-4">
                <label for="author">Author*</label><bt/>
                <select id="author" class="form-control" style="width:250px" name="author">
                <option></option>
                <?
                    while ($row = mysqli_fetch_array($data)) {
                        echo "<option value='" . $row['Author_Id'] . "'>" . $row['FirstName'] . " " . $row['LastName']. "</option>";
                    }
                ?>

                </select>
                <span id="authError"  class=".err"></span>
            </div>

           

        </div>
        <div class="row">

        <div class="col-md-4">
                <label for="isbn">ISBN </label>
                <input type="text" id="isbn" class="form-control input" name="isbn" placeholder="ISBN">  
            </div>
            <div class="col-md-4">
                <label for="Title">Aisle</label>
                <input type="text" id="aisle" class="form-control input" name="aisle" placeholder="Aisle"> 
            </div>

            <div class="col-md-4">
                <label for="date">Section </label>
                <input type="text" id="section" class="form-control input" name="section" placeholder="Section">  
            </div>


        </div>
        <br/>
        <div class="row">
        <div class="col-md-4">
                <label for="Genre">Genre </label>
                <input type="text" id="genre" name="genre" class="form-control" placeholder="Genre" />
            </div>
            <div class="col-md-4">
                <label for="isbn">Image </label>
                <input type="file" id="ig" class="form-control input" name="ig" placeholder="ISBN">  
            </div>
                </div>
                <div class="row">
        <div class="col-md-4">
                <label for="Genre">Number of Copies </label>
                <input type="text" id="num" name="num" class="form-control" placeholder="Number of Copes" value="<? echo $genre; ?>"/>
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

        <input type="button" id="btnSubmit" class="btn btn-primary" value="Add Book" onclick="addBook()">
        <br/>

        <div id='lst'>
       <strong> Available Books </strong>
        <br/>
        <br/>
        <div id="bookd"></div>
                </div>
      </div>
  </div>

   
</div>
</body>
</html>
