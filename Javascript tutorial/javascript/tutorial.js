function substitute(){
  var myValue = document.getElementById('myTextBox').value;

  if (myValue.length == 0){
    alert("Please enter the real value in the text box");
    return;
  }

  var myTitle = document.getElementById('title');
  myTitle.innerHTML = myValue;
}
