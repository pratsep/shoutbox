<?php
	$servername = "localhost";
	$username = "test";
	$password = "t3st3r123";
	$dbname = "test";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Ei saanud ühendada: ".$conn->connect_error);
	}
	if(isset($_POST['user']) && isset($_POST['comment']) ){
		$username = $_POST['user'];
		$comment = $_POST['comment'];
		mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
												 values('$username','$comment', sysdate())")
												 or die("MySQL error:" . $conn->error);
	}
	mysqli_close($conn);
	header('Location: index.php');
	exit();
?>
