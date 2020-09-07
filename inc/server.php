<?php 
	date_default_timezone_set('Europe/Amsterdam');
	session_start();
	
	if (isset($_GET['methode'])){
		$methode = $_GET['methode'];
	} else {
		$methode = "";
	}

	$lang = file_get_contents('./inc/languages/'.$language.'.json');
    $lang = json_decode($lang);

	// Login
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = md5($password);
		
		$loginjson = file_get_contents('users.json');
  		$logindata = json_decode($loginjson);

  		foreach ($logindata as $userdata) {
  			if($userdata->Username == $username && $userdata->Password == $password){
				$_SESSION['UserId'] = $userdata->UserId;
				$_SESSION['Username'] = $userdata->Username;
				$_SESSION['Role'] = $userdata->Role;
				
				header('location: ../punishments');
				echo '
				<script>
					location.replace("../punishments");
					window.location.href = "../punishments"
				</script>
				';
			}else{
				$_SESSION['Error'] = "WrongUsernameOrPassword";
				header('location: ../');
				echo '
				<script>
					location.replace("../");
					window.location.href = "../"
				</script>
				';
			}
  		}
	}

	// Setup
	if (isset($_POST['setup'])) {
		if(file_exists("./inc/dbconfig.php") && file_exists("./inc/users.json")){
			header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
		}else{
			$dbhostname = $_POST['dbhostname'];
			$dbdatabase = $_POST['dbdatabase'];
			$dbusername = $_POST['dbusername'];
			$dbpassword = $_POST['dbpassword'];

			$username = $_POST['username'];
			$password = $_POST['password'];
			$password = md5($password);

			$UserId = substr(str_shuffle("0123456789"), 0, 10);
			$users[] = array(
				"UserId" => $UserId,
				"Username" => $username,
				"Password" => $password,
				"Role" => "admin"
			);

			$dbconfig = '<?php $dbhostname="'.$dbhostname.'";$dbdatabase="'.$dbdatabase.'";$dbusername="'.$dbusername.'";$dbpassword="'.$dbpassword.'"; ?>';
			$users = json_encode($users);
			file_put_contents("users.json", $users);
			file_put_contents("dbconfig.php", $dbconfig);
			
			header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
		}
	}

	// add user
	if (isset($_POST['adduser'])) {
		$Role = $_SESSION['Role'];
		if($Role != "admin"){
            $username = $_POST['username'];
			$password = $_POST['password'];
			$Role = $_POST['role'];
			$password = md5($password);
			
			$UserId = substr(str_shuffle("0123456789"), 0, 10);
			$json = file_get_contents('users.json');
			$data = json_decode($json);
			
			$data[] = array(
				'UserId' => $UserId,
				'Username' => $username,
				'Password' => $password,
				'Role' => $Role
			);
			
			file_put_contents('users.json', json_encode($data));

			header('location: ../settings');
			echo '
			<script>
				location.replace("../settings");
				window.location.href = "../settings"
			</script>
			';
        }else{
        	header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}
	
	//delete user
	if ($methode == "deleteuser") {
		$Role = $_SESSION['Role'];
		if($Role == "admin"){
			$index = $_GET['index'];
			
			$json = file_get_contents('users.json');
			$data = json_decode($json);
			
			unset($data[$index]);
			
			file_put_contents('users.json', json_encode($data));

			header('location: ../settings');
			echo '
			<script>
				location.replace("../settings");
				window.location.href = "../settings"
			</script>
			';
		}else{
        	header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}

	// Change Lang
	if (isset($_POST['updatelang'])) {
		$Role = $_SESSION['Role'];
		if($Role == "admin"){
			$lang = $_POST['lang'];
			
			$configjson = file_get_contents('config.json');
			$config = json_decode($configjson);

			$config = array(
				"version" => $config->version,
				"language" => $lang
			);

			$config = json_encode($config);
			file_put_contents("config.json", $config);
			
			header('location: ../settings');
			echo '
			<script>
				location.replace("../settings");
				window.location.href = "../settings"
			</script>
			';
		}else{
        	header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}
?>