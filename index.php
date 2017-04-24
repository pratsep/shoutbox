<?php require_once("page_head.html"); ?>


<?php
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
        include("register_user.php");
        break;
    case "gallery":
        include("gallery_page.php");

        break;

    default:
        include("user_input.php");
        include("posts.php");
        break;
}
?>

<?php require_once("page_foot.html"); ?>
