<?php
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once 'connection.php';
		require_once 'helper.php';

		switch($_GET['auth']){
			case 'login' :
				if(isset($_POST['email']) && isset($_POST['password'])){
					$email = validasi_data(strtolower($_POST['email']));
					$password = $mysqli->real_escape_string($_POST['password']);

					$sql = "SELECT * FROM users WHERE email = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$result = $stmt->get_result();

					if($result->num_rows > 0){
						$data = $result->fetch_assoc();

						if(password_verify($password, $data['password'])){
							if($data['status'] == 1){
								$_SESSION['is_admin'] = true;
								$_SESSION['id'] = $data['id'];
								$_SESSION['name'] = $data['name'];
								$_SESSION['email'] = $data['email'];
								$_SESSION['role'] = $data['role'];
								$_SESSION['photo'] = $data['photo'];

								if(isset($_POST['remember'])){
									/* setcookie('id_admin', $data['id'], time()+2592000, '/; SameSite=None; Secure');
									setcookie('key_admin', hash('sha256', $data['email']), time()+2592000, '/; SameSite=None; Secure'); */
									$cookie_options = array(
										//'domain' => 'localhost',
										'path' => '/',
										'expires' => time()+2592000,
										'httponly' => false,
										'secure' => true,
										'samesite' => 'None'
									);
									setcookie('id_admin', $data['id'], $cookie_options);
									setcookie('key_admin', hash('sha256', $data['email']), $cookie_options);
								}
								echo 'success';
							}else{
								echo 'status';
							}
						}else{
							echo 'password';
						}
					}else{
						echo 'email';
					}
					$stmt->close();
					$mysqli->close();
				}
			break;

			case 'logout' :
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

				/* header('location: ../login.php#logout');
				echo '<script type="text/javascript">
					sessionStorage.setItem("message", "logout");
					window.location.replace("../login.php");
				</script>';
				exit(); */
				echo 'success';
			break;

			case 'register' :

			break;

			case 'password' :

			break;
		}
	}else{
		echo '<script>window.history.back();</script>';
	}
?>