<?php
class Database
{
    private $host = "localhost";
    private $db_name = "mydb";
    private $username = "root";
    private $password = "";
    public $conn;

    public function dbConnection()
	{

	    $this->conn = null;
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Welcome Home</title>
    <link rel="stylesheet" href="style.css" type="text/css"  />
    </head>
    <body>



    	<div id="main">

    								<h1><font color="green">Congratulation!</font></h1>

                   <p><b >Database Connected.</b></p>


    						<p><a href="logout.php?logout=true"  ><button class="button" >SIGN OUT</button</a></p>

            </div>

    </body>
    </html>';


        }








		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>
