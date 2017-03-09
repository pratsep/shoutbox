<?php
    session_start();
    if(isset($_SESSION['login_user'])) {
        session_unset();
        session_destroy();
        $_SESSION = array();
        header("Location: index.php");
        die;
    }
?>