alert("test");

var myName="Jae"; //variable name can start with _, letter, $
                  // but cannot start with number

var a = 1;
var b = "Jae";
var c = true;

var a2 = 2 , b2 = 3, c2 =4; // This is possible as well.

// javascript is case sensitive!

var result = a + a2;
alert(result);  // alert function acts twice "test" & result



//CONDITIONAL STATEMENT
var aa= 10;
var bb= 20;

if (aa==bb){
  var result = aa+bb;
  document.write("result of summation is", result);
} else{
  document.write("hihi");
}

var cc = (aa>bb) ? alert("aa is bigger") : alert("bb is bigger");
