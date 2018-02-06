<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Password Generator</title>
<link rel="stylesheet" href="style.css" type="text/css"  />


<script type="text/javascript">
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("Copy");
  alert("Your Password Copied: " + copyText.value);
}
</script>

</head>
<body>

<div id="main2">
<h1>Password Generator</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
  <select name="limit">
    <option value="16" >16 Recommended </option>
    <option value="18" >18</option>
    <option value="20" >20</option>
  </select>
<input class="button" type="submit"  value="GENERATE" >
</form>


</div>


</body>
</html>
