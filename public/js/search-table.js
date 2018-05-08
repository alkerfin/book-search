function searchBooks() {
  var srchQuery = $("#searchQuery").val();

  if(srchQuery == "") {
    return;
  }

  $.ajax({
    method:"GET",
    url:"/books/"+srchQuery
  }).done(function(resp) {
    $("#search-results").html("");
    var resultHtml = "";
    if(resp != "") {
      resp.sort(function(a,b) {if(a.title > b.title) { return 1; } else { return -1;} })
      for(var i = 0;i < resp.length;i++) {
        resultHtml += "<tr>";
        if(resp[i].authors.length > 0) {
          resultHtml += "<td>"+resp[i].authors.join()+"</td>";
        } else {
          resultHtml += "<td>Tuntematon kirjailija</td>";
        }
        resultHtml += "<td>"+resp[i].title+"</td>";
        resultHtml += "<td>"+resp[i].description+"</td>";
        resultHtml += "<td><a href=\"#\" onClick=\"javascript:OpenBookInfo('"+resp[i].id+"');\">Näytä</a></td>";
        resultHtml += "</tr>";
      }
    }
    $("#search-results").html(resultHtml);
  });

}
