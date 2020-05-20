<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])) {
    $query =  $con->prepare("SELECT * FROM videoProgress 
                             WHERE videoId=:videoId AND username=:username");
    $query->bindValue(":videoId",$_POST["videoId"]);
    $query->bindValue(":username",$_POST["username"]);
    $query->execute();

    if($query->rowCount() == 0){
        
        $query = $con->prepare("INSERT INTO videoProgress (username, videoId)
                                VALUES(:username, :videoId)");
        $query->bindValue(":videoId",$_POST["videoId"]);
        $query->bindValue(":username",$_POST["username"]);
        $query->execute();
    }
}
else {
    echo "No videoId or username passed into file";
}

?>