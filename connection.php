<?php
    $con = mysqli_connection('localhost:3306', 'slasherf_login', '^+=[Fff)aVIx', 'slasherf_macflix');

    if(!$con){
        die('Please check you connection'.mysqli_error($con));
    }


?>