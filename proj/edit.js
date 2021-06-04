$(document).ready(function(){
        $('#imgDiv').find("img").attr("height", "100px");
        $('#imgDiv').find("img").attr("width", "100px");
        $('#fl').val( $('#imgDiv').html());
        console.log("h is");
        console.log($('#fl').val());
});

function remove() {
    $('#imgDiv').html("");
    $('#fl').val("");
}
function addBook() {

    if (validateBook())
    {
        convertImgToString();
        
        //$('#frm').submit();
    }

} 

function validateBook() {

   // convertImgToString();
   
    if(!$('#title').val()) {
        alert("Title is required");
        return false;
    }

    if(!$('#pub').val()) {
        alert("Publication date is required");
        return false;
    }

    if(!$('#author').val()) {
        alert("Please select an author");
        return false;
    }

    return true;
        
}

function convertImgToString() {

    var fl  = document.getElementById("ig").files;
    if (fl.length > 0) {
      var fileToLoad = fl[0];

      var fr = new FileReader();

      fr.onload = function(env) {
        var str = env.target.result; // <--- data: base64

        var ni = document.createElement('img');
        ni.src = str;

       // document.getElementById("imgTest").innerHTML = ni.outerHTML;
        //alert("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
        //console.log("Converted Base64 version is " + ni.outerHTML);
        $('#fl').val(ni.outerHTML);
        $('#frm').submit();
        //location.reload();
      }
      fr.readAsDataURL(fileToLoad);
    } else {
        //$('#fl').val("none");
        $('#frm').submit();
    }
  }