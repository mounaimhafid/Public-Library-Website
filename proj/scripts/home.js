var table = null;
$(document).ready(function(){
getData();
});
// Setup - add a text input to each footer cell


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
    str += "<thead><tr><th>Title</th><th>ISBN</th><th>Aisle</th><th>Section</th><th>Genre</th><th>Image</th><th></th></tr></thead>";
    str += "<tbody>";
    for(var i=0; i<data.length; i++)
    {
        str += "<tr>";
        str += "<td class='bt'>" + data[i].title + "<div id='hover" + data[i].id  + "'></div></td>";
        str += "<td>" + (data[i].isbn ? data[i].isbn : "" ) + "</td>";
        str += "<td>" + (data[i].aisle ? data[i].aisle : "") + "</td>";
        str += "<td>" + (data[i].section ? data[i].section : "") + "</td>";
        str += "<td>" + (data[i].genre ? data[i].genre : "" ) + "</td>";
        //str += "<td>" + (data[i].status == 0 ? "Available" : "Checked Out" ) + "</td>";
        if (data[i].img) {
            str += "<td style='height:100%'><div class='bt' id='" + data[i].id + "'></div></td>";
        } else {
            str += "<td></td>";
        }
        if(!data[i].num || data[i].num == "0")
            str += "<td>Unavailable</td>"; 
        else
            str += "<td>" + getAddToCartButton(data[i].title, data[i].idb, data[i].num, data[i].img ) + "</td>";  

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


function getAddToCartButton(title, id, num, img){
    return '<form action = "addCart.php" method = "POST"><button name = "addcart" value="' + title + '?' + id+ '?'+ num+ "?" + '" type = "submit" class="btn btn-success" > Add to Cart </button></form>';
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
