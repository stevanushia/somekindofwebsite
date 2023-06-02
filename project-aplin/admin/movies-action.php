<?php
use Hidehalo\Nanoid\Client;

if (isset($_POST["upload"]))
    {
        $title = $_POST["title"];
        $desc = $_POST["desc"];
        $age = $_POST["age"];
        $release = $_POST["releasedate"];
        $imdb = $_POST["imdb"];
        $vid = $_FILES["video_file"];
        $thumbnail = $_FILES["thumbnail_file"];
        $ts = $_FILES["ts_file"];
        $ts_count = count($ts["name"]);
        $score = $_POST["score"];
        
        if ($_FILES["video_file"]["size"] == 0) $vid = $_POST["video_link"] ?? "";
        if ($_FILES["thumbnail_file"]["size"] == 0) $thumbnailLink = $_POST["thumbnail_link"] ?? "";

        if ($title == "" || $desc == "" || $age == "" || $release == "" || $imdb == "" || $vid == "" || $ts_count == 0)
        {
            $_SESSION['msg'] = "Empty Fields";
            header("Location: movies-add.php");
        }
        else {
            if ($_FILES["video_file"]["size"] > 0)
            {
                $uploadOk = 1;
                $folder = Film::generateId();
                $targetDirectory = "movies/".$folder."/"; 
                mkdir("../admin/movies/$folder");
                $targetFile = $targetDirectory . basename($_FILES['video_file']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                if ($_FILES["video_file"]["size"] > 50000000) {
                    $_SESSION['msg'] = "File terlalu besar ".$_FILES['video_file']["size"];
                    header("Location: movies-add.php");
                    $uploadOk = 0;
                }
                
                if($imageFileType != "m3u8") {
                    $_SESSION['msg'] = "Hanya boleh file: .m3u8 ";
                    header("Location: movies-add.php");
                    $uploadOk = 0;
                }

                if ($uploadOk) {
                    $nanoid = new Client();
                    $name = $nanoid->generateId();
                    $ext = ".".explode(".",$_FILES['video_file']["name"])[1] ?? ".m3u8";
                    $name = $name . $ext;

                    $targetFile = $targetDirectory . $name;

                    $bool = move_uploaded_file($_FILES['video_file']['tmp_name'], $targetFile);

                    for($i=0; $i<$ts_count; $i++){
                        $filename = $ts['name'][$i];
                        move_uploaded_file($ts['tmp_name'][$i],$targetDirectory.$filename);
                    }

                    if ($bool)
                    {
                        $vid = $targetFile;
                    }
                    else {

                        $_SESSION["msg"] = "error : ".$targetFile." code : ".$_FILES['video_file']['error'];
                        header("Location: movies-add.php");
                        die();
                    }
                }
            }

            if ($_FILES["thumbnail_file"]["size"] > 0)
            {
                $uploadOk = 1;
                $targetDirectory = "thumbnail/"; 
                $targetFile = $targetDirectory . basename($_FILES['thumbnail_file']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                $image_info = getimagesize($_FILES['thumbnail_file']['tmp_name']);
                $image_width = $image_info[0];
                $image_height = $image_info[1];
                $aspect_ratio = $image_width / $image_height;

                if (abs($aspect_ratio - (16 / 9)) >= 0.01) {
                    $_SESSION['msg'] = "Resolusi tidak sesuai ".$aspect_ratio;
                    header("Location: movies-add.php");
                    die();
                    $uploadOk = 0;
                }
                if ($_FILES["thumbnail_file"]["size"] > 50000000) {
                    $_SESSION['msg'] = "File terlalu besar ".$_FILES['thumbnail_file']["size"];
                    header("Location: movies-add.php");
                    die();
                    $uploadOk = 0;
                }

                if ($_FILES["thumbnail_file"]["size"] > 50000000) {
                    $_SESSION['msg'] = "File terlalu besar ".$_FILES['thumbnail_file']["size"];
                    header("Location: movies-add.php");
                    die();
                    $uploadOk = 0;
                }
                
                if($imageFileType != "png" && $imageFileType != "jpg") {
                    $_SESSION['msg'] = "Hanya boleh file: png/jpg ";
                    header("Location: movies-add.php");
                    die();
                    $uploadOk = 0;
                }

                if ($uploadOk) {
                    $nanoid = new Client();
                    $name = $nanoid->generateId();
                    $ext = ".".explode(".",$_FILES['thumbnail_file']["name"])[1] ?? $imageFileType;
                    $name = $name . $ext;

                    $targetFile = $targetDirectory . $name;

                    $bool = move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $targetFile);
                    if ($bool)
                    {
                        $thumbnailLink = $targetFile;
                    }
                    else {

                        $_SESSION["msg"] = "error : ".$targetFile." code : ".$_FILES['thumbnail_file']['error'];
                        header("Location: movies-add.php");
                        die();
                    }
                }
            }

            Film::insert($title, $desc, $age, $release, $vid, $thumbnailLink, $imdb, $score);
            header("Location: movies.php");
        }
    }

    if (isset($_POST["update"]))
    {
        // $name = $_POST["name"];
        $id = $_POST["id"];
        $title = $_POST["title"];
        $desc = $_POST["desc"];
        $age = $_POST["age"];
        $release = $_POST["releasedate"];
        $imdb = $_POST["imdb"];
        $vid = $_FILES["video_file"];
        $thumbnail = $_FILES["thumbnail_file"];
        $ts = $_FILES["ts_file"] ?? "";
        $ts_count = count($ts["name"]);
        $score = $_POST["score"];
        
        if ($_FILES["video_file"]["size"] == 0) $vid = $_POST["video_link"] ?? "";
        if ($_FILES["thumbnail_file"]["size"] == 0) $thumbnailLink = $_POST["thumbnail_link"] ?? "";

        if ($title == "" || $desc == "" || $age == "" || $release == "" || $imdb == "" || $vid == "" || $ts_count == 0)
        {
            $_SESSION['msg'] = "Empty Fields";
            header("Location: movie-details.php?film=".$id);
        }
        else {
            if ($_FILES["video_file"]["size"] > 0)
            {
                $uploadOk = 1;
                $folder = Film::generateId();
                $targetDirectory = "movies/".$folder."/"; 
                mkdir("../admin/movies/$folder");
                $targetFile = $targetDirectory . basename($_FILES['video_file']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                if ($_FILES["video_file"]["size"] > 50000000) {
                    $_SESSION['msg'] = "File terlalu besar ".$_FILES['video_file']["size"];
                    header("Location: movie-details.php?film=".$id);
                    $uploadOk = 0;
                }
                
                if($imageFileType != "m3u8") {
                    $_SESSION['msg'] = "Hanya boleh file: .m3u8 ";
                    header("Location: movie-details.php?film=".$id);
                    $uploadOk = 0;
                }

                if ($uploadOk) {
                    $nanoid = new Client();
                    $name = $nanoid->generateId();
                    $ext = ".".explode(".",$_FILES['video_file']["name"])[1] ?? ".m3u8";
                    $name = $name . $ext;

                    $targetFile = $targetDirectory . $name;

                    $bool = move_uploaded_file($_FILES['video_file']['tmp_name'], $targetFile);

                    for($i=0; $i<$ts_count; $i++){
                        $filename = $ts['name'][$i];
                        move_uploaded_file($ts['tmp_name'][$i],$targetDirectory.$filename);
                    }

                    if ($bool)
                    {
                        $vid = $targetFile;
                    }
                    else {

                        $_SESSION["msg"] = "error : ".$targetFile." code : ".$_FILES['video_file']['error'];
                        header("Location: movie-details.php?film=".$id);
                        die();
                    }
                }
            }

            if ($_FILES["thumbnail_file"]["size"] > 0)
            {
                $uploadOk = 1;
                $targetDirectory = "thumbnail/"; 
                $targetFile = $targetDirectory . basename($_FILES['thumbnail_file']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                $image_info = getimagesize($_FILES['thumbnail_file']['tmp_name']);
                $image_width = $image_info[0];
                $image_height = $image_info[1];
                $aspect_ratio = $image_width / $image_height;

                if (abs($aspect_ratio - (16 / 9)) >= 0.01) {
                    $_SESSION['msg'] = "Resolusi tidak sesuai ".$aspect_ratio;
                    header("Location: movie-details.php?film=".$id);
                    die();
                    $uploadOk = 0;
                }
                if ($_FILES["thumbnail_file"]["size"] > 50000000) {
                    $_SESSION['msg'] = "File terlalu besar ".$_FILES['thumbnail_file']["size"];
                    header("Location: movie-details.php?film=".$id);
                    die();
                    $uploadOk = 0;
                }

                if ($_FILES["thumbnail_file"]["size"] > 50000000) {
                    $_SESSION['msg'] = "File terlalu besar ".$_FILES['thumbnail_file']["size"];
                    header("Location: movie-details.php?film=".$id);
                    die();
                    $uploadOk = 0;
                }
                
                if($imageFileType != "png" && $imageFileType != "jpg") {
                    $_SESSION['msg'] = "Hanya boleh file: png/jpg ";
                    header("Location: movie-details.php?film=".$id);
                    die();
                    $uploadOk = 0;
                }

                if ($uploadOk) {
                    $nanoid = new Client();
                    $name = $nanoid->generateId();
                    $ext = ".".explode(".",$_FILES['thumbnail_file']["name"])[1] ?? $imageFileType;
                    $name = $name . $ext;

                    $targetFile = $targetDirectory . $name;

                    $bool = move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $targetFile);
                    if ($bool)
                    {
                        $thumbnailLink = $targetFile;
                    }
                    else {
                        $_SESSION["msg"] = " error : ".$targetFile." code : ".$_FILES['thumbnail_file']['error'];
                        header("Location: movie-details.php?film=".$id);
                        die();
                    }
                }
            }
            // var_dump($title);
            Film::update($id,$title,$desc,$age,$release,$vid,$thumbnailLink,$imdb,$score);
            $_SESSION["success"] = "hehe";
            header("Location: movie-details.php?film=".$id);
        }
    }

    if (isset($_POST["delete"]))
    {  
        $id_delete = $_POST["id_delete"];
        $dirPath = base_path() . '/admin/movies/'.$id_delete;

        $film = Film::getFromId($id_delete);
        $dirFolder = substr($film["link"], 7, 6);
        if ($dirFolder != $id_delete)
        {
            Film::delete($id_delete);
            header("Location: movies.php");
            die();
        }

        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
        
        Film::delete($id_delete);
        header("Location: movies.php");
    }
