<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once '../config/connection.php';
		require_once '../config/helper.php';
		$api = 'Akun';

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
					$table = 'users';
					$primaryKey = 'id';

					$columns = array(
						array(
							'db' => 'id',
							'dt' => 'DT_RowId',
							'formatter' => function($d, $row){
								return 'row_' . $d;
							}
						),
						array('db' => 'id', 'dt' => 'id'),
						array('db' => 'name', 'dt' => 'name'),
						array('db' => 'username', 'dt' => 'username'),
						array('db' => 'password', 'dt' => 'password'),
						array('db' => 'level', 'dt' => 'level'),
						array('db' => 'photo', 'dt' => 'photo'),
						array('db' => 'status', 'dt' => 'status'),
						array(
							'db' => 'created_at',
							'dt' => 'created_at',
							'formatter' => function($d, $row){
								return date('d-m-Y H:i:s', strtotime($d)) . ' WIB';
							}
						),
						array(
							'db' => 'updated_at',
							'dt' => 'updated_at',
							'formatter' => function($d, $row){
								return date('d-m-Y H:i:s', strtotime($d)) . ' WIB';
							}
						)
					);

					require_once '../config/processing.php';
					require('../config/ssp.class.php');

					header('Content-Type: application/json');
					echo json_encode(
						SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
					);
				}
			break;

			case 'POST' :
				if(isset($_SESSION['is_admin']) && $_SESSION['level'] == 'admin'){
					if(isset($_GET['id']) && isset($_POST['id']) && $_GET['id'] === $_POST['id']){
						$id = $_POST['id'];
						$name = remove_slashes($_POST['name']);
						$username = remove_slashes($_POST['username']);

						$name = validasi_data(ucwords($name));
						$username = validasi_data(strtolower($username));
						$password = $mysqli->real_escape_string($_POST['password']);
						$confirmation = $mysqli->real_escape_string($_POST['confirmation']);
						$level = $_POST['level'];
						$status = $_POST['status'];

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
							$stmt = $mysqli->prepare("UPDATE users SET name = ?, username = ?, password = ?, level = ?, status = ? WHERE id = ?");
							$stmt->bind_param('ssssii', $name, $username, $password, $level, $status, $id);
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
						}

						if($update > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Data ' . $api . ' Berhasil Diubah',
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
								'message' => 'Data ' . $api . ' Berhasil Dihapus',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Data ' . $api . ' Gagal Dihapus',
								'type' => 'error'
							]);
						}
						$stmt->close();
						$mysqli->close();
					}else{
						$name = remove_slashes($_POST['name']);
						$username = remove_slashes($_POST['username']);

						$name = validasi_data(ucwords($name));
						$username = validasi_data(strtolower($username));
						$password = $mysqli->real_escape_string($_POST['password']);
						$confirmation = $mysqli->real_escape_string($_POST['confirmation']);
						$level = $_POST['level'];
						$photo = 'user.png';
						$status = 1;

						if($password != $confirmation){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'confirmation',
								'title' => 'Peringatan!',
								'message' => 'Konfirmasi Password Tidak Sesuai',
								'type' => 'warning'
							]);
							exit();
						}else{
							$password = password_hash($password, PASSWORD_DEFAULT);
							$sql = "INSERT INTO users (name, username, password, level, photo, status) VALUES (?, ?, ?, ?, ?, ?)";
							$stmt = $mysqli->prepare($sql);
							$stmt->bind_param('sssssi', $name, $username, $password, $level, $photo, $status);
							$stmt->execute();
							$create = $stmt->affected_rows;

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
						}

						if($create > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Data ' . $api . ' Berhasil Disimpan',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Data ' . $api . ' Gagal Disimpan',
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
				if(isset($_SESSION['is_admin']) && $_SESSION['level'] == 'admin'){
					// parse_str(file_get_contents('php://input'), $_PUT);
					_parsePut();

					if(isset($_GET['id']) && $_GET['id'] === $_PUT['id']){
						$id = $_PUT['id'];
						$name = remove_slashes($_PUT['name']);
						$username = remove_slashes($_PUT['username']);

						$name = validasi_data(ucwords($name));
						$username = validasi_data(strtolower($username));
						$password = $mysqli->real_escape_string($_PUT['password']);
						$confirmation = $mysqli->real_escape_string($_PUT['confirmation']);
						$level = $_PUT['level'];
						$status = $_PUT['status'];

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
							$stmt = $mysqli->prepare("UPDATE users SET name = ?, username = ?, password = ?, level = ?, status = ? WHERE id = ?");
							$stmt->bind_param('ssssii', $name, $username, $password, $level, $status, $id);
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
						}

						if($update > 0){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'success',
								'title' => 'Sukses!',
								'message' => 'Data ' . $api . ' Berhasil Diubah',
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
				if(isset($_SESSION['is_admin']) && $_SESSION['level'] == 'admin'){
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
								'message' => 'Data ' . $api . ' Berhasil Dihapus',
								'type' => 'success'
							]);
						}else{
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Data ' . $api . ' Gagal Dihapus',
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