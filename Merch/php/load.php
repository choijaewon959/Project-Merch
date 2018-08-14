<?php
  session_start();
  require_once("class.user.php");
  $auth_user = new USER();
  $counter = 0 ;
  $product_list = array();
  $quality = $_POST['q_value'];
  $category = $_POST['c_value'];
  $_SESSION['max_price'] = 0;
//  print_r($_POST);
//  print_r("XXXX");
//  print_r($_SESSION);

  if($quality=="default" && $category=="default")
  {
    $product_stmt = $auth_user->runQuery("SELECT * FROM sell_product WHERE price BETWEEN '".$_POST['min_range']."' AND '".$_POST['max_range']."' ORDER BY upload_date DESC");
    $product_stmt->execute();
    while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
      $counter = $counter +1 ;
    }
    $product_num = sizeof($product_list)-1;
    $product_list = array_slice($product_list,0,$product_num);
  }
  else if($quality!=="default" && $category!=="default")
  {
    $product_stmt = $auth_user->runQuery("SELECT * FROM sell_product WHERE quality=:quality AND category=:category AND price BETWEEN '".$_POST['min_range']."' AND '".$_POST['max_range']."' ORDER BY upload_date DESC");
    $product_stmt->bindparam(":quality", $quality);
    $product_stmt->bindparam(":category", $category);
    $product_stmt->execute();
    while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
      $counter = $counter +1 ;
    }
    $product_num = sizeof($product_list)-1;
    $product_list = array_slice($product_list,0,$product_num);

  }
  else if($quality!=="default")
  {
    $product_stmt = $auth_user->runQuery("SELECT * FROM sell_product WHERE quality=:quality AND price BETWEEN '".$_POST['min_range']."' AND '".$_POST['max_range']."' ORDER BY upload_date DESC");
    $product_stmt->bindparam(":quality", $quality);
    $product_stmt->execute();
    while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
      $counter = $counter +1 ;
    }
    $product_num = sizeof($product_list)-1;
    $product_list = array_slice($product_list,0,$product_num);
  }
  else if($category!=="default")
  {
    $product_stmt = $auth_user->runQuery("SELECT * FROM sell_product WHERE category=:category AND price BETWEEN '".$_POST['min_range']."' AND '".$_POST['max_range']."' ORDER BY upload_date DESC");
    $product_stmt->bindparam(":category", $category);
    $product_stmt->execute();
    while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
      $counter = $counter +1 ;
    }
    $product_num = sizeof($product_list)-1;
    $product_list = array_slice($product_list,0,$product_num);

  }
  if($product_num !==0)
  {
    $enter = 0;
    if(isset($_SESSION['match_list']))
    {
      if(isset($_SESSION['match_list'][0]) || $_POST['search_word'] !== "")
      {
        for($i = 0 ; $i < $product_num ; $i ++)
        {
          $id = $product_list[$i]['product_id'];
          if(in_array($id, $_SESSION['match_list']) == true)
          {

            $enter = 1;
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

            echo "<div class='contentBox'>
               <div class='headerInBox'>";
            if ($product_list[$i]['category'] == "book"){
              echo "<div id='bookIconInBox'></div>";
            }
            else if($product_list[$i]['category'] == "appliance"){
              echo "<div id='applianceIconInBox'></div>";
            }
            else if($product_list[$i]['category'] == "clothe"){
                echo "<div id='clotheIconInBox'></div>";
            }
            else if($product_list[$i]['category'] == "etc"){
                echo "<div id='etcIconInBox'>Etc</div>";
            }
            echo  "<div class='title'>".$product_list[$i]['title']."</div>".
              "<div class='updatedDate'>".$product_list[$i]['upload_date']."</div>".
            "</div>".
            "<div class='imgWrap'>".
              "<div class='img_description'>".
                "<div class='description'>".$product_list[$i]['description'].'</div>'.
                '<div class="hashtags">'.$hash_out."</div>".
              '</div>'.
              "<img class='image' src=".$auth_user->image_dir(1, $product_list[$i]['product_id'])." alt='book' width=400px height=420px>".
            "</div>".
            "<footer>".
              "<div class='pricePanel'>".
                "<div id='price'>".
                  (string)$product_list[$i]['price']." HKD".
                "</div>".
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
      }
      else
      {
        for($i = 0 ; $i < $product_num ; $i ++)
        {
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
          if($product_list[$i]['price'] > $_SESSION['max_price'])
          {
            $_SESSION['max_price'] = $product_list[$i]['price'];
          }
          echo "<div class='contentBox'>
	           <div class='headerInBox'>";
          if ($product_list[$i]['category'] == "book"){
            echo "<div id='bookIconInBox'></div>";
          }
          else if($product_list[$i]['category'] == "appliance"){
            echo "<div id='applianceIconInBox'></div>";
          }
          else if($product_list[$i]['category'] == "clothe"){
              echo "<div id='clotheIconInBox'></div>";
          }
          else if($product_list[$i]['category'] == "etc"){
              echo "<div id='etcIconInBox'>Etc</div>";
          }
          echo   "<div class='title  '>".$product_list[$i]['title']."</div>".
            "<div class='updatedDate' class=' '>".$product_list[$i]['upload_date']."</div>".
          "</div>".
          "<div class='imgWrap  '>".
            "<div class='img_description'>".
              "<div class='description'>".$product_list[$i]['description'].'</div>'.
              '<div class="hashtags">'.$hash_out."</div>".
            '</div>'.
            "<img class='image' src=".$auth_user->image_dir(1, $product_list[$i]['product_id'])." alt='book' width=400px height=420px>".
          "</div>".
          "<footer>".
            "<div class='pricePanel'>".
              "<div id='price'>".
                (string)$product_list[$i]['price']." HKD".
              "</div>".
            "</div>".
          "</footer>".
        "</div>";
        }
      }
      if($enter == 0 && $_POST['search_word'] !== "")
      {
        echo "<h3 align 'center'>No product found </h3> ";
      }
    }
  }
  else{
    echo "<h3 align 'center'>No product found </h3> ";
  }
?>
