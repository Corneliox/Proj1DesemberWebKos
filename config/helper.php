<?php
	function _parsePut(){
		global $_PUT;

		$putdata = fopen('php://input', 'r');
		$raw_data = '';

		while($chunk = fread($putdata, 1024)){
			$raw_data .= $chunk;
		}
		fclose($putdata);
		$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

		if(empty($boundary)){
			parse_str($raw_data, $data);
			$GLOBALS['_PUT'] = $data;
			return;
		}
		$parts = array_slice(explode($boundary, $raw_data), 1);
		$data = array();

		foreach($parts as $part){
			if($part == "--\r\n") break;

			$part = ltrim($part, "\r\n");
			list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);
			$raw_headers = explode("\r\n", $raw_headers);
			$headers = array();

			foreach($raw_headers as $header){
				list($name, $value) = explode(':', $header);
				$headers[strtolower($name)] = ltrim($value, ' ');
			}

			if(isset($headers['content-disposition'])){
				$filename = null;
				$tmp_name = null;
				preg_match(
					'/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
					$headers['content-disposition'],
					$matches
				);
				list(, $type, $name) = $matches;

				if(isset($matches[4])){
					if(isset($_FILES[$matches[2]])){
						continue;
					}
					$filename = $matches[4];
					$filename_parts = pathinfo($filename);
					$tmp_name = tempnam(ini_get('upload_tmp_dir'), $filename_parts['filename']);
					$_FILES[$matches[2]] = array(
						'name' => $filename,
						'type' => ltrim($value, ' '),
						'tmp_name' => $tmp_name,
						'error' => 0,
						'size' => strlen($body)
					);
					file_put_contents($tmp_name, $body);
				}else{
					if(ltrim($value, ' ') == 'application/octet-stream'){
						$_FILES[$matches[2]] = array(
							'name' => '',
							'type' => '',
							'tmp_name' => '',
							'error' => 4,
							'size' => 0
						);
					}
					$data[$name] = substr($body, 0, strlen($body) - 2);
				}
			}
		}
		$GLOBALS['_PUT'] = $data;
		return;
	}

	function crud($action, $query){
		global $mysqli;

		switch($action){
			case 'create' :
				$create = $mysqli->query($query);
				return $create;
			break;

			case 'read' :
				$result = $mysqli->query($query);
				$data = array();
				while($row = $mysqli->fetch_assoc($result)){
					$data[] = $row;
				}
				return $data;
			break;

			case 'update' :
				$update = $mysqli->query($query);
				return $update;
			break;

			case 'delete' :
				$delete = $mysqli->query($query);
				return $delete;
			break;
		}
	}

	function remove_slashes($string){
		$string = implode('', explode('\\', $string));
		return stripcslashes(trim($string));
	}

	function validasi_data($data){
		global $mysqli;

		$data = trim($data);
		// $data = stripslashes($data);
		// $data = strip_tags($data);
		$data = htmlspecialchars($data, ENT_QUOTES);
		$data = $mysqli->real_escape_string($data);
		return $data;
	}

	function settings(){
		global $mysqli;

		$application_name = 'Kost Ertiga Ngaliyan';
		$author = 'Kost Ertiga Semarang';
		$description = 'Kos Ertiga terletak di kawasan strategis Semarang, menawarkan lingkungan asri dan akses mudah ke berbagai fasilitas umum. Dengan fasilitas lengkap seperti kamar ber-AC, WiFi super cepat, kamar mandi dalam, dapur bersama, dan area parkir luas, Kos Ertiga adalah pilihan tepat untuk hunian yang nyaman, praktis, dan mendukung kebutuhan Anda sehari-hari.';
		$keywords = '';
		$creator = 'Kost Ertiga Ngaliyan';
		$version = '1.0';
		$title = 'BKK Tracer Study';
		$header = 'BKK Tracer Study';
		$footer = 'Kost Ertiga Ngaliyan';
		$address = '241 Jl. Karonsih Utara Raya Jawa Tengah';
		$telephone = '';
		$facsimile = '';
		$email = '';
		$whatsapp = '';
		$website = '';
		$facebook = '';
		$instagram = 'https://www.instagram.com/kostputriertiga_ngaliyan?igsh=ZXFzcWZjMHVtZTNk';
		$twitter = '';
		$youtube = '';

		return array($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube);
	}

	function session($sesi){
		global $mysqli;

		switch($sesi){
			case 'all' :
				if(!isset($_SESSION['is_admin'])){
					// header('location: login.php#login');
					echo '<script type="text/javascript">
						sessionStorage.setItem("message", "login");
						window.location.replace("./login");
					</script>';
					exit();
				}
			break;

			case 'admin' :
				if(!isset($_SESSION['is_admin'])){
					// header('location: login.php#login');
					echo '<script type="text/javascript">
						sessionStorage.setItem("message", "login");
						window.location.replace("./login");
					</script>';
					exit();
				}elseif(isset($_SESSION['is_admin']) && $_SESSION['role'] != 'admin'){
					// header("{$_SERVER['SERVER_PROTOCOL']} 403");
					http_response_code(403);
					include_once './resources/views/errors/403.php';
					exit();
				}
			break;

			case 'login' :
				if(isset($_COOKIE['id_admin']) && isset($_COOKIE['key_admin'])){
					$id = $_COOKIE['id_admin'];
					$key = $_COOKIE['key_admin'];

					$sql = "SELECT * FROM users WHERE id = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('i', $id);
					$stmt->execute();
					$data = $stmt->get_result()->fetch_assoc();

					if($key === hash('sha256', $data['email'])){
						$_SESSION['is_admin'] = true;
						$_SESSION['id'] = $data['id'];
						$_SESSION['name'] = $data['name'];
						$_SESSION['email'] = $data['email'];
						$_SESSION['role'] = $data['role'];
						$_SESSION['photo'] = $data['photo'];
					}
					$stmt->close();
					$mysqli->close();
				}

				if(isset($_SESSION['is_admin'])){
					// header('location: index.php#welcome-back');
					echo '<script type="text/javascript">
						sessionStorage.setItem("message", "welcome-back");
						window.location.replace("./");
					</script>';
					exit();
				}
			break;
		}
	}

	function tanggal($format){
		switch($format){
			case 'hari' :
				$hari = date('N');

				switch($hari){
					case 1 :
						$hari = 'Senin';
					break;
					case 2 :
						$hari = 'Selasa';
					break;
					case 3 :
						$hari = 'Rabu';
					break;
					case 4 :
						$hari = 'Kamis';
					break;
					case 5 :
						$hari = 'Jumat';
					break;
					case 6 :
						$hari = 'Sabtu';
					break;
					case 7 :
						$hari = 'Minggu';
					break;
					default :
						$hari = 'UnKnown';
					break;
				}
				return "Hari {$hari},";
			break;

			case 'bulan' :
				$date = date('Y-m-d');
				$tgl = substr($date, 8, 2);
				$bln = substr($date, 5, 2);
				$thn = substr($date, 0, 4);

				switch($bln){
					case 1 :
						$bln = 'Januari';
					break;
					case 2 :
						$bln = 'Februari';
					break;
					case 3 :
						$bln = 'Maret';
					break;
					case 4 :
						$bln = 'April';
					break;
					case 5 :
						$bln = 'Mei';
					break;
					case 6 :
						$bln = 'Juni';
					break;
					case 7 :
						$bln = 'Juli';
					break;
					case 8 :
						$bln = 'Agustus';
					break;
					case 9 :
						$bln = 'September';
					break;
					case 10 :
						$bln = 'Oktober';
					break;
					case 11 :
						$bln = 'November';
					break;
					case 12 :
						$bln = 'Desember';
					break;
					default :
						$bln = 'UnKnown';
					break;
				}
				return "{$tgl} {$bln} {$thn}";
			break;
		}
	}
?>