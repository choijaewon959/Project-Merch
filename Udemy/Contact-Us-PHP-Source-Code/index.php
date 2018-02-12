
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign In</title>
<link rel="stylesheet" href="style1.css" type="text/css"  />
</head>
<body>

<div id="main2">



       <form  method="post" action="contact.php" >

        <h1 >Contact Us</h1>


        <input type="text"  name="name" placeholder="Name" required />
        <input type="text"  name="email" placeholder="Email" required />
				  <input type="text"  name="mobile" placeholder="Mobile" required />
					  <textarea type="text"  name="message" placeholder="Message" required /></textarea>



                <?php

               $a = rand(0, 9);
               $b = rand(0, 9);

       ?>  <input type="text"  name="ans" placeholder="Answer : <?php echo "$a + $b"; ?>" required />
<input value="<?php echo $a ?>"  name="a" type="hidden">
<input value=" <?php echo $b ?>" name="b"  type="hidden"></td>




            <input value="SEND" type="submit"  class="button">



      </form>



</div>

</body>
</html>
