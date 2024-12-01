<?php
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
		session_start();
		require_once '../config/connection.php';
		require_once '../config/helper.php';

		switch($_SERVER['REQUEST_METHOD']){
			case 'GET' :
				if(isset($_GET['id']) && $_GET['id'] == 'info'){
					$sql = "SELECT (SELECT COUNT(*) FROM classifications) AS total_classification, (SELECT COUNT(*) FROM archives) AS total_archive, (SELECT COUNT(*) FROM users WHERE level = 'admin') AS total_admin, (SELECT COUNT(*) FROM users WHERE level = 'operator') AS total_operator";
					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$data = $stmt->get_result()->fetch_assoc();
					$stmt->close();
					$mysqli->close();

					header('Content-Type: application/json');
					echo json_encode($data);
				}elseif(isset($_GET['id']) && $_GET['id'] == 'archive'){
					$sql = "SELECT code, COUNT(archives.id) AS total FROM archives LEFT JOIN classifications ON archives.id_classifications = classifications.id WHERE DATE(archives.created_at) = CURDATE() GROUP BY code";
					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
					$stmt->close();
					$mysqli->close();

					header('Content-Type: application/json');
					echo json_encode($data);
				}elseif(isset($_GET['id']) && $_GET['id'] == 'statistic'){
					$sql1 = "SELECT year AS labels, COUNT(CASE WHEN id_classifications = '1' THEN 1 ELSE NULL END) AS total1, COUNT(CASE WHEN id_classifications = '2' THEN 1 ELSE NULL END) AS total2, (CASE WHEN id_classifications = '1' THEN content ELSE NULL END) AS label1, (CASE WHEN id_classifications = '2' THEN content ELSE NULL END) AS label2 FROM archives LEFT JOIN classifications ON archives.id_classifications = classifications.id GROUP BY labels";
					$stmt = $mysqli->prepare($sql1);
					$stmt->execute();
					$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
					$stmt->close();
					$mysqli->close();

					header('Content-Type: application/json');
					echo json_encode($data);
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