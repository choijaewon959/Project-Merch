function openNav() {
    document.getElementById("requested").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("requested").style.width = "0%";
}


//Request modal

function requestDivfunction(){
  var modalcontent = document.getElementById('requestContentDiv');
  var modal = document.getElementById('requestModal');

  modal.style.display = "block";
  $(modalcontent).animate({height:'400px'});
}

window.onclick = function(event) {
    var modalcontent = document.getElementById('requestContentDiv');
    var modal = document.getElementById('requestModal');
    var closebtn = document.getElementById('closeBtn');

    if (event.target == modal || event.target == closebtn) {
        $(modalcontent).animate({height:'0px'});
        modal.style.display = "none";
    }
}


$("document").ready(function(){
  document.getElementById('files').addEventListener('change', handleFileSelect, false);

  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }
      var reader = new FileReader();
      var image = new Image();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          console.log(theFile);
          console.log(image);
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="previewimage" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('preview').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }
});


/*

$("document").ready(function(){
  var template = '';
  var counter = 0 ;
    $("#files").change(function(e){
      console.log("aa");
      var files = e.target.files;
      $.each(files, function(i,files){
        console.log("bb");
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function(e){
          var template = '<form action ="/upload">'+
                      '<img src ='+e.target.result+'>'+"</form>";
        };
      counter = counter +1 ;
      console.log(files);
      console.log(reader);
      });
      $("#preview").append(template);
    });
    document.getElementById('files').onchange = function(e) {
        readFile(e.srcElement.files[0]);
    };
});
*/

$(function() {
    var $sidebar   = $("#tips-panel"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 90;
    $(window).scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });//scroll

});//function

/*
$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });

	#.ajax({
    					url: "file_upload.php",
    					type: "POST",
    					data: new FormData(this),
    					contentType : false,
    					processdata : false,
    					success: function(data)
    					{
    						$('#preview').html(data);
    						alert("Image Uploaded");
    					}
    	});
}); */
