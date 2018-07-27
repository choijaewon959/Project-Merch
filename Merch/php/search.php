<?php
  require_once("class.user.php");
  $auth_user = new USER();
  $search_stmt = $auth_user->runQuery("SELECT * FROM hashTag");
  $search_stmt->execute();
  $search_list = array();
  $_POST['match_list'] = array();
  $counter = 0 ;
  $cc = 0;
  while($search_list[$counter] = $search_stmt->fetch(PDO::FETCH_ASSOC)){
    $counter = $counter +1 ;
  }
  $search_num = sizeof($search_list)-1;
  $search_list = array_slice($search_list,0,$search_num);
  if(isset($_POST['search_word']))
  {
    $search = $_POST['search_word'];
    if(strlen($search) !== 0)
    {
      for($i = 0 ; $i < $search_num; $i++)
      {
        if(strpos($search_list[$i]['hashtag'],$search)!== false)
        {
            echo "#".$search_list[$i]['hashtag']."\n";
            if(in_array($search_list[$i]['product_id'],$_POST['match_list']) == false)
            {
                $_POST['match_list'][$cc] = $search_list[$i]['product_id'];
                $cc = $cc + 1;
            }
        }
      }
    }
  }
  $search_list = array();
  $search_stmt = $auth_user->runQuery("SELECT title, product_id FROM sell_product");
  $search_stmt->execute();
  $counter = 0 ;
  while($search_list[$counter] = $search_stmt->fetch(PDO::FETCH_ASSOC)){
    $counter = $counter +1 ;
  }
  $search_num = sizeof($search_list)-1;
  $search_list = array_slice($search_list,0,$search_num);
  if(isset($_POST['search_word']))
  {
    $search = $_POST['search_word'];
    if(strlen($search) !== 0)
    {
      for($i = 0 ; $i < $search_num; $i++)
      {
        if(strpos($search_list[$i]['title'],$search)!== false)
        {
            echo "#".$search_list[$i]['title']."\n";
            if(in_array($search_list[$i]['product_id'],$_POST['match_list']) == false)
            {
                $_POST['match_list'][$cc] = $search_list[$i]['product_id'];
                $cc = $cc + 1;
            }
        }

      }
    }
  }
  print_r($_POST);
?>
