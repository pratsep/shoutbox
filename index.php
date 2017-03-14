<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <script src="jubinad.js"></script>
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <title>MEGA SHOUTBOX</title>
    <!--<meta http-equiv="refresh" content="5">-->
</head>
<body>
    <?php
        session_start();
        include("config.php");
    ?>
    <!--
    <div class="pgHeader"></div>
    <div id="pgLeft"></div>
    <div id="pgRight"></div>
    -->
    <div class="pgBody">

        <?php
            if(!isset($_SESSION['login_user'])) {
                echo '<form method="POST" action="register_user.php">';
                echo '<input id="registerBtn" type="submit" value="Register" formtarget="_blank"/>';
                echo '</form>';
            }
            if (isset($_SESSION['login_user'])) {
                echo "Logged in as: " . $_SESSION["login_user"];
                echo '<form method="POST" action="log_out.php">';
                echo '<button type="submit">Log out</button>';
                echo '</form>';
                //tere
            }
            else{
                echo "Not logged in";
                echo '<div class="logInOut">';
                echo '<form method="post" action="log_in.php" id="login_form">';
                echo '<input type="text" name="userID" placeholder="Username" required/>';
                echo '<input type="text" name="userPW" placeholder="Password" required/>';
                echo '<input id="login_button" type="submit" value="Log in"/>';
                echo '</form>';
                if (isset($_GET['wronglogin'])) {
                    if ($_GET['wronglogin'] == 1) {
                        echo 'Invalid username or password';
                    }
                }
                echo '</div>';
            }
            echo '<div class="input">';
            echo '    <div style="color: red; width: 300px; auto; position: relative; left: 350px; top: 100px">SHIFT+ENTER VAHETAB RIDA OKEI?</div>';
                if (isset($_SESSION['login_user'])){
                    echo '    <form method="post" action="send_data.php" id="insert_form" onsubmit="return checkFormNoUser(this);">';
                }
                else {
                    echo '    <form method="post" action="send_data.php" id="insert_form" onsubmit="return checkForm(this);">';
                }
                if (!isset($_SESSION['login_user'])){
                    echo '<input type="text" name="user" placeholder="Sisesta kasutaja" required/>';
                }
            echo '        <textarea id="txtArea" name="comment" form="insert_form" placeholder="Sisesta tekst" onkeydown="pressed(event)" required></textarea>';
            echo '        <input id="submit_button" type="submit" value="Post"/>';
            echo '    </form>';
            echo '</div>';
        ?>

        <div class="pages">
            <?php
                if (isset($_GET['notUser'])) {
                    if ($_GET['notUser'] == 1) {
                        echo 'Username you are trying to use is already registered as a user</br>';
                        echo 'Choose another username</br>';
                    }
                }
                $sql = "SELECT username, comment, time FROM pratsep_shoutbox order by time desc";
                $result = mysqli_query($conn, $sql);
                $pages = ceil(mysqli_num_rows($result))/10;
                if (!isset($_GET['page'])) {
                  $currentpage=1;
                }
                else {
                  $currentpage=$_GET['page'];
                }
                //previous
                if ($pages>1 && isset($_GET['page']) && $currentpage>1) {
                  $pagenr1 = $_GET['page'] - 1;
                  $addr1 = "window.location.href='?page=$pagenr1'";
                  echo '<button class="pnBtn" id="prBtn" onclick="'.$addr1.'">Previous page</button>';
                }
                //next
                if ($pages>1 && $currentpage<$pages) {
                  $pagenr2 = $currentpage + 1;
                  $addr2 = "window.location.href='?page=$pagenr2'";
                  echo '<button class="pnBtn" id="ntBtn" onclick="'.$addr2.'">Next page</button>';
                }
                //page buttons
                if ($pages > 1) {
                  if ($currentpage-4<1) {
                    $underpage = abs($currentpage-5);
                  }
                  else {
                    $underpage = 0;
                  }
                  if ($currentpage+4>$pages) {
                    $overpage = $currentpage+4-$pages;
                  }
                  else {
                    $overpage = 0;
                  }
                  for ($i=$currentpage-4+$underpage; $i < $currentpage+5-$overpage; $i++) {
                    $addr = "window.location.href='?page=$i'";
                    echo '<button class="nrBtn" id="pg'.$i.'" onclick="'.$addr.'">'.$i.'</button>';
                    //id="page'.$i.'"
                  }
                }
            ?>
        </div>
        <?php
            echo '<script>active_button("pg'.$currentpage.'")</script>';
        ?>
        <div class="comments">
            <?php
                if (isset($_GET['page']) && $_GET['page']>1) {
                    $ofset = (($_GET['page'])*10) - 10;
                }
                else{
                    $ofset = 0;
                }
                $sql = "SELECT id, username, comment, time FROM pratsep_shoutbox order by time desc LIMIT 10 OFFSET $ofset";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = $result->fetch_assoc()) {
                        $date = new DateTime($row["time"]);
                        $newDate = $date->format('H:i:s d-m-Y');
                        echo '<div class ="comment">';
                        echo '<h1>'.$row["username"].'</h1>';
                        echo '<pre>'.$row["comment"].'</pre>';
                        echo '<p class="dTime">'.$newDate.'</p>';
                        if (isset($_SESSION['login_user'])){
                            if (strcasecmp($row['username'], $_SESSION['login_user']) == 0 || $_SESSION['login_user'] == "admin") {
                                echo "<form action='send_data.php' method='post' name='deleteCmt'>";
                                echo "<input type='hidden' name='delete' value=".$row['id']." />";
                                echo "<input type='submit' value='Delete post'/></form>";
                            }
                        }
                        echo '</div>';
                    }
                }
                else {
                    echo "<h2>Ühtegi sõnumit pole!</h2>";
                }
            ?>
        </div>
    </div>
    <?php
        mysqli_close($conn);
    ?>
</body>
</html>
