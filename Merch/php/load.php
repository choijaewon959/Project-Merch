<?php
  require_once("class.user.php");
  $auth_user = new USER();
  $product_stmt = $auth_user->runQuery("SELECT * FROM sell_product WHERE price BETWEEN '".$_POST['min_range']."' AND '".$_POST['max_range']."' ORDER BY price ASC");
  $product_stmt->execute();
  $counter = 0 ;
  $product_list = array();
  while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
    $counter = $counter +1 ;
  }
  $product_num = sizeof($product_list)-1;
  $product_list = array_slice($product_list,0,$product_num);
  if($product_num !==0)
  {
    for($i = 0 ; $i < $product_num ; $i ++){
      $id = $product_list[$i]['product_id'];
      $hash_stmt = $auth_user->runQuery("SELECT * FROM hashtag WHERE product_id=:product_id");
      $hash_stmt->execute(array(":product_id"=>$id));
      $counter = 0;
      $hash_list = array();
      $hash_out = '#';
      while($hash_list[$counter] = $hash_stmt->fetch(PDO::FETCH_ASSOC)){
        $hash_out .=$hash_list[$counter]['hashtag']."#";
        $counter = $counter +1 ;
      }
      $hash_out = substr($hash_out,0,-1);
    echo "<div class='contentBox'>";
    echo	"<div class='headerInBox'>.
        <div class='title'>".$product_list[$i]['title']."</div>".
        "<div class='updatedDate'>"."Upload Date ".$product_list[$i]['upload_date']."</div>".
      "</div>".

      "<div class='imgWrap'>".
        "<div class='img_description'>".
          "<div class='description'>".$product_list[$i]['description'].'</div>'.
          '<div class="hashtags">'.$hash_out."</div>".
        '</div>'.
        "<img class='image' src=".$auth_user->image_dir(1,$i+1)." alt='book' width=200px height=150px>".
      "</div>".
      "<footer>".
        "<div class='pricePanel'>".
          "<div id='numOfView'>".
            "15".
          "</div>".
          "<div id='eye'>".
            "<img src='../img/view.png' alt='eye'>".
          "</div>".
          "<div id='price'>".
            (string)$product_list[$i]['price']." HKD".
          "</div>".
        "</div>".
      "</footer>".
    "</div>";
    }
  }
  else{
    echo "<h3 align 'center'>No product found </h3> ";
  }
?>
