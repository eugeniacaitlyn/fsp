<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project FSP</title>
    <link rel="stylesheet" href="css/navbar.css?v=1">
    <style>
        html, body{
            height: 100vh;
            width: 100%;
            margin:0;
        }
        body{
            background: url(images/backgroundHome.png) ;
            background-size: cover; 
            background-position: top; 
            background-attachment: scroll; 
            background-repeat: no-repeat; 
            margin: 0; 
            padding: 0;
            overflow-x: hidden;
            background-color: #0D212a;
            color:white;
        }
        .isi{
            display:block;
        }
        .welcome{
            color:white;
            text-align:center;
            font-size: 48px;
            margin:-60px;
        }
        .header{
            font-weight:bold;
            font-size:120px !important;
        }
        .isi-welcome{
            margin-top:300px;
        }
        .isi-club{
            margin-top:30px;
        }
    </style>
</head>
<body>
    <?php
        include('navbar.php');
    ?>
    <div class="isi">
        <div class="isi-welcome">
            <p class="welcome">WELCOME TO</p>
        </div>
        <div class="isi-club">
            <p class="welcome header">CLUB</p>
            <p class="welcome header">INFORMATICS</p>
        </div>
    </div>
</body>
</html>