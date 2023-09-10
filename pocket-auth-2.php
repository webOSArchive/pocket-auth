<?php
$docRoot = "./";
include($docRoot . "config.php");
include($docRoot . "common.php");
$hostRoot = findHostRoot();
spl_autoload_register(function($classes){
  include 'classes/'.$classes.".php";
});
$cache = new Cache();
require __DIR__ . '/vendor/autoload.php';
$params = array(
	'consumerKey' => $apiKey
);
if (empty($params['consumerKey'])) {
	diePretty('Server configuration file missing Pocket App Consumer Key');
}
$pocket = new Pocket($params);
debugEcho("<i>Requesting Token Conversion: </i><br>\n" . $_SESSION['request_token'] . "<br>\n");
$pocket_response = $pocket->convertToken($_SESSION['request_token']);
debugEcho ("\n<br>");
debugEcho ("<i>Pocket Response:</i><br>\n");
debugEcho (json_encode($pocket_response));
debugEcho ("\n<br>");

if (isset($pocket_response['access_token']) && isset($pocket_response['username'])) {
    debugEcho ("<br><i>Access token for activation code " . $_SESSION['activation_code'] . " is: </i>" . $pocket_response['access_token'] . "<br>");
    $_SESSION['username'] = $pocket_response['username'];
    $_SESSION['access_token'] = $pocket_response['access_token'];
    if ($cache->updateLoginCache($_SESSION['activation_code'], $cachePath, $pocket_response['username'], $pocket_response['access_token'])) {
      
      if ($debugMode) {
        succeedPretty("<i>Logged in!</i><br/><br/>Now press the <a href='check-code.php?code=" . $_SESSION['activation_code'] . "'>Verify</a> button on your webOS device.");
        echo "<p align='center'><a href='list-articles.php?token=" . $pocket_response['access_token'] . "'>List Articles</a></p>";
      } else {
        succeedPretty("<i>Logged in!</i><br/><br/>Now press the <b>Verify</b> button on your webOS device!<br><br>");
      }
        
    } else {
      diePretty("ERROR updating login cache!");
    }
}

?>