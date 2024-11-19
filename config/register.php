<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once 'connection.php';
		require_once 'helper.php';

		$name = remove_slashes($_POST['name']);
		$email = remove_slashes($_POST['email']);
		$alamat = remove_slashes($_POST['alamat']);

		$name = validasi_data(ucwords($name));
		$tgl_lahir = $_POST['tgl_lahir'];
		$nik = $_POST['nik'];
		$email = validasi_data(strtolower($email));
		$password = $mysqli->real_escape_string($_POST['password']);
		$confirmation = $mysqli->real_escape_string($_POST['confirmation']);
		$alamat = validasi_data(ucwords($alamat));
		$telepon = $_POST['telepon'];
		$jurusan = $_POST['jurusan'];
		$tahun_lulus = $_POST['tahun_lulus'];
		$role = 'user';
		$photo = 'user.png';
		$status = 0;

		$token = md5($email).rand(10,9999);
		$link = "<a href='localhost/bursakerja/verify_email.php?key={$email}&token={$token}'>Click and Verify Email</a>";

		$sql = "SELECT * FROM users WHERE email = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		if($result->num_rows == 0){
			if($password != $confirmation){
				$_SESSION['warning'] = '<strong>Peringatan!</strong> Konfirmasi Password Tidak Sesuai.';
				header('location: ../register');
				exit();
			}else{
				include 'classes/class.phpmailer.php';
				include 'classes/class.smtp.php';
				$mail = new PHPMailer();

				//Server settings
				$mail->CharSet = 'utf-8';
				$mail->Mailer = 'smtp';
				$mail->IsSMTP();
				$mail->SMTPDebug = 2;
				$mail->Port = 465;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPAuth = true;
				$mail->Host = 'smtp.gmail.com';
				$mail->Username = 'basecamppp159@gmail.com';
				$mail->Password = 'nldcdvhruietqtvk';
				//Recipients
				$mail->setFrom('basecamppp159@gmail.com', 'BKK Tracer Study');
				$mail->addAddress($email, $name);
				//Content
				$mail->IsHTML(true);
				$mail->Subject = 'Email Verification';
				$mail->Body = "Click On This Link to Verify Email {$link}";

				if($mail->Send()){
					$password = password_hash($password, PASSWORD_DEFAULT);
					$sql = "INSERT INTO users (name, email, password, role, photo, status, email_verification_link) VALUES (?, ?, ?, ?, ?, ?, ?)";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('sssssis', $name, $email, $password, $role, $photo, $status, $token);
					$stmt->execute();
					$register = $stmt->affected_rows;

					if($stmt->errno){
						$_SESSION['warning'] = '<strong>Peringatan!</strong> Email yang Dipilih Sudah Terpakai. Silahkan Login atau Cek Email untuk Verifikasi.';
						header('location: ../register');
						exit();
					}
					$stmt->close();

					$sql = "INSERT INTO tb_alumni (nama, tgl_lahir, nik, email, alamat, telepon, jurusan, tahun_lulus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('ssssssss', $name, $tgl_lahir, $nik, $email, $alamat, $telepon, $jurusan, $tahun_lulus);
					$stmt->execute();
				}else{
					$_SESSION['warning'] = "<strong>Peringatan!</strong> {$mail->ErrorInfo}";
					header('location: ../register');
					exit();
				}
			}

			if($register > 0){
				$_SESSION['success'] = '<strong>Sukses!</strong> Registrasi Akun Berhasil. Silahkan Cek Email untuk Verifikasi.';
				header('location: ../register');
			}else{
				$_SESSION['warning'] = '<strong>Error!</strong> Registrasi Akun Gagal.';
				header('location: ../register');
			}
			$stmt->close();
			$mysqli->close();
		}else{
			$_SESSION['warning'] = '<strong>Peringatan!</strong> Email yang Dipilih Sudah Terpakai. Silahkan Login atau Cek Email untuk Verifikasi.';
			header('location: ../register');
		}
		$mysqli->close();
	/* }else{
		echo '<script>window.history.back();</script>';
	} */
?>