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
include ($docRoot . "common.php");
echo file_get_contents("https://www.webosarchive.org/app-template/header.php?docRoot=" . $docRoot . "&appTitle=" . $appTitle . "&protocol=" . findProtocol());
?>
<?php
    if ($_SESSION["attempts"] <= $maxAttempts) {
?>
<script>
window.addEventListener('load', function() {
    document.getElementById("activationCode").focus();
});
</script>
<div align="center">
    <form action="../pocket-auth-1.php" method="POST">
        <b>Enter the activation code from your webOS device</b>
        <p><input type="text" name="activationCode" id="activationCode" style="text-align: center;font-size: larger;text-transform: uppercase;"></p>
        <p><input type="submit" name="btnPocketAuth" id="btnPocketAuth" value="Login to Pocket"></p>
    </form>
</div>
<?php
    } else {
        echo "<p align='middle'>Too many attempts (" . $_SESSION["attempts"] . "/" . $maxAttempts . ") Try again later!</p>";
    }
?>
