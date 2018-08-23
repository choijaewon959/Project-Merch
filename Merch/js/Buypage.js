//My info modal
/*
var myInfoShowing = false;
function myInfofunction(){
  var modalcontent = document.getElementById('myInfoContentDiv');
  var modal = document.getElementById('myInfoDiv');

  modal.style.display = "block";
  $(modalcontent).animate({height:"600px"});
}*/

//Request modal
function requestModalfunction(){
  var modalcontent = document.getElementById('requestContentDiv');
  var modal = document.getElementById('requestModal');

  modal.style.display = "block";
  $(modalcontent).animate({height:"450px"});
}

//popup div for main contents
var sliderIndex = 1;

function popUpProduct(){
  if ($('.contentBox').hasClass('ui-draggable-dragging')) {
        $('.contentBox').removeClass('dragging');
  }
  else{
    var popUpPanel = document.getElementById('onClickPopUp');
    var popUpConent = document.getElementById('popUpContent');
  
    popUpPanel.style.display = "block";
    $(popUpConent).animate({height: "730px"});
    changeSlider(sliderIndex);
  }
  
}

//popup slider control
function incrementSliderIndex(n){
  changeSlider(sliderIndex+=n);
}

function currentSlider(n){
  changeSlider(sliderIndex=n);
}

function changeSlider(n){
  let slidePhoto = document.getElementsByClassName("slidePhoto");
  if (n > slidePhoto.length) {sliderIndex = 1} ;
  if (n < 1) {sliderIndex = slidePhoto.length} ;
  for (let i = 0; i < slidePhoto.length; i++) {
      slidePhoto[i].style.display = "none";
  }
  slidePhoto[sliderIndex-1].style.display = "block";
}

window.onclick = function(event) {
    var modalcontent = document.getElementById('requestContentDiv');
    var modal = document.getElementById('requestModal');
    var closebtn = document.getElementById('closeBtn');

    var popUpPanel = document.getElementById('onClickPopUp');
    var popUpConent = document.getElementById('popUpContent');
    var popupClose = document.getElementById('popupClose');

    if (event.target == modal || event.target == closebtn) {
        modalcontent.style.height = "0px";
        modal.style.display = "none";
    }

    if(event.target == popUpPanel || event.target == popupClose){
        popUpConent.style.height = "0px";
        popUpPanel.style.display= "none";
    }
}

//filters
var slider = document.getElementById("priceSlider");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    output.innerHTML = this.value;
}

$("#slider").slider({
    min: 0,
    max: 100,
    step: 1,
    values: [10, 90],
    slide: function(event, ui) {
        for (var i = 0; i < ui.values.length; ++i) {
            $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
        }
    }
});



//my Selling what I am selling
var sliderIndex2 = 1;

function incrementSliderIndex2(n){
  changeSlider2(sliderIndex2+=n);
}

function currentSlider2(n){
  changeSlider2(sliderIndex2=n);
}

function changeSlider2(n){
  var slidePhoto2 = document.getElementsByClassName("mySellingPhoto");
  if (n > slidePhoto2.length) {sliderIndex2 = 1} ;
  if (n < 1) {sliderIndex2 = slidePhoto2.length} ;
  for (let i = 0; i < slidePhoto2.length; i++) {
      slidePhoto2[i].style.display = "none";
  }
  slidePhoto2[sliderIndex2-1].style.display = "block";

}
changeSlider2(1);