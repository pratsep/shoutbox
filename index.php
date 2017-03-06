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
    <div>
		<form method="post" action="send_data.php" id="insert_form" onsubmit="return checkForm(this);">
			<input type="text" name="user" placeholder="Sisesta kasutaja" required/>
      <textarea name="comment" form="insert_form" placeholder="Sisesta tekst" onkeydown="pressed(event)" required></textarea>
      <input id="submit_button" type="submit" value="Postita"/>
		</form>
   </div>
    <div class="comments">
		<?php
      $sql = "SELECT username, comment, time FROM pratsep_shoutbox order by time desc";
      $result = mysqli_query($conn, $sql);
      $pages = ceil(mysqli_num_rows($result))/10;
      //tere
      echo '<div class="pages">';
      if ($pages>1 && isset($_GET['page']) && $_GET['page']>1) {
        $pagenr1 = $_GET['page'] - 1;
        $addr1 = "window.location.href='?page=$pagenr1'";
        echo '<button onclick="'.$addr1.'">Previous</button>';
      }
      if ($pages > 1) {
        for ($i=$_GET['page']; $i < $_GET['page'] + 10; $i++) {
          $addr = "window.location.href='?page=$i'";
          echo '<button onclick="'.$addr.'">'.$i.'</button>';
        }
      }
      if ($pages>1 && isset($_GET['page']) && $_GET['page']<$pages) {
        $pagenr2 = $_GET['page'] + 1;
        $addr2 = "window.location.href='?page=$pagenr2'";
        echo '<button onclick="'.$addr2.'">Next</button>';
      }
      echo '</div>';
      if (isset($_GET['page']) && $_GET['page']>1) {
        $ofset = (($_GET['page'])*10) - 10;
      }
      else{
        $ofset = 0;
      }
  		$sql = "SELECT username, comment, time FROM pratsep_shoutbox order by time desc LIMIT 10 OFFSET $ofset";
  		$result = mysqli_query($conn, $sql);
  		if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
    			echo '<div class ="comment">';
    			echo '<h1>'.$row["username"].'</h1>';
    			echo '<h3>'.$row["time"].'</h3>';
    			echo '<p>'.$row["comment"].'</p>';
    			//echo "User: " . $row["username"]. " - Comment: " . $row["comment"]. " " . $row["time"]. "<br>";
    			echo '</div>';
        }
  	  }
  		else {
  			echo "<h2>MEIE KARJUMISALA ON VEEEEL TÜHI!</h2>";
  		}
		?>
    </div>
    <?php
    		mysqli_close($conn);
    ?>
</body>
</html>
