<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <script src="jubinad.js"></script>
    <title>MEGA SHOUTBOX</title>
    <!--<meta http-equiv="refresh" content="5">-->
</head>
<body>
    <?php
        $servername = "localhost";
        $username = "test";
        $password = "t3st3r123";
        $dbname = "test";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Ei saanud ühendada: ".$conn->connect_error);
        }
    ?>
    <!--
    <div class="pgHeader"></div>
    <div id="pgLeft"></div>
    <div id="pgRight"></div>
    -->
    <div class="pgBody">
        <div class="input">
            <div style="color: red; width: 300px; auto; position: relative; left: 350px; top: 100px">SHIFT+ENTER VAHETAB RIDA OKEI?</div>
            <form method="post" action="send_data.php" id="insert_form" onsubmit="return checkForm(this);">
                <input type="text" name="user" placeholder="Sisesta kasutaja" required/>
                <textarea name="comment" form="insert_form" placeholder="Sisesta tekst" onkeydown="pressed(event)" required></textarea>
                <input id="submit_button" type="submit" value="Postita"/>
            </form>
        </div>

        <div class="pages">
            <?php
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
            echo '<script>active_button("pg'.$currentpage.'")</script>'
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
                        echo "<form action='send_data.php' method='post' name='deleteCmt'>";
                        echo "<input type='hidden' name='delete' value=".$row['id']." />";
                        echo "<input type='submit' value='Kustuta'/></form>";
                        //echo "User: " . $row["username"]. " - Comment: " . $row["comment"]. " " . $row["time"]. "<br>";
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
