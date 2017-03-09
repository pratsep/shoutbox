<?php
    session_start();
    include("config.php");
    if(!isset($_SESSION['login_user'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $myusername = mysqli_real_escape_string($conn, $_POST['userID']);
            $mypassword = mysqli_real_escape_string($conn, $_POST['userPW']);

            $sql = "SELECT id FROM pratsep_users WHERE username = '$myusername' and password = '$mypassword'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            //Kui ridade arv on 1 siis järelikult on see user ja pw kombinatsioon olemas
            if ($count == 1) {
                $_SESSION['login_user'] = $myusername;
                header('Location: index.php');
                exit();
            } else {
                header('Location: http://enos.itcollege.ee/~pratsep/index.php?wronglogin=1');
            }
        }
    }