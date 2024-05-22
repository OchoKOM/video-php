<?php
require_once('upload.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video php</title>
</head>

<body>
    <?php
    // Verifier les messages
    if (isset($msg)) {
        echo "" . $msg . "";
    }
    ?>
    <form method="post" enctype="multipart/form-data">
        <label for="video">Sélectionnez une vidéo à télécharger:</label>
        <input type="file" name="video" id="video" accept="video/*" required>
        <input type="submit" value="Télécharger la vidéo" name="submit">
    </form>
    <div class="videos">
        <h2>Toutes les videos enregistres seront affiches ici</h2>
        <?php
        // Affichage des vidéos
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <span class="video">
                    <video width="320" height="240" controls>
                        <source src="<?= $row['path'] ?>" type="<?= $row['type'] ?>">
                        "Votre navigateur ne prend pas en charge la lecture de vidéos."
                    </video>
                    <h3>Nom: <?= $row['name'] ?></h3>
                    <p>Taille: <?= $row['size'] ?> octets</p>
                    <p>Type: <?= $row['type'] ?></p>
                    <p>Date de téléchargement: <?= $row['uploaded_at'] ?></p>
                </span>
            <?php
        }
        ?>
    </div>
</body>

</html>