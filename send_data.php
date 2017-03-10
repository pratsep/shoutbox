<?php
	session_start();
	include("config.php");
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	if(isset($_POST['user']) && isset($_POST['comment']) ){
        $sql1 = mysqli_query($conn, "SELECT * FROM pratsep_users WHERE username = '$_POST[user]'");
        $count = mysqli_num_rows($sql1);
        if($count < 1 ) {
			$username = test_input($_POST['user']);
			$comment = test_input($_POST['comment']);
			mysqli_query($conn, "insert into pratsep_shoutbox(username, comment, time)
							   values('$username','$comment', sysdate())")
			or die("MySQL error:" . $conn->error);
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
