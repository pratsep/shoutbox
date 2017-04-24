<?php
include("config.php");
function login(){
    require_once("log_in.php");
    if(!isset($_SESSION['login_user'])) {
        global $conn;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $myusername = mysqli_real_escape_string($conn, $_POST['userID']);
            $mypassword = mysqli_real_escape_string($conn, $_POST['userPW']);

            $sql = "SELECT id, username FROM pratsep_users WHERE username = '$myusername' and password = '$mypassword'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);

            //Kui ridade arv on 1 siis järelikult on see user ja pw kombinatsioon olemas
            if ($count == 1) {
                $_SESSION['login_user'] = $row['username'];
                header('Location: index.php');
                exit();
            } else {
                echo 'Wrong username or password';
                exit();
            }
        }
    }
}
function logout(){
    if(isset($_SESSION['login_user'])) {
        session_unset();
        session_destroy();
        $_SESSION = array();
        header("Location: index.php");
        die;
    }
}
function gallery(){
    $directory = "images/";
    $files = glob($directory . "*");
    include_once("gallery_page.php");
}
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
function register(){
    include_once ("register_user.php");
    if(isset($_POST['newUser']) && isset($_POST['newPw'])) {
        SignUp();
    }
}
