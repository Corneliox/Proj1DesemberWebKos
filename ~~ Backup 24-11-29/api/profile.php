<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once '../config/connection.php';
		require_once '../config/helper.php';
		$api = 'Profil';

		switch($_SERVER['REQUEST_METHOD']){
			case 'GET' :
				if(isset($_GET['id'])){
					$id = $_GET['id'];

					$sql = "SELECT * FROM users WHERE id = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('i', $id);
					$stmt->execute();
					$result = $stmt->get_result();

					if($result->num_rows > 0){
						$data = $result->fetch_assoc();
						header('Content-Type: application/json');
						echo json_encode($data);
					}else{
						http_response_code(404);
						exit();
					}
					$stmt->close();
					$mysqli->close();
				}else{
					http_response_code(404);
					exit();
				}
			break;

			case 'POST' :
				if(isset($_SESSION['is_admin'])){
					if(isset($_GET['id']) && $_GET['id'] === $_POST['id'] && isset($_POST['password'])){
						$id = $_POST['id'];
						$password = $mysqli->real_escape_string($_POST['password']);
						$confirmation = $mysqli->real_escape_string($_POST['confirmation']);

						$sql = "SELECT * FROM users WHERE id = ?";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$data = $stmt->get_result()->fetch_assoc();
						$stmt->close();

						if($password != $confirmation){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'confirmation',
								'title' => 'Peringatan!',
								'message' => 'Konfirmasi Password Tidak Sesuai',
								'type' => 'warning'
							]);
							exit();
						}elseif(password_verify($password, $data['password'])){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'password',
								'title' => 'Peringatan!',
								'message' => 'Password Baru dan Lama Tidak Boleh Sama',
								'type' => 'warning'
							]);
							exit();
						}else{
							$password = password_hash($password, PASSWORD_DEFAULT);
							$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
							$stmt->bind_param('si', $password, $id);
							$stmt->execute();
							$update = $stmt->affected_rows;

							/* $_SESSION = [];
							session_unset();
							session_destroy(); */
							unset($_SESSION['is_admin']);
							unset($_SESSION['id']);
							unset($_SESSION['name']);
							unset($_SESSION['username']);
							unset($_SESSION['level']);
							unset($_SESSION['photo']);

							setcookie('id_admin', '', time()-2592000, '/');
							setcookie('key_admin', '', time()-2592000, '/');
						}

						if($update > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Password Anda Berhasil Diubah',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Password Anda Gagal Diubah',
								'type' => 'error'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}elseif(isset($_GET['id']) && $_GET['id'] === $_POST['id'] && isset($_POST['name'])){
						$id = $_POST['id'];
						$name = remove_slashes($_POST['name']);
						$username = remove_slashes($_POST['username']);

						$name = validasi_data(ucwords($name));
						$username = validasi_data(strtolower($username));

						$file_name = explode('.', $_FILES['photo']['name']);
						$photo = round(microtime(true)) . '.' . end($file_name);
						$tmp_name = $_FILES['photo']['tmp_name'];
						$folder = '../images/photos/';
						$destination = $folder.basename($photo);
						$file_size = $_FILES['photo']['size'];
						$upload = $_FILES['photo']['error'];

						if($upload == 0){
							$mime_type = mime_content_type($tmp_name);
							$extension = ['image/jpg', 'image/jpeg', 'image/png'];

							if(!in_array($mime_type, $extension)){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'extension',
									'title' => 'Peringatan!',
									'message' => 'File yang Dipilih Bukan Gambar (jpg, jpeg, png)',
									'type' => 'warning'
								]);
								exit();
							}else{
								$file_info = getimagesize($tmp_name);
								$width = $file_info[0];
								$height = $file_info[1];
							}

							if($width != $height){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'resolution',
									'title' => 'Peringatan!',
									'message' => 'Gambar Tidak Mempunyai Aspek Rasio Persegi (1:1)',
									'type' => 'warning'
								]);
								exit();
							}elseif($file_size > 1000000){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'size',
									'title' => 'Peringatan!',
									'message' => 'Ukuran Gambar Terlalu Besar, Maksimal 1 MB',
									'type' => 'warning'
								]);
								exit();
							}else{
								$sql = "UPDATE users SET name = ?, username = ? WHERE id = ?";
								$stmt = $mysqli->prepare($sql);
								$stmt->bind_param('ssi', $name, $username, $id);
								$stmt->execute();

								if($stmt->errno){
									header('Content-Type: application/json');
									echo json_encode([
										'status' => 'username',
										'title' => 'Peringatan!',
										'message' => 'Username yang Dipilih Sudah Terpakai',
										'type' => 'warning'
									]);
									exit();
								}
								$stmt->close();
								$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
								$stmt->bind_param('i', $id);
								$stmt->execute();
								$result = $stmt->get_result();
								$stmt->close();

								if($result->num_rows > 0){
									$data = $result->fetch_assoc();
									$file = $data['photo'];

									if($file != 'user.png'){
										if(is_file($folder.$file)){
											if(!unlink($folder.$file)){
												header('Content-Type: application/json');
												echo json_encode([
													'status' => 'photo',
													'title' => 'Informasi!',
													'message' => 'Foto ' . $api . ' Gagal Dihapus',
													'type' => 'info'
												]);
												exit();
											}
										}
									}
									if(!rename($tmp_name, $destination)){
										header('Content-Type: application/json');
										echo json_encode([
											'status' => 'photo',
											'title' => 'Informasi!',
											'message' => 'Foto ' . $api . ' Gagal Diubah',
											'type' => 'info'
										]);
										exit();
									}
								}else{
									http_response_code(404);
									exit();
								}
								$stmt = $mysqli->prepare("UPDATE users SET photo = ? WHERE id = ?");
								$stmt->bind_param('si', $photo, $id);
								$stmt->execute();
								$update = $stmt->affected_rows;

								$_SESSION['name'] = $name;
								$_SESSION['username'] = $username;
								$_SESSION['photo'] = $photo;
							}
						}else{
							$sql = "UPDATE users SET name = ?, username = ? WHERE id = ?";
							$stmt = $mysqli->prepare($sql);
							$stmt->bind_param('ssi', $name, $username, $id);
							$stmt->execute();
							$update = $stmt->affected_rows;

							if($stmt->errno){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'username',
									'title' => 'Peringatan!',
									'message' => 'Username yang Dipilih Sudah Terpakai',
									'type' => 'warning'
								]);
								exit();
							}
							$_SESSION['name'] = $name;
							$_SESSION['username'] = $username;
						}

						if($update > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => '' . $api . ' Anda Berhasil Diubah',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'info',
								'title' => 'Informasi!',
								'message' => 'Anda Tidak Melakukan Perubahan Data',
								'type' => 'info'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}elseif(isset($_GET['id'])){
						$id = $_GET['id'];

						$sql = "SELECT * FROM users WHERE id = ?";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$result = $stmt->get_result();
						$stmt->close();

						if($result->num_rows > 0){
							$data = $result->fetch_assoc();
							$file = $data['photo'];
							$folder = '../images/photos/';

							if($file != 'user.png'){
								if(is_file($folder.$file)){
									if(!unlink($folder.$file)){
										header('Content-Type: application/json');
										echo json_encode([
											'status' => 'photo',
											'title' => 'Peringatan!',
											'message' => 'Foto ' . $api . ' Gagal Dihapus',
											'type' => 'warning'
										]);
										exit();
									}
								}
							}
						}else{
							http_response_code(404);
							exit();
						}
						$stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$delete = $stmt->affected_rows;

						if($delete > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Akun Anda Berhasil Dihapus',
								'type' => 'success'
							]);

							/* $_SESSION = [];
							session_unset();
							session_destroy(); */
							unset($_SESSION['is_admin']);
							unset($_SESSION['id']);
							unset($_SESSION['name']);
							unset($_SESSION['username']);
							unset($_SESSION['level']);
							unset($_SESSION['photo']);

							setcookie('id_admin', '', time()-2592000, '/');
							setcookie('key_admin', '', time()-2592000, '/');
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Akun Anda Gagal Dihapus',
								'type' => 'error'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}
				}else{
					http_response_code(403);
					exit();
				}
			break;

			case 'PUT' :
				if(isset($_SESSION['is_admin'])){
					// parse_str(file_get_contents('php://input'), $_PUT);
					_parsePut();

					if(isset($_GET['id']) && $_GET['id'] === $_PUT['id'] && isset($_PUT['password'])){
						$id = $_PUT['id'];
						$password = $mysqli->real_escape_string($_PUT['password']);
						$confirmation = $mysqli->real_escape_string($_PUT['confirmation']);

						$sql = "SELECT * FROM users WHERE id = ?";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$data = $stmt->get_result()->fetch_assoc();
						$stmt->close();

						if($password != $confirmation){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'confirmation',
								'title' => 'Peringatan!',
								'message' => 'Konfirmasi Password Tidak Sesuai',
								'type' => 'warning'
							]);
							exit();
						}elseif(password_verify($password, $data['password'])){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'password',
								'title' => 'Peringatan!',
								'message' => 'Password Baru dan Lama Tidak Boleh Sama',
								'type' => 'warning'
							]);
							exit();
						}else{
							$password = password_hash($password, PASSWORD_DEFAULT);
							$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
							$stmt->bind_param('si', $password, $id);
							$stmt->execute();
							$update = $stmt->affected_rows;

							/* $_SESSION = [];
							session_unset();
							session_destroy(); */
							unset($_SESSION['is_admin']);
							unset($_SESSION['id']);
							unset($_SESSION['name']);
							unset($_SESSION['username']);
							unset($_SESSION['level']);
							unset($_SESSION['photo']);

							setcookie('id_admin', '', time()-2592000, '/');
							setcookie('key_admin', '', time()-2592000, '/');
						}

						if($update > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Password Anda Berhasil Diubah',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Password Anda Gagal Diubah',
								'type' => 'error'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}elseif(isset($_GET['id']) && $_GET['id'] === $_PUT['id'] && isset($_PUT['name'])){
						$id = $_PUT['id'];
						$name = remove_slashes($_PUT['name']);
						$username = remove_slashes($_PUT['username']);

						$name = validasi_data(ucwords($name));
						$username = validasi_data(strtolower($username));

						$file_name = explode('.', $_FILES['photo']['name']);
						$photo = round(microtime(true)) . '.' . end($file_name);
						$tmp_name = $_FILES['photo']['tmp_name'];
						$folder = '../images/photos/';
						$destination = $folder.basename($photo);
						$file_size = $_FILES['photo']['size'];
						$upload = $_FILES['photo']['error'];

						if($upload == 0){
							$mime_type = mime_content_type($tmp_name);
							$extension = ['image/jpg', 'image/jpeg', 'image/png'];

							if(!in_array($mime_type, $extension)){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'extension',
									'title' => 'Peringatan!',
									'message' => 'File yang Dipilih Bukan Gambar (jpg, jpeg, png)',
									'type' => 'warning'
								]);
								exit();
							}else{
								$file_info = getimagesize($tmp_name);
								$width = $file_info[0];
								$height = $file_info[1];
							}

							if($width != $height){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'resolution',
									'title' => 'Peringatan!',
									'message' => 'Gambar Tidak Mempunyai Aspek Rasio Persegi (1:1)',
									'type' => 'warning'
								]);
								exit();
							}elseif($file_size > 1000000){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'size',
									'title' => 'Peringatan!',
									'message' => 'Ukuran Gambar Terlalu Besar, Maksimal 1 MB',
									'type' => 'warning'
								]);
								exit();
							}else{
								$sql = "UPDATE users SET name = ?, username = ? WHERE id = ?";
								$stmt = $mysqli->prepare($sql);
								$stmt->bind_param('ssi', $name, $username, $id);
								$stmt->execute();

								if($stmt->errno){
									header('Content-Type: application/json');
									echo json_encode([
										'status' => 'username',
										'title' => 'Peringatan!',
										'message' => 'Username yang Dipilih Sudah Terpakai',
										'type' => 'warning'
									]);
									exit();
								}
								$stmt->close();
								$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
								$stmt->bind_param('i', $id);
								$stmt->execute();
								$result = $stmt->get_result();
								$stmt->close();

								if($result->num_rows > 0){
									$data = $result->fetch_assoc();
									$file = $data['photo'];

									if($file != 'user.png'){
										if(is_file($folder.$file)){
											if(!unlink($folder.$file)){
												header('Content-Type: application/json');
												echo json_encode([
													'status' => 'photo',
													'title' => 'Informasi!',
													'message' => 'Foto ' . $api . ' Gagal Dihapus',
													'type' => 'info'
												]);
												exit();
											}
										}
									}
									if(!rename($tmp_name, $destination)){
										header('Content-Type: application/json');
										echo json_encode([
											'status' => 'photo',
											'title' => 'Informasi!',
											'message' => 'Foto ' . $api . ' Gagal Diubah',
											'type' => 'info'
										]);
										exit();
									}
								}else{
									http_response_code(404);
									exit();
								}
								$stmt = $mysqli->prepare("UPDATE users SET photo = ? WHERE id = ?");
								$stmt->bind_param('si', $photo, $id);
								$stmt->execute();
								$update = $stmt->affected_rows;

								$_SESSION['name'] = $name;
								$_SESSION['username'] = $username;
								$_SESSION['photo'] = $photo;
							}
						}else{
							$sql = "UPDATE users SET name = ?, username = ? WHERE id = ?";
							$stmt = $mysqli->prepare($sql);
							$stmt->bind_param('ssi', $name, $username, $id);
							$stmt->execute();
							$update = $stmt->affected_rows;

							if($stmt->errno){
								header('Content-Type: application/json');
								echo json_encode([
									'status' => 'username',
									'title' => 'Peringatan!',
									'message' => 'Username yang Dipilih Sudah Terpakai',
									'type' => 'warning'
								]);
								exit();
							}
							$_SESSION['name'] = $name;
							$_SESSION['username'] = $username;
						}

						if($update > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => '' . $api . ' Anda Berhasil Diubah',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'info',
								'title' => 'Informasi!',
								'message' => 'Anda Tidak Melakukan Perubahan Data',
								'type' => 'info'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}else{
						http_response_code(404);
						exit();
					}
				}else{
					http_response_code(403);
					exit();
				}
			break;

			case 'DELETE' :
				if(isset($_SESSION['is_admin'])){
					if(isset($_GET['id'])){
						$id = $_GET['id'];

						$sql = "SELECT * FROM users WHERE id = ?";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$result = $stmt->get_result();
						$stmt->close();

						if($result->num_rows > 0){
							$data = $result->fetch_assoc();
							$file = $data['photo'];
							$folder = '../images/photos/';

							if($file != 'user.png'){
								if(is_file($folder.$file)){
									if(!unlink($folder.$file)){
										header('Content-Type: application/json');
										echo json_encode([
											'status' => 'photo',
											'title' => 'Peringatan!',
											'message' => 'Foto ' . $api . ' Gagal Dihapus',
											'type' => 'warning'
										]);
										exit();
									}
								}
							}
						}else{
							http_response_code(404);
							exit();
						}
						$stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$delete = $stmt->affected_rows;

						if($delete > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Akun Anda Berhasil Dihapus',
								'type' => 'success'
							]);

							/* $_SESSION = [];
							session_unset();
							session_destroy(); */
							unset($_SESSION['is_admin']);
							unset($_SESSION['id']);
							unset($_SESSION['name']);
							unset($_SESSION['username']);
							unset($_SESSION['level']);
							unset($_SESSION['photo']);

							setcookie('id_admin', '', time()-2592000, '/');
							setcookie('key_admin', '', time()-2592000, '/');
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Akun Anda Gagal Dihapus',
								'type' => 'error'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}
				}else{
					http_response_code(403);
					exit();
				}
			break;

			default :
				http_response_code(405);
				exit();
			break;
		}
	/* }else{
		echo '<script>window.history.back();</script>';
	} */
?>