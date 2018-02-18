
window.onscroll = function(){sticky()};

var sticked = document.getElementById("stickedToTop");
var position = sticked.offsetTop;


function sticky(){
  if (window.pageYOffset >= position) {
    sticked.classList.add("position");
  } else {
    sticked.classList.remove("position");
  }
}
