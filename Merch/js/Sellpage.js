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


$(function() {
    var $sidebar   = $("#tips-panel"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 90;

    $window.scroll(function() {
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
});
