//My info modal
function myInfofunction(){
  var modalcontent = document.getElementById('myInfoContentDiv');
  var modal = document.getElementById('myInfoDiv');

  modal.style.display = "block";
  $(modalcontent).animate({height:"600px"});
}

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
    var myInfoContent = document.getElementById('myInfoContentDiv');
    var myInfoDiv = document.getElementById('myInfoDiv');
    var myInfoCloseBtn = document.getElementById('accountDivCloseBtn');

    if (event.target == modal || event.target == closebtn) {
        modalcontent.style.height = "0px";
        modal.style.display = "none";
    }

    if (event.target == myInfoDiv || event.target == myInfoCloseBtn) {
        myInfoContent.style.height = "0px";
        myInfoDiv.style.display = "none";
    }
}


//fileterDiv
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
