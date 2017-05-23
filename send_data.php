<?php
session_start();
include("functions.php");
configDB();
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
    $errors = array();
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
    $extensions = array("jpeg", "jpg", "png");
    $file_size = $_FILES['image']['size'];
    if (getimagesize($_FILES["image"]["tmp_name"]) == false) {
        $_SESSION['errors'] = "This file is not an image, please upload images only";
    }
    if (in_array($file_ext, $extensions) === false) {
        $_SESSION['errors'] = "Extension not allowed, please choose a JPEG or PNG file";
    }
    if ($file_size > 2097152) {
        $_SESSION['errors'] = 'File size must be less than 2 MB';
    }
}

function add_picture($rowid){
    if (isset($_FILES['image'])) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
        if (empty($_SESSION['errors'])) {
            move_uploaded_file($file_tmp, "images/" . $rowid . '.' . $file_ext);
        }
    }
}
$isUser = 0;
if (empty($_SESSION['errors'])) {
    if (isset($_POST['user']) && isset($_POST['comment'])) {
        $sql1 = mysqli_query($conn, "SELECT * FROM pratsep_users WHERE username = '$_POST[user]'");
        $count = mysqli_num_rows($sql1);
        if ($count < 1) {
            $username = test_input($_POST['user']);
            $comment = test_input($_POST['comment']);
            mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
                                   values('$username','$comment', sysdate())")
            or die("MySQL error:" . $conn->error);
            $last_id = $conn->insert_id; //saame viimati sisestatud id
            add_picture($last_id);
        } else {
            $isUser = 1;
        }
    }
    if (isset($_SESSION['login_user']) && isset($_POST['comment'])) {
        $username = test_input($_SESSION['login_user']);
        $comment = test_input($_POST['comment']);
        mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
                                       values('$username','$comment', sysdate())")
        or die("MySQL error:" . $conn->error);
        $last_id = $conn->insert_id; //saame viimati sisestatud id
        add_picture($last_id);
    }
    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM pratsep_shoutbox WHERE id='" . $_POST['delete'] . "'";
        mysqli_query($conn, $sql);
    }
    mysqli_close($conn);
}
if ($isUser == 1) {
    header("Location: http://enos.itcollege.ee/~pratsep/index.php?notUser=1");
}
else {
    header('Location: index.php');
}
exit();
?>