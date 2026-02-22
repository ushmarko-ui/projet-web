<?php
// Si le formulaire est envoyé
if (isset($_POST['new_description'])) {
    $description = $_POST['new_description'];
} else {
    // Description par défaut
    $description = "Ceci est la description actuelle.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier description</title>
</head>
<body>

    <p><?php echo $description; ?></p>

    <form method="POST">
        <textarea name="new_description" rows="4" cols="40"><?php echo $description; ?></textarea>
        <br><br>
        <button type="submit">Enregistrer</button>
    </form>

</body>
</html>
