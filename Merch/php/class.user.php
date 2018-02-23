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
	public function addProduct($user,$title,$category,$price,$quality,$description)
	{
		echo "user ==\n";
		echo $user ;
		$stmt = $this->conn->prepare("INSERT into sell_product(seller_id,title,quality,category,price,description)
																	VALUES(:seller_id,:title,:quality,:category,:price,:description)");

		$stmt->bindparam(":seller_id",$user);
		$stmt->bindparam(":title",$title);
		$stmt->bindparam(":quality",$quality);
		$stmt->bindparam(":category",$category);
		$stmt->bindparam(":description",$description);
		$stmt->bindparam(":price",$price);
		$stmt->execute();

		$stmt = $this->conn->prepare("SELECT product_id FROM sell_product WHERE seller_id =:seller_id AND description = :description ");
		$stmt->execute(array(':seller_id'=>$user, ':description'=>$description));
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if(isset($_SESSION['product_id'])){
			unset($_SESSION['product_id']);}
		$_SESSION['product_id'] = $userRow['product_id'];
		return $stmt;
	}
	public function addAppliance(){}
	public function addBook($edition,$subject,$author,$product_id)
	{
		try{
			$stmt = $this->conn->prepare("INSERT into book(edition,subject,author,product_id)
																		VALUES(:edition,:subject,:author,:product_id)");
			$edition = (int)$edition;
			$product_id =(int)$product_id;
			$stmt->bindparam(":edition", $edition);
			$stmt->bindparam(":subject", $subject);
			$stmt->bindparam(":author", $author);
			$stmt->bindparam(":product_id", $product_id);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			print_r($e);
		}
	}
	public function addClothe(){}
	public function addHashtag(){}

}
?>

	<!--	$stmt = $this->conn->prepare("INSERT INTO users(user_name,email,user_pass,phone_num)
		                                               VALUES(:uname, :umail, :upass, :phone_num)");
-->
