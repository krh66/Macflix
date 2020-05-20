<?php
require_once("includes/header.php");

//get id from URL
if(!isset($_GET["id"])){
    ErrorMessage::show("No ID passed into page");
}
$entityId = $_GET["id"];
$entity = new Entity($con, $entityId);

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($con, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainer = new categoryContainer($con, $userLoggedIn);
echo $categoryContainer->showCategory($entity->getCategoryId(), "You might also like");

?>