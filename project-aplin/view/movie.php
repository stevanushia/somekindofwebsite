<?php
    if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo "<script>alert('$msg')</script>";
    }
    
    if (!isset($_SESSION["logged"])) 
    {
        
        $_SESSION["msg"] = "Belum Login";
        header("Location: ../view/login.php");
    }

    $user = $_SESSION["logged"];
    if (Users::checkSubscription($user["id"])){
        if (!isset($_GET["film"])) header("Location: ../view/index.php");

        $film = Film::getFromId($_GET["film"]);
        $token = Film::generateToken($user["id"], $film["id"]);
        $link = "../admin/".$film["link"];

        $year = " (" . substr($film['release_date'],0,4) . ")";
        $title = $film['title'].$year;
    }
    else{
        header("Location: payment.php");
    }  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
    <link href="./css/video-player.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@videojs/http-streaming@3.3.0/dist/videojs-http-streaming.min.js"></script>
</head>
<body>
    <video id="my-video" class="video-js vjs-default-skin vjs-sleek-skin" controls preload="auto" width="1920" height="1080" data-setup='{"plugins":{"httpStreaming":{"beforeRequest": function(options) {options.headers = options.headers || {};options.headers.Authorization = "<?= $token ?>";}}}}'>
        <source src="<?= $link ?>" type="application/x-mpegURL">
    </video>
    <?php
        if (Users::checkSubscription($user["id"])){
            $getHistory = History::getByUsersFilm($user["id"], $film["id"]);
            $current_time = 0;
            if (!$getHistory)
            {
                History::insert($user["id"], $film["id"], 0, 0);
            }
            else {
                $current_time = $getHistory["timestamp"];
            }
        }
        
    ?>
    <script>
        var player = videojs('my-video');
        document.addEventListener('DOMContentLoaded', function() {
            var video = document.getElementById('my-video');
            video.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
        });
    </script>
        <?php
            echo "
                <script>
                videojs.getPlayer('my-video').currentTime($current_time);
                window.addEventListener('beforeunload', function() {
                    var current_time = videojs.getPlayer('my-video').currentTime();
                    var duration = videojs.getPlayer('my-video').duration();

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'update_timestamp.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.send('timestamp='+current_time+'&id={$getHistory['id']}&duration='+duration);

                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log('Timestamp updated successfully.');
                        }
                    };
                });
                </script>"
                ;
        ?>
</body>
</html> 