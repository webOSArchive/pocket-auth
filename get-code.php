<?php
include("config.php");
include("common.php");
spl_autoload_register(function($classes){
    include 'classes/'.$classes.".php";
  });
$cache = new Cache();

header('Content-type: application/json; charset=utf-8');

if ($cache->cleanUp($cachePath)) {
    $useCode = generateUniqueCode(5, $cachePath);
} else {
    die("{\"error\":\"Unable to perform code management due to server error.\"}");
}
if ($useCode) {
    $codeObj = new stdClass;
    $codeObj->code = $useCode;
    $codeObj->useUrl = $useUrl . "activate";
    
    if ($cache->createLoginCache($codeObj, $cachePath)) {
        echo json_encode($codeObj);
    } else {
        die("{\"error\":\"Unable to generate code due to server error.\"}");
    }    
} else {
    die("{\"error\":\"Unable to read codes due to server error.\"}");
}

function generateUniqueCode($length, $cachePath) {
    $useCode = "";
    do {
        $useCode = generateCode($length);
    } while (is_file($cachePath . $useCode . ".json"));
    return $useCode;    
}
function generateCode($length) {
    $characters = 'BCDFGHJKLMNPQRSTUVWXZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>