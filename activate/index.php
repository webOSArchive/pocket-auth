<?php
session_start();
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    session_unset();
    session_destroy();
    session_start();
}
// either new or old, it should live at most for 30 minutes
$_SESSION['discard_after'] = $now + 1800;

if (isset($_SESSION["attempts"])) {
    $_SESSION["attempts"] = $_SESSION["attempts"] + 1;
} else {
    $_SESSION["attempts"] = 0;
}
$docRoot="../";
include ($docRoot . "config.php");
include ($docRoot . "inc/header.php");
?>
<html>
<head>
<title>Pocket for webOS Activation</title>
</head>
<body>
    <?php
        if ($_SESSION["attempts"] <= $maxAttempts) {
    ?>
    <div align="center">
        <form action="../pocket-auth-1.php" method="POST">
            <b>Enter the activation code from your webOS device</b>
            <p><input type="text" name="activationCode" id="activationCode"></p>
            <p><input type="submit" name="btnPocketAuth" id="btnPocketAuth" value="Login to Pocket"></p>
        </form>
    </div>
    <?php
        } else {
            echo "<p align='middle'>Too many attempts (" . $_SESSION["attempts"] . "/" . $maxAttempts . ") Try again later!</p>";
        }
    ?>
</body>
</html>