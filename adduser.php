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
        if($Role != "admin"){
            header('location: ./punishments');
            echo '
            <script>
                location.replace("./punishments");
                window.location.href = "./punishments"
            </script>
            ';
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
    <title>UltraPunishments - <?php echo $lang->adduser; ?></title>
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
        <a class="LeaveBtn" href="./"><i title="<?php echo $lang->back; ?>" class="fas fa-arrow-left"></i></a>
    </div>
    <div class="row no-gutters justify-content-center bannerrow">
        <div class="col-auto"><img class="img-fluid bannerimg" src="assets/img/banner.png">
            <div class="panel">
                <h3 class="h3custom">UltraPunishments&nbsp;v<?php echo $version; ?><br></h3><span class="madeby"><?php echo $lang->webaddonby; ?>&nbsp;<a href="https://www.spigotmc.org/members/eazyftw.55966/">EazyFTW</a>&nbsp;&amp;&nbsp;<a href="https://www.spigotmc.org/members/faab007.324536/">Faab007NL</a><br></span>
                <a href="./settings"><?php echo $lang->back; ?></a>
                <h2><?php echo $lang->adduser; ?></h2>
                <?php
                    if(isset($_SESSION['Error'])){
                        if($_SESSION['Error'] == "WrongUsernameOrPassword"){
                            echo 'Wrong Username Or Password';
                        }
                        $_SESSION['Error'] = "";
                    }
                ?>
                <form action="inc/server.php" method="post">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="<?php echo $lang->username; ?>" name="username" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="<?php echo $lang->password; ?>" name="password" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="role">
                          <option value="default"><?php echo $lang->default; ?></option>
                          <option value="admin"><?php echo $lang->admin; ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block btnsubmit" value="<?php echo $lang->done; ?>" name="adduser" type="submit"><?php echo $lang->done; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>