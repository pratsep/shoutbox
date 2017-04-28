<?php
function configDB(){
    global $conn;
    $servername = "localhost";
    $username = "test";
    $password = "t3st3r123";
    $dbname = "test";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ei saanud ühendada: ".$conn->connect_error);
    }
}
function update_pw(){
    global $conn;
    $select_query = "SELECT * FROM pratsep_users WHERE id<28";
    $result = mysqli_query($conn, $select_query);
    while($row = mysqli_fetch_assoc($result)){
        $update_query = "UPDATE pratsep_users SET password = SHA1('{$row['password']}') WHERE id = {$row['id']}";
        mysqli_query($conn, $update_query);
    }

}
function login(){
    require_once("log_in.php");
    if(!isset($_SESSION['login_user'])) {
        global $conn;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $myusername = mysqli_real_escape_string($conn, $_POST['userID']);
            $mypassword = mysqli_real_escape_string($conn, $_POST['userPW']);

            $sql = "SELECT id, username FROM pratsep_users WHERE username = '$myusername' and password = SHA1('$mypassword')";
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
function search_user(){
    include('userposts_page.html');
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['search'])) {
            global $conn;
            $searched_username = mysqli_real_escape_string($conn, $_POST['search']);
            $sql = "SELECT id, username, comment, time FROM pratsep_shoutbox WHERE username = '$searched_username' order by time desc";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $date = new DateTime($row["time"]);
                    $newDate = $date->format('H:i:s d-m-Y');
                    echo '<div class ="comment">';
                    echo '<h1>' . $row["username"] . '</h1>';
                    echo '<pre>' . $row["comment"] . '</pre>';
                    echo '<p class="dTime">' . $newDate . '</p>';
                    $directory = "images/";
                    $files = glob($directory . "*");
                    foreach ($files as $key => $oneFile) {
                        $array1 = explode("/", $oneFile);
                        $array2 = explode(".", $array1[1]);
                        $id = $array2[0];
                        if ($id == $row['id']) {
                            echo '<img src="' . $files[$key] . '" width="200" height="200" class="pic"/>';
                        }
                    }
                    echo '</div>';
                }
            } else {
                echo "<h2>Ühtegi sõnumit pole!</h2>";
            }
        }
    }

}
function user_data(){
    global $conn;
    $posts = array();
    $sql = "SELECT username FROM pratsep_users";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $count2 = $count - 1;
    $sql2 = "SELECT username FROM pratsep_users LIMIT 1 OFFSET ".$count2;
    $result2 = mysqli_query($conn, $sql2);
    $lastuser = mysqli_fetch_assoc($result2);
    while($row2 = mysqli_fetch_assoc($result)){
        $sql3 = "SELECT * FROM pratsep_shoutbox WHERE username = '".$row2['username']."'";
        $result3 = mysqli_query($conn, $sql3);
        $posts[$row2['username']] = mysqli_num_rows($result3);
    }
    include_once("userdata_page.html");
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
							                        values('$username', SHA1('$password'))")
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
