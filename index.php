<?php
session_start();
include("functions.php");
include("page_head.html");

if(!empty($_GET) && isset($_GET['navigate'])){
    $navigate = htmlspecialchars($_GET['navigate']);
}
else{
    $navigate = "posts";
}
switch($navigate){
    case "posts":
        include("user_input.php");
        include("posts.php");
        break;
    case "register":
        register();
        break;
    case "gallery":
        gallery();
        break;
    case "logout":
        logout();
        break;
    case "login":
        login();
        break;
    default:
        include("user_input.php");
        include("posts.php");
        break;
}
?>

<?php require_once("page_foot.html"); ?>
