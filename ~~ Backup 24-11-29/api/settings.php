<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once '../config/connection.php';
		require_once '../config/helper.php';
		$api = 'Setelan Website';

		switch($_SERVER['REQUEST_METHOD']){
			case 'GET' :
				if(isset($_GET['id'])){
					$id = $_GET['id'];

					$sql = "SELECT * FROM settings WHERE id = ?";
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
					$table = 'settings';
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
						array('db' => 'mode', 'dt' => 'mode')
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
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$mode = $_POST['mode'];

						$sql = "UPDATE settings SET mode = ? WHERE id = ?";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('si', $mode, $id);
						$stmt->execute();
						$update = $stmt->affected_rows;

						if($stmt->errno){
							header('Content-Type: application/json');
							echo json_encode([
								'status' => 'error',
								'title' => 'Error!',
								'message' => 'Data ' . $api . ' Gagal Diubah',
								'type' => 'error'
							]);
							exit();
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
					}
				}else{
					http_response_code(403);
					exit();
				}
			break;

			case 'PUT' :
				http_response_code(405);
				exit();
			break;

			case 'DELETE' :
				http_response_code(405);
				exit();
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