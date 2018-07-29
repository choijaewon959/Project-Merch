<?php
require_once('../Database/dbconfig.php');
class USER
{
	private $conn;
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function register($uname,$umail,$upass,$phone_num)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			$stmt = $this->conn->prepare("INSERT INTO users(user_name,email,user_pass,phone_num)
		                                               VALUES(:uname, :umail, :upass, :phone_num)");
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);
			$stmt->bindparam(":phone_num",$phone_num);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function checkEmail($umail)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_name, email, user_pass FROM users WHERE email=:umail ");
			$stmt->execute(array(':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowcount() ==1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function doLogin($uname,$umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_name, email, user_pass FROM users WHERE user_name=:uname OR email=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($upass, $userRow['user_pass']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	public function redirect($url)
	{
		header("Location: $url");
		exit();
	}
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
	public function addProduct()
	{
		$p_category = "";
		$p_quality ="";
		$stmt = $this->conn->prepare("INSERT into sell_product(seller_id,title,quality,category,price,description)
																	VALUES(:seller_id,:title,:quality,:category,:price,:description)");
		if($_SESSION['product_category'] == 1){$p_category = "book";}
		else if($_SESSION['product_category'] == 2){$p_category = "clothe";}
		else if($_SESSION['product_category'] == 3){$p_category = "appliance";}
		else if($_SESSION['product_category'] == 4){$p_category = "etc";}
		if($_SESSION['product_quality'] == 1){$p_quality = "new";}
		else if($_SESSION['product_quality'] == 2){$p_quality = "used";}
		else if($_SESSION['product_quality'] == 3){$p_quality = "old";}
		$stmt->bindparam(":seller_id",$_SESSION['user_session']);
		$stmt->bindparam(":title",$_SESSION['product_title']);
		$stmt->bindparam(":quality",$p_quality);
		$stmt->bindparam(":category",$p_category);
		$stmt->bindparam(":description",$_SESSION['product_description']);
		$stmt->bindparam(":price",$_SESSION['product_price']);
		$stmt->execute();
		$stmt = $this->conn->prepare("SELECT product_id FROM sell_product WHERE seller_id =:seller_id");
		$stmt->execute(array(':seller_id'=>$_SESSION['user_session']));
		$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
		if(isset($_SESSION['product_id']))
		{unset($_SESSION['product_id']);}
		$_SESSION['product_id'] ="";
		$_SESSION['product_id'] = (string)$userRow[sizeof($userRow)-1]['product_id'];
		return $stmt;
	}
	public function addRequest($user_id)
	{
		try{
			$r_category = "";
			$stmt = $this->conn->prepare("INSERT into request(user_id,title,category,price,description)
																		VALUES(:user_id,:title,:category,:price,:description)");
			if($_SESSION['request_category'] == 1){$r_category = "book";}
			else if($_SESSION['request_category'] == 2){$r_category = "clothe";}
			else if($_SESSION['request_category'] == 3){$r_category = "appliance";}
			else if($_SESSION['request_category'] == 4){$r_category = "etc";}
			$stmt->bindparam(":user_id",$user_id);
			$stmt->bindparam(":title",$_SESSION['request_title']);
			$stmt->bindparam(":category",$r_category);
			$stmt->bindparam(":description",$_SESSION['request_description']);
			$stmt->bindparam(":price",$_SESSION['request_price']);
			$stmt->execute();
			return $stmt;
		}catch(PDOException $e){
			$_SESSION['request_error'] = $e;
		}
	}

	public function convert_hashtag()
	{
		$hash_arr = array();
		$tmp_hash = $_SESSION['product_hashtag'];
		$hash_arr = explode("#",$tmp_hash);
		unset($hash_arr[0]);
		return $hash_arr;
	}
	public function addHashtag($hash_arr)
	{
		$stmt = "";
		for($a = 1; $a< sizeof($hash_arr)+1; $a ++)
		{
			$stmt = $this->conn->prepare("INSERT into hashtag(hashtag,product_id)
																		VALUES(:hashtag,:product_id)");
			$stmt->bindparam(":hashtag", $hash_arr[$a]);
			$stmt->bindparam(":product_id", $_SESSION['product_id']);
			$stmt->execute();
		}
		return $stmt;
	}
	// returns array of filenames in db
	public function dbList()
	{
		$imgspath = "C:\\xampp\\htdocs\\Merch\\Database\\image\\" ;
		$files = scandir($imgspath);
		$total = sizeof($files);
		$images = array();
		for($x = 0; $x < $total; $x++) {
			if ($files[$x] != '.' && $files[$x] != '..') {
				$str = $files[$x];
				$pos = strpos($str, '.');
				$str = substr($str,0, $pos);
				$images[] = $str;
			}
		}
		return $images ;
	}
	// returns the index of k th picture of nth product
	public function nthproduct($k,$n)
	{
		$imgnames = $this->dbList();
		$len = sizeof($imgnames);
		$id = '';
		$pid = '';
		$data = array() ;
		for($i =0 ; $i < $len ; $i ++){
			$str = $imgnames[$i];
			$pos = strpos($str,'_');
			$poss = strpos($str,'_',$pos+1);

			$id = (int)substr($str,0,$pos);
			$pid = (int)substr($str,$pos+1,$poss-$pos-1);
			$tmp = $id*1000 +$pid ;
			$lenn = sizeof($data);
			if($lenn==0){
				$data[0]=array();
				$data[0][0] = $tmp;
				$data[0][1] = 1;
				if($k ==1 && $n ==1){return 0 ;}
			}
			else{
				for($p = 0 ; $p <$lenn ; $p ++)
				{
					if($data[$p][0] == $tmp)
					{
						$data[$p][1]= $data[$p][1]+1;
						if($p+1 == $n && $data[$p][1]== $k)
						{return $i;}
						break;
					}
					else if($p == $lenn-1)
					{
						$data[$lenn]= array();
						$data[$lenn][0] = $tmp;
						$data[$lenn][1] = 1 ;
						if($lenn+1 == $n && 1== $k)
						{return $i;}
					}
						if($p+1 == $n && $data[$p][1]== $k)
						{return $i;}
					}
				}
			}
			return null ;
	}
	// returns dir of kth image of nth product
	public function image_dir($k ,$n)
	{
		$imgspath = "../Database/image/" ;
		$files = scandir($imgspath);
		$index = $this->nthproduct($k,$n);
		$dir = $files[$index+2];
		$dir = $imgspath.$dir;
		return $dir ;
	}
	public function productId()
	{
		$stmt = $this->conn->prepare("SELECT product_id FROM sell_product WHERE seller_id =:seller_id");
		$stmt->execute(array(':seller_id'=>$_SESSION['user_session']));
		$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
		if(isset($_SESSION['product_id']))
		{unset($_SESSION['product_id']);}
		$_SESSION['product_id'] ="";
		$_SESSION['product_id'] = (string)$userRow[sizeof($userRow)-1]['product_id']+1;
	}
	public function changeInfo($user_id)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE users SET user_name=:user_name, email=:user_email, phone_num=:phone_num WHERE user_id=:user_id");
			$stmt->bindparam(":user_name", $_SESSION['my_userName']);
			$stmt->bindparam(":user_email", $_SESSION['my_email']);
			$stmt->bindparam(":phone_num", $_SESSION['my_phonenum']);
			$stmt->bindparam(":user_id", $user_id);
			$stmt->execute();

		}catch(PDOException $e)
		{
			$_SESSION['request_error'] = $e;
		}

	}
	public function changepwd($currentpass,$confirmpass,$user_id)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_name, email, user_pass FROM users WHERE user_id=:uid");
			$stmt->bindparam(":uid", $user_id);
			$stmt->execute();
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($currentpass, $userRow['user_pass']))
				{
					$new_password = password_hash($confirmpass, PASSWORD_DEFAULT);
					$stmt = $this->conn->prepare("UPDATE users SET user_pass=:newpass WHERE user_id=:uid");
					$stmt->bindparam(":newpass", $new_password);
					$stmt->bindparam(":uid", $user_id);
					$stmt->execute();
					echo "<script type='text/javascript'>alert('Password successfully changed.');</script>";
				}
				else
				{
					echo "<script type='text/javascript'>alert('Current password invalid.');</script>";
				}
			}

		}catch(PDOException $e)
		{
			$_SESSION['request_error'] = $e;
		}
	}
}

?>

	<!--	$stmt = $this->conn->prepare("INSERT INTO users(user_name,email,user_pass,phone_num)
		                                               VALUES(:uname, :umail, :upass, :phone_num)");
-->
