<?php
  $stmt = $auth_user->runQuery("SELECT * FROM request");
  $request_list= array();
  $c = 0;
  $stmt->execute(array(":user_id"=>$user_id));
  while($request_list[$c] = $stmt->fetch(PDO::FETCH_ASSOC)){
    $c = $c + 1;
  }
  for($a = 0; $a < $c ; $a ++)
  {
    ?>
if($a == 0){
  echo   "<div id="requestedDiv">
      <div id="requested-Book">
      <header id="requested-Book-logo">
        <div id='iconContainer-book'>
          Book
        </div>
      </header>";
}
if($request_list[$a]['category'] == "book")
{

}
if($request_list[$a]['category'] == "appliance")
{
echo      "<div id="contents">
        <div id="requested-contents">
          <div id="conts">
            <div id="usertitle">
              <label>Title: </label>
              <span>".$request_list[$a]['title']."</span></br>
            </div>
            <div id="updatedTime">"
              .$request_list[$a]['upload_date'].
            "</div>
            <div id="userPrice">
              <label>Price: </label>
              <span>".$request_list[$a]['price']."</span>
            </div>
            <div id="userdescription">
              <label>Description</label>
              <div id="userDes">"
                .$request_list[$a]['description'].
              "</div>
            </div>
          </div>
        </div>
      </div><!--requested div for appliance-->
}
if($a == 0){
    echo      " </div>
    <div id="requested-Clothe">
          <header id="requested-Clothe-logo">
            <div id='iconContainer-clothe'>
                Clothe
              </div>
            </header>";
}
if ($request_list[$a]['category'] == "clothe")
{
  echo        "<div id="contents">
          <div id="requested-contents">
            <div id="conts">
              <div id="usertitle">
                <label>Title: </label>
                <span>".$request_list[$a]['title']."</span></br>
              </div>
              <div id="updatedTime">"
                .$request_list[$a]['upload_date'].
              "</div>
              <div id="userPrice">
                <label>Price: </label>
                <span>".$request_list[$a]['price']."</span>
              </div>
              <div id="userdescription">
                <label>Description</label>
                <div id="userDes">"
                  .$request_list[$a]['description'].
                "</div>
              </div>
            </div>
          </div>
        </div>";
}
if($a == 0){
  echo     "</div>
      <div id="requested-Etc">
      <header id="requested-Etc-logo">
        <div id='iconContainer-etc'>
          Etc
        </div>
      </header>";
}
if ($request_list[$a]['category'] == "etc")
{
  echo    "<div id="contents">
          <div id="requested-contents">
            <div id="conts">
              <div id="usertitle">
                <label>Title: </label>
                <span>".$request_list[$a]['title']."</span></br>
              </div>
              <div id="updatedTime">"
                .$request_list[$a]['upload_date'].
              "</div>
              <div id="userPrice">
                <label>Price: </label>
                <span>".$request_list[$a]['price']."</span>
              </div>
              <div id="userdescription">
                <label>Description</label>
                <div id="userDes">"
                  .$request_list[$a]['description'].
                "</div>
              </div>
            </div>
          </div>
        </div>";
}
if($a == 0){
    echo "</div>
      <div id="requested-Etc">
      <header id="requested-Etc-logo">
        <div id='iconContainer-etc'>
          Etc
        </div>
      </header>;
}
  echo  "</div>";<!--requested div content-->
?>
