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
                    if($Role != "admin"){
                        header('location: ./punishments');
                        echo '
                        <script>
                            location.replace("./punishments");
                            window.location.href = "./punishments"
                        </script>
                        ';
                    }
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
    <title>UltraPunishments - <?php echo $lang->settings; ?></title>
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
    <div class="LeaveBtnDiv">
        <a class="LeaveBtn" href="./inc/logout.php"><i title="<?php echo $lang->signout; ?>" class="fas fa-sign-out-alt"></i></a>
    </div>
    <div class="row no-gutters justify-content-center bannerrow">
        <div class="col-auto"><img class="img-fluid bannerimg" src="assets/img/banner.png"></div>
    </div>
    <div class="row no-gutters justify-content-center">
        <?php 
            if (!$detect->isMobile() ) {
                echo '<div class="col-1"></div>';
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
                            <li class="tab-item" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./punishments"><?php echo $lang->punishments; ?></a></li>
                            <li class="tab-item" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./warnings"><?php echo $lang->warnings; ?></a></li>
                            <li class="tab-item" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./users"><?php echo $lang->users; ?></a></li>
                            <li class="tab-item" style="border-bottom: solid 1px #e7e9ed;"><a class="link" href="./reports"><?php echo $lang->reports; ?></a></li>
                            <li class="tab-item active" style="border-bottom: solid 1px #f77727;color:#f77727;"><a class="link" href="./settings" style="color:#f77727;"><?php echo $lang->settings; ?></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <h2><?php echo $lang->welcome; ?> <?php echo $username; ?></h2>
                        <?php 
                            $newUpdate = CheckForUpdates(); 

                            if($newUpdate == true){
                                $newVersion = GetNewVersion();
                                echo '
                                    <hr>
                                    <h2>Version <strong>'.$newVersion.'</strong> is out!</h2>
                                    <a class="btn btn-primary" style="color:white;" type="button" target="_blank" href="https://www.spigotmc.org/resources/web-addon-ultrapunishments.83478/">Download And Update Now</a>
                                ';
                            }
                        ?>
                        <hr>
                        <h2><?php echo $lang->languagesettings; ?></h2>
                        <form style="width: 285px;margin:auto;" class="form form-inline" action="inc/server.php" method="post">
                            <div class="form-group">
                                <select class="form-control" name="lang" style="width: 200px;margin-right:5px;">
                                    <?php
                                        $files = glob('inc/languages/*.json', GLOB_BRACE);
                                        foreach($files as $file) {
                                            $file = str_replace("inc/languages/", "", $file);
                                            $file = str_replace(".json", "", $file);
                                            if($file !== "blank"){
                                                $filelang = file_get_contents('./inc/languages/'.$file.'.json');
                                                $filelang = json_decode($filelang);
                                                if($file == $language){
                                                    echo '<option value="'.$file.'" selected="">'.$filelang->langname.'</option>';  
                                                }else{
                                                    echo '<option value="'.$file.'">'.$filelang->langname.'</option>';  
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button style="width: 80px;" class="btn btn-primary btn-block btnsubmit" value="<?php echo $lang->done; ?>" name="updatelang" type="submit"><?php echo $lang->done; ?></button>
                            </div>
                        </form>
                        <hr>
                        <h2><?php echo $lang->users; ?></h2>
                        <a class="btn btn-primary" role="button" style="margin-bottom: 10px;" href="./adduser"><?php echo $lang->adduser; ?></a>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="table-header-cell"><?php echo $lang->userid; ?><br></th>
                                        <th class="table-header-cell"><?php echo $lang->username; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->role; ?></th>
                                        <th class="table-header-cell"><?php echo $lang->actions; ?></th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <?php
                                        $pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users");
                                        $pdoExec = $pdoResult->execute();
                                        
                                        if($pdoExec){
                                            while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                                                $UId = $row['Id'];
                                                $username = $row['Username'];
                                                $role = $row['Role'];
                                                
                                                if($role == "admin"){
                                                    $role == $lang->admin;
                                                }elseif($role == "default"){
                                                    $role == $lang->default;
                                                }
                                                
                                                if($UserId == $UId){
                                                    echo '
                                                        <tr>
                                                            <td class="table-cell">'.$UId.'</td>
                                                            <td class="table-cell">'.$username.'</td>
                                                            <td class="table-cell">'.$role.'</td>
                                                            <td class="table-cell">'.$lang->none.'</td>
                                                        </tr>
                                                    ';
                                                }else{
                                                    echo '
                                                        <tr>
                                                            <td class="table-cell">'.$UId.'</td>
                                                            <td class="table-cell">'.$username.'</td>
                                                            <td class="table-cell">'.$role.'</td>
                                                            <td class="table-cell"><a class="btn btn-primary" style="color:white;" type="button" href="inc/server.php?methode=deleteuser&UId='.$UId.'">'.$lang->delete.'</a></td>
                                                        </tr>
                                                    ';
                                                }
                                            }
                                        }else{
                                            echo 'Something has gone wrong';
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