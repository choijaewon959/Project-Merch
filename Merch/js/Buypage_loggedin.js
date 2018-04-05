//filter
$(‘#filterdiv’).animate({left: 1});


//Request modal
var modalcontent = document.getElementById('requestContentDiv');
var modal = document.getElementById('requestModal');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
