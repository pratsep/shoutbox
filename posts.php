
<?php
if(!isset($_SESSION))
{
    session_start();
}
$servername = "localhost";
$username = "test";
$password = "t3st3r123";
$dbname = "test";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ei saanud ühendada: ".$conn->connect_error);
}


//echo '<div class="comments">';

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
        echo '<h1>'.htmlspecialchars($row["username"]).'</h1>';
        echo '<pre>'.htmlspecialchars($row["comment"]).'</pre>';
        echo '<p class="dTime">'.htmlspecialchars($newDate).'</p>';
        $directory = "images/";
        $files = glob($directory . "*");
        foreach ($files as $key => $oneFile) {
            $array1 = explode("/",$oneFile);
            $array2 = explode(".",$array1[1]);
            $id = $array2[0];
            if ($id == $row['id']){
                echo '<img src="'.$files[$key].'" width="200" height="200" class="pic" alt="small picture"/>';
            }
        }
        if (isset($_SESSION['login_user'])){
            if (strcasecmp($row['username'], $_SESSION['login_user']) == 0 || $_SESSION['login_user'] == "admin") {
                echo "<form action='send_data.php' method='post' name='deleteCmt'>";
                echo "<input type='hidden' name='delete' value=".htmlspecialchars($row['id'])." />";
                echo "<input type='submit' value='Delete post'/></form>";
            }
        }
        echo '</div>';
    }
}
else {
    echo "<h2>Ühtegi sõnumit pole!</h2>";
}
echo '</div>';


?>