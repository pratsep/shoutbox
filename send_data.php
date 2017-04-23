<?php
session_start();
include("config.php");

function add_picture($rowid) {
    if (isset($_FILES['image'])) {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));


        $expensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $expensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }


        if ($file_size > 2097152) {
            $errors[] = 'File size must be less than 2 MB';
        }


        if (empty($errors) == true) {
            $directory = "images/";
            $filecount = 0;
            $files = glob($directory . "*");
            $filecount = count($files) + 1;

            move_uploaded_file($file_tmp, "images/" . $rowid . '.' . $file_ext);
            echo "Success";
        } else {
            print_r($errors);
        }
    }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$isUser = 0;
if(isset($_POST['user']) && isset($_POST['comment']) ){
    $sql1 = mysqli_query($conn, "SELECT * FROM pratsep_users WHERE username = '$_POST[user]'");
    $count = mysqli_num_rows($sql1);
    if($count < 1 ) {
        $username = test_input($_POST['user']);
        $comment = test_input($_POST['comment']);
        mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
							   values('$username','$comment', sysdate())")
        or die("MySQL error:" . $conn->error);
        $last_id = $conn->insert_id; //saame viimati sisestatud id
        add_picture($last_id);
    }
    else {
        $isUser = 1;
    }
}
if(isset($_SESSION['login_user']) && isset($_POST['comment']) ){
    $username = test_input($_SESSION['login_user']);
    $comment = test_input($_POST['comment']);
    mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
								   values('$username','$comment', sysdate())")
    or die("MySQL error:" . $conn->error);
    $last_id = $conn->insert_id; //saame viimati sisestatud id
    add_picture($last_id);
}
if(isset($_POST['delete'])) {
    $sql = "DELETE FROM pratsep_shoutbox WHERE id='".$_POST['delete']."'";
    mysqli_query($conn, $sql);
}
mysqli_close($conn);
if ($isUser == 1) {
    header("Location: http://enos.itcollege.ee/~pratsep/index.php?notUser=1");
}
else {
    header('Location: index.php');
}
exit();
?>