<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
const NEWLINE = '<br /><br />';

function findHostRoot() {
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $protocol = "https://";
    else
        $protocol = "http://";
    $thisFile = $_SERVER['REQUEST_URI'];
    $thisFile = substr($thisFile, strrpos("/$thisFile", '/'));
    $hostRoot = str_replace($thisFile, "", $_SERVER['REQUEST_URI']);
    $hostRoot = $protocol . $_SERVER['HTTP_HOST'] . $hostRoot;
    return $hostRoot;
}

function debugEcho($msg) {
    global $debugMode;
    if (isset($debugMode) && $debugMode == true) {
        echo $msg;
    }
}

function diePretty($msg) {
    global $docRoot;
    global $appTitle;
    include ($docRoot . "inc/header.php");
    echo "<p align='center'><b>Error</b>:" . $msg . "</p>";
    include ($docRoot . "inc/footer.php");
}

function succeedPretty($msg) {
    global $docRoot;
    global $appTitle;
    include ($docRoot . "inc/header.php");
    echo "<p align='center'>" . $msg . "</p>";
    include ($docRoot . "inc/footer.php");
}
?>