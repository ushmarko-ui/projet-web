
<?php
$cookiesAccepted = isset($_COOKIE['cookiesAccepted']) && $_COOKIE['cookiesAccepted'] === 'true';
if (isset($_POST['accept_cookies'])) {
    setcookie('cookiesAccepted', 'true', time() + (365*24*60*60), "/");
    $cookiesAccepted = true;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  var cookieModalEl = document.getElementById('cookieModal');
  if (cookieModalEl) {
    var cookieModal = new bootstrap.Modal(cookieModalEl);
    cookieModal.show();
  }
});
</script>