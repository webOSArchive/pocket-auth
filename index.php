<?php
$docRoot = "./";
include($docRoot . "config.php");
include($docRoot . "common.php");
echo file_get_contents("https://www.webosarchive.org/app-template/header.php?docRoot=" . $docRoot . "&appTitle=" . $appTitle);
?>
<p align="middle">Pocket is back on webOS! You'll need an app for your device to get started.</p>
<p align="middle">Check out <a href="<?php echo $REQUEST_PROTOCOL; ?>://appcatalog.webosarchive.org/app/ReadOnTouchPRO3.0">ReadOnTouch Pro</a> in the App Museum!</p>
<?php
include($docRoot . "inc/footer.php");
?>