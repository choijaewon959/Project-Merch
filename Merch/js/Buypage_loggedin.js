
//Request modal
function requestModalfunction(){
  var modalcontent = document.getElementById('requestContentDiv');
  var modal = document.getElementById('requestModal');

  modal.style.display = "block";
  $(modalcontent).animate({height:"400px"});
}

window.onclick = function(event) {
    var modalcontent = document.getElementById('requestContentDiv');
    var modal = document.getElementById('requestModal');
    var closebtn = document.getElementById('closeBtn');

    if (event.target == modal || event.target == closebtn) {
        modalcontent.style.height = "0px";
        modal.style.display = "none";
    }
}
