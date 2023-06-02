<?php 
session_start();
/**
 * Return realpath(__DIR__."/../");
 */
function base_path() : string
{
    return realpath(__DIR__."/../");
}

function load_config()
{
    $filesConfig = scandir(base_path()."/config");
    foreach ($filesConfig as $value) {
        if (substr($value, -4) == ".php")
        {
            require_once(base_path()."/config/".$value);
        }
    }
}

function load_library(array $files)
{
    foreach ($files as $value) {
        if (substr($value, -4) == ".php")
        {
            require_once(base_path()."/library/".$value);
        }
    }
}

function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

load_config();

if (realpath(base_path()."/vendor/autoload.php") !== false)
{
    require_once base_path()."/vendor/autoload.php";
}

function base_url(string $path) : string
{
    return "http://mhs.sib.stts.edu/k1video-ondemand$path";
}

function set_message($type, $message) : void
{
    if (!isset($_SESSION["msg"])) $_SESSION["msg"] = [];
    $_SESSION['msg'][] = [
        "type" => $type,
        "message" => $message
    ];
}

function show_message()
{
    if (!isset($_SESSION["msg"])) $_SESSION["msg"] = [];
    foreach ($_SESSION["msg"] as $m)
    {
        echo "<div class='alert alert-{$m['type']}'>
            {$m['message']}
            </div>
        ";
    }
    $_SESSION["msg"] = null; unset($_SESSION["msg"]);
}
