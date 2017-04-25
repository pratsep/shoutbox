<div class="input">
<?php
if (isset($_SESSION['login_user'])){
    echo '    <form method="post" action="send_data.php" enctype="multipart/form-data" id="insert_form" onsubmit="return checkFormNoUser(this);">';
}
else {
    echo '    <form method="post" action="send_data.php" enctype="multipart/form-data" id="insert_form" onsubmit="return checkForm(this);">';
}
if (!isset($_SESSION['login_user'])){
    echo '<input type="text" name="user" placeholder="Sisesta kasutaja" required/>';
}
echo '        <textarea id="txtArea" name="comment" form="insert_form" placeholder="Sisesta tekst" onkeydown="pressed(event)" required></textarea>';
?>
    <div class="sisestus">
        Lisa pilt</br>
        <input type="file" name="image"></br>
    </div>
    <input id="submit_button" type="submit" value="Post"/>
    </form>
</div>

    <div class="pages">
<?php
global $conn;
if (isset($_GET['notUser'])) {
    if ($_GET['notUser'] == 1) {
        echo 'Username you are trying to use is already registered as a user<br/>';
        echo 'Choose another username<br/>';
    }
}
$sql = "SELECT username, comment, time FROM pratsep_shoutbox order by time desc";
$result = mysqli_query($conn, $sql);
$pages = ceil(mysqli_num_rows($result)/10);
if (!isset($_GET['page'])) {
    $currentpage=1;
}
else {
    $currentpage=$_GET['page'];
}
//previous
echo '<div class="prvnxtButtons">';
if ($pages>1 && isset($_GET['page']) && $currentpage>1) {
    $pagenr1 = $_GET['page'] - 1;
    $addr1 = "window.location.href='?page=$pagenr1'";
    echo '<button id="previousButton" onclick="'.$addr1.'">Previous page</button>';
}
echo '</div>';
//page buttons
echo '<div id="pageButtons">';
if ($pages > 1 && $currentpage < 6) {
    if($pages-$currentpage>4){
        for ($i=1; $i < 10; $i++) {
            $addr = "window.location.href='?page=$i'";
            echo '<button class="numberButton" id="pg' . $i . '" onclick="' . $addr . '">' . $i . '</button>';
            //id="page'.$i.'"
        }
    }
}
else if($pages > 1 && $currentpage >= 6 && $currentpage + 3 < $pages) {
    for ($i=$currentpage-4; $i < $currentpage+5; $i++) {
        $addr = "window.location.href='?page=$i'";
        echo '<button class="numberButton" id="pg' . $i . '" onclick="' . $addr . '">' . $i . '</button>';
        //id="page'.$i.'"
    }
}
else {
    for ($i=$pages-8; $i < $pages+1; $i++) {
        $addr = "window.location.href='?page=$i'";
        echo '<button class="numberButton" id="pg' . $i . '" onclick="' . $addr . '">' . $i . '</button>';
        //id="page'.$i.'"
    }
}
echo '</div>';
//next
echo '<div class="prvnxtButtons">';
if ($pages>1 && $currentpage<$pages) {
    $pagenr2 = $currentpage + 1;
    $addr2 = "window.location.href='?page=$pagenr2'";
    echo '<button id="nextButton" onclick="'.$addr2.'">Next page</button>';
}
echo '</div>';
echo '</div>';
echo '<script>active_button("pg'.$currentpage.'")</script>';
?>