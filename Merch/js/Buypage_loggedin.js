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
  $(modalcontent).animate({height:"400px"});
}

//popup div for main contents
let sliderIndex = 1;

function popUpProduct(){
  //alert('test');
  var popUpPanel = document.getElementById('onClickPopUp');
  var popUpConent = document.getElementById('popUpContent');

  popUpPanel.style.display = "block";
  $(popUpConent).animate({height: "730px"});
  changeSlider(sliderIndex);
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

//drag content div
$(function() 
{
  $( ".contentBox" ).draggable({revert: "invalid"});
  $( ".cartDiv").droppable(
  {   
    hoverClass: "drop-ui-hover",
    accept: ".draggable",
    drop: function(event, ui)
    {
      $(ui.draggable).remove();
    }
  });
});


//filters
var slider = document.getElementById("priceSlider");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    output.innerHTML = this.value;
}

function qualityFilterDivShow(){
  var outerDiv = document.getElementById('qualitySortDiv');
  var qualityDiv = document.getElementById('qualityFilterDiv');
  var selecting = true;
  var medal = document.getElementById('medalIcon');


  if (selecting){
    outerDiv.style.height="90px";
    outerDiv.style.background="#a27cef";
    outerDiv.style.color="#fff";

    //change the color of the icon
    $(medal).attr('src', "../img/medal-white.png");
    qualityDiv.style.display="block";
    $(outerDiv).animate({width:"300px"});

    window.onclick = function(event){
      if(event.target == outerDiv){
        selecting = false;
        outerDiv.style.height="0px";
        outerDiv.style.background="#f5f5f5";
        outerDiv.style.color="#555";

        //change the color of the icon
        $(medal).attr('src', "../img/medal.png");
        qualityDiv.style.display="none";
        $(outerDiv).animate({width:"0px"});
      }
    }
  }

}

function categoryFilterDivShow(){
  var outerDiv = document.getElementById('categorySortDiv');
  var categoryDiv = document.getElementById('categoryFilterDiv');
  var selecting = true;
  var box = document.getElementById('boxIcon');


  if (selecting){
    outerDiv.style.height="90px";
    outerDiv.style.background="#a27cef";
    outerDiv.style.color="#fff";

    //change the color of the icon
    $(box).attr('src', "../img/box-white.png");

  }

  categoryDiv.style.display="block";
  $(outerDiv).animate({width:"300px"});

}
function priceFilterDivShow(){
  var outerDiv = document.getElementById('priceSortDiv');
  var priceDiv = document.getElementById('priceFilterDiv');
  var selecting = true;
  var barcode = document.getElementById('barcodeIcon');


  if (selecting){
    outerDiv.style.height="90px";
    outerDiv.style.background="#a27cef";
    outerDiv.style.color="#fff";

    //change the color of the icon
    $(barcode).attr('src', "../img/barcode-white.png");

  }

  priceDiv.style.display="block";
  $(outerDiv).animate({width:"300px"});

}
