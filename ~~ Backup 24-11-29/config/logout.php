<?php
	session_start();
	/* $_SESSION = [];
	session_unset();
	session_destroy(); */
	unset($_SESSION['is_admin']);
	unset($_SESSION['id']);
	unset($_SESSION['name']);
	unset($_SESSION['email']);
	unset($_SESSION['role']);
	unset($_SESSION['photo']);

	setcookie('id_admin', '', time()-2592000, '/');
	setcookie('key_admin', '', time()-2592000, '/');

	// header('location: ../login.php#logout');
	echo '<script type="text/javascript">
		sessionStorage.setItem("message", "logout");
		window.location.replace("../login");
	</script>';
	exit();
?>