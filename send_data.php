<?php
	include("config.php");
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	if(isset($_POST['user']) && isset($_POST['comment']) ){
		$username = test_input($_POST['user']);
		$comment = test_input($_POST['comment']);
		mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
							   values('$username','$comment', sysdate())")
		or die("MySQL error:" . $conn->error);
	}
	if(isset($_POST['delete'])) {
		$sql = "DELETE FROM pratsep_shoutbox WHERE id='".$_POST['delete']."'";
		mysqli_query($conn, $sql);
	}
	mysqli_close($conn);
	header('Location: index.php');
	exit();
?>
