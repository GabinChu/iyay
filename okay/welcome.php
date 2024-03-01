<?php
session_start();

if (!isset($_SESSION['username'])){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Welcome - merctech</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            position: relative;
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
        }
    </style>
</head>
<body>
    <video autoplay loop muted id="background-video">
        <source src="images/Monkey.mp4" type="video/mp4">
    </video>
    <div class="container">
        <p>Hello</p>
        <?php echo "<h1>Welcome " . $_SESSION['lname'] . "</h1>"; ?>
        <a href="logout.php">Logout</a>
    </div>
    <script>
        // Synchronize audio with video
        var video = document.getElementById('background-video'); 

        video.addEventListener('timeupdate', function() {
            var audio = document.getElementById('background-audio');
            if (!audio.currentTime || audio.currentTime < video.currentTime || audio.currentTime >= video.currentTime + 0.5) {
                audio.currentTime = video.currentTime;
            }
        });
    </script>
</body>
</html>
