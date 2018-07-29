<?php
  session_start();
  require_once("class.user.php");
  $auth_user = new USER();
  $search_stmt = $auth_user->runQuery("SELECT * FROM hashTag");
  $search_stmt->execute();
  $search_list = array();
  $counter = 0 ;
  $cc = 0;
  $_SESSION['match_list']= array();
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
        if(strpos($search_list[$i]['hashtag'],$search) !== false)
        {
          if(!in_array($search_list[$i]['product_id'],$_SESSION['match_list']))
          {
            $query = "SELECT quality, category FROM sell_product WHERE product_id =: pid";
            if ($_POST['c_value'] !== "default"){
              $query .=  "AND category =: c_value";
            }
            if ($_POST['q_value'] !== "default"){
              $query .=  "AND quality =: q_value";
            }
            $search_stmt = $auth_user->runQuery($query);
            $search_stmt->bindparam(":pid",$search_list[$i]['product_id']);
            if ($_POST['c_value'] !== "default"){
              $search_stmt->bindparam(":c_value",$_POST['c_value']);
            }
            if ($_POST['q_value'] !== "default"){
              $search_stmt->bindparam(":q_value",$_POST['q_value']);
            }
            echo "#".$search_list[$i]['hashtag']."\n";
            $_SESSION['match_list'][$cc] = $search_list[$i]['product_id'];
            $cc = $cc + 1;
          }
          else
          {
            echo "#".$search_list[$i]['hashtag']."\n";
          }
        }
      }
    }
  }
  $search_list = array();
  $query = "SELECT title, product_id FROM sell_product";
  if($_POST['c_value'] !== "default" || $_POST['q_value'] !== "default"){
    $query .= " WHERE";
  }
  if ($_POST['c_value'] !== "default"){
    $query .=  " AND category =: c_value";
  }
  if ($_POST['q_value'] !== "default"){
    $query .=  " AND quality =: q_value";
  }
  if ($_POST['c_value'] !== "default"){
    $search_stmt->bindparam(":c_value",$_POST['c_value']);
  }
  if ($_POST['q_value'] !== "default"){
    $search_stmt->bindparam(":q_value",$_POST['q_value']);
  }
  $search_stmt = $auth_user->runQuery($query);
  $search_stmt->execute();
  $counter = 0 ;
  while($search_list[$counter] = $search_stmt->fetch(PDO::FETCH_ASSOC)){
    $counter = $counter +1 ;
  }
  $search_num = sizeof($search_list)-1;
  $search_list = array_slice($search_list,0,$search_num);
  if(isset($_POST['search_word']))
  {
    if(strlen($search) !== 0 && $search_num > 0)
    {
      for($i = 0 ; $i < $search_num; $i++)
      {
        if(strpos($search_list[$i]['title'],$_POST['search_word'])!== false)
        {
          if(in_array($search_list[$i]['product_id'],$_SESSION['match_list']) == false)
          {
            echo "#".$search_list[$i]['title']."\n";
            $_SESSION['match_list'][$cc] = $search_list[$i]['product_id'];
            $cc = $cc + 1;
          }
          else
          {
            echo "#".$search_list[$i]['title']."\n";
          }
        }
      }
    }
  }
  ?>
