<?php
    $film = Film::getFromId($_GET["film"]);
    $token = Film::generateToken("admin", $film["id"]);
    $link = "../admin/".$film["link"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@videojs/http-streaming@3.3.0/dist/videojs-http-streaming.min.js"></script>
</head>
<style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        #my-video {
            width: 100%;
            height: 100%;
        }
        /* Custom styles for the sleek skin */
        .vjs-sleek-skin .vjs-control-bar {
        background-color: #202020;
        }

        .vjs-sleek-skin .vjs-slider {
            background-color: #909090;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-play-progress,
        .vjs-sleek-skin .vjs-load-progress {
            background-color: #f2f2f2;
        }

        .vjs-sleek-skin .vjs-play-progress {
            height: 8px;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-load-progress {
            height: 4px;
            border-radius: 2px;
        }

        .vjs-sleek-skin .vjs-volume-bar {
            background-color: #909090;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-volume-level {
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-mute-control,
        .vjs-sleek-skin .vjs-volume-menu-button {
        color: #f2f2f2;
        }

        .vjs-sleek-skin .vjs-big-play-button {
            /* color: #f2f2f2; */
            /* background-color: rgba(0, 0, 0, 0.5); */
            /* border-radius: 50%; */
            border: none;
            height: 80px;
            width: 80px;
            margin: auto;
            margin-left: 50vw;
            margin-top: 50vh;
            font-size: 48px;
            line-height: 80px;
            text-align: center;
        }

        .vjs-sleek-skin .vjs-big-play-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .vjs-sleek-skin .vjs-control-bar .vjs-current-time,
        .vjs-sleek-skin .vjs-control-bar .vjs-duration {
            color: #f2f2f2;
        }

    </style>
<body>
    
</body>
</html>

<video id="my-video" class="video-js vjs-default-skin vjs-sleek-skin" controls preload="auto" width="1920" height="1080" data-setup='{"plugins":{"httpStreaming":{"beforeRequest": function(options) {options.headers = options.headers || {};options.headers.Authorization = "admin";}}}}'>
        <source src="<?= $link ?>" type="application/x-mpegURL">
</video>