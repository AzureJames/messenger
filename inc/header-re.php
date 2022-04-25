<?php include ("connect.php"); 
session_start();

if(isset($_GET['theme'])){
    $_SESSION['theme'] = $_GET['theme'];

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Messaging site">
    <meta name="author" content="Azure James">
    <meta http-equiv="refresh" content="2" > 
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>css/style.css"/> 
    <title>Azuur Messenger</title>
</head>
    <header class="<?php if(isset($_SESSION['theme'])){echo $_SESSION['theme'];}?>">
        <div class="container">
            <a href="index.php">azuur messenger</a>
            <nav>
                <ul role="list" class="list">
                    <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                    <?php if (!isset($_SESSION['a-unique-catbb-thingyyy'])): ?>
                    <li><a href="<?php echo BASE_URL; ?>inc/admin-login.php">Login</a></li>
                    <li><a href="<?php echo BASE_URL; ?>register.php">Register</a></li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['a-unique-catbb-thingyyy'])): ?>
                        <li><a href="<?php echo BASE_URL; ?>friends.php">Friends</a></li> 
                        <li><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
        <div class="container flex theme">
            <p>theme:</p>
            <a href="<?php echo strtok($_SERVER['REQUEST_URI']);?>?theme=normal">normal</a>
            <a href="<?php echo strtok($_SERVER['REQUEST_URI']);?>?theme=blue">blue</a>
            <a href="<?php echo strtok($_SERVER['REQUEST_URI']);?>?theme=kawaii">kawaii</a>
        </div>
    </header>
<body>
    <main class="<?php if(isset($_SESSION['theme'])){echo $_SESSION['theme'];}?>">
        <div class="container">