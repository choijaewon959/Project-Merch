function openNav() {
    document.getElementById("requested").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("requested").style.width = "0%";
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
