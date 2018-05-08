function OpenBookInfo(id) {

  $.ajax({
    method:"GET",
    url:"/book/"+id
  }).done(function(resp) {

        $("#book-header").html(resp.volumeInfo.title);
        $("#modal-book-description").html("Nothing found");
        $("#modal-book-snippet").html("Nothing found");

        $("#modal-book-description").html(resp.volumeInfo.description);

        $("#modal-book-snippet").html("<a target=\"_BLANK\" href=\""+resp.volumeInfo.previewLink+"\">Lue Googlesta</a>")

        if(resp.volumeInfo.readingModes.image) {
          $("#modal-book-image").html("<img id=\"modal-book-img\" src=\""+resp.volumeInfo.imageLinks.smallThumbnail+"\"/>")
        } else {
          $("#modal-book-image").html("");
        }


        $("#overlay").css("display","block");
        $("#modal").css("display","block");

  });


}
function closeModal() {
  $("#overlay").css("display","none");
  $("#modal").css("display","none");
}
