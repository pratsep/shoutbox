<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="styles2.css">
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
		<form method="post" action="send_data.php" id="insert_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="text" name="user" placeholder="Sisesta kasutaja" required/><br/>
		</form>
    <textarea name="comment" form="insert_form" placeholder="Sisesta tekst" required></textarea><br/>
    <button id="submit_button" type="submit" form="insert_form">Sisesta</button>
    <?php
      $sql = "SELECT username, comment, time FROM pratsep_shoutbox order by time desc";
      $result = mysqli_query($conn, $sql);
      $pages = ceil(mysqli_num_rows($result))/10;
      if ($pages > 1) {
        echo '<div class="pages">';
        for ($i=1; $i < $pages + 1; $i++) {
          $addr = "window.location.href='?page=$i'";
          echo '<button onclick="'.$addr.'">'.$i.'</button>';
        }
        echo '</div>';
      }

    ?>
   </div>
    <div class="comments">
		<?php
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
