$(document).ready(function() {
    $("#btnSubmit").on("click", validateData);
});

function validateData() {
    var valid = isRequiredValueSupplied();
    if (isRequiredValueSupplied())
        getData();
}

function isRequiredValueSupplied() {
    var isValid = true;
    if (! $('#username').val()) {
        isValid = false;
        $('#userError').html("*Username is required");
    } else 
        $('#userError').html("");
    if (! $('#password').val()) {
        isValid = false;
        $('#passError').html("*Password is required");
    } else
        $('#passError').html("");
    if (! $('#email').val()) {
        isValid = false;
        $('#emailError').html("*Email is required");
    } else
        $('#emailError').html("");
    if (! $('#dob').val()) {
        isValid = false;
        $('#dobError').html("*Dob is required");
    } else
        $('#dobError').html("");
    return isValid;
}

function getData() {

    //('#userError').html("");
    $('#passError').html("");
    var username = $('#username').val();
    var password = $('#password').val();
    var email = $('#email').val();
    var dob = $('#dob').val();
    var fname = $('#firstname').val();
    var lname = $('#lname').val();
    var isValid = true;
    if (!username) {
        $('#userError').html("*Please enter your username.");
        isValid = false;
    }
    if (!username) {
        $('#passError').html("*Please enter your password.");
        isValid = false;
    }
    if (!isValid)
        return;
   // alert("isvalid");
   var param = {username: username, password:password, email: email, dob:dob, firstname:fname, lname:lname};
    $.ajax({
      type: "POST",
      url: "Signup.php",
      dataType: "JSON",
      data: param,
      success: function(data) {
          alert("success");
          console.log("data is");
          console.log(data);
          if (data == "redirect")
            window.location = "login.html";
          if (data == "-1") {
              $("#error").html("*Incorrect username or password supplied.");

          } else {


          }
       //$('#nameDiv').html(data);
      },
      error: function(err) {
          alert("Error");
          console.log(err.responseText);
      }
  });
}