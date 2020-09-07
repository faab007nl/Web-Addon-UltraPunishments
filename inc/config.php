<?php

/* ------------------------------------------------------------------------ */
//MYSQL//
  
if(file_exists("./inc/dbconfig.php") && file_exists("./inc/users.json")){
  include './inc/dbconfig.php';
  
  $hostname = $dbhostname;
  $database = $dbdatabase;
  $username = $dbusername;
  $password = $dbpassword;
}else{
  header('location: ./setup');
  echo '
  <script>
    location.replace("./setup");
    window.location.href = "./setup"
  </script>
  ';
}

$configjson = file_get_contents('./inc/config.json');
$configjson = json_decode($configjson);

// Web Addon Version
$version = $configjson->version;
$language = $configjson->language;
?>