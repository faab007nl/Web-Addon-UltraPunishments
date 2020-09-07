<?php
    include 'inc/functions.php';
    include 'inc/config.php';
    include 'inc/mysql.php';
    include 'inc/server.php';
    require_once "inc/Mobile_Detect.php";
    $detect = new Mobile_Detect;

    if(isset($_SESSION['UserId'])){
        $UserId = $_SESSION['UserId'];
        $username = $_SESSION['Username'];
        $Role = $_SESSION['Role'];
    }else{
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
    <title>UltraPunishments - <?php echo $lang->users; ?></title>
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
    <?php 
        if($Role == "admin"){
            $newUpdate = CheckForUpdates(); 

            if($newUpdate == true){
                echo '
                    <div class="NewUpdate">
                        <span><strong>There is a new update available!</strong></span></br>
                        <span>Go to the settings to download it!</span>
                    </div>
                ';
            }
        }
    ?>
    <div class="LeaveBtnDiv">
        <a class="LeaveBtn" href="./inc/logout.php"><i title="<?php echo $lang->signout; ?>" class="fas fa-sign-out-alt"></i></a>
    </div>
    <div class="row no-gutters justify-content-center bannerrow">
        <div class="col-auto"><img class="img-fluid bannerimg" src="assets/img/banner.png"></div>
    </div>
    <div class="row no-gutters justify-content-center">
        <?php 
            if (!$detect->isMobile() ) {
                echo '
                <div class="col-1"></div>';
            }else{
            	echo '
		        <style type="text/css">
		        	.tab{
		        		display: block;
		        	}
		        </style>
                ';
            }
        ?>
        <div class="col">
            <div class="panel">
                <h3 class="h3custom">UltraPunishments&nbsp;v<?php echo $version; ?><br></h3><span class="madeby"><?php echo $lang->webaddonby; ?>&nbsp;<a href="https://www.spigotmc.org/members/eazyftw.55966/">EazyFTW</a>&nbsp;&amp;&nbsp;<a href="https://www.spigotmc.org/members/faab007.324536/">Faab007NL</a><br></span>
                <div>
                    <div class="nav">
                        <ul class="tab tab-block">
                            <li class="tab-item active" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./punishments"><?php echo $lang->punishments; ?></a></li>
                            <li class="tab-item active" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./warnings"><?php echo $lang->warnings; ?></a></li>
                            <li class="tab-item active" style="border-bottom: solid 1px #f77727;"><a style="color:#f77727;" class="link" href="./users"><?php echo $lang->users; ?></a></li>
                            <li class="tab-item active" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./reports"><?php echo $lang->reports; ?></a></li>
                            <?php
                            if($Role == "admin"){
                                    echo '
                                        <li class="tab-item active" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./settings">'.$lang->settings.'</a></li>
                                    ';
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="table-header-cell"><?php echo $lang->uuid; ?><br></th>
                                        <th class="table-header-cell"><?php echo $lang->playername; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->ip; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->prevent; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->skull; ?></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <?php
                                        $pdoResult = $PDOdb->prepare("SELECT * FROM UltraPunishments_PlayerIndexes ORDER BY UltraPunishments_PlayerIndexes.key DESC");
                                        $pdoExec =  $pdoResult->execute();

                                        if($pdoExec){
                                            while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                                                $data = base64_decode($row['value']);
                                                $data = json_decode($data, true);
                                                
                                                $prevent = $data['prevent'];
                                                if($prevent == 1){
                                                    $prevent = "true";
                                                }else{
                                                    $prevent = "false";
                                                }

                                                echo '
                                                <tr>
                                                    <td class="table-cell">'.$data['uuid'].'</td>
                                                    <td class="table-cell">'.$data['playerName'].'</td>
                                                    <td class="table-cell">'.$data['ip'].'</td>
                                                    <td class="table-cell">'.$prevent.'</td>
                                                    <td class="table-cell"><img src="https://crafatar.com/avatars/'.$data['uuid'].'?overlay&size=50"></td>
                                                </tr>
                                                ';                          
                                            }
                                        }else{
                                            echo 'error Player';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            if (!$detect->isMobile() ) {
                echo '<div class="col-1"></div>';
            }
        ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>