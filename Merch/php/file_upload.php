<?php
  $output = '';
  if(is_array($_FILES))
  {
    $counter = 0 ;
    foreach ($_files['files']['name'] as $name => $value)
    {
        if($_files['files']['error'][$counter] ==0){
          $file_name = explode(',',$_files['files']['names'][$name]);
          $allowed_ext = array("image/jpg" => "jpg", "image/jpeg" => "jpeg", "image/gif" => "gif", "image/png" => "png");
          $product__id = $_SESSION['product_id'];
					$product__id = $product__id +1;
					$image_type = $_FILES["product_image"]["type"][$counter];
					// image name is set as seller_id + product id + photo sequence number
					$image_name = (string)$_SESSION['user_session']."_".(string)$product__id."_".(string)$a.'.'.$allowed[$image_type];
					$name_tmp = (string)$_SESSION['user_session']."_".(string)$product__id."_".(string)$a;

          if(in_array($file_name[1],$allowed_ext)){
            $new_name = $store_name.'.'.$file_name[1];
            $sourcepath = $_files['files']['tmp_name'][$name];
            $targetpath = ""
            if(move_uploaded_file($sourcepath,$targetpath)){
              $output .= '<img src ='.$targetPath.'"width = 150 px height = 150p>"';
            }
          }
        }
        $counter = $counter + 1;
    }
    echo $output;
  }
 ?>

<?php
$output = '';
$_SESSION['uploaded'] = 0;
if(isset($_POST["files[]"])) {
  for($a = 0; $a < sizeof($_FILES["files"]["name"]); $a ++)
  {
    if($_FILES["files"]["error"][$a] == 0)
    {
        $file_dir = "uploads/";
        $image_file = $file_dir . basename($_FILES["product_image"]["name"][$a]);
        $imageFileType = strtolower(pathinfo($image_file,PATHINFO_EXTENSION));
        $allowed = array("image/jpg" => "jpg", "image/jpeg" => "jpeg", "image/gif" => "gif", "image/png" => "png");
        $product__id = $_SESSION['product_id'];
        $product__id = $product__id +1;
        $image_type = $_FILES["product_image"]["type"][$a];
        // image name is set as seller_id + product id + photo sequence number
        $image_name = (string)$_SESSION['user_session']."_".(string)$product__id."_".(string)$a.'.'.$allowed[$image_type];
        $name_tmp = (string)$_SESSION['user_session']."_".(string)$product__id."_".(string)$a;
        $image_size = $_FILES["product_image"]["size"][$a];
        $check = getimagesize($_FILES["product_image"]["tmp_name"][$a]);

        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            unset($_SESSION['uploaded']);
            $_SESSION['uploaded'] = 1;
        } else {
            echo "File is not an image.";
            unset($_SESSION['uploaded']);
            $_SESSION['uploaded'] = 0;
        }

    if (file_exists($image_file)) {
        echo "Sorry, file already exists.";
        unset($_SESSION['uploaded']);
        $_SESSION['uploaded'] = 0;
    }
    if ($image_size > 500000) {
        echo "Sorry, your file is too large.";
        unset($_SESSION['uploaded']);
        $_SESSION['uploaded'] = 0;
    }
    if(!array_key_exists($image_type, $allowed))
    {
        echo "Error: Please select a valid file format.";
    }
    foreach($allowed as $b => $c)
    {
      $dir = "..\\Database\\image\\".$name_tmp.'.'.$c;
      if(file_exists($dir))
      {
        unlink($dir);
      }
    }
    // Check if $_SESSION['uploaded'] is set to 0 by an error
    if ($_SESSION['uploaded'] == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"][$a], "C:\\xampp\\htdocs\\Merch\\Database\\image\\".$image_name)) {
          $output .= '<img src ='.$targetPath.'"width = 150 px height = 150p>"';
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
      }
  }
}
echo $output ;
}
?>
