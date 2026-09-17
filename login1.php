

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{
        background-image: url("pic2.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 1366px;
        font-family: Arial, sans-serif;
    } 
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Username:</label>
            <input type="text" name="user_name" value="<?php echo htmlspecialchars($user_name ?? ''); ?>" required><br>

            <label>Password:</label>
            <input type="password" name="pass_word"><br>

            <input type="submit" name="submit" value="Login"><br>
            <p>
            Don't have an account? <a href="registration.php">create an account.</a>
           </p>
         
        </form>

        <?php
    
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cwmsdb";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

// Add this PHP code below the HTML code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Your existing PHP login code goes here

  
        $ad_email=$_POST['user_name'];
        $ad_pwd=$_POST['pass_word'];//double encrypt to increase security
        $stmt=$conn->prepare("SELECT user_name ,pass_word,id  FROM users WHERE user_name=? AND pass_word=? ");//sql to log in user
        $stmt->bind_param('ss',$ad_email,$ad_pwd);//bind fetched parameters
        $stmt->execute();//execute bind
        $stmt -> bind_result($ad_email,$ad_pwd,$id);//bind result
        $rs=$stmt->fetch();
        $_SESSION['id']=$id;//Assign session to admin 
        //$uip=$_SERVER['REMOTE_ADDR'];
        //$ldate=date('d/m/Y h:i:s', time());
        if($rs)
            {//if its sucessfull
                header("location:index.php");
            }

        else
            {
            echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
                $err = "Access Denied Please Check Your Credentials";
            }
    }

   
?>

    </div>

</body>
</html>
