
//Request modal

function requestDivfunction(){
  var modalcontent = document.getElementById('requestContentDiv');
  var modal = document.getElementById('requestModal');

  modal.style.display = "block";
}

window.onclick = function(event) {
    var modalcontent = document.getElementById('requestContentDiv');
    var modal = document.getElementById('requestModal');

    if (event.target == modal) {
        modal.style.display = "none";
    }
}
