<?php
    if(isset($_SESSION['login_user'])) {
        session_destroy();
    }
    session_start();
    include("config.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form

        $myusername = mysqli_real_escape_string($conn,$_POST['userID']);
        $mypassword = mysqli_real_escape_string($conn,$_POST['userPW']);

        $sql = "SELECT id FROM pratsep_users WHERE username = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
            $_SESSION['login_user'] = $myusername;
            mysqli_close($conn);
            //header('Location: index.php');
            echo "Logged in as: " . $_SESSION["login_user"] . ".";
            exit();
        }else {
            mysqli_close($conn);
            //header('Location: index.php');
            echo '<script>error()</script>';

        }
    }
?>
