<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>

 <title>PHP URL SHORTENER </title>
  <link rel="stylesheet" href="style.css" type="text/css"  />
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<?php
  // Include One time Database Connetion parameter file
   include_once  "dbconfig.php";
  // Get Redirect Code
  if(isset($_GET['cp'])){
  $rd= $_GET["cp"];
  // Run PDO Query
  $stmt = $db_con -> prepare( "select * from red where shrt = '$rd' " );
  // Execute Statment
  $stmt -> execute();
  // Fatch Result
  $result = $stmt -> fetch();
  // Store URL Field result into Resource Varriable
  $res= $result["url"];
  // Redirect 301 Permenatly
  header('HTTP/1.1 301 Moved Permanently');
  header("location:".$res);

}
  ?>


    <div id="main">
<!--*********************Start Main*********************-->

     	<form id="form1" method="post" action="" >


             <table>
  <tbody>

  <!--********************** Table Row No 1 ***************************-->
   <tr >
      <td><h1>Short Link Generator</h1></td>

    </tr>

    <tr>

      <td>   <input id="txt_field" type="text" value= "http://"  name="url"/></td>
    </tr>

      <!--********************** Table Row No 2 ***************************-->

  <!--********************** Table Row No 3 ***************************-->
    <tr>
      <td><input class="button" type="submit" name="submit" value="Generate" /> </form> </td></tr>

    <tr>
<!--*********************From End*********************-->
    <tr><td>




    <?php
if(isset($_POST['submit'])){

//***********************************************************************************************
//************************Start PHP Short Code *****************************************
//***********************************************************************************************


//database connection required.
require_once 'dbconfig.php';





  if (!$_POST['url'])
        {

  die('<p><font  color="red" size="36" >Do not empty the required fields!</span><p>');
  }


  if(isset($_POST['url'])){



$c = $_POST['url'];


// random short code
$id=rand(10000,99999);
$shorturl=base_convert($id,20,36);
$stmt = $db_con->prepare("INSERT INTO red(url,shrt)
VALUES(:eurl, :eshrt)");
$stmt->bindParam(":eurl", $c);
$stmt->bindParam(":eshrt", $shorturl);

// execute statment
if($stmt->execute())
{
  echo ""; // you can add any success message.
}

		// Display URL

        echo '<p>Short URL: <a  target="_blank" href="index.php?cp='.$shorturl.'">q.com/'.$shorturl.'</a></p>';


exit;




}

  else{


  		  die('<p><font color="red" size="38"><strong> Sorry Captcha is not right. </strong> </font></p>' );



  }
//***********************************************************************************************
//************************End PHP Short Code *****************************************
//***********************************************************************************************

}

?>


      </td></tr>



  </tbody>
</table>









</div>
<!--*********************End Main*********************-->
</body>
</html>
