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
		$stmt = $this->conn->prepare("INSERT into sell_product(seller_id,title,quality,category,price,description)
																	VALUES(:seller_id,:title,:quality,:category,:price,:description)");
		if($_SESSION['product_category'] == 1){$p_category = "book";}
		else if($_SESSION['product_category'] == 2){$p_category = "clothe";}
		else if($_SESSION['product_category'] == 3){$p_category = "appliance";}
		else if($_SESSION['product_category'] == 4){$p_category = "etc";}

		$stmt->bindparam(":seller_id",$_SESSION['user_session']);
		$stmt->bindparam(":title",$_SESSION['product_title']);
		$stmt->bindparam(":quality",$_SESSION['product_quality']);
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
	public function addAppliance()
	{
		$stmt = $this->conn->prepare("INSERT into appliance(brand,product_id)
																	VALUES(:brand,:product_id)");

		$stmt->bindparam(":product_id", $_SESSION['product_id']);
		$stmt->bindparam(":brand", $_SESSION['appliance_brand']);
		$stmt->execute();
		return $stmt;

	}
	public function addBook()
	{
		try{
			$stmt = $this->conn->prepare("INSERT into book(edition,subject,author,product_id)
																		VALUES(:edition,:subject,:author,:product_id)");
			$stmt->bindparam(":edition", $_SESSION['book_edition']);
			$stmt->bindparam(":subject", $_SESSION['book_subject']);
			$stmt->bindparam(":author", $_SESSION['book_author']);
			$stmt->bindparam(":product_id", $_SESSION['product_id']);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			print_r($e);
		}
	}
	public function addClothe()
	{
		$clothe_char ;
		$stmt = $this->conn->prepare("INSERT into clothe(size_char,size_num,product_id)
																	VALUES(:size_char,:size_num,:product_id)");
		if($_SESSION['clothe_size_char'] == 0){$clothe_char = "XS";}
		else if($_SESSION['clothe_size_char'] == 1){$clothe_char = "S";}
		else if($_SESSION['clothe_size_char'] == 2){$clothe_char = "M";}
		else if($_SESSION['clothe_size_char'] == 3){$clothe_char = "L";}
		else if($_SESSION['clothe_size_char'] == 4){$clothe_char = "XL";}
		else if($_SESSION['clothe_size_char'] == 5){$clothe_char = "XXL";}

		$stmt->bindparam(":size_char", $clothe_char);
		$stmt->bindparam(":size_num", $_SESSION['clothe_size_num']);
		$stmt->bindparam(":product_id", $_SESSION['product_id']);

		$stmt->execute();
		return $stmt;


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

}
?>

	<!--	$stmt = $this->conn->prepare("INSERT INTO users(user_name,email,user_pass,phone_num)
		                                               VALUES(:uname, :umail, :upass, :phone_num)");
-->
