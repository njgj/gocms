<?php
        session_start();
		session_destroy();
		echo "<script>top.location.href='login.php';</script>";
		exit();
?>