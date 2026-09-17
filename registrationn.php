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

// Initialize variables
$id = $name = $user_name = $email = $pass_word = $confirm_pass_word = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $user_name = $_POST["user_name"];
    $email = $_POST["email"];
    $pass_word = $_POST["pass_word"];
    $confirm_pass_word = $_POST["confirm_pass_word"];

    // Validate form data
    if (empty($name)) {
        $errors[] = "<b>Kindly Know that;<b>";
    }
    if (empty($name)) {
        $errors[] = "<b>Name is required<b>";
    }

    if (empty($user_name)) {
        $errors[] = "Username is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    }

    if (empty($pass_word)) {
        $errors[] = "Password is required";
    }

    if ($pass_word != $confirm_pass_word) {
        $errors[] = "<b>Passwords do not match<b>";
    }

    // If no errors, proceed with registration
    if (count($errors) == 0) {
        // Hash the password
     

        // Prepare SQL statement
        $sql = "INSERT INTO users (name, user_name, email, pass_word) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bind_param("ssss", $name, $user_name, $email, $pass_word);
        if ($stmt->execute()) {
            header("Location: login1.php");
            
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body {
            background-image: url('pic2.jpg'); /* Change 'background_image.jpg' to your desired image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #registrationForm {
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Shadow effect */
            max-width: 400px;
            width: 100%;
        }

        #registrationForm label {
            display: block;
            margin-bottom: 5px;
        }

        #registrationForm input {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #registrationForm input[type="submit"] {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #registrationForm input[type="submit"]:hover {
            background-color: #45a049;
        }

        #registrationForm div {
            margin-top: 10px;
            background-color: #f2dede; /* Red background for error messages */
            color: #a94442; /* Text color for error messages */
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    
   
    <form method="post" id="registrationForm">
    <h2>Register</h2>
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" ><br><br>

        <label>Username:</label>
        <input type="text" name="user_name" value="<?php echo $user_name; ?>" ><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" ><br><br>

        <label>Password:</label>
        <input type="password" name="pass_word" ><br><br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_pass_word"><br><br>

        <input type="submit" name="submit" value="Register" onclick="redirectToLogin();"><br><br>
        <p>
            Already have an account? <a href="login1.php">Login.</a>
           </p>
    </form>
    
    <?php
    // Display validation errors
    if (count($errors) > 0) {
        echo "<div>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
    ?>

    <script>
        function redirectToLogin() {
            window.location.href = "login1.php";
        }
    </script>
</body>
</html>
