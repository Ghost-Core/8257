<?php
    if(!isset($_SESSION) || empty($_SESSION)){
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="Contents/css/bootstrap.css">
    <link rel="stylesheet" href="Contents/AlgCss/Site.css">
</head>
<body>
    <nav class="navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" style="padding: 10px;">
                <img style="height: 100%;" src="Contents/img/AC.png">
            </a>
        </div>
        <div class="container-fluid">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?=(strpos($_SERVER["REQUEST_URI"],"Index.php") || substr($_SERVER["REQUEST_URI"], -1, 1)=="/") ? 'class="active"' : ''?>><a href="Index.php">Home</a></li>
                    <li <?=strpos($_SERVER["REQUEST_URI"],"courseselection.php") ? 'class="active"' : ''?>><a href="courseselection.php">Course Selection</a></li>
                    <li <?=strpos($_SERVER["REQUEST_URI"],"CurrentRegistration.php") ? 'class="active"' : ''?>><a href="CurrentRegistration.php">Current Registration</a></li>
                    <?php               
                    if ($_SESSION['studentIdTxt'] == "") 
                    {?>
                        <li <?=strpos($_SERVER["REQUEST_URI"],"login.php") ? 'class="active"' : ''?>><a href='Login.php'>Login</a></li>
                    <?php }
                    else 
                    { ?>
                       <li <?=strpos($_SERVER["REQUEST_URI"],"logout.php") ? 'class="active"' : ''?>><a href='Logout.php'>Log Out</a></li>
                    <?php }   
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
