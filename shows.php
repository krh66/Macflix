<?php
require_once("includes/header.php");

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createTVShowPreviewVideo(null);

$containers = new CategoryContainer($con, $userLoggedIn);
echo $containers->showTVShowsCategory();
?>

