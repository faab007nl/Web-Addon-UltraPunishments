<?php
    require_once "inc/Mobile_Detect.php";
    $detect = new Mobile_Detect;

    $configjson = file_get_contents('./inc/config.json');
	$configjson = json_decode($configjson);
	$version = $configjson->version;

	if(file_exists("./inc/dbconfig.php") && file_exists("./inc/users.json")){
		header('location: ./');
		echo '
		<script>
			location.replace("./");
			window.location.href = "./"
		</script>
		';
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">   
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <title>UltraPunishments - Setup</title>
    <link rel="icon" href="./assets/img/icon.jpg" sizes="16x16">
    <meta property="og:title" content="Stats" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="UltraPunishments - Punishments" />
    <meta property="og:description" content="View all of Server's Punishments." />
    <meta property="og:image" content="./inc/img/upunlogo.jpg"/>
    <meta property="og:image:url" content="https://stats.extasynetwork.net"/>
    <meta name="theme-color" content="#f77727">
    <meta name="msapplication-TileColor" content="#f77727">
</head>

<body>
    <div class="row no-gutters justify-content-center bannerrow">
        <div class="col-auto"><img class="img-fluid bannerimg" src="assets/img/banner.png">
            <div class="panel">
                <h3 class="h3custom">UltraPunishments&nbsp;v<?php echo $version; ?><br></h3><span class="madeby">Web Addon by&nbsp;<a href="https://www.spigotmc.org/members/eazyftw.55966/">EazyFTW</a>&nbsp;&amp;&nbsp;<a href="https://www.spigotmc.org/members/faab007.324536/">Faab007NL</a><br></span>
                <h2>Setup</h2>
                <hr>
                <form action="inc/server.php" method="post">
                    <h5>Database</h5>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Hostname" name="dbhostname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Database" name="dbdatabase" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Username" name="dbusername" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Password" name="dbpassword" required>
                    </div>
                    <hr>
                    <h5>Admin Login</h5>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Username" name="username" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block btnsubmit" value="Done" name="setup" type="submit">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>