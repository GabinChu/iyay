<?php 
include 'config.php';
session_start();
error_reporting(0);

/*Check whether there's any session active */
if (isset($_SESSION['username'])){
    header("location: aaa.php");
}
if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $passwords = md5($_POST['passwords']); #md5 will convert password to strings in the database
    $sql = "SELECT * FROM users WHERE email = '$email' AND passwords ='$passwords'";
    $result=mysqli_query($conn, $sql);

    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: aaa.php");
    }  else{
        echo "<script>alert('Whoops ! Email or Password is Wrong.')</script>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form - merctech Technologies LTD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">   
    <link href="css/style.css" rel="stylesheet">
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
            max-width: 400px;
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
    <audio autoplay loop id="background-audio">
        <source src="ass/login/AUDIO/monkey.mp3" type="audio/mpeg">
    </audio>
    <div class="container"> 
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">
                Login
            </p>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="passwords" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn"> Login </button>
            </div>
            <p class="login-register-text"> Don't have an account? <a href="register.php">Register Here </a> . </p>
        </form>         
    </div>
    
    <script>
        // Synchronize audio with video
        var video = document.getElementById('background-video'); 
        var audio = document.getElementById('background-audio');

        video.addEventListener('timeupdate', function() {
            if (!audio.currentTime || audio.currentTime < video.currentTime || audio.currentTime >= video.currentTime + 0.5) {
                audio.currentTime = video.currentTime;
            }
        });

        video.addEventListener('play', function() {
            audio.play();
        });

        video.addEventListener('pause', function() {
            audio.pause();
        });
    </script>
</body>
</html>
