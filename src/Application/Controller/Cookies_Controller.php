
<?php
$cookiesAccepted = isset($_COOKIE['cookiesAccepted']) && $_COOKIE['cookiesAccepted'] === 'true';
if (isset($_POST['accept_cookies'])) {
    setcookie('cookiesAccepted', 'true', time() + (365*24*60*60), "/");
    $cookiesAccepted = true;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>