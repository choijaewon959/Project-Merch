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
		$stmt = $this->$conn->prepare("INSERT into sell_product()");
	}
}
?>

	<!--	$stmt = $this->conn->prepare("INSERT INTO users(user_name,email,user_pass,phone_num)
		                                               VALUES(:uname, :umail, :upass, :phone_num)");
-->
