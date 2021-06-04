var table = null;
$(document).ready(function(){
getData();
$('#add').hide();
$('#btnSubmit').hide();
$("td").on('mouseenter', function() {
    alert("hello");
    $(this).find("img").attr("height", "100px");
    $(this).find("img").attr("width", "100px");
});
$("document").on('mouseleave', 'td', function() {
    $(this).find("img").attr("height", "40px");
    $(this).find("img").attr("width", "40px");
});
$('.del, .del').click( function(e){
    var msg = "Are you sure you want to delete the selected book?";
    if (!confirm(msg)) {
        e.preventDefault();
        e.stopPropagation();
    }
});
// Setup - add a text input to each footer cell

});

function showAdd(elem) {
    $('#add').show();
    $('#btnSubmit').show();
    $('#lst').hide();
    $(elem).hide();
}

function getData() {
    var param = {gender:  $('#gender').val(), year:$('#year').val()};
     $.ajax({
       type: "GET",
       url: "getBooks.php",
       dataType: "JSON",
       success: function(data) {
        console.log("book data is");
        console.log(data);
        displayBooks(data);
       },
       error: function(err) {
           alert("Error");
           console.log(err);
       }
   });
 }

function displayBooks(data) {
    var str = "<table id='books' class='table table-striped'>";
    str += "<thead><tr><th>Title</th><th>ISBN</th><th>Aisle</th><th>Section</th><th>Genre</th><th>Status</th><th>Image</th><th></th></tr></thead>";
    str += "<tbody>";
    for(var i=0; i<data.length; i++)
    {
        str += "<tr>";
        str += "<td class='bt'>" + data[i].title + "<div id='hover" + data[i].id  + "'></div></td>";
        str += "<td>" + (data[i].isbn ? data[i].isbn : "" ) + "</td>";
        str += "<td>" + (data[i].aisle ? data[i].aisle : "") + "</td>";
        str += "<td>" + (data[i].section ? data[i].section : "") + "</td>";
        str += "<td>" + (data[i].genre ? data[i].genre : "" ) + "</td>";
        str += "<td>" + (data[i].status == 0 ? "Available" : "Checked Out" ) + "</td>";
        if (data[i].img) {
            str += "<td style='height:100%'><div class='bt' id='" + data[i].id + "'></div></td>";
        } else {
            str += "<td></td>";
        }
        var editLnk = "<a href='edit.php?id=" + data[i].idb + "'> Edit</a>";
        //var deleteLnk = "<a  class='del' href='delete.php?id=" + data[i].idb + "'> Delete</a>";
        var deleteLnk = "<input type='button' class='btn btn-link' onclick='confirmDelete(" + data[i].idb + ")' value='Delete' style='padding:0px' />";
        str += "<td>" + editLnk + deleteLnk + "</td>";  

    }
    
    str += "</tbody></table>";
    $("#bookd").html(str);
    for(var i=0; i<data.length; i++)
    {
        
        if (data[i].img) {
           // alert($('#' + data[i].id).html());
            $('#' + data[i].id).html(data[i].img);
            //$('#hover' + data[i].id).hide();
            //$('#hover' + data[i].id).html(data[i].img);
            $('#' + data[i].id).find("img").attr("height", "100px");
            $('#' + data[i].id).find("img").attr("width", "100px");
        }

    }
   // $('#books').DataTable();
   setUpDataTable();

}

function confirmDelete(id) {
    var msg = "Are you sure you want to delete the selected book?";
    if (!confirm(msg)) {
        return;
    }
    window.location.href = "delete.php?id=" + id;
}

function setUpDataTable() {
    $('#books thead tr').clone(true).appendTo( '#books thead' );
    $('#books thead tr:eq(1) th').each( function (i) {
        var n = $(this).text();
        if(n && n != "Image") {
            if (n == "Aisle" || n == "Section")
                $(this).html( '<input type="text" style="width:50px" />');
            else
                $(this).html( '<input type="text"  style="width:150px" />' );
            $('input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table.column(i).search( this.value).draw();
                }
            });
        } else {
            $(this).html("");
        }
    });
    table =  $('#books').DataTable();
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
        $('#fl').val("none");
        $('#frm').submit();
    }
  }