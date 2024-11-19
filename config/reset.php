<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once 'connection.php';
		require_once 'helper.php';

		$email = validasi_data(strtolower($_POST['email']));
		$nik = $_POST['nik'];
		$password = $mysqli->real_escape_string($_POST['password']);
		$confirmation = $mysqli->real_escape_string($_POST['confirmation']);

		$sql = "SELECT * FROM tb_alumni WHERE email = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows > 0){
			$data = $result->fetch_assoc();

			if($data['nik'] == $nik){
				if($password == $confirmation){
					$password = password_hash($password, PASSWORD_DEFAULT);
					$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE email = ?");
					$stmt->bind_param('ss', $password, $email);
					$stmt->execute();
					$update = $stmt->affected_rows;

					if($update > 0){
						$_SESSION['success'] = '<strong>Sukses!</strong> Password Anda Berhasil Diubah.';
						header('location: ../login');
					}else{
						$_SESSION['warning'] = '<strong>Error!</strong> Password Anda Gagal Diubah.';
						header('location: ../forget_password');
					}
				}else{
					$_SESSION['warning'] = '<strong>Peringatan!</strong> Konfirmasi Password Tidak Sesuai.';
					header('location: ../forget_password');
				}
			}else{
				$_SESSION['warning'] = '<strong>Peringatan!</strong> NIK yang Anda Masukkan Tidak Sesuai.';
				header('location: ../forget_password');
			}
		}else{
			$_SESSION['warning'] = '<strong>Peringatan!</strong> Email yang Anda Masukkan Tidak Terdaftar.';
			header('location: ../forget_password');
		}
		$stmt->close();
		$mysqli->close();
	/* }else{
		echo '<script>window.history.back();</script>';
	} */
?>