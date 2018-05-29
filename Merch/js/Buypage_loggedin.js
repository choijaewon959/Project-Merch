//sticked part effect
$(document).ready(function(){
    var shoppinBag = document.getElementById('stickedToTop');
    $(shoppinBag).animate({height:'200px'},'slow');
});



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
