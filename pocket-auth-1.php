<?php
$docRoot = "./";
include($docRoot . "config.php");
include($docRoot . "common.php");
$hostRoot = findHostRoot();
require __DIR__ . '/vendor/autoload.php';
$params = array(
	'consumerKey' => $apiKey
);
if (empty($params['consumerKey'])) {
	diePretty('Server configuration file missing Pocket App Consumer Key');
}
$pocket = new Pocket($params);

if (isset($_POST["activationCode"])) {
  $useCode = strtoupper($_POST["activationCode"]);
  if (is_file($cachePath . $useCode . ".json")) {
    $_SESSION['activation_code'] = $useCode;

    debugEcho ("<i>Sending auth request to Pocket for " . $_SESSION['activation_code'] . "</i><br>\n");
    $pocket_response = $pocket->requestToken($hostRoot . "pocket-auth-2.php");
    debugEcho ("\n<br><br>");
    debugEcho ("<i>Pocket Response:</i><br>\n");
    debugEcho (json_encode($pocket_response));
    debugEcho ("\n<br>");

    $_SESSION['request_token'] = $pocket_response['request_token'];
    debugEcho ("<br><a href='" . $pocket_response['redirect_uri'] . "'>Login</a>");
    debugEcho ("<br><i>Code will be: </i>" . $_SESSION['request_token'] . "<br>");
    if (!$debugMode) {
      header('Location: '. $pocket_response['redirect_uri']);
    }

  } else {
    error_log("Pocket auth service could not find requested activation code cache file at: " . $cachePath . $useCode . ".json");
    diePretty("Unknown activation code provided!<br>Get a code from your webOS device, then <a href='activate/index.php'>Try Again</a>");
  }
} else {
  diePretty("No Activation code provided!<br>Get a code from your webOS device, then <a href='activate/'>Try Again</a>");
}
?>