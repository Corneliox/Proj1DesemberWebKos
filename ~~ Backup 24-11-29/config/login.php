<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once 'connection.php';
		require_once 'helper.php';

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
				if($data['email_verified_at'] != NULL){
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
						header('location: ../');
					}else{
						$_SESSION['info'] = '<strong>Informasi!</strong> Akun Anda belum Dikonfirmasi oleh Admin.';
						header('location: ../login');
					}
				}else{
					$_SESSION['info'] = '<strong>Informasi!</strong> Email Anda belum Diverifikasi, Silahkan Cek Email.';
					header('location: ../login');
				}
			}else{
				$_SESSION['warning'] = '<strong>Peringatan!</strong> Password yang Anda Masukkan Salah.';
				header('location: ../login');
			}
		}else{
			$_SESSION['warning'] = '<strong>Peringatan!</strong> Email yang Anda Masukkan Salah.';
			header('location: ../login');
		}
		$stmt->close();
		$mysqli->close();
	/* }else{
		echo '<script>window.history.back();</script>';
	} */
?>