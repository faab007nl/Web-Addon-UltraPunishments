<?php
    include 'inc/functions.php';
    include 'inc/server.php';
    require_once "inc/Mobile_Detect.php";

    $detect = new Mobile_Detect;    
    if(isset($_SESSION['UserId'])){
        $UserId = $_SESSION['UserId'];
        $pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Id=:Id LIMIT 1");
        $pdoExec = $pdoResult->execute(array(":Id"=>$UserId));
        $rowcount = $pdoResult->rowCount();
        
        if($pdoExec){
            if($rowcount != 0){
                while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    $username = $row['Username'];
                    $Role = $row['Role'];
                }
            }
        }else{
            echo '
            <div style="background-color: rgba(255,0,0,0.6); position: absolute; top: 0px; left: 0px; bottom:0px; right: 0px; z-index: 5000; cursor: wait;">
                <div style="position: absolute;top: 25%; left: 10%;font-size: 50px; width:80%; color: white;">
                    <p style="text-align: center;">Can`t connect to DataBase<br/>Please check the dbconfig.php file</p>
                </div>
            </div>';
        }
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
    <title>UltraPunishments - <?php echo $lang->reports; ?></title>
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
                            <li class="tab-item active" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./users"><?php echo $lang->users; ?></a></li>
                            <li class="tab-item active" style="border-bottom: solid 1px #f77727;"><a style="color:#f77727;" class="link" href="./reports"><?php echo $lang->reports; ?></a></li>
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
                                        <th class="table-header-cell"><?php echo $lang->target; ?><br></th>
                                        <th class="table-header-cell"><?php echo $lang->issuer; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->server; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->time; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->message; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->evidence; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->closed; ?></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <?php
                            
                                        $pdoResult1 = $PDOdb->prepare("SELECT * FROM UltraPunishments_Reports ORDER BY UltraPunishments_Reports.key DESC");
                                        $pdoExec1 =  $pdoResult1->execute();

                                        if($pdoExec1){
                                            while($row1 = $pdoResult1->fetch(PDO::FETCH_ASSOC)){
                                                $data = base64_decode($row1['value']);
                                                $data = json_decode($data, true);
                                                $target = $data['target'];
                                                $issuer = $data['issuer'];
                                                
                                                $pdoResult2 = $PDOdb->prepare("SELECT * FROM UltraPunishments_PlayerIndexes");
                                                $pdoExec2 =  $pdoResult2->execute();

                                                if($pdoExec2){
                                                    while($row2 = $pdoResult2->fetch(PDO::FETCH_ASSOC)){
                                                        if($row2['key'] == $target){
                                                            $targetdata = base64_decode($row2['value']);
                                                            $targetdata = json_decode($targetdata, true);
                                                        }

                                                        if($row2['key'] == $issuer){
                                                            $issuerdata = base64_decode($row2['value']);
                                                            $issuerdata = json_decode($issuerdata, true);

                                                        }
                                                        
                                                    }
                                                }else{
                                                    echo 'error Player';
                                                }

                                                $closed = $data['closed'];
                                                if($closed == '1'){
                                                    $closed = "true";
                                                }else{
                                                    $closed = "false";  
                                                }
                                                $evidence = $data['evidence'];
                                                if(empty($evidence)){
                                                    $evidence = "None";
                                                }

                                                echo '
                                                <tr>
                                                    <td class="table-cell"><img src="https://crafatar.com/avatars/'.$targetdata['uuid'].'?overlay&size=20">'.$targetdata['playerName'].'</td>
                                                    <td class="table-cell"><img src="https://crafatar.com/avatars/'.$issuerdata['uuid'].'?overlay&size=20">
                                                        '.$issuerdata['playerName'].'</td>
                                                    <td class="table-cell">'.$data['server'].'</td>
                                                    <td class="table-cell">'.date("Y-m-d h:i:s A", $data['time']).'</td>
                                                    <td class="table-cell">'.$data['message'].'</td>
                                                    <td class="table-cell">'.$evidence.'</td>
                                                    <td class="table-cell">'.$closed.'</td>
                                                </tr>
                                                ';
                                            }
                                        }else{
                                            echo 'Error Warnings';
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