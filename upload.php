<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'votre_base_de_donnees';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données en utilisant PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    ?>
        <h1>Impossible de se connecter au serveur verifiez votre console pour plus d'information</h1>
        <script>
            console.log(<?=json_encode("Erreur de connexion : " . $e->getMessage())?>);
        </script>
    <?php
    die();
}
if(isset($_POST['submit'])){
    if (isset($_FILES['video'])) {
        $fileName = $_FILES['video']['name'];
        $fileTmpName = $_FILES['video']['tmp_name'];
        $fileSize = $_FILES['video']['size'];
        $fileError = $_FILES['video']['error'];
        $fileType = $_FILES['video']['type'];
    
        // Vérifier s'il n'y a pas d'erreur lors du téléchargement
        if ($fileError === 0) {
            // Verifier si le dossier de destination existe
            !is_dir('uploads/') && mkdir('uploads/');
    
            // Définir le chemin de destination
            $fileDestination = 'uploads/' . $fileName;
    
            // Déplacer le fichier téléchargé vers le dossier de destination
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Préparer et exécuter la requête d'insertion
                $sql = "INSERT INTO videos (name, path, size, type) VALUES (:name, :path, :size, :type)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':name' => $fileName,
                    ':path' => $fileDestination,
                    ':size' => $fileSize,
                    ':type' => $fileType
                ]);
    
                $msg = "Vidéo téléchargée et enregistrée avec succès !";
            } else {
                $msg = "Erreur lors du déplacement du fichier téléchargé.";
            }
        } else {
            $msg = "Erreur lors du téléchargement du fichier : $fileError";
        }
    }
}

// Afficher toutes les videos de la base des donnees
// Requête pour récupérer toutes les vidéos par ordre decroissant
$sql = "SELECT * FROM videos ORDER BY `id` DESC";
$stmt = $conn->query($sql);
?>
