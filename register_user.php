<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <script src="jubinad.js"></script>
    <title>Register</title>
</head>
<body>
    <div class="registerForm">
        <form method="post" action="">
            <input type="text" name="newUser" placeholder="Username" pattern="[A-Za-z0-9_]{1,15}" title="Username should only contain letters, numbers and underscore and maximum 15 characters!" required/><br/>
            <input type="text" name="newPw" placeholder="Password" pattern="[A-Za-z0-9]{1,10}" title="Password should only contain lettersand numbers and maximum 10 characters" required/><br/>
            <input type="submit" value="Create user" required/>
        </form>
    </div>
</body>
</html>
<?php
    include("config.php");
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function NewUser() {
        global $conn;
        if(isset($_POST['newUser']) && isset($_POST['newPw']) ) {
            $username = test_input(mysqli_real_escape_string($conn, $_POST['newUser']));
            $password = test_input(mysqli_real_escape_string($conn, $_POST['newPw']));
            $sql = mysqli_query($conn, "insert into pratsep_users(username, password)
							                        values('$username','$password')")
            or die("MySQL error:" . $conn->error);
        }
        echo 'REGISTRATION COMPLETE!';
    }
    function SignUp() {
        global $conn;
        if(isset($_POST['newUser']) && isset($_POST['newPw'])) {
            $sql = mysqli_query($conn, "SELECT * FROM pratsep_users WHERE username = '$_POST[newUser]'");
            $count = mysqli_num_rows($sql);
            if($count < 1 ) {
                newuser();
            }
            else {
                echo 'USERNAME ALREADY IN USE!';
            }
        }
    }
    if(isset($_POST['newUser']) && isset($_POST['newPw'])) {
        SignUp();
    }
?>